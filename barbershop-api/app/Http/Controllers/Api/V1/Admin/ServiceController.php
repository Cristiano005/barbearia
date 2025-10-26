<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function __construct() {}

    public function index(Request $request)
    {
        $all = filter_var($request->query('all'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        $paginate = $request->query('paginate') ?? 5;

        $validator = Validator::make(["all" => $all, "paginate" => $paginate], [
            "all" => ["nullable", "boolean:strict"],
            "paginate" => ["required", "integer:strict"],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422); // ensure a JSON response came back and not loop.
        }

        $validatedData = $validator->validate();

        if ($validatedData["all"]) {
            return ServiceResource::collection(Service::orderByDesc("id")->get());
        }

        return ServiceResource::collection(Service::orderByDesc("id")->paginate($validatedData["paginate"]));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "name" => "required|string",
            "price" => "required|numeric|max:200",
        ]);

        $insert = Service::create($validatedData);

        if ($insert) {
            return response()->json([
                "success" => true,
                "message" => "Service created successfully!",
            ])->setStatusCode(200);
        }

        return response()->json([
            "success" => false,
            "message" => "It was occured an error to the create service!",
        ])->setStatusCode(500);
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            "name" => "required|string",
            "price" => "required|numeric|max:200",
        ]);

        $update = Service::find($id)->update($validatedData);

        if ($update) {
            return response()->json([
                "success" => true,
                "message" => "Service updated successfully!",
            ])->setStatusCode(200);
        }

        return response()->json([
            "success" => false,
            "message" => "It was occured an error to the update service!",
        ])->setStatusCode(500);
    }

    public function destroy(Service $service)
    {
        $service->delete();
        
        return response()->json([
            "success" => true,
            "message" => "Service deleted successfully!"
        ])->setStatusCode(200);
    }
}
