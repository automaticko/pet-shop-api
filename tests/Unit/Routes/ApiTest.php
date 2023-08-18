<?php

namespace Tests\Unit\Routes;

use Illuminate\Routing\Route;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use CanFetchApiV1Routes;

    /**
     * @test
     *
     * @param string             $uri
     * @param array<int, string> $methods
     *
     * @dataProvider routesProvider
     */
    public function intended_routes_should_be_registered(string $uri, array $methods): void
    {
        $fullUri   = "api/v1/{$uri}";
        $apiRoutes = $this->apiV1Routes()->filter(function(Route $route) use ($fullUri) {
            return $route->uri() == $fullUri;
        });
        $this->assertNotEmpty($apiRoutes, "Route {$fullUri} does not exist");

        $routeMethods = Collection::make($apiRoutes->first()->methods());
        foreach ($methods as $method) {
            $this->assertTrue($routeMethods->contains($method), "Path: {$fullUri}. Method $method does not exist.");
        }
    }

    /**
     * @return array<int|string, array<int, mixed>>
     */
    public static function routesProvider(): array
    {
        return self::definedRoutes()->map(fn(Collection $methods, string $uri) => [
            $uri,
            $methods->toArray(),
        ])->values()->toArray();
    }

    /** @test */
    public function registered_routes_should_be_tested(): void
    {
        $apiV1Routes   = $this->apiV1Routes();
        $definedRoutes = $this->definedRoutes();
        $apiV1Routes->each(function(Route $route) use ($definedRoutes) {
            $uri = Str::substr($route->uri(), Str::length('api/v1/'));

            $this->assertTrue($definedRoutes->has($uri), "Failed asserting that api/v1/{$uri} is tested.");

            $methods = Collection::make($route->methods())->filter(fn(string $method) => 'HEAD' !== $method);

            /** @var \Illuminate\Support\Collection<string, \Illuminate\Support\Collection<int, string>> $definedRoute */
            $definedRoute = $definedRoutes->get($uri);
            $this->assertEqualsCanonicalizing($definedRoute->toArray(), $methods->toArray());
        });
    }

    /**
     * @return \Illuminate\Support\Collection<string, \Illuminate\Support\Collection<int, string>>
     */
    private static function definedRoutes(): Collection
    {
        return Collection::make([
            'admins'       => Collection::make(['POST']),
            'admins/login' => Collection::make(['POST']),
        ]);
    }
}
