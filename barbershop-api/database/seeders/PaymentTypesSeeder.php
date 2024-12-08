<?php

namespace Database\Seeders;

use App\Models\PaymentTypes;
use Database\Factories\PaymentTypesFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentTypesSeeder extends Seeder
{
    public function run(): void
    {
        PaymentTypes::factory(
            count(
                PaymentTypesFactory::getAllPaymentTypes()
            )
        )->create();
    }
}
