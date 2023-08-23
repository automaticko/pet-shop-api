<?php

namespace Tests\Unit\App\Models;

use App\Models\orderStatus;
use App\Models\Order;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class OrderStatusTest extends TestCase
{
    /** @test */
    public function it_defines_a_orders_relation(): void
    {
        $model    = new OrderStatus();
        $relation = $model->orders();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertInstanceOf(Order::class, $relation->getRelated());
        $this->assertSame('id', $relation->getLocalKeyName());
        $this->assertSame('order_status_id', $relation->getForeignKeyName());
    }
}
