<?php

namespace Database\Factories;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patients>
 */
class PatientsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fname' => fake()->firstname(),
            'lname' => fake()->lastname(),
            'mname' => fake()->lastname(),
            'dob' => fake()->date(),
            'region' => 'REGION 7',
            'province_id' => 2,
            'muncity_id' => 63,
            'facility_id' => 24,
            'barangay_id' => 1444,
            'proponent_id' => 1, 
            // 'amount' => fake()->randomNumber(5),
            'guaranteed_amount' => fake()->randomNumber(5),
            'actual_amount' => fake()->randomNumber(5),
            'remaining_balance' => fake()->randomNumber(5),
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
