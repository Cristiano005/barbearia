<?php

use App\Http\Controllers\Api\V1\ServiceController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware("auth:sanctum")->apiResource(
    'services', ServiceController::class,
);

Route::get("/auth/check", [AuthController::class, "check"]);
Route::post("/auth/login", [AuthController::class, "authenticate"]);