<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'posyandu_id', 'user_id', 'gallery_folder_id', 'title', 'description', 'photo', 'type',
    ];

    // Relationship with Folder
    public function folder()
    {
        return $this->belongsTo(GalleryFolder::class, 'gallery_folder_id');
    }

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
     * Scope to filter galleries based on User role access
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

        return $query->where('posyandu_id', $user->posyandu_id);
    }
}
