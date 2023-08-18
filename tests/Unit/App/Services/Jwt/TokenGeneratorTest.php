<?php

namespace Tests\Unit\App\Services\Jwt;

use App\Services\Jwt\TokenGenerator;
use Carbon\CarbonImmutable;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\Token\Parser;
use Tests\TestCase;

class TokenGeneratorTest extends TestCase
{
    /** @test */
    public function it_generates_a_valid_token()
    {
        $generator = new TokenGenerator(true);
        $token     = $generator->generate($issuer = 'issuer', CarbonImmutable::now(), $userUuid = 'uuid');
        $parser    = new Parser(new JoseEncoder());

        $this->assertInstanceOf(Token::class, $parsed = $parser->parse($token->toString()));

        $claims = $parsed->claims();

        $this->assertTrue($claims->has('user_uuid'));
        $this->assertSame($userUuid, $claims->get('user_uuid'));
        $this->assertSame($issuer, $claims->get('iss'));
    }
}
