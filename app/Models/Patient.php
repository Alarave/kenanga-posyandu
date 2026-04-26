<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Casts\EncryptedCast;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'posyandu_id', 'category', 'parent_name', 'id_number', 'full_name',
        'birth_date', 'gender', 'address', 'phone_number', 'profile_photo'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'id_number'  => EncryptedCast::class,
    ];

    // Relationship with Posyandu
    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class);
    }

    // Relationship with MedicalRecord
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    // Age accessors
    public function getAgeAttribute(): string
    {
        return $this->birth_date ? $this->birth_date->diff(now())->format('%y thn, %m bln') : '-';
    }

    public function getAgeInMonthsAttribute(): int
    {
        return $this->birth_date ? (int) $this->birth_date->diffInMonths(now()) : 0;
    }

    /**
     * Scope to filter patients by posyandu
     *
     * @param Builder $query
     * @param int $posyanduId
     * @return Builder
     */
    public function scopeByPosyandu(Builder $query, int $posyanduId): Builder
    {
        return $query->where('posyandu_id', $posyanduId);
    }

    /**
     * Scope to filter patients based on User role access
     *
     * @param Builder $query
     * @param \App\Models\User $user
     * @return Builder
     */
    public function scopeAccessibleBy(Builder $query, $user): Builder
    {
        if ($user->isSuperAdmin()) {
            return $query;
        }

        if ($user->isCoordinator()) {
            $pedukuhanId = $user->posyandu?->pedukuhan_id;
            if ($pedukuhanId) {
                return $query->whereHas('posyandu', fn($q) => $q->where('pedukuhan_id', $pedukuhanId));
            }
            // Fallback if coordinator has no posyandu assigned, they shouldn't see anything or maybe default to empty?
            // To be safe, follow previous logic which didn't restrict if not found, but let's be strict:
            return $query->whereNull('id'); // Explicitly return empty
        }

        // Admin, Staff, Medical can only see their posyandu
        return $query->where('posyandu_id', $user->posyandu_id);
    }
}
