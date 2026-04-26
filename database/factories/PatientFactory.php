<?php

namespace Database\Factories;

use App\Models\Patient;
use App\Models\Posyandu;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    protected $model = Patient::class;

    public function definition(): array
    {
        return [
            'posyandu_id' => Posyandu::factory(),
            'category' => fake()->randomElement(['balita', 'ibu_hamil', 'remaja', 'lansia']),
            'parent_name' => fake()->name(),
            'id_number' => fake()->numerify('################'), // 16 digit NIK
            'full_name' => fake()->name(),
            'birth_date' => fake()->dateTimeBetween('-60 years', '-1 month'),
            'gender' => fake()->randomElement(['M', 'F']),
            'address' => fake()->address(),
            'phone_number' => fake()->phoneNumber(),
            'profile_photo' => null,
        ];
    }

    public function balita(): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => 'balita',
            'birth_date' => fake()->dateTimeBetween('-59 months', '-1 month'),
        ]);
    }

    public function ibuHamil(): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => 'ibu_hamil',
            'gender' => 'F',
            'birth_date' => fake()->dateTimeBetween('-40 years', '-18 years'),
        ]);
    }

    public function remaja(): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => 'remaja',
            'birth_date' => fake()->dateTimeBetween('-18 years', '-10 years'),
        ]);
    }

    public function lansia(): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => 'lansia',
            'birth_date' => fake()->dateTimeBetween('-90 years', '-60 years'),
        ]);
    }
}
