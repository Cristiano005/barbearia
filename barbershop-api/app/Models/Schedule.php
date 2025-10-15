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

    const UPDATED_AT = null;

    const STATUS_SUCCESS = "success";
    const STATUS_PENDING = "pending";
    const STATUS_ABSENT = "absent";
    const STATUS_CANCELLED = "cancelled";

    public static function allStatuses(): array
    {
        return [
            self::STATUS_SUCCESS,
            self::STATUS_PENDING,
            self::STATUS_ABSENT,
            self::STATUS_CANCELLED,
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function payment()
    {
        return $this->belongsTo(PaymentTypes::class);
    }

    public function getAllRevenueOfYear()
    {
        return self::selectRaw('YEAR(date) as year, MONTH(date) as month, SUM(services.price) as total')
            ->join('services', 'schedules.service_id', '=', 'services.id')
            ->where('status', 'success')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
    }
}
