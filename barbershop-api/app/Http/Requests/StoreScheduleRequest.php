<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "service_id" => ["required", "integer", "exists:App\Models\Service,id"],
            "payment_id" => ["required", "integer", "exists:App\Models\PaymentTypes,id"],
            "date" => ["required", "date_format:d/m/Y"],
            "time" => ["required", "date_format:H:i:s"],
        ];
    }
}
