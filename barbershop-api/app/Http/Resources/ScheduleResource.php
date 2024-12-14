<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
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
    }
}
