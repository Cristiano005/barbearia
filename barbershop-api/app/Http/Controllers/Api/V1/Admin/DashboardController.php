<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentTypes;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getDashboardMetrics(Request $request)
    {
        $validatedData = $request->validate([
            "startDate" => "required|date_format:Y-m-d|before:endDate",
            "endDate" => "required|date_format:Y-m-d|after:startDate",
        ]);

        $schedulesInPeriod = Schedule::with(["service", "payment"])->whereBetween("date", [
            $validatedData["startDate"],
            $validatedData["endDate"],
        ])->get();

        return response()->json([
            "success" => true,
            "data" => [
                "monthly_revenue" => $this->getYearlyMonthlyRevenue(),
                "period_revenue" => $this->getRevenueByPeriod($schedulesInPeriod),
                "schedule_count" => $schedulesInPeriod->count(),
                "worked_time" => $this->getTotalWorkedTimeFromSchedules($schedulesInPeriod),
                "new_customers" => $this->getRegisteredCustomersInPeriod($validatedData["startDate"], $validatedData["endDate"]),
                "payment_type_counts" => $this->getPaymentTypeCounts($schedulesInPeriod),
                "status_counts" => $this->getScheduleStatusCounts($schedulesInPeriod),
            ],
        ]);
    }

    private function getYearlyMonthlyRevenue(): array
    {

        $defaultValues = array_fill(0, 12, 0);

        $availableMonths = (new Schedule())->getAllRevenueOfYear();

        foreach ($availableMonths as $availableMonth) {
            $index = $availableMonth->month - 1;
            $defaultValues[$index] = (float) $availableMonth->total;
        }

        return $defaultValues;
    }

    private function getRevenueByPeriod(Collection $schedulesInPeriod): float
    {
        $total = 0;

        foreach ($schedulesInPeriod as $schedule) {
            if ($schedule->status === "success") {
                $total += $schedule->service->price;
            }
        }

        return $total;
    }

    private function getTotalWorkedTimeFromSchedules(Collection $schedules): string
    {
        $workedCount = $schedules->where("status", "success")->count();
        $totalMinutes = $workedCount * 30;

        $carbonTime = Carbon::createFromTime(0, $totalMinutes);
        return $carbonTime->format("H\h:i\m");
    }

    private function getRegisteredCustomersInPeriod($startDate, $endDate): int
    {
        return User::where("is_admin", 0)->whereBetween("created_at", [
            $startDate,
            $endDate,
        ])->count();
    }

    private function getPaymentTypeCounts(Collection $schedulesInPeriod): array
    {
        $paymentTypes = PaymentTypes::allTypes();
        $counts = array_fill_keys($paymentTypes, 0);

        foreach ($schedulesInPeriod as $schedule) {
            if ($schedule->status === "success") {
                $counts[$schedule->payment->payment_type] += 1;
            }
        }

        return $counts;
    }

    private function getScheduleStatusCounts(Collection $schedulesInPeriod)
    {
        $statuses = Schedule::allStatuses();
        return collect($statuses)->map(function ($status) use ($schedulesInPeriod) {
            return $schedulesInPeriod->where("status", $status)->count();
        })->toArray();
    }
}
