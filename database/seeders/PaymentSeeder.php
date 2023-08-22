<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        Payment::factory(3)->typeCreditCard()->create();
        Payment::factory(3)->typeBankTransfer()->create();
        Payment::factory(3)->typeCashOnDelivery()->create();
    }
}
