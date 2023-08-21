<?php

namespace Tests\Unit\App\Observers;

use App\Models\File;
use App\Observers\FileObserver;
use App\Observers\UuidSetter;
use Tests\TestCase;

class FileObserverTest extends TestCase
{
    /** @test */
    public function it_fills_uuid_when_creating(): void
    {
        $model    = new File();
        $observer = new FileObserver(new UuidSetter());
        $observer->creating($model);

        $this->assertNotNull($model->uuid);
    }
}
