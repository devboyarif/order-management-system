<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->value('id'),
            'order_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'subtotal' => $this->faker->numberBetween(100, 10000),
            'taxes' => config('app.orders.taxes'),
            'total' => $this->faker->numberBetween(100, 10000),
        ];
    }
}
