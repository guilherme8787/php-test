<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'conference' => $this->faker->randomElement(['East', 'West']),
            'division' => $this->faker->randomElement(['Atlantic', 'Central', 'Southeast', 'Northwest', 'Pacific', 'Southwest']),
            'city' => $this->faker->city,
            'name' => $this->faker->word,
            'full_name' => $this->faker->city . ' ' . $this->faker->word,
            'abbreviation' => strtoupper($this->faker->lexify('???')),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
