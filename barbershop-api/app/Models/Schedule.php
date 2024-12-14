<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ["user_id", "service_id", "payment_id", "date", "time", "status"];

    public function service() {
        return $this->belongsTo(Service::class);
    }

    public function payment() {
        return $this->belongsTo(PaymentTypes::class);
    }
}
