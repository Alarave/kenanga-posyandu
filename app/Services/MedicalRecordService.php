<?php

namespace App\Services;

use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Carbon;

class MedicalRecordService
{
    protected ActivityLogService $activityLogService;
    protected NutritionCalculatorService $nutritionService;
    protected WhatsAppService $whatsAppService;

    public function __construct(
        ActivityLogService $activityLogService, 
        NutritionCalculatorService $nutritionService,
        WhatsAppService $whatsAppService
    ) {
        $this->activityLogService = $activityLogService;
        $this->nutritionService = $nutritionService;
        $this->whatsAppService = $whatsAppService;
    }

    /**
     * Check for duplicate Vitamin A and Pill FE in current month
     */
    public function getDuplicateWarnings(int $patientId, ?Carbon $visitDate = null, ?int $excludeRecordId = null)
    {
        $date = $visitDate ?? now();

        $query = MedicalRecord::where('patient_id', $patientId)
            ->whereYear('visit_date', $date->year)
            ->whereMonth('visit_date', $date->month)
            ->where(function($q) {
                $q->where('vitamin_a', true)
                  ->orWhere('pill_fe', true);
            });

        if ($excludeRecordId) {
            $query->where('id', '!=', $excludeRecordId);
        }

        return $query->first();
    }

    /**
     * Create a new medical record
     */
    public function createRecord(array $data, User $user): MedicalRecord
    {
        $patient = Patient::findOrFail($data['patient_id']);

        // Verify patient belongs to user's posyandu (for admin/staff/kader)
        if (!$user->isSuperAdmin() && !$user->isCoordinator()) {
            if ($patient->posyandu_id !== $user->posyandu_id) {
                abort(403, 'Anda tidak memiliki akses untuk membuat rekam medis untuk pasien ini.');
            }
        }

        $data = $this->calculateNutrition($data, $patient);

        $data['user_id'] = $user->id;
        $data['immunization'] = $data['immunization'] ?? 'Tidak ada';
        $data['complaint'] = $data['complaint'] ?? '—';
        $data['nutrition_status'] = $data['nutrition_status'] ?? 'Normal';

        $medicalRecord = MedicalRecord::create($data);

        // Log activity
        $this->activityLogService->log(
            'create_medical_record',
            "Menambahkan rekam medis: {$patient->full_name} (Tanggal: {$medicalRecord->visit_date->format('Y-m-d')})",
            $medicalRecord->id,
            'MedicalRecord',
            null,
            $medicalRecord->toArray()
        );

        return $medicalRecord;
    }

    /**
     * Update an existing medical record
     */
    public function updateRecord(MedicalRecord $medicalRecord, array $data, User $user): MedicalRecord
    {
        $oldValues = $medicalRecord->toArray();
        $patient = Patient::findOrFail($data['patient_id']);

        // Verify patient belongs to user's posyandu
        if (!$user->isSuperAdmin() && !$user->isCoordinator()) {
            if ($patient->posyandu_id !== $user->posyandu_id) {
                abort(403, 'Anda tidak memiliki akses untuk mengubah rekam medis untuk pasien ini.');
            }
        }

        $weightChanged = isset($data['weight']) && $data['weight'] != $oldValues['weight'];
        $heightChanged = isset($data['height']) && $data['height'] != $oldValues['height'];

        if ($weightChanged || $heightChanged) {
            $data = $this->calculateNutrition($data, $patient);
        }

        $data['immunization'] = $data['immunization'] ?? $medicalRecord->immunization ?? 'Tidak ada';
        $data['complaint'] = $data['complaint'] ?? $medicalRecord->complaint ?? '—';

        $medicalRecord->update($data);

        // Log activity
        $this->activityLogService->log(
            'update_medical_record',
            "Mengubah rekam medis: {$patient->full_name} (Tanggal: {$medicalRecord->visit_date->format('Y-m-d')})",
            $medicalRecord->id,
            'MedicalRecord',
            $oldValues,
            $medicalRecord->fresh()->toArray()
        );

        return $medicalRecord;
    }

    /**
     * Delete a medical record
     */
    public function deleteRecord(MedicalRecord $medicalRecord): void
    {
        $recordData = $medicalRecord->toArray();
        $patientName = $medicalRecord->patient->full_name;
        $visitDate = $medicalRecord->visit_date->format('d/m/Y');

        $medicalRecord->delete();

        // Log activity
        $this->activityLogService->log(
            'delete_medical_record',
            "Menghapus rekam medis untuk: {$patientName} (Tanggal: {$visitDate})",
            null,
            'MedicalRecord',
            $recordData,
            null
        );
    }

