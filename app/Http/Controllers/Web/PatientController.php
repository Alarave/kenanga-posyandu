<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\PatientRequest;
use App\Imports\PatientImport;
use App\Models\Patient;
use App\Models\Pedukuhan;
use App\Models\Posyandu;
use App\Services\ActivityLogService;
use App\Services\PatientService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PatientController extends Controller
{
    public function __construct(
        private PatientService $patientService,
        private ActivityLogService $activityLogService
    ) {}

    /**
     * Show the form for creating a new patient.
     */
    public function create(Request $request)
    {
        $this->authorize('create', Patient::class);

        if (! $request->has('category')) {
            return view('livewire.admin.patient-management.select-category');
        }

        $pedukuhans = Pedukuhan::all();
        $posyandus = $this->getAvailablePosyandus();

        return view('livewire.admin.patient-management.create', compact('pedukuhans', 'posyandus'));
    }

    /**
     * Store a newly created patient.
     */
    public function store(PatientRequest $request)
    {
        $this->authorize('create', Patient::class);

        try {
            $this->patientService->createPatient($request->validated(), auth()->user());

            return redirect()->route('admin.patients.index')->with('success', 'Data warga berhasil disimpan.');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors($e->errors());
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data: '.$e->getMessage());
        }
    }

    /**
     * Display the specified patient with medical records history.
     */
    public function show(Patient $patient, Request $request)
    {
        $this->authorize('view', $patient);

        $patient->load([
            'posyandu',
            'medicalRecords' => function ($q) {
                $q->reorder('visit_date', 'asc');
            },
            'medicalRecords.user',
        ]);

        $medicalRecords = $patient->medicalRecords()
            ->with('user')
            ->when($request->history_search, function ($q) use ($request) {
                $q->where(function ($sq) use ($request) {
                    $sq->where('diagnosis', 'like', '%'.$request->history_search.'%')
                        ->orWhere('immunization', 'like', '%'.$request->history_search.'%')
                        ->orWhere('visit_date', 'like', '%'.$request->history_search.'%');
                });
            })
            ->latest('visit_date')
            ->paginate(10)
            ->withQueryString();

        return view('livewire.admin.patient-management.details', compact('patient', 'medicalRecords'));
    }

    /**
     * Show the form for editing the specified patient.
     */
    public function edit(Patient $patient)
    {
        $this->authorize('update', $patient);

        $pedukuhans = Pedukuhan::all();
        $posyandus = $this->getAvailablePosyandus();

        return view('livewire.admin.patient-management.update', compact('patient', 'pedukuhans', 'posyandus'));
    }

    /**
     * Update the specified patient.
     */
    public function update(PatientRequest $request, Patient $patient)
    {
        $this->authorize('update', $patient);

        try {
            $this->patientService->updatePatient($patient, $request->validated(), auth()->user());

            return redirect()->route('admin.patients.index')->with('success', 'Data warga berhasil diperbarui.');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors($e->errors());
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data: '.$e->getMessage());
        }
    }

    /**
     * Remove the specified patient.
     */
    public function destroy(Patient $patient)
    {
        $this->authorize('delete', $patient);

        try {
            $this->patientService->deletePatient($patient);

            return redirect()->route('admin.patients.index')->with('success', 'Data warga berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.patients.index')->with('error', 'Gagal menghapus data: '.$e->getMessage());
        }
    }

    /**
     * Show import form.
     */
    public function importForm()
    {
        $this->authorize('create', Patient::class);

        $posyandus = $this->getAvailablePosyandus();

        return view('livewire.admin.patient-management.import', compact('posyandus'));
    }

    /**
     * Process CSV/Excel import.
     */
    public function import(Request $request)
    {
        $this->authorize('create', Patient::class);

        $request->validate([
            'file' => [
                'required',
                'file',
                'max:5120',
                function ($attribute, $value, $fail) {
                    $extension = strtolower($value->getClientOriginalExtension());
                    if (!in_array($extension, ['csv', 'xlsx', 'xls'])) {
                        $fail('Format file harus CSV, XLSX, atau XLS (Excel lama).');
                    }
                }
            ],
            'posyandu_id' => 'required|exists:posyandus,id',
        ], [
            'file.required' => 'File wajib diunggah.',
            'file.max' => 'Ukuran file maksimal 5 MB.',
            'posyandu_id.required' => 'Posyandu wajib dipilih.',
        ]);

        $user = auth()->user();
        $posyanduId = $user->isSuperAdmin() ? (int) $request->posyandu_id : $user->posyandu_id;

        try {
            $import = new PatientImport($posyanduId, $user->id);
            $import->import($request->file('file'));

            $this->logImportActivity($import, $posyanduId);

            return redirect()->route('admin.patients.index')
                ->with('success', $this->buildImportSuccessMessage($import))
                ->with('import_errors', $this->buildImportErrors($import));

        } catch (\Exception $e) {
            \Log::error('Patient import failed: '.$e->getMessage());

            return redirect()->back()
                ->with('error', 'Import gagal: '.$e->getMessage());
        }
    }

    public function downloadTemplate(Request $request)
    {
        $category = $request->query('category', 'balita');

        $filename = match ($category) {
            'ibu_hamil' => 'template_import_ibu_hamil.csv',
            'lansia' => 'template_import_lansia.csv',
            default => 'template_import_balita.csv',
        };

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ];

        $rows = $this->getTemplateRowsForCategory($category);

        return response()->stream(function () use ($rows) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF"); // BOM UTF-8
            fwrite($file, "sep=,\n"); // Force Excel to use comma separator
            foreach ($rows as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        }, 200, $headers);
    }

    /**
     * Get available posyandus based on user role.
     */
    private function getAvailablePosyandus()
    {
        $user = auth()->user();

        return $user->isSuperAdmin()
            ? Posyandu::orderBy('name')->get()
            : Posyandu::where('id', $user->posyandu_id)->get();
    }

    /**
     * Log import activity.
     */
    private function logImportActivity($import, int $posyanduId): void
    {
        $posyandu = Posyandu::find($posyanduId);

        $this->activityLogService->log(
            'create_patient',
            "Import data warga: {$import->imported} berhasil, {$import->skipped} dilewati — Posyandu {$posyandu?->name}",
            $posyanduId,
            'Patient'
        );
    }

    /**
     * Build success message for import.
     */
    private function buildImportSuccessMessage($import): string
    {
        $message = "Import selesai: {$import->imported} warga berhasil diimpor";

        if ($import->recordsImported > 0) {
            $message .= ", {$import->recordsImported} rekam medis tersimpan";
        }

        $message .= '.';

        if ($import->skipped > 0) {
            $message .= " {$import->skipped} baris dilewati.";
        }

        return $message;
    }

    /**
     * Build errors array for import.
     */
    private function buildImportErrors($import): array
    {
        return $import->errors;
    }

    /**
     * Get template rows for CSV download based on category.
     */
    private function getTemplateRowsForCategory(string $category): array
    {
        if ($category === 'ibu_hamil') {
            return [
                // Baris Header
                [
                    // Identitas Warga
                    'NIK', 'nama', 'tgl_lahir', 'jk', 'suami', 'tempat_lahir', 'phone_number',
                    'RT', 'RW', 'desa_kelurahan', 'kecamatan', 'ALAMAT', 'apakah_hamil',
                    // Detil Kehamilan
                    'pregnancy_number', 'pregnancy_spacing', 'starting_weight', 'starting_height', 'delivery_date', 'delivery_method',
                    // ANC
                    'TANGGAL UKUR', 'gestational_age', 'BERAT', 'upper_arm_circumference', 'tensi', 'imt_plotting_status', 'lila_plotting_status', 'bp_plotting_status',
                    'tbc_screening_cough', 'tbc_screening_fever', 'tbc_screening_weight_loss', 'tbc_screening_contact',
                    'nakes_gives_fe_mms', 'consumes_fe_mms_regularly', 'nakes_gives_mt_kek', 'mt_package_details', 'consumes_mt_kek_regularly',
                    'counseling_topic', 'joins_pregnant_class', 'anc_referral',
                    // Postpartum
                    'postpartum_period', 'postpartum_imt_plotting', 'postpartum_bp_plotting', 'nakes_gives_vit_a', 'vit_a_capsule_count', 'consumes_vit_a_regularly', 'is_breastfeeding', 'postpartum_kb', 'postpartum_counseling_topic', 'postpartum_referral'
                ],
                // Baris Contoh
                [
                    '3275011234567890', 'Siti Rahayu', '1995-08-15', 'P', 'Budi Santoso',
                    'Bandung', '08123456789', '003', '001', 'Cigondewah', 'Bandung Barat', 'Jl. Contoh No. 1 RT 003/001', 'Ya',
                    '1', '3 Tahun', '60.5', '158.0', '2026-10-15', 'Normal',
                    date('Y-m-d'), '16 Minggu', '65.5', '24.5', '120/80', 'Normal', 'Normal', 'Normal',
                    'Tidak', 'Tidak', 'Tidak', 'Tidak',
                    'Ya', 'Ya', 'Tidak', '', 'Tidak',
                    'Gizi Ibu Hamil', 'Ya', 'Tidak Rujuk',
                    '', '', '', '', '', '', '', '', '', ''
                ],
            ];
        }

        if ($category === 'lansia') {
            return [
                // Baris Header
                [
                    // Identitas Warga
                    'NIK', 'nama', 'tgl_lahir', 'jk',
                    'tempat_lahir', 'phone_number', 'RT', 'RW', 'ALAMAT',
                    // Riwayat Penyakit Keluarga
                    'riwayat_penyakit_keluarga',
                    // Perilaku Berisiko Mandiri
                    'perilaku_berisiko',
                    // Data Pemeriksaan
                    'TANGGAL UKUR', 'BERAT', 'TINGGI', 'IMT',
                    'lingkar_perut', 'tekanan_darah',
                    'gds', 'asam_urat', 'kolesterol',
                    'tes_mata', 'tes_telinga',
                    'skrining_puma', 'skrining_tbc', 'skrining_jiwa',
                    'kontrasepsi', 'edukasi', 'rujuk',
                ],
                // Baris Contoh
                [
                    '3275019876543210', 'Hj. Sumiyati', '1955-03-20', 'P',
                    'Yogyakarta', '08987654321', '002', '001', 'Jl. Mawar No. 5 RT 002/001',
                    'Hipertensi, Jantung',
                    'Merokok, Kurang Aktivitas',
                    date('Y-m-d'), '58.0', '155.0', '24.1',
                    '82.0', '130/80',
                    '110', '5.4', '195',
                    'Normal', 'Normal',
                    'Tidak', 'Tidak', 'Tidak',
                    'Tidak', 'Pola makan sehat', 'Tidak Rujuk',
                ],
            ];
        }

        // Default: balita / bayi / baduta / anak
        return [
            // Baris Header
            [
                // Identitas Anak & Orang Tua
                'NIK', 'nama_anak', 'tgl_lahir', 'jk',
                'ayah', 'ibu', 'NIK_ibu', 'tempat_lahir', 'phone_number',
                'RT', 'RW', 'ALAMAT',
                'BB_lahir', 'PB_lahir', 'kepemilikan_buku_kia',
                // Data Pemeriksaan (Antropometri)
                'TANGGAL UKUR', 'BERAT', 'TINGGI', 'LILA', 'lingkar_kepala', 'CARA UKUR',
                // Perkembangan & Skrining
                'kpsp_status', 
                'tbc_screening_cough', 'tbc_screening_fever', 'tbc_screening_contact', 'tbc_screening_lethargy', 'tbc_screening_lumps', 'tbc_screening_weight_loss',
                // Nutrisi & Imunisasi
                'is_exclusive_breastfeeding', 'mp_asi', 'vitamin', 'Imunisasi', 'is_basic_immunization_complete', 'deworming_medicine',
                // Pelayanan Lainnya
                'pmt_given', 'counseling_notes', 'complaint', 'disease_history', 'health_note', 'referral_type'
            ],
            // Baris Contoh
            [
                '3275011112223334', 'Anak Sehat', '2022-06-10', 'L',
                'Budi Santoso', 'Siti Rahayu', '3275011234567890', 'Bandung', '08123456789',
                '003', '001', 'Jl. Contoh No. 1 RT 003/001',
                '3.2', '50.5', '1',
                date('Y-m-d'), '12.5', '80.0', '16', '44.0', 'berdiri',
                'Sesuai',
                'Tidak', 'Tidak', 'Tidak', 'Tidak', 'Tidak', 'Tidak',
                'Ya', 'Ya', 'Ya', 'BCG, Polio 1', 'Ya', 'Tidak',
                'Biskuit Balita', 'Pola asuh sehat', 'Tidak ada keluhan', 'Sehat', 'Anak aktif', 'Tidak Rujuk'
            ],
        ];
    }
}
