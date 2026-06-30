<?php

namespace App\Services;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;

class PatientService
{
    protected ActivityLogService $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    /**
     * Create a new patient.
     *
     * @throws ValidationException
     */
    public function createPatient(array $data, User $user): Patient
    {
        // Enforce posyandu_id for non-superadmin users
        if (! $user->isSuperAdmin()) {
            $data['posyandu_id'] = $user->posyandu_id;
        }

        // SECURITY: Validate unique NIK using Blind Index (id_number_hash)
        $nikHash = Patient::generateBlindIndex($data['id_number']);
        $existingPatient = Patient::where('id_number_hash', $nikHash)
            ->where('posyandu_id', $data['posyandu_id'])
            ->first();

        if ($existingPatient) {
            throw ValidationException::withMessages([
                'id_number' => 'NIK sudah terdaftar dalam sistem untuk Posyandu ini.',
            ]);
        }

        if (isset($data['profile_photo']) && $data['profile_photo'] instanceof UploadedFile) {
            $data['profile_photo'] = $data['profile_photo']->store('patients', 'public');
        }

        $patient = Patient::create($data);

        // SECURITY: Filter sensitive data before logging
        $logData = collect($patient->toArray())
            ->except(['id_number', 'id_number_hash', 'phone_number'])
            ->toArray();

        // Log activity (No NIK in description)
        $this->activityLogService->log(
            'create_patient',
            "Menambahkan data warga: {$patient->full_name}",
            $patient->id,
            'Patient',
            null,
            $logData
        );

        return $patient;
    }

    /**
     * Update an existing patient.
     *
     * @throws ValidationException
     */
    public function updatePatient(Patient $patient, array $data, User $user): Patient
    {
        // Enforce posyandu_id for non-superadmin users
        if (! $user->isSuperAdmin()) {
            $data['posyandu_id'] = $user->posyandu_id;
        }

        // SECURITY: Validate unique NIK using Blind Index
        $nikHash = Patient::generateBlindIndex($data['id_number']);
        $existingPatient = Patient::where('id_number_hash', $nikHash)
            ->where('posyandu_id', $data['posyandu_id'])
            ->where('id', '!=', $patient->id)
            ->first();

        if ($existingPatient) {
            throw ValidationException::withMessages([
                'id_number' => 'NIK sudah terdaftar dalam sistem untuk Posyandu ini.',
            ]);
        }

        // Store old values before update (filtered)
        $oldValues = collect($patient->toArray())
            ->except(['id_number', 'id_number_hash', 'phone_number'])
            ->toArray();

        if (isset($data['profile_photo']) && $data['profile_photo'] instanceof UploadedFile) {
            $data['profile_photo'] = $data['profile_photo']->store('patients', 'public');
        }

        $patient->update($data);

        // Fresh data for logging (filtered)
        $newValues = collect($patient->fresh()->toArray())
            ->except(['id_number', 'id_number_hash', 'phone_number'])
            ->toArray();

        // Log activity (No NIK in description)
        $this->activityLogService->log(
            'update_patient',
            "Mengubah data warga: {$patient->full_name}",
            $patient->id,
            'Patient',
            $oldValues,
            $newValues
        );

        return $patient;
    }

    /**
     * Delete a patient.
     */
    public function deletePatient(Patient $patient): void
    {
        // SECURITY: Filter sensitive data before deletion logging
        $patientData = collect($patient->toArray())
            ->except(['id_number', 'id_number_hash', 'phone_number'])
            ->toArray();

        $patientName = $patient->full_name;
        $patientId = $patient->id;

        $patient->delete();

        // Log activity (No NIK in description)
        $this->activityLogService->log(
            'delete_patient',
            "Menghapus data warga: {$patientName}",
            $patientId,
            'Patient',
            $patientData,
            null
        );
    }
}
