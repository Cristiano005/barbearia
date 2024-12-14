<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "service_id" => ["required", "integer", "exists:App\Models\Service,id"],
            "payment_id" => ["required", "integer", "exists:App\Models\PaymentTypes,id"],
            "date" => ["required", "date_format:d/m/Y"],
            "time" => ["required", "date_format:H:i:s"],
        ]);

        $schedule = Schedule::create([
            "user_id" => Auth::id(),
            "service_id" => $validatedData["service_id"],
            "payment_id" => $validatedData["payment_id"],
            "date" => Carbon::createFromFormat("d/m/Y", $validatedData["date"])->format("Y-m-d"),
            "time" => $validatedData["time"],
            "status" => "success",
        ]);

        if ($schedule) {
            return response()->json([
                "success" => true,
                "message" => "Schedule created successfully"
            ])->setStatusCode(200);
        }

        return response()->json([
            "success" => false,
            "message" => "Occurred failed"
        ])->setStatusCode(500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
