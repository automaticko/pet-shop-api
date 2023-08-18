<?php

namespace App\Services;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\InvalidTokenStructure;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\UnencryptedToken;

class JwtGuard implements Guard
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

        $parser = new Parser(new JoseEncoder());
        try {
            /** @var UnencryptedToken $parsed */
            $parsed = $parser->parse($token);
        } catch (InvalidTokenStructure) {
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
}
