<?php

namespace App\Service;

use App\Models\Availability;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class ScheduleService
{
    public function createSchedule(mixed $validatedData)
    {
        try {

            $this->runCreateTransaction($validatedData);

            return [
                "success" => true,
                "message" => "Schedule created successfully!",
                "status" => 200,
            ];
        } catch (Throwable $th) {

            Log::error("Schedule create failed: {$th->getMessage()}");

            return [
                "success" => false,
                "message" => "An error occurred while creating the schedule. Please try again.",
                "status" => 500,
            ];
        }
    }

    public function updateSchedule(Request $request, Schedule $schedule): array
    {
        $validatedData = $request->validate([
            "service_id" => ["required", "integer", "exists:App\Models\Service,id"],
            "date" => ["required", "date_format:Y-m-d"],
            "time" => ["required", "date_format:H:i:s"],
        ]);

        $cancelLimitTime = (int) env("CANCEL_MINUTES_BEFORE", 30);
        $scheduleDateTime = Carbon::createFromFormat("Y-m-d H:i:s", "{$validatedData['date']} {$validatedData['time']}", config("app.timezone"));
        $now = Carbon::now(config("app.timezone"));

        if ($now->diffInMinutes($scheduleDateTime, false) < $cancelLimitTime) {
            return [
                "success" => false,
                "message" => "Cannot update schedule. Cancellation time limit exceeded!",
                "status" => 422,
            ];
        }

        try {

            $this->runTransaction($schedule, $validatedData);

            return [
                "success" => true,
                "message" => "Schedule updated successfully!",
                "status" => 200,
            ];
        } catch (Throwable $th) {
            Log::error("Schedule update failed: {$th->getMessage()}");

            return [
                "success" => false,
                "message" => "An error occurred while updating the schedule. Please try again.",
                "status" => 500,
            ];
        }
    }

    public function updateOnlyStatus(Request $request, Schedule $schedule): array
    {
        $validator = Validator::make($request->all(), [
            "status" => ["required", "string", Rule::in(["success", "absent"])]
        ]);

        if ($validator->fails()) {
            return [
                "success" => false,
                "message" => $validator->errors()->first("status"),
                "status" => 422,
            ];
        }

        if ($schedule->status !== "pending") {
            return [
                "success" => false,
                "message" => "Only pending schedules can have their status updated!",
                "status" => 403,
            ];
        }

        $validatedData = $validator->validated();

        $scheduleDateTime = Carbon::createFromFormat("Y-m-d H:i:s", "{$schedule->date} {$schedule->time}", config("app.timezone"))->addMinutes(15);
        $now = Carbon::now(config("app.timezone"));

        $message = $this->formatterTime($scheduleDateTime);

        if ($now->lessThanOrEqualTo($scheduleDateTime)) {
            return [
                "success" => false,
                "message" => "Update not allowed. You can try again on {$message}, 15 minutes after the scheduled time!",
                "status" => 403,
            ];
        }

        try {

            $schedule->update($validatedData);

            return [
                "success" => true,
                "message" => "Schedule's status updated successfully!",
                "status" => 200,
            ];
        } catch (Throwable $th) {

            Log::error("Failed to update schedule status due to a server error '{$th->getMessage()}'");

            return [
                "success" => false,
                "message" => "Failed to update schedule status due to a server error!",
                "status" => 500,
            ];
        }
    }

    private function formatterTime(Carbon $scheduleDateTime): string
    {
        Carbon::setLocale("en");
        return $scheduleDateTime->isoFormat("dddd [at] h:mm A");
    }

    private function toggleAvailabilityStatus(Availability $availability): void
    {
        $availability->status = ($availability->status === "available") ? "unavailable" : "available";
        $availability->save();
    }

    private function runTransaction(Schedule $schedule, array $validatedData): bool
    {
        return DB::transaction(function () use ($schedule, $validatedData): bool {
            // 1. Reverter o status da disponibilidade ANTIGA
            $oldAvailability = Availability::where("schedule_date", $schedule->date)
                ->where("schedule_time", $schedule->time)
                ->firstOrFail(); // Usa firstOrFail para garantir que exista

            $this->toggleAvailabilityStatus($oldAvailability);

            // 2. Definir o status da disponibilidade NOVA
            $newAvailability = Availability::where("schedule_date", $validatedData['date'])
                ->where("schedule_time", $validatedData['time'])
                ->firstOrFail(); // Usa firstOrFail para garantir que exista

            $this->toggleAvailabilityStatus($newAvailability);

            // 3. Atualizar o agendamento
            $updateData = array_merge($validatedData, [
                'updated_at' => Carbon::now(config('app.timezone')),
            ]);

            $schedule->update($updateData);

            return true;
        });
    }

    private function runCreateTransaction(mixed $validatedData)
    {
        return DB::transaction(function () use ($validatedData): bool {

            Schedule::create([
                "user_id" => $validatedData["user_id"],
                "service_id" => $validatedData["service_id"],
                "payment_id" => $validatedData["payment_id"],
                "date" => $validatedData["date"],
                "time" => $validatedData["time"],
                "status" => "pending",
                "updated_at" => null,
            ]);

            $newAvailability = Availability::where("schedule_date", $validatedData["date"])->where("schedule_time", $validatedData["time"])->firstOrFail();
            $this->toggleAvailabilityStatus($newAvailability);

            return true;
        });
    }
}
