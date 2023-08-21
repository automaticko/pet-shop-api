<?php

namespace Tests\Unit\App\Observers;

use App\Models\User;
use App\Observers\UserObserver;
use App\Observers\UuidSetter;
use Tests\TestCase;

class UserObserverTest extends TestCase
{
    /** @test */
    public function it_fills_uuid_when_creating(): void
    {
        $model    = new User();
        $observer = new UserObserver(new UuidSetter());
        $observer->creating($model);

        $this->assertNotNull($model->uuid);
    }
}
