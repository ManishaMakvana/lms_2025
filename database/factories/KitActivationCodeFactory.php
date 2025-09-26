<?php

namespace Database\Factories;

use App\Models\TinkeringModule;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KitActivationCode>
 */
class KitActivationCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $prefix = $this->faker->randomElement(['TE', 'TP', 'TR']);
        $number = $this->faker->unique()->numberBetween(1, 999999);
        
        return [
            'code' => $prefix . '-' . str_pad($number, 6, '0', STR_PAD_LEFT),
            'status' => $this->faker->randomElement(['unused', 'used', 'blocked']),
            'module_id' => TinkeringModule::factory(),
            'generated_by' => User::factory(),
            'used_by' => null,
            'used_at' => null,
        ];
    }

    /**
     * Indicate that the code is unused.
     */
    public function unused(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'unused',
            'used_by' => null,
            'used_at' => null,
        ]);
    }

    /**
     * Indicate that the code is used.
     */
    public function used(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'used',
            'used_by' => User::factory(),
            'used_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ]);
    }
}
