<?php

namespace App\Livewire\Traits;

use App\Models\Posyandu;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

/**
 * Trait untuk menangani pembatasan data (scoping) berdasarkan Role dan Posyandu pengguna.
 */
trait HasPosyanduScope
{
    /**
     * Terapkan scope posyandu ke query builder.
     */
    protected function applyPosyanduScope(Builder $query, string $patientIdColumn = 'id'): Builder
    {
        $user = Auth::user();

        if ($user->isSuperAdmin()) {
            return $query;
        }

        if ($user->isCoordinator()) {
            $pedukuhanId = Posyandu::find($user->posyandu_id)?->pedukuhan_id;
            
            if ($pedukuhanId) {
                $posyanduIds = Posyandu::where('pedukuhan_id', $pedukuhanId)->pluck('id');
                
                // Jika tabel medical_records, scope via patient_id
                if ($query->getModel() instanceof \App\Models\MedicalRecord) {
                    return $query->whereHas('patient', fn($q) => $q->whereIn('posyandu_id', $posyanduIds));
                }
                
                return $query->whereIn('posyandu_id', $posyanduIds);
            }
        }

        // Default: Staff/Kader/Admin hanya melihat posyandu mereka
        if ($query->getModel() instanceof \App\Models\MedicalRecord) {
            return $query->whereHas('patient', fn($q) => $q->where('posyandu_id', $user->posyandu_id));
        }

        return $query->where('posyandu_id', $user->posyandu_id);
    }

    /**
     * Dapatkan daftar Posyandu yang diizinkan untuk dilihat user (untuk dropdown filter).
     */
    protected function getAllowedPosyandus()
    {
        $user = Auth::user();

        if ($user->isSuperAdmin()) {
            return Posyandu::all();
        }

        if ($user->isCoordinator()) {
            $pedukuhanId = Posyandu::find($user->posyandu_id)?->pedukuhan_id;
            if ($pedukuhanId) {
                return Posyandu::where('pedukuhan_id', $pedukuhanId)->get();
            }
        }

        return Posyandu::where('id', $user->posyandu_id)->get();
    }
}
