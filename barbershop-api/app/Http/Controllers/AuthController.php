<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

abstract class AuthController extends Controller
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
