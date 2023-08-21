<?php

namespace Tests\Unit\App\Observers;

use App\Models\Product;
use App\Observers\ProductObserver;
use App\Observers\UuidSetter;
use Tests\TestCase;

class ProductObserverTest extends TestCase
{
    /** @test */
    public function it_fills_uuid_when_creating(): void
    {
        $model    = new Product();
        $observer = new ProductObserver(new UuidSetter());
        $observer->creating($model);

        $this->assertNotNull($model->uuid);
    }
}
