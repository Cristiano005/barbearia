<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ScheduleResource;
use App\Models\Availability;
use App\Models\Schedule;
use App\Service\ScheduleService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->query(), [
            "status" => ["required", Rule::in(Schedule::allStatuses())]
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422); // ensure a JSON response came back and not loop.
        }

        $validatedData = $validator->validate();
        $schedules = Schedule::where("status", $validatedData["status"])->orderByDesc("date")->orderBy("time", "asc")->paginate(5);

        return ScheduleResource::collection($schedules);
    }

    public function store(Request $request, ScheduleService $scheduleService)
    {
        $validatedData = $request->validate([
            "user_id" => ["required", "integer", "exists:App\Models\User,id"],
            "service_id" => ["required", "integer", "exists:App\Models\Service,id"],
            "payment_id" => ["required", "integer", "exists:App\Models\PaymentTypes,id"],
            "date" => ["required", "date_format:d/m/Y"],
            "time" => ["required", "date_format:H:i:s"],
        ]);

        $validatedData["date"] = Carbon::createFromFormat("d/m/Y", $validatedData["date"])->format("Y-m-d");
        $response = $scheduleService->createSchedule($validatedData);

        return response()->json($response)->setStatusCode($response["status"]);
    }

    public function update(Request $request, Schedule $schedule, ScheduleService $scheduleService)
    {
        $response = $scheduleService->updateSchedule($request, $schedule);
        return response()->json($response)->setStatusCode($response["status"]);
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
