<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\AvailabilityResource;
use App\Models\Availability;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function index(Request $request) {

        $validated = $request->validate([
            "date" => ["required", "date"],
        ]);

        return AvailabilityResource::collection(Availability::where("schedule_date", $validated["date"])->paginate());
    }
}
