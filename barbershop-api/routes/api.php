<?php

use App\Http\Controllers\Api\V1\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Api\V1\Admin\ScheduleController as AdminScheduleController;
use App\Http\Controllers\Api\V1\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Api\V1\User\AvailabilityController;
use App\Http\Controllers\Api\V1\User\PaymentController;
use App\Http\Controllers\Api\V1\User\ScheduleController;
use App\Http\Controllers\Api\V1\User\ServiceController;
use App\Http\Controllers\Api\V1\User\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth:sanctum")->apiResource(
    'services',
    ServiceController::class,
);

Route::middleware("auth:sanctum")->apiResource(
    'payments',
    PaymentController::class,
);

Route::middleware("auth:sanctum")->apiResource(
    'schedules',
    ScheduleController::class,
);

Route::middleware("auth:sanctum")->apiResource("availabilities", AvailabilityController::class);

Route::prefix("/auth")->controller(AuthController::class)->group(function () {
    Route::get("/check", "check");
    Route::get("/logout", "logout");
    Route::post("/authenticate", "authenticate");
    Route::post("/register", "register");
});

Route::prefix("/auth/admin")->controller(AdminAuthController::class)->group(function () {
    Route::get("/check", "check");
    Route::get("/logout", "logout");
    Route::post("/authenticate", "authenticate");
});

Route::middleware(["auth:sanctum", "admin"])->prefix("admin")->group(function () {
    Route::apiResource("schedules", AdminScheduleController::class);
    Route::apiResource("services", AdminServiceController::class);
});