<?php

namespace Tests\Unit\App\Services\JwtGuard;

use App\Models\User;
use App\Services\JwtGuard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token\Builder;
use Mockery;
use Tests\TestCase;

class UserTest extends TestCase
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
    public function it_returns_user(): void
    {
        $provider = Mockery::mock(UserProvider::class);
        $provider->shouldReceive('retrieveById')->with($uuid = 1)->once()->andReturn($user = new User());

        $tokenBuilder = (new Builder(new JoseEncoder(), ChainedFormatter::default()));
        $algorithm    = new Sha256();
        $signingKey   = InMemory::plainText(random_bytes(32));
        $token        = $tokenBuilder->withClaim('user_uuid', $uuid)->getToken($algorithm, $signingKey);

        $request = Mockery::mock(Request::class);
        $request->shouldReceive('bearerToken')->withNoArgs()->once()->andReturn($token->toString());

        $guard = new JwtGuard($provider, $request);
        $this->assertSame($user, $guard->user());
        $this->assertSame($user, $guard->user());
    }
}
