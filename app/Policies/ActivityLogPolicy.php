<?php

namespace App\Policies;

use App\Models\User;

class ActivityLogPolicy
{
    /**
     * Determine if the user can view any activity logs.
     * Only superadmin and admin can view activity logs.
     */
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin() || $user->isAdmin();
    }

    /**
     * Determine if the user can view the activity log.
     * Only superadmin and admin can view activity logs.
     */
    public function view(User $user): bool
    {
        return $user->isSuperAdmin() || $user->isAdmin();
    }

    /**
     * Determine if the user can delete activity logs.
     * Only superadmin can delete activity logs.
     */
    public function delete(User $user): bool
    {
        return $user->isSuperAdmin();
    }
}
