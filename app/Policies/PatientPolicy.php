<?php

namespace App\Policies;

use App\Models\Patient;
use App\Models\User;
use App\Services\ActivityLogService;

class PatientPolicy
{
    /**
     * Determine if the user can view any patients.
     */
    public function viewAny(User $user): bool
    {
        // Superadmin can view all patients
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Coordinator can view patients (read-only across RW)
        if ($user->isCoordinator()) {
            return true;
        }

        // Admin, staff, and medical can view patients from their posyandu
        if ($user->isAdmin() || $user->isKader()) {
            return $user->posyandu_id !== null;
        }

        // Log unauthorized access
        $this->logUnauthorizedAccess($user, 'viewAny', 'Patient');
        return false;
    }

    /**
     * Determine if the user can view the patient.
     */
    public function view(User $user, Patient $patient): bool
    {
        // Superadmin can view any patient
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Coordinator can view any patient in their RW
        if ($user->isCoordinator()) {
            $canView = $user->posyandu && $patient->posyandu && $user->posyandu->pedukuhan_id === $patient->posyandu->pedukuhan_id;
            if (!$canView) {
                $this->logUnauthorizedAccess($user, 'view', 'Patient', $patient->id);
            }
            return $canView;
        }

        // Admin, staff, and medical can only view patients from their posyandu
        if ($user->isAdmin() || $user->isKader()) {
            $canView = $user->posyandu_id === $patient->posyandu_id;
            if (!$canView) {
                $this->logUnauthorizedAccess($user, 'view', 'Patient', $patient->id);
            }
            return $canView;
        }

        $this->logUnauthorizedAccess($user, 'view', 'Patient', $patient->id);
        return false;
    }

    /**
     * Determine if the user can create patients.
     */
    public function create(User $user): bool
    {
        // Superadmin can create patients
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Only Admin can create patients for their posyandu (Kader is read-only)
        if ($user->isAdmin()) {
            return $user->posyandu_id !== null;
        }

        // Coordinator and Kader cannot create (read-only)
        $this->logUnauthorizedAccess($user, 'create', 'Patient');
        return false;
    }

    /**
     * Determine if the user can update the patient.
     */
    public function update(User $user, Patient $patient): bool
    {
        // Superadmin can update any patient
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Coordinator and Kader cannot update (read-only)
        if ($user->isCoordinator() || $user->isKader()) {
            $this->logUnauthorizedAccess($user, 'update', 'Patient', $patient->id);
            return false;
        }

        // Only Admin can update patients from their posyandu
        if ($user->isAdmin()) {
            $canUpdate = $user->posyandu_id === $patient->posyandu_id;
            if (!$canUpdate) {
                $this->logUnauthorizedAccess($user, 'update', 'Patient', $patient->id);
            }
            return $canUpdate;
        }

        $this->logUnauthorizedAccess($user, 'update', 'Patient', $patient->id);
        return false;
    }

    /**
     * Determine if the user can delete the patient.
     */
    public function delete(User $user, Patient $patient): bool
    {
        // Superadmin can delete any patient
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Coordinator cannot delete (read-only)
        if ($user->isCoordinator()) {
            $this->logUnauthorizedAccess($user, 'delete', 'Patient', $patient->id);
            return false;
        }

        // Only Admin can delete patients from their posyandu (not Kader)
        if ($user->isAdmin()) {
            $canDelete = $user->posyandu_id === $patient->posyandu_id;
            if (!$canDelete) {
                $this->logUnauthorizedAccess($user, 'delete', 'Patient', $patient->id);
            }
            return $canDelete;
        }

        $this->logUnauthorizedAccess($user, 'delete', 'Patient', $patient->id);
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
