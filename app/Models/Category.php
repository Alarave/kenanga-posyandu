<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    protected static function booted()
    {
        static::saved(function ($category) {
            Cache::forget('public_categories_count');
        });

        static::deleted(function ($category) {
            Cache::forget('public_categories_count');
        });
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
