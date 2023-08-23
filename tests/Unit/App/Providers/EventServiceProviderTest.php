<?php

namespace Tests\Unit\App\Providers;

use App\Models\File;
use App\Models\Model;
use App\Models\User;
use App\Providers\EventServiceProvider;
use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use Tests\TestCase;

class EventServiceProviderTest extends TestCase
{
    /** @test */
    public function it_register_model_observers(): void
    {
        $eventServiceProvider = new EventServiceProvider($this->app);
        $dispatcher           = Model::getEventDispatcher();

        $withCreating = Collection::make([File::class, User::class]);
        $withCreating->each(function(string $model) use ($dispatcher) {
            $listener = "eloquent.creating: {$model}";
            $dispatcher->forget($listener);
            $this->assertFalse($dispatcher->hasListeners($listener));
        });

        $eventServiceProvider->boot();

        $withCreating->each(function(string $model) use ($dispatcher) {
            $listener = "eloquent.creating: {$model}";
            $this->assertTrue($dispatcher->hasListeners($listener));
        });
    }
}
