<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=LoginHistory>
 */
class LoginHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'ip' => $this->faker->ipv4,
            'user_agent' => $this->faker->userAgent,
            'login_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
