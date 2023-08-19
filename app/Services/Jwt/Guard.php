<?php

namespace App\Services\Jwt;

use Exception;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard as BaseGuard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\UnencryptedToken;

class Guard implements BaseGuard
{
    use GuardHelpers;

    public function __construct(UserProvider $provider, private readonly Request $request)
    {
        $this->provider = $provider;
    }

    public function user(): Authenticatable|null
    {
        if ($this->user) {
            return $this->user;
        }

        $token = $this->request->bearerToken();
        if (!$token) {
            return null;
        }

        $decoder = App::make(JoseEncoder::class);
        $parser  = App::make(Parser::class, compact('decoder'));
        try {
            /** @var UnencryptedToken $parsed */
            $parsed = $parser->parse($token);
        } catch (Exception) {
            return null;
        }

        $this->user = $this->provider->retrieveById($parsed->claims()->get('user_uuid'));

        return $this->user;
    }

    /**
     * @param array<string, string> $credentials
     *
     * @return bool
     */
    public function validate(array $credentials = []): bool
    {
        $user = $this->provider->retrieveByCredentials($credentials);
        if (!$user) {
            return false;
        }

        $this->user = $this->provider->validateCredentials($user, $credentials) ? $user : null;

        return (bool) $this->user;
    }

    public function login(Authenticatable $authenticatable): void
    {
        $this->user = $authenticatable;
    }
}
