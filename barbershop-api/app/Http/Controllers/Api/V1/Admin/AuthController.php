<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthController
{
    public function authenticate(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            "email" => ["required", "email"],
            "password" => ["required"],
        ]);

        if (!Auth::attempt($validatedData)) {
            return response()->json([
                "success" => false,
                "message" => "Email or Password are invalid",
            ])->setStatusCode(401);
        }

        $request->session()->regenerate();

        if(auth()->user()->is_admin !== 1) {
            return response()->json([
                "success" => false,
                "message" => "Unauthorized",
            ])->setStatusCode(403);
        }

        return response()->json([
            "success" => true,
            "message" => "User authenticated successfully",
        ])->setStatusCode(200);
    }

    public function check(): JsonResponse
    {
        $isAuthenticated = Auth::check();
        return response()->json($isAuthenticated);
    }

    public function logout(Request $request): JsonResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            "success" => true,
            "message" => "Logout realized successfully",
        ])->setStatusCode(200);
    }
}
