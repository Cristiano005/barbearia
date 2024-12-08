<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Availability>
 */
class AvailabilityFactory extends Factory
{
    private $allowedTimes = [
        "8:30", "9:00", "9:30", "10:00", "10:30", "11:00", "11:30", "17:00", "17:30", "18:00"
    ];

    public function definition(): array
    {
        return [
            "schedule_date" => $this->faker->dateTimeBetween("2024-12-04", "2024-12-31")->format("Y-m-d"),
            "schedule_time" => $this->faker->unique()->randomElement($this->allowedTimes),
        ];
    }
}
