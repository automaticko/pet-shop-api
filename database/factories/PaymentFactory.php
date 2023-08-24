<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\User;
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
            'user_id' => User::factory(),
            'uuid'    => $this->faker->unique()->uuid,
            'type'    => Payment::TYPE_CREDIT_CARD,
            'details' => '{}',
        ];
    }

    public function usingUser(User $user): self
    {
        return $this->state(fn() => ['user_id' => $user]);
    }

    public function typeCreditCard(): self
    {
        return $this->state(fn() => ['type' => Payment::TYPE_CREDIT_CARD]);
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
