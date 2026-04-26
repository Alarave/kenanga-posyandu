<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id', 'user_id', 'visit_date', 'weight', 'height',
        'measurement_method', 'head_circumference', 'immunization', 
        'vitamin_a', 'pill_fe', 'is_exclusive_breastfeeding',
        'complaint', 'diagnosis',
        // Gizi BB/U
        'nutrition_status', 'z_score', 'nutrition_trend',
        // Gizi TB/U (stunting)
        'z_score_hfa', 'stunting_status',
        // Gizi BB/TB (wasting)
        'z_score_wfh', 'wasting_status',
        // Gizi IMT/U (obesitas)
        'z_score_bfa',
    ];

    protected $casts = [
        'visit_date'                => 'date',
        'vitamin_a'                 => 'boolean',
        'pill_fe'                   => 'boolean',
        'is_exclusive_breastfeeding' => 'boolean',
        'weight'                    => 'decimal:2',
        'height'                    => 'decimal:2',
        'head_circumference'        => 'decimal:2',
        // Z-Score semua indeks
        'z_score'            => 'decimal:2',  // BB/U
        'z_score_hfa'        => 'decimal:2',  // TB/U
        'z_score_wfh'        => 'decimal:2',  // BB/TB
        'z_score_bfa'        => 'decimal:2',  // IMT/U
    ];

    // Relationship with Patient
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // Relationship with User (Kader yg input)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope to filter medical records based on User role access
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \App\Models\User $user
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAccessibleBy($query, $user)
    {
        if ($user->isSuperAdmin()) {
            return $query;
        }

        if ($user->isCoordinator()) {
            // They can see records from their RW area (pedukuhan)
            $pedukuhanId = $user->posyandu?->pedukuhan_id;
            if ($pedukuhanId) {
                return $query->whereHas('patient.posyandu', fn($q) => $q->where('pedukuhan_id', $pedukuhanId));
            }
            return $query->whereNull('id'); // Explicitly return empty if no pedukuhan_id
        }

        // Admin, Staff, Medical can only see their posyandu's records
        return $query->whereHas('patient', fn($q) => $q->where('posyandu_id', $user->posyandu_id));
    }
}
