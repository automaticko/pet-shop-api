<?php

namespace Database\Factories;

use App\Models\OrderStatus;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'         => User::factory(),
            'order_status_id' => OrderStatus::factory(),
            'payment_id'      => Payment::factory(),
            'uuid'            => $this->faker->unique()->uuid,
            'products'        => '{}',
            'address'         => '{}',
            'amount'          => rand(1000, 99999),
        ];
    }

    public function usingUser(User $user): self
    {
        return $this->state(fn() => ['user_id' => $user]);
    }

    public function usingOrderStatus(OrderStatus $orderStatus): self
    {
        return $this->state(fn() => ['order_status_id' => $orderStatus]);
    }

    public function usingPayment(Payment $payment): self
    {
        return $this->state(fn() => ['payment_id' => $payment]);
    }
}
