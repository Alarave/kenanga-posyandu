<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryFolder extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'posyandu_id', 'user_id', 'name', 'description', 'cover_photo',
    ];

    // Relationship with Posyandu
    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class);
    }

    // Relationship with User (Creator)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Galleries (Media inside)
    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'gallery_folder_id');
    }

    /**
     * Scope to filter folders based on User role access
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \App\Models\User  $user
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAccessibleBy($query, $user)
    {
        if ($user->isSuperAdmin()) {
            return $query;
        }

        return $query->where('posyandu_id', $user->posyandu_id);
    }
}
