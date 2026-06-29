<?php

namespace App\Policies;

use App\Models\Schedule;
use App\Models\User;
use App\Services\ActivityLogService;

class SchedulePolicy
{
    /**
     * Determine if the user can view any schedules.
     */
    public function viewAny(User $user): bool
    {
        // Superadmin can view multiple schedules
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Admin and Kader can view if they have a posyandu
        return $user->posyandu_id !== null;
    }

    /**
     * Determine if the user can view the schedule.
     */
    public function view(User $user, Schedule $schedule): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return $user->posyandu_id === $schedule->posyandu_id;
    }

    /**
     * Determine if the user can create schedules.
     */
    public function create(User $user): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Only Admin can create for their posyandu (Kader is read-only)
        if ($user->isAdmin()) {
            return $user->posyandu_id !== null;
        }

        return false;
    }

    /**
     * Determine if the user can update the schedule.
     */
    public function update(User $user, Schedule $schedule): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Only Admin can update for their posyandu (Kader is read-only)
        if ($user->isAdmin()) {
            return $user->posyandu_id === $schedule->posyandu_id;
        }

        return false;
    }

    public function delete(User $user, Schedule $schedule): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Admin can delete for their posyandu
        if ($user->isAdmin()) {
            return $user->posyandu_id === $schedule->posyandu_id;
        }

        return false;
    }

    /**
     * Log unauthorized access (Internal helper)
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
