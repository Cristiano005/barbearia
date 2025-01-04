<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data = [
            "id" => $this->id,
            "service" => [
                "name" => $this->service->name,
                "price" => $this->service->price,
            ],
            "payment" => $this->payment->payment_type,
            "date" => $this->date,
            "time" => $this->time,
            "status" => $this->status,
        ];

        if ($request->user()->is_admin) {
            $data["user"] = [
                "name" => $this->user->name,
                "email" => $this->user->email,
            ];
        }

        return $data;
    }
}
