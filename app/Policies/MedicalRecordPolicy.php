<?php

namespace App\Policies;

use App\Models\MedicalRecord;
use App\Models\User;
use App\Services\ActivityLogService;

class MedicalRecordPolicy
{
    /**
     * Determine if the user can view any medical records.
     */
    public function viewAny(User $user): bool
    {
        // Superadmin can view all medical records
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Coordinator can view medical records (read-only across RW)
        if ($user->isCoordinator()) {
            return true;
        }

        // Admin, staff, and medical can view medical records from their posyandu
        if ($user->isAdmin() || $user->isKader()) {
            return $user->posyandu_id !== null;
        }

        // Log unauthorized access
        $this->logUnauthorizedAccess($user, 'viewAny', 'MedicalRecord');
        return false;
    }

    /**
     * Determine if the user can view the medical record.
     */
    public function view(User $user, MedicalRecord $medicalRecord): bool
    {
        // Superadmin can view any medical record
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Coordinator can view any medical record (read-only)
        if ($user->isCoordinator()) {
            return true;
        }

        // Admin, staff, and medical can only view medical records from their posyandu
        if ($user->isAdmin() || $user->isKader()) {
            $canView = $user->posyandu_id === $medicalRecord->patient->posyandu_id;
            if (!$canView) {
                $this->logUnauthorizedAccess($user, 'view', 'MedicalRecord', $medicalRecord->id);
            }
            return $canView;
        }

        $this->logUnauthorizedAccess($user, 'view', 'MedicalRecord', $medicalRecord->id);
        return false;
    }

    /**
     * Determine if the user can create medical records.
     */
    public function create(User $user): bool
    {
        // Superadmin can create medical records
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Admin and Kader can create medical records for their posyandu
        if ($user->isAdmin() || $user->isKader()) {
            return $user->posyandu_id !== null;
        }

        // Coordinator cannot create (read-only)
        $this->logUnauthorizedAccess($user, 'create', 'MedicalRecord');
        return false;
    }

    /**
     * Determine if the user can update the medical record.
     */
    public function update(User $user, MedicalRecord $medicalRecord): bool
    {
        // Superadmin can update any medical record
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Coordinator cannot update (read-only)
        if ($user->isCoordinator()) {
            $this->logUnauthorizedAccess($user, 'update', 'MedicalRecord', $medicalRecord->id);
            return false;
        }

        // Admin and Kader can only update medical records from their posyandu
        if ($user->isAdmin() || $user->isKader()) {
            $canUpdate = $user->posyandu_id === $medicalRecord->patient->posyandu_id;
            if (!$canUpdate) {
                $this->logUnauthorizedAccess($user, 'update', 'MedicalRecord', $medicalRecord->id);
            }
            return $canUpdate;
        }

        $this->logUnauthorizedAccess($user, 'update', 'MedicalRecord', $medicalRecord->id);
        return false;
    }

    /**
     * Determine if the user can delete the medical record.
     */
    public function delete(User $user, MedicalRecord $medicalRecord): bool
    {
        // Superadmin can delete any medical record
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Coordinator cannot delete (read-only)
        if ($user->isCoordinator()) {
            $this->logUnauthorizedAccess($user, 'delete', 'MedicalRecord', $medicalRecord->id);
            return false;
        }

        // Only Admin can delete medical records from their posyandu (not Kader)
        if ($user->isAdmin()) {
            $canDelete = $user->posyandu_id === $medicalRecord->patient->posyandu_id;
            if (!$canDelete) {
                $this->logUnauthorizedAccess($user, 'delete', 'MedicalRecord', $medicalRecord->id);
            }
            return $canDelete;
        }

        $this->logUnauthorizedAccess($user, 'delete', 'MedicalRecord', $medicalRecord->id);
        return false;
    }

    /**
     * Log unauthorized access attempt
     */
    private function logUnauthorizedAccess(User $user, string $action, string $entityType, ?int $entityId = null): void
    {
        $activityLogService = app(ActivityLogService::class);
        $activityLogService->log(
            'unauthorized_access',
            "Percobaan akses tidak sah: {$action} pada {$entityType}" . ($entityId ? " (ID: {$entityId})" : ""),
            $entityId,
            $entityType,
            null,
            ['action' => $action, 'user_role' => $user->role]
        );
    }
}