    /**
     * Calculate nutrition data (z-score, status, trend) and append to data array
     */
    private function calculateNutrition(array $data, Patient $patient): array
    {
        if ($patient->category === 'balita' && isset($data['weight']) && $patient->birth_date) {
            $ageInMonths = $patient->birth_date->diffInMonths(now());
            
            $nutritionResult = $this->nutritionService->calculateAll(
                (float) $data['weight'],
                (float) ($data['height'] ?? 0),
                $ageInMonths,
                $patient->gender
            );
            
            $data['z_score'] = $nutritionResult['z_score'];
            $data['nutrition_status'] = $nutritionResult['nutrition_status'];
            $data['z_score_hfa'] = $nutritionResult['z_score_hfa'];
            $data['stunting_status'] = $nutritionResult['stunting_status'];
            $data['z_score_wfh'] = $nutritionResult['z_score_wfh'];
            $data['wasting_status'] = $nutritionResult['wasting_status'];
            $data['z_score_bfa'] = $nutritionResult['z_score_bfa'];
            
            // Calculate nutrition trend
            $previousRecord = MedicalRecord::where('patient_id', $patient->id)
                ->where('visit_date', '<', $data['visit_date'])
                ->whereNotNull('nutrition_status')
                ->orderBy('visit_date', 'desc')
                ->first();
            
            if ($previousRecord && $previousRecord->nutrition_status) {
                $data['nutrition_trend'] = $this->calculateNutritionTrend(
                    $previousRecord->nutrition_status,
                    $nutritionResult['nutrition_status']
                );
            }

            // Check for growth alerts (Stunting, 2T, etc.)
            $this->checkGrowthTrends($patient, $data);
        }

        return $data;
    }

    /**
     * Deteksi tren pertumbuhan dan kirim peringatan jika perlu (2T / Stunting).
     */
    private function checkGrowthTrends(Patient $patient, array $data): void
    {
        // 1. Alert Stunting Baru
        if (($data['stunting_status'] ?? '') !== 'Normal' && $data['stunting_status'] !== 'Tidak Dapat Dihitung') {
            $this->sendGrowthAlert($patient, "Perhatian: Balita {$patient->full_name} terdeteksi memiliki status {$data['stunting_status']}. Mohon konsultasikan dengan petugas kesehatan.");
        }

        // 2. Deteksi 2T (Tidak Naik 2 Kali Berturut-turut)
        $recentRecords = MedicalRecord::where('patient_id', $patient->id)
            ->where('visit_date', '<', $data['visit_date'])
            ->orderBy('visit_date', 'desc')
            ->limit(2)
            ->get();

        if ($recentRecords->count() >= 2) {
            $lastWeight = (float) $data['weight'];
            $prevWeight1 = (float) $recentRecords[0]->weight;
            $prevWeight2 = (float) $recentRecords[1]->weight;

            // Jika BB tidak naik (tetap atau turun) di kunjungan ini DAN kunjungan sebelumnya
            if ($lastWeight <= $prevWeight1 && $prevWeight1 <= $prevWeight2) {
                $this->sendGrowthAlert($patient, "Peringatan 2T: Berat badan {$patient->full_name} tidak naik dalam 2 penimbangan terakhir. Segera konsultasikan ke Posyandu atau Puskesmas.");
            }
        }
    }

    /**
     * Kirim notifikasi via WhatsApp Service.
     */
    private function sendGrowthAlert(Patient $patient, string $message): void
    {
        // Cari nomor WhatsApp orang tua (dari model Patient, biasanya disimpan di field tertentu)
        // Jika tidak ada di model Patient, mungkin di model User yang terkait?
        // Asumsi: Patient memiliki field phone_number atau kita kirim ke kader.
        
        $target = $patient->phone_number ?? $patient->parent_phone ?? null;

        if ($target) {
            $this->whatsAppService->sendMessage($target, $message);
        }
    }

    /**
     * Calculate nutrition trend by comparing current and previous nutrition status
     */
    private function calculateNutritionTrend(string $previousStatus, string $currentStatus): string
    {
        $statusRank = [
            'Gizi Buruk' => 1,
            'Gizi Kurang' => 2,
            'Gizi Baik' => 3,
            'Normal' => 3,
            'Gizi Lebih' => 2,
            'Risiko Gemuk' => 2,
            'Gemuk (Overweight)' => 1,
            'Obesitas' => 1,
            'Tidak Dapat Dihitung' => 0,
        ];

        $prevRank = $statusRank[$previousStatus] ?? 0;
        $currRank = $statusRank[$currentStatus] ?? 0;

        if ($prevRank === 0 || $currRank === 0) {
            return 'tetap';
        }

        if ($currRank > $prevRank) {
            return 'naik';
        } elseif ($currRank < $prevRank) {
            return 'turun';
        } else {
            return 'tetap';
        }
    }
}
