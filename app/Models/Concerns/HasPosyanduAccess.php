<?php

namespace App\Models\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

/**
 * Trait untuk mengelola akses berbasis Posyandu
 */
trait HasPosyanduAccess
{
    /**
     * Scope untuk memfilter berdasarkan akses user
     */
    public function scopeAccessibleBy(Builder $query, User $user): Builder
    {
        if ($user->isSuperAdmin()) {
            return $query;
        }

        return $this->scopeByPosyandu($query, $user);
    }

    /**
     * Scope untuk user dengan akses posyandu tunggal
     */
    protected function scopeByPosyandu(Builder $query, User $user): Builder
    {
        if (! $user->posyandu_id) {
            return $query->whereNull('id');
        }

        return $query->where('posyandu_id', $user->posyandu_id);
    }
}
