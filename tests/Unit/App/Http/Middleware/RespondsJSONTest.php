<?php

namespace Tests\Unit\App\Http\Middleware;

use App\Http\Middleware\RespondsJSON;
use Illuminate\Http\Request;
use Mockery;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class RespondsJSONTest extends TestCase
{
    /** @test */
    public function it_sets_request_with_accept_json_header(): void
    {
        $headers = Mockery::mock(HeaderBag::class);
        $headers->shouldReceive('set')->once()->withArgs(['accept', 'application/json']);

        $request = Mockery::mock(Request::class);
        $request->headers = $headers;

        $middleware = new RespondsJSON();

        $middleware->handle($request, fn() => new Response());
    }
}
