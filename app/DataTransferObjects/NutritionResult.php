<?php

namespace App\DataTransferObjects;

/**
 * Data Transfer Object untuk hasil perhitungan gizi antropometri.
 */
class NutritionResult
{
    public function __construct(
        public ?float $z_score,
        public string $nutrition_status,
        public ?float $z_score_hfa,
        public string $stunting_status,
        public ?float $z_score_wfh,
        public string $wasting_status,
        public ?float $z_score_bfa,
        public string $bmi_status
    ) {}

    /**
     * Konversi ke array untuk compatibility dengan Eloquent/Blade.
     */
    public function toArray(): array
    {
        return [
            'z_score' => $this->z_score,
            'nutrition_status' => $this->nutrition_status,
            'z_score_hfa' => $this->z_score_hfa,
            'stunting_status' => $this->stunting_status,
            'z_score_wfh' => $this->z_score_wfh,
            'wasting_status' => $this->wasting_status,
            'z_score_bfa' => $this->z_score_bfa,
            'bmi_status' => $this->bmi_status,
        ];
    }
}
