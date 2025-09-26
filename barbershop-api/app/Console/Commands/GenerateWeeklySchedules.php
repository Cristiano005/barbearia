<?php

namespace App\Console\Commands;

use App\Models\Availability;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateWeeklySchedules extends Command
{
    protected $signature = "schedules:generate-weekly";
    protected $description = "Generate haircut schedules for the next week";

    public function handle()
    {
        $startDate = Carbon::now()->next("Monday");
        $endDate = (clone $startDate)->next("Saturday");

        $endTime = Carbon::createFromTimeString("18:00:00");

        $intervalInMinutes = 30;

        Availability::query()->delete();

        for ($startDate; $startDate->lte($endDate); $startDate->addDay(1)) {

            $startTime = Carbon::createFromTimeString("08:00:00");

            for ($startTime; $startTime->lt($endTime); $startTime->addMinute($intervalInMinutes)) {

                Availability::create([
                    "schedule_date" => $startDate,
                    "schedule_time" => $startTime,
                    "status" => "available",
                    "created_at" => now(),
                    "updated_at" => null,
                ]);

            }
        }
    }
}
