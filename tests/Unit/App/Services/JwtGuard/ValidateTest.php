<?php

namespace Tests\Unit\App\Services\JwtGuard;

use App\Models\User;
use App\Services\JwtGuard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;

class ValidateTest extends TestCase
{
    /** @test */
    public function it_returns_null_on_no_bearer_token()
    {
        $provider = Mockery::mock(UserProvider::class);
        $request  = Mockery::mock(Request::class);
        $request->shouldReceive('bearerToken')->withNoArgs()->once()->andReturn(null);

        $guard = new JwtGuard($provider, $request);
        $this->assertNull($guard->user());
    }

    /** @test */
    public function it_returns_false_on_incorrect_credentials(): void
    {
        $provider = Mockery::mock(UserProvider::class);
        $provider->shouldReceive('retrieveByCredentials')->with($credentials = [])->once()->andReturnNull();

        $request = Mockery::mock(Request::class);
        $guard   = new JwtGuard($provider, $request);
        $this->assertFalse($guard->validate($credentials));
    }

    /** @test */
    public function it_returns_false_on_invalid_credentials(): void
    {
        $provider = Mockery::mock(UserProvider::class);
        $provider->shouldReceive('retrieveByCredentials')
            ->with($credentials = [])
            ->once()
            ->andReturn($user = new User());
        $provider->shouldReceive('validateCredentials')->with($user, $credentials)->andReturnFalse();

        $request = Mockery::mock(Request::class);
        $guard   = new JwtGuard($provider, $request);
        $this->assertFalse($guard->validate($credentials));
    }

    /** @test */
    public function it_returns_true_on_valid_credentials(): void
    {
        $provider = Mockery::mock(UserProvider::class);
        $provider->shouldReceive('retrieveByCredentials')
            ->with($credentials = [])
            ->once()
            ->andReturn($user = new User());
        $provider->shouldReceive('validateCredentials')->with($user, $credentials)->andReturnTrue();

        $request = Mockery::mock(Request::class);
        $guard   = new JwtGuard($provider, $request);
        $this->assertTrue($guard->validate($credentials));
    }
}
