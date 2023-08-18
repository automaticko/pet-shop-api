<?php

namespace Tests\Integration\App\Http\Requests\Admin;

use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\Keys;
use Illuminate\Foundation\Testing\RefreshDatabase;
use MohammedManssour\FormRequestTester\TestsFormRequests;
use Tests\Integration\App\Http\Requests\FormRequestsTestCase;

class LoginRequestTest extends FormRequestsTestCase
{
    use TestsFormRequests;
    use RefreshDatabase;

    protected string $requestClass = LoginRequest::class;

    /** @test
     * @dataProvider keyRequiredDataProvider
     */
    public function its_key_is_required(string $key): void
    {
        $this->assertRequestKeyIsRequired($this->requestClass, $key);
    }

    /**
     * @return array<int|string, array<int, mixed>>
     */
    public static function keyRequiredDataProvider(): array
    {
        return [
            Keys::EMAIL    => [Keys::EMAIL],
            Keys::PASSWORD => [Keys::PASSWORD],
        ];
    }

    /** @test
     * @dataProvider keyStringDataProvider
     */
    public function its_key_is_string(string $key): void
    {
        $this->assertRequestKeyIsString($this->requestClass, $key);
    }

    /**
     * @return array<int|string, array<int, mixed>>
     */
    public static function keyStringDataProvider(): array
    {
        return [
            Keys::EMAIL    => [Keys::EMAIL],
            Keys::PASSWORD => [Keys::PASSWORD],
        ];
    }

    /** @test */
    public function its_email_must_be_a_valid_email(): void
    {
        $this->assertRequestKeyIsValidEmail($this->requestClass, Keys::EMAIL);
    }

    /** @test */
    public function its_email_must_be_a_strictly_valid_email(): void
    {
        $this->assertRequestKeyIsStrictlyValidEmail($this->requestClass, Keys::EMAIL);
    }
}
