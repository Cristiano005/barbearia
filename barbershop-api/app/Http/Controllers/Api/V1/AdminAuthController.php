<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class AdminAuthController extends AuthController
{
    public function authenticateAdmin(Request $request): JsonResponse
    {
        $response = Parent::authenticate($request);

        if ($response->getData()->success === true && !Gate::allows("signin-with-admin")) {
            return response()->json([
                "success" => false,
                "message" => "Unauthorized",
            ])->setStatusCode(403);
        }

        return $response;
    }
}