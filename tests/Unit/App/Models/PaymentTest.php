<?php

namespace Tests\Unit\App\Models;

use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    /** @test */
    public function it_defines_a_user_relation(): void
    {
        $model    = new Payment();
        $relation = $model->user();

        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertInstanceOf(User::class, $relation->getRelated());
        $this->assertSame('id', $relation->getOwnerKeyName());
        $this->assertSame('user_id', $relation->getForeignKeyName());
        $this->assertSame('user', $relation->getRelationName());
    }

    /** @test */
    public function it_defines_an_order_relation(): void
    {
        $model    = new Payment();
        $relation = $model->order();

        $this->assertInstanceOf(HasOne::class, $relation);
        $this->assertInstanceOf(Order::class, $relation->getRelated());
        $this->assertSame('id', $relation->getLocalKeyName());
        $this->assertSame('payment_id', $relation->getForeignKeyName());
    }
}
