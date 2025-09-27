<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TinkeringModule>
 */
class TinkeringModuleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $moduleName = $this->faker->randomElement(['Tinkering Electro Basics', 'Tinkering Programming', 'Tinkering Robotics']);
        
        return [
            'module_name' => $moduleName,
            'slug' => \Illuminate\Support\Str::slug($moduleName),
            'description' => $this->faker->paragraph(3),
            'focus_area' => $this->faker->randomElement(['Electronics', 'Programming', 'Robotics', 'Mechanics']),
            'suggested_age_group' => $this->faker->randomElement(['8-12 years', '10-14 years', '12-16 years']),
            'duration' => $this->faker->randomElement(['4-6 weeks', '6-8 weeks', '8-10 weeks']),
            'key_skills' => $this->faker->randomElements(['Problem Solving', 'Creativity', 'Logic', 'Teamwork', 'Critical Thinking'], 3),
            'is_active' => true,
            'created_by' => User::factory(),
        ];
    }
}
