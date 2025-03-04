<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getSomeData(Request $request) {

        $validatedData = $request->validate([
            "startDate" => "required|date_format:Y-m-d|before:endDate",
            "endDate" => "required|date_format:Y-m-d|after:startDate",
        ]);

        $totalOfScheduleInPeriod = Schedule::with("service")->whereBetween("date", [
            $validatedData["startDate"],
            $validatedData["endDate"],
        ])->get();

        $totalOfRevenue = 0;

        if($totalOfScheduleInPeriod->count() > 0) {
            foreach($totalOfScheduleInPeriod as $schedule) {
                $totalOfRevenue += $schedule->service->price;
            }
        }

        $carbonInstanceForConvertMinutesToTime = Carbon::createFromTime(0, $totalOfScheduleInPeriod->count() * 30);
        $totalOfWorkedHours = $carbonInstanceForConvertMinutesToTime->format("H\h:i\m");

        $allCustomersRegisteredInThisPeriod = User::all()->where("is_admin", 0)->whereBetween("created_at", [
            $validatedData["startDate"],
            $validatedData["endDate"],
        ])->count(); 

        return response()->json([
            "success" => true,
            "data" => [
                "total_of_revenue" => $totalOfRevenue,
                "total_of_schedules_in_period" => $totalOfScheduleInPeriod->count(),
                "total_of_worked_hours" => $totalOfWorkedHours,
                "total_of_registered_customers" => $allCustomersRegisteredInThisPeriod,
            ]
        ]);
    }
}