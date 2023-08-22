<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid'    => $this->faker->unique()->uuid,
            'type'    => Payment::TYPE_CREDIT_CAR,
            'details' => '{}',
        ];
    }

    public function typeCreditCard(): self
    {
        return $this->state(fn() => ['type' => Payment::TYPE_CREDIT_CAR]);
    }

    public function typeBankTransfer(): self
    {
        return $this->state(fn() => ['type' => Payment::TYPE_BANK_TRANSFER]);
    }

    public function typeCashOnDelivery(): self
    {
        return $this->state(fn() => ['type' => Payment::TYPE_CASH_ON_DELIVERY]);
    }
}
