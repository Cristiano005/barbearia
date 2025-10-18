<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Resources\ScheduleResource;
use App\Models\Availability;
use App\Models\Schedule;
use App\Service\ScheduleService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $schedule = Schedule::where("user_id", $userId)->get();
        return ScheduleResource::collection($schedule);
    }

    public function store(StoreScheduleRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData["date"] = Carbon::createFromFormat("d/m/Y", $validatedData["date"])->format("Y-m-d");

        try {

            $result = DB::transaction(function () use ($validatedData): bool {

                Schedule::create([
                    "user_id" => Auth::id(),
                    "service_id" => $validatedData["service_id"],
                    "payment_id" => $validatedData["payment_id"],
                    "date" => $validatedData["date"],
                    "time" => $validatedData["time"],
                    "status" => "pending",
                    "updated_at" => null,
                ]);

                Availability::where("schedule_date", $validatedData["date"])->where("schedule_time", $validatedData["time"])->update([
                    "status" => "unavailable",
                ]);

                return true;
            });
        } catch (Throwable $th) {

            Log::error("Schedule creation failed: {$th->getMessage()}");

            return response()->json([
                "success" => false,
                "message" => "An error occurred while creating the schedule. Please try again."
            ])->setStatusCode(500);
        }

        if ($result) {
            return response()->json([
                "success" => true,
                "message" => "Schedule created successfully"
            ])->setStatusCode(200);
        }
    }

    public function update(Request $request, Schedule $schedule, ScheduleService $scheduleService)
    {
        $response = $scheduleService->updateSchedule($request, $schedule);
        return response()->json($response)->status($response["status"]);
    }

    public function destroy(int $id)
    {
        try {

            $result = Schedule::where("id", $id)->delete();

            if ($result) {
                return response()->json([
                    "success" => true,
                    "message" => "Schedule cancelled successfully",
                ])->setStatusCode(200);
            }
        } catch (Throwable $th) {
            Log::error("Schedule cancelled failed {$th->getMessage()}");
            return response()->json([
                "success" => false,
                "message" => "An error occurred while cancelling the schedule. Please try again.",
            ])->setStatusCode(500);
        }
    }
}
