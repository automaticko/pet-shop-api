<?php

namespace Integration\App\Models;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Payment;
use App\Models\User;
use Tests\Integration\App\Models\RelationsTestCase;

class OrderRelationsTest extends RelationsTestCase
{
    /** @test */
    public function it_belongs_to_an_user(): void
    {
        $model   = Order::factory()->create();
        $related = $model->user()->first();

        $this->assertInstanceOf(User::class, $related);
    }

    /** @test */
    public function it_belongs_to_an_order_status(): void
    {
        $model   = Order::factory()->create();
        $related = $model->status()->first();

        $this->assertInstanceOf(OrderStatus::class, $related);
    }

    /** @test */
    public function it_belongs_to_an_payment(): void
    {
        $model   = Order::factory()->create();
        $related = $model->payment()->first();

        $this->assertInstanceOf(Payment::class, $related);
    }
}
