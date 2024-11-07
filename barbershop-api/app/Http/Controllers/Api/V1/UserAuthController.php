<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends AuthController
{
    public function authenticate(Request $request): JsonResponse
    {
        $response = Parent::authenticate($request);

        if ($response->getData()->success === true && Gate::allows("signin-with-admin")) {
            return response()->json([
                "success" => false,
                "message" => "Unauthorized",
            ])->setStatusCode(403);
        }

        return $response;
    }

    public function register(Request $request) {

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

         if($user) {
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