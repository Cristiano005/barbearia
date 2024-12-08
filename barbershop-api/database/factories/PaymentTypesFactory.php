<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentTypesFactory extends Factory
{
    private static array $paymentTypes = [
        "Credit Card", "Debit Card", "Money", "Pix"
    ];

    public function definition(): array
    {
        return [
            "payment_type" => $this->faker->unique()->randomElement(
                static::$paymentTypes
            ),
        ];
    }

    public static function getAllPaymentTypes(): array {
        return static::$paymentTypes;
    }
}
