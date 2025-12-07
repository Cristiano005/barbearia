<?php

namespace Database\Factories;

use App\Models\Availability;
use App\Models\PaymentTypes;
use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    public function definition(): array
    {
        $availability = Availability::where("status", "available")->inRandomOrder()->first();

        if (!$availability) {
            $availabilityDate = now()->addDay()->format("Y-m-d");
            $availabilityTime = "08:00:00";
        } else {
            $availabilityDate = $availability->schedule_date;
            $availabilityTime = $availability->schedule_time;
        }

        return [
            "user_id" => User::inRandomOrder()->first()->id,
            "service_id" => Service::inRandomOrder()->first()->id,
            "payment_id" => PaymentTypes::inRandomOrder()->first()->id,
            "date" => $availabilityDate,
            "time" => $availabilityTime,
            "status" => $this->faker->randomElement(
                ["success", "absent", "cancelled"]
            ),
        ];
    }
}
