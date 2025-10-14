<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class UserController extends Controller
{
    public function me()
    {
        return response()->json([
            "data" => Auth::user(),
        ])->setStatusCode(200);
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            "name" => ["required", "string", "max:255"],
            "phone_number" => ["required", "string", "max:15"],
        ]);

        $user = Auth::user();

        if (!$user) {
            return response()->json([
                "success" => false,
                "message" => "Unauthorized!",
            ])->setStatusCode(401);
        }

        try {

            $user->update([
                "name" => $validatedData["name"],
                "phone_number" => $validatedData["phone_number"],
                "updated_at" => now(),
            ]);

            return response()->json([
                "success" => true,
                "message" => "Data updated successfully!",
            ])->setStatusCode(200);
            
        } catch (Throwable $th) {

            Log::error("User update failed: {$th->getMessage()}");

            return response()->json([
                "success" => false,
                "message" => "An error occurred while updating data!",
            ])->setStatusCode(500);
        }
    }
}
