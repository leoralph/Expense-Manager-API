<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => fake()->sentence(),
            'value' => fake()->randomFloat(2, 0, 1000),
            'date' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'user_id' => 11
        ];
    }
}
