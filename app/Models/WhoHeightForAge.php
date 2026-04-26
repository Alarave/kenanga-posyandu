<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk data referensi WHO Height-for-Age (TB/U)
 * Digunakan untuk mendeteksi stunting pada balita 0-60 bulan.
 */
class WhoHeightForAge extends Model
{
    protected $table = 'who_height_for_age';
    public $timestamps = false;

    protected $fillable = [
        'gender', 'age_months',
        'l_value', 'm_value', 's_value',
        'sd_minus3', 'sd_minus2', 'sd_plus2', 'sd_plus3',
    ];

    protected $casts = [
        'age_months' => 'integer',
        'l_value'    => 'float',
        'm_value'    => 'float',
        's_value'    => 'float',
        'sd_minus3'  => 'float',
        'sd_minus2'  => 'float',
        'sd_plus2'   => 'float',
        'sd_plus3'   => 'float',
    ];

    /**
     * Dapatkan referensi LMS untuk gender dan usia tertentu.
     *
     * @param string $gender 'M' atau 'F'
     * @param int $ageMonths Usia dalam bulan (0-60)
     */
    public static function getReference(string $gender, int $ageMonths): ?self
    {
        return self::where('gender', $gender)
            ->where('age_months', min($ageMonths, 60))
            ->first();
    }
}
