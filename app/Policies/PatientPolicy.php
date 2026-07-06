<?php

namespace App\Policies;

use App\Models\Patient;
use App\Models\User;
use App\Services\ActivityLogService;

class PatientPolicy
{
    public function viewAny(User $user): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return ($user->isAdmin() || $user->isKader()) && $user->posyandu_id !== null;
    }

    /**
     * Determine if the user can view the patient.
     */
    public function view(User $user, Patient $patient): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return ($user->isAdmin() || $user->isKader()) && $user->posyandu_id === $patient->posyandu_id;
    }

    /**
     * Determine if the user can create patients.
     */
    public function create(User $user): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return $user->isAdmin() && $user->posyandu_id !== null;
    }

    /**
     * Determine if the user can update the patient.
     * Kaders have read-only access; only admins and superadmins can edit.
     */
    public function update(User $user, Patient $patient): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return $user->isAdmin() && $user->posyandu_id === $patient->posyandu_id;
    }

    /**
     * Determine if the user can delete the patient.
     */
    public function delete(User $user, Patient $patient): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return $user->isAdmin() && $user->posyandu_id === $patient->posyandu_id;
    }

    /**
     * Log unauthorized access attempt
     */
    private function logUnauthorizedAccess(User $user, string $action, string $entityType, ?int $entityId = null): void
    {
        $activityLogService = app(ActivityLogService::class);
        $activityLogService->log(
            'unauthorized_access',
            "Percobaan akses tidak sah: {$action} pada {$entityType}".($entityId ? " (ID: {$entityId})" : ''),
            $entityId,
            $entityType,
            null,
            ['action' => $action, 'user_role' => $user->role]
        );
    }
}
