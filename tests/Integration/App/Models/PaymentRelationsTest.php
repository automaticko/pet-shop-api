<?php

namespace Integration\App\Models;

use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Tests\Integration\App\Models\RelationsTestCase;

class PaymentRelationsTest extends RelationsTestCase
{
    /** @test */
    public function it_belongs_to_a_user(): void
    {
        $model   = Payment::factory()->create();
        $related = $model->user()->first();

        $this->assertInstanceOf(User::class, $related);
    }

    /** @test */
    public function it_has_an_order(): void
    {
        $model = Payment::factory()->create();
        Order::factory()->usingPayment($model)->create();

        $related = $model->order()->first();

        $this->assertInstanceOf(Order::class, $related);
    }
}
