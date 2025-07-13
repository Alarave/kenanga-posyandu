<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'role', // role untuk mengelola jenis role pengguna
        'is_active', 
        'verified_email'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Role constants
     */
    const ROLE_SUPERADMIN = 'superadmin';
    const ROLE_ADMIN = 'admin';
    const ROLE_MANAGER = 'manager';
    const ROLE_STAFF = 'staff';
    const ROLE_MEDICAL = 'medical';
    const ROLE_PATIENT = 'patient';
    const ROLE_PARTNER = 'partner';

    /**
     * Cek apakah user adalah SuperAdmin
     */
    public function isSuperAdmin()
    {
        return $this->role === self::ROLE_SUPERADMIN;
    }

    /**
     * Cek apakah user adalah Admin
     */
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Cek apakah user adalah Manager
     */
    public function isManager()
    {
        return $this->role === self::ROLE_MANAGER;
    }

    /**
     * Cek apakah user adalah Staff
     */
    public function isStaff()
    {
        return $this->role === self::ROLE_STAFF;
    }

    /**
     * Cek apakah user adalah Medical (Dokter/Tenaga Medis)
     */
    public function isMedical()
    {
        return $this->role === self::ROLE_MEDICAL;
    }

    /**
     * Cek apakah user adalah Patient
     */
    public function isPatient()
    {
        return $this->role === self::ROLE_PATIENT;
    }

    /**
     * Cek apakah user adalah Partner
     */
    public function isPartner()
    {
        return $this->role === self::ROLE_PARTNER;
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    /**
     * Relationship with Posyandu
     */
    public function posyandus()
    {
        return $this->hasMany(Posyandu::class);
    }

    /**
     * Relationship with Schedule
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Relationship with Gallery
     */
    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    /**
     * Relationship with Article
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Relationship with MedicalRecord
     */
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    /**
     * Setting default values for the user model
     */
    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->role)) {
                $user->role = self::ROLE_ADMIN;
            }

            if (is_null($user->is_active)) {
                $user->is_active = true;
            }

            if (is_null($user->verified_email)) {
                $user->verified_email = false;
            }
        });
    }
}
