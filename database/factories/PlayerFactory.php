<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Conta>
 */
class PlayerFactory extends Factory
{
    protected $model = Player::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'position' => $this->faker->randomElement(['G', 'F', 'C']),
            'height' => $this->faker->randomElement(['6-1', '6-2', '6-3', '6-4', '7-0']),
            'weight' => $this->faker->numberBetween(180, 250),
            'jersey_number' => $this->faker->numberBetween(1, 99),
            'college' => $this->faker->optional()->word,
            'country' => $this->faker->country,
            'draft_year' => $this->faker->optional()->year,
            'draft_round' => $this->faker->optional()->numberBetween(1, 2),
            'draft_number' => $this->faker->optional()->numberBetween(1, 60),
            'team_id' => Team::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
