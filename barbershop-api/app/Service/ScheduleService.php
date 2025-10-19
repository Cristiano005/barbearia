<?php

namespace App\Service;

use App\Models\Availability;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ScheduleService
{
    public function createSchedule(mixed $validatedData) {

        try {
            
            $this->runCreateTransaction($validatedData);

            return [
                "success" => true,
                "message" => "Schedule created successfully!",
                "status" => 200,
            ];
        } 
        catch (Throwable $th) {
            
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
        return DB::transaction(function() use ($validatedData): bool {

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
