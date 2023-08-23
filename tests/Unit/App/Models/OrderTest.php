<?php

namespace Tests\Unit\App\Models;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;

class OrderTest extends TestCase
{
    /** @test */
    public function it_defines_a_status_relation(): void
    {
        $model    = new Order();
        $relation = $model->status();

        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertInstanceOf(OrderStatus::class, $relation->getRelated());
        $this->assertSame('id', $relation->getOwnerKeyName());
        $this->assertSame('order_status_id', $relation->getForeignKeyName());
        $this->assertSame('status', $relation->getRelationName());
    }

    /** @test */
    public function it_defines_a_payment_relation(): void
    {
        $model    = new Order();
        $relation = $model->payment();

        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertInstanceOf(Payment::class, $relation->getRelated());
        $this->assertSame('id', $relation->getOwnerKeyName());
        $this->assertSame('payment_id', $relation->getForeignKeyName());
        $this->assertSame('payment', $relation->getRelationName());
    }
}
