<?php

namespace Tests\Unit\App\Observers;

use App\Models\Order;
use App\Observers\OrderObserver;
use App\Observers\UuidSetter;
use Tests\TestCase;

class OrderObserverTest extends TestCase
{
    /** @test */
    public function it_fills_uuid_when_creating(): void
    {
        $model    = new Order();
        $observer = new OrderObserver(new UuidSetter());
        $observer->creating($model);

        $this->assertNotNull($model->uuid);
    }
}
