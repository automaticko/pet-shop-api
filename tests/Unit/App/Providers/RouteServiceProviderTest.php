<?php

namespace Tests\Unit\App\Providers;

use App\Http\Middleware\RespondsJSON;
use App\Providers\RouteServiceProvider;
use Illuminate\Container\Container;
use Illuminate\Routing\Route;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Tests\TestCase;

class RouteServiceProviderTest extends TestCase
{
    /** @test */
    public function it_add_returns_json_middleware_to_api_routes(): void
    {
        /** @var \Illuminate\Foundation\Application $app */
        $app = Container::getInstance();

        $serviceProvider = new RouteServiceProvider($app);

        $apiRoutes = Collection::make($serviceProvider->getRoutes()->getRoutes())->filter(function(Route $route) {
            return Str::startsWith($route->uri(), 'api');
        });

        $apiRoutes->each(function(Route $route) {
            $this->assertTrue(Collection::make($route->gatherMiddleware())->contains(RespondsJSON::class));
        });
    }
}
