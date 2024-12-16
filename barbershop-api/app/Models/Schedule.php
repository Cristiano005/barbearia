<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ["user_id", "service_id", "payment_id", "date", "time", "status"];

    public function service() {
        return $this->belongsTo(Service::class);
    }

    public function payment() {
        return $this->belongsTo(PaymentTypes::class);
    }
}
