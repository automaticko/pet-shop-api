<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $creditCardPayment     = Payment::factory()->typeCreditCard()->create();
        $cashOnDeliveryPayment = Payment::factory()->typeCashOnDelivery()->create();
        $bankTransfer          = Payment::factory()->typeBankTransfer()->create();

        Order::factory()->usingPayment($creditCardPayment)->create();
        Order::factory()->usingPayment($cashOnDeliveryPayment)->create();
        Order::factory()->usingPayment($bankTransfer)->create();
    }
}
