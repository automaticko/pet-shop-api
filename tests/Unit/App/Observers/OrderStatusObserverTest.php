<?php

namespace Tests\Unit\App\Observers;

use App\Models\OrderStatus;
use App\Observers\OrderStatusObserver;
use App\Observers\UuidSetter;
use Tests\TestCase;

class OrderStatusObserverTest extends TestCase
{
    /** @test */
    public function it_fills_uuid_when_creating(): void
    {
        $model    = new OrderStatus();
        $observer = new OrderStatusObserver(new UuidSetter());
        $observer->creating($model);

        $this->assertNotNull($model->uuid);
    }
}
