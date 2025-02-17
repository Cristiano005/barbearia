<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {
        return ServiceResource::collection(Service::paginate(6));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            "name" => "required",
            "price" => "required"
        ]);

        $update = Service::find($id)->update($validatedData);

        if($update) {
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
