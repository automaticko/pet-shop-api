<?php

namespace Tests\Unit\App\Observers;

use App\Models\Payment;
use App\Observers\PaymentObserver;
use App\Observers\UuidSetter;
use Tests\TestCase;

class PaymentObserverTest extends TestCase
{
    /** @test */
    public function it_fills_uuid_when_creating(): void
    {
        $model    = new Payment();
        $observer = new PaymentObserver(new UuidSetter());
        $observer->creating($model);

        $this->assertNotNull($model->uuid);
    }
}
