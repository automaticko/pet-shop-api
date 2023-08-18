<?php

namespace App\Services\Jwt;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Signer;
use Lcobucci\JWT\Signer\Hmac\Sha256 as HmacSha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Rsa\Sha256 as RsaSha256;
use Lcobucci\JWT\Token\Builder;
use Lcobucci\JWT\UnencryptedToken;

class TokenGenerator
{
    public function __construct(private readonly bool $isTesting = false)
    {
    }

    public function generate(string $issuer, CarbonImmutable $issuedAt, string $userUuid): UnencryptedToken
    {
        /** @var non-empty-string $issuer */

        $encoder        = App::make(JoseEncoder::class);
        $claimFormatter = ChainedFormatter::default();
        /** @var Builder $tokenBuilder */
        $tokenBuilder = App::make(Builder::class, compact('encoder', 'claimFormatter'));

        return $tokenBuilder->issuedBy($issuer)
            ->identifiedBy(Str::uuid()->toString())
            ->issuedAt($issuedAt)
            ->canOnlyBeUsedAfter($issuedAt)
            ->expiresAt($issuedAt->addYear())
            ->withClaim('user_uuid', $userUuid)
            ->getToken($this->algorithm(), $this->signingKey());
    }

    private function signingKey(): InMemory
    {
        $key = '12345678901234567890123456789012';

        return $this->isTesting ? InMemory::plainText($key) : InMemory::file(Config::get('jwt.key'));
    }

    private function algorithm(): Signer
    {
        return $this->isTesting ? App::make(HmacSha256::class) : App::make(RsaSha256::class);
    }
}
