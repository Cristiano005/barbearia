<?php

use App\Http\Controllers\Api\V1\AvailabilityController;
use App\Http\Controllers\Api\V1\AdminAuthController;
use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\Api\V1\ServiceController;
use App\Http\Controllers\Api\V1\UserAuthController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth:sanctum")->apiResource(
    'services',
    ServiceController::class,
);

Route::middleware("auth:sanctum")->apiResource(
    'payments',
    PaymentController::class,
);

Route::middleware("auth:sanctum")->apiResource("availabilities", AvailabilityController::class);

Route::prefix("/auth")->controller(UserAuthController::class)->group(function () {
    Route::get("/check", "check");
    Route::get("/logout", "logout");
    Route::post("/authenticate", "authenticate");
    Route::post("/register", "register");
});

Route::prefix("/auth/admin")->controller(AdminAuthController::class)->group(function () {
    Route::get("/check", "check");
    Route::get("/logout", "logout");
    Route::post("/authenticate", "authenticateAdmin");
});