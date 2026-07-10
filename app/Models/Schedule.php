<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'posyandu_id', 'user_id', 'title', 'description', 'start_time', 'end_time', 'location', 'status',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    // Relationship with Posyandu
    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class);
    }

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope untuk pencarian berdasarkan judul atau lokasi.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $searchTerm = '%'.strtolower($search).'%';
            $q->whereRaw('LOWER(title) LIKE ?', [$searchTerm])
                ->orWhereRaw('LOWER(location) LIKE ?', [$searchTerm]);
        });
    }

    /**
     * Scope to filter schedules based on User role access
     *
     * @param  Builder  $query
     * @param  User  $user
     * @return Builder
     */
    public function scopeAccessibleBy($query, $user)
    {
        if ($user->isSuperAdmin()) {
            return $query;
        }

        // Default or other roles just see their own posyandu
        return $query->where('posyandu_id', $user->posyandu_id);
    }
}
