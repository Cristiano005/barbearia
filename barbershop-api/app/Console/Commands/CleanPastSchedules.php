<?php

namespace App\Console\Commands;

use App\Models\Availability;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CleanPastSchedules extends Command
{
    protected $signature = "schedules:clean";
    protected $description = "Clean past schedules";

    public function handle()
    {
        $today = Carbon::today()->format("Y-m-d");
        Availability::where("schedule_date", "<", $today)->delete();
    }
}
