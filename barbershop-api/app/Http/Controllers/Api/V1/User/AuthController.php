<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function authenticate(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            "email" => ["required", "email", "exists:users,email"], 
            "password" => ["required", "min:8"],
        ]);

        if (!Auth::attempt($validatedData)) {
            return response()->json([
                "success" => false,
                "message" => "Email or Password are invalid!",
            ])->setStatusCode(401);
        }

        $request->session()->regenerate();

        return response()->json([
            "success" => true,
            "message" => "User authenticated successfully",
        ])->setStatusCode(200);
    }

    public function check(): JsonResponse
    {
        $isAuthenticated = Auth::check();
        return response()->json([
            "authenticated" => $isAuthenticated,
        ])->setStatusCode(200);
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

    public function register(Request $request)
    {

        $validatedData = $request->validate([
            "name" => ["required", "regex:/^[a-zA-Zà-ÿÀ-ÿ' -]{2,50}$/", "unique:App\Models\User,name"],
            "email" => ["required", "email", "unique:App\Models\User,email"],
            "password" => ["required", "min:8"],
        ]);

        $user = User::create([
            "name" => $validatedData["name"],
            "email" => $validatedData["email"],
            "password" => Hash::make($validatedData["password"]),
        ]);

        if ($user) {
            return response()->json([
                "success" => true,
                "message" => "User created successfully"
            ])->setStatusCode(200);
        }

        return response()->json([
            "success" => false,
            "message" => "Occurred failed"
        ])->setStatusCode(500);
    }
}
