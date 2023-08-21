<?php

namespace Tests\Unit\App\Observers;

use App\Models\Category;
use App\Observers\CategoryObserver;
use App\Observers\UuidSetter;
use Tests\TestCase;

class CategoryObserverTest extends TestCase
{
    /** @test */
    public function it_fills_uuid_when_creating(): void
    {
        $model    = new Category();
        $observer = new CategoryObserver(new UuidSetter());
        $observer->creating($model);

        $this->assertNotNull($model->uuid);
    }
}
