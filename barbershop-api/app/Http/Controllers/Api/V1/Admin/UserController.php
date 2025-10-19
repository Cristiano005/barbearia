<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index() {
        return response()->json([
            "data" => User::all(["id", "name", "email"]),
            "status" => 200,
        ], 200);
    }
}
