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

        $totalOfScheduleInPeriod = Schedule::with(["service", "payment"])->whereBetween("date", [
            $validatedData["startDate"],
            $validatedData["endDate"],
        ])->get();

        $totalOfRevenue = $this->getTotalOfRevenue($totalOfScheduleInPeriod);
        $totalOfWorkedHours = $this->getWorkedHours($totalOfScheduleInPeriod);
        $allCustomersRegisteredInThisPeriod = $this->getNewCustomers($validatedData["startDate"], $validatedData["endDate"]);
        $totalOfPaymentTypes = $this->getTypesOfPayments($totalOfScheduleInPeriod);

        return response()->json([
            "success" => true,
            "data" => [
                "total_of_revenue" => $totalOfRevenue,
                "total_of_schedules_in_period" => $totalOfScheduleInPeriod->count(),
                "total_of_worked_hours" => $totalOfWorkedHours,
                "total_of_registered_customers" => $allCustomersRegisteredInThisPeriod,
                "total_of_payment_types" => $totalOfPaymentTypes,
            ]
        ]);
    }

    private function getTotalOfRevenue($period): string {

        $totalOfRevenue = 0;

        if($period->count() > 0) {
            foreach($period as $schedule) {
                $totalOfRevenue += $schedule->service->price;
            }
        }

        return number_format($totalOfRevenue, 2, ",", ".");
    }

    private function getWorkedHours($period): string {
        $carbonInstanceForConvertMinutesToTime = Carbon::createFromTime(0, $period->count() * 30);
        return $carbonInstanceForConvertMinutesToTime->format("H\h:i\m");
    }

    private function getNewCustomers($startDate, $endDate): int {
        return User::all()->where("is_admin", 0)->whereBetween("created_at", [
            $startDate,
            $endDate,
        ])->count(); 
    }

    private function getTypesOfPayments($period): array {

        $quantityOfPaymentsRealized = [
            "Credit Card" => 0,
            "Debit Card" => 0,
            "Pix" => 0,
            "Money" => 0,
        ];

        foreach($period as $paymentType) {
            $quantityOfPaymentsRealized[$paymentType->payment->payment_type] += 1;
        }

        return $quantityOfPaymentsRealized;
    }
}