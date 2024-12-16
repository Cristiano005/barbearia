<?php

namespace Database\Factories;

use App\Models\PaymentTypes;
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
            "payment_id" => PaymentTypes::inRandomOrder()->first()->id,
            "date" => "2024-12-25",
            "time" => "12:00:00",
            "status" => $this->faker->randomElement(
                ["success", "absent", "cancelled"]
            ),
        ];
    }
}
