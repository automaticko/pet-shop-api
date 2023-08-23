<?php

namespace Tests\Unit\App\Models;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    /** @test */
    public function it_defines_an_orders_relation(): void
    {
        $model    = new Payment();
        $relation = $model->order();

        $this->assertInstanceOf(HasOne::class, $relation);
        $this->assertInstanceOf(Order::class, $relation->getRelated());
        $this->assertSame('id', $relation->getLocalKeyName());
        $this->assertSame('payment_id', $relation->getForeignKeyName());
    }
}
