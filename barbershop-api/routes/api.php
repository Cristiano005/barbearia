<?php

use App\Http\Controllers\Api\V1\AdminAuthController;
use App\Http\Controllers\Api\V1\ServiceController;
use App\Http\Controllers\Api\V1\UserAuthController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth:sanctum")->apiResource(
    'services',
    ServiceController::class,
);

Route::prefix("/auth")->controller(UserAuthController::class)->group(function () {
    Route::get("/check", "check");
    Route::get("/logout", "logout");
    Route::post("/authenticate", "authenticate");
});

Route::prefix("/auth/admin")->controller(AdminAuthController::class)->group(function () {
    Route::get("/check", "check");
    Route::get("/logout", "logout");
    Route::post("/authenticate", "authenticateAdmin");
});