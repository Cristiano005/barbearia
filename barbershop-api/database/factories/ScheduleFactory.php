<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    public function definition(): array
    {
        return [
            "user_id" => User::inRandomOrder()->first()->id,
            "service_id" => Service::inRandomOrder()->first()->id,
            "scheduled" => $this->faker->time(),
            "status" => $this->faker->randomElement(
                ["success", "absent", "cancelled"]
            ),
        ];
    }
}
