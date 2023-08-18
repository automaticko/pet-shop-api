<?php

namespace Tests\Unit\Routes;

use Illuminate\Routing\Route;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait CanFetchApiV1Routes
{
    private function apiV1Routes(): Collection
    {
        $routes = Collection::make(\Route::getRoutes()->getRoutes());

        return $routes->filter(function(Route $route) {
            return Str::startsWith($route->uri(), 'api/v1');
        });
    }
}
