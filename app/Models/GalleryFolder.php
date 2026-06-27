<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryFolder extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description', 
        'cover_image',
        'posyandu_id',
        'created_by',
    ];

    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'folder_id');
    }

    public function coverImage()
    {
        return $this->galleries()->whereNotNull('photo')->latest()->first();
    }

    public function scopeAccessibleBy($query, $user)
    {
        if ($user->isSuperAdmin()) {
            return $query;
        }
        return $query->where('posyandu_id', $user->posyandu_id);
    }
}