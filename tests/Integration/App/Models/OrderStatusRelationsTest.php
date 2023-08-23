<?php

namespace Integration\App\Models;

use App\Models\OrderStatus;
use App\Models\Order;
use Tests\Integration\App\Models\RelationsTestCase;

class OrderStatusRelationsTest extends RelationsTestCase
{
    /** @test */
    public function it_has_orders(): void
    {
        $model = OrderStatus::factory()->create();
        Order::factory()->usingOrderStatus($model)->count(parent::COUNT)->create();

        $related = $model->orders()->get();

        $this->assertCorrectRelation($related, Order::class);
    }
}
