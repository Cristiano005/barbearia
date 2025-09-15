<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTypes extends Model
{
    const TYPE_CREDIT_CARD = 'Credit Card';
    const TYPE_DEBIT_CARD = 'Debit Card';
    const TYPE_PIX = 'Pix';
    const TYPE_MONEY = 'Money';

    use HasFactory;

    public static function allTypes(): array {
        return [
            self::TYPE_CREDIT_CARD,
            self::TYPE_DEBIT_CARD,
            self::TYPE_PIX,
            self::TYPE_MONEY,
        ];
    }
}
