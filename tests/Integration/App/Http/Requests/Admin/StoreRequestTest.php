<?php

namespace Tests\Integration\App\Http\Requests\Admin;

use App\Http\Requests\Admin\StoreRequest;
use App\Http\Requests\Keys;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Lang;
use MohammedManssour\FormRequestTester\TestsFormRequests;
use Tests\Integration\App\Http\Requests\FormRequestsTestCase;

class StoreRequestTest extends FormRequestsTestCase
{
    use TestsFormRequests;
    use RefreshDatabase;

    protected string $requestClass = StoreRequest::class;

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
            Keys::FIRST_NAME   => [Keys::FIRST_NAME],
            Keys::LAST_NAME    => [Keys::LAST_NAME],
            Keys::EMAIL        => [Keys::EMAIL],
            Keys::PASSWORD     => [Keys::PASSWORD],
            Keys::AVATAR       => [Keys::AVATAR],
            Keys::ADDRESS      => [Keys::ADDRESS],
            Keys::PHONE_NUMBER => [Keys::PHONE_NUMBER],
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
            Keys::FIRST_NAME   => [Keys::FIRST_NAME],
            Keys::LAST_NAME    => [Keys::LAST_NAME],
            Keys::EMAIL        => [Keys::EMAIL],
            Keys::PASSWORD     => [Keys::PASSWORD],
            Keys::AVATAR       => [Keys::AVATAR],
            Keys::ADDRESS      => [Keys::ADDRESS],
            Keys::PHONE_NUMBER => [Keys::PHONE_NUMBER],
            Keys::MARKETING    => [Keys::MARKETING],
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

    /** @test */
    public function its_email_must_be_unique(): void
    {
        User::factory()->create(['email' => $email = 'valid@email.com']);
        $request = $this->formRequest($this->requestClass, [Keys::EMAIL => $email]);

        $request->assertValidationFailed();
        $request->assertValidationErrors([Keys::EMAIL]);
        $request->assertValidationMessages([Lang::get('validation.unique', ['attribute' => Keys::EMAIL])]);
    }

    /** @test */
    public function its_password_must_be_confirmed(): void
    {
        $request = $this->formRequest($this->requestClass, [Keys::PASSWORD => 'Secret123.']);

        $request->assertValidationFailed();
        $request->assertValidationErrors([Keys::PASSWORD]);
        $request->assertValidationMessages([Lang::get('validation.confirmed', ['attribute' => Keys::PASSWORD])]);
    }

    /** @test */
    public function its_password_must_have_a_minimum_size(): void
    {
        $request = $this->formRequest($this->requestClass, [Keys::PASSWORD => 'secret']);

        $request->assertValidationFailed();
        $request->assertValidationErrors([Keys::PASSWORD]);
        $request->assertValidationMessages([
            Lang::get('validation.min.string', [
                'attribute' => Keys::PASSWORD,
                'min'       => 8,
            ]),
        ]);
    }

    /** @test */
    public function its_password_must_contain_mixed_case(): void
    {
        $request = $this->formRequest($this->requestClass, [Keys::PASSWORD => 'secret123']);

        $request->assertValidationFailed();
        $request->assertValidationErrors([Keys::PASSWORD]);
        $request->assertValidationMessages([Lang::get('validation.password.mixed', ['attribute' => Keys::PASSWORD])]);
    }

    /** @test */
    public function its_password_must_contain_letters(): void
    {
        $request = $this->formRequest($this->requestClass, [Keys::PASSWORD => '12345678']);

        $request->assertValidationFailed();
        $request->assertValidationErrors([Keys::PASSWORD]);
        $request->assertValidationMessages([Lang::get('validation.password.letters', ['attribute' => Keys::PASSWORD])]);
    }

    /** @test */
    public function its_password_must_contain_symbols(): void
    {
        $request = $this->formRequest($this->requestClass, [Keys::PASSWORD => '12345678']);

        $request->assertValidationFailed();
        $request->assertValidationErrors([Keys::PASSWORD]);
        $request->assertValidationMessages([Lang::get('validation.password.symbols', ['attribute' => Keys::PASSWORD])]);
    }

    /** @test */
    public function its_password_must_contain_numbers(): void
    {
        $request = $this->formRequest($this->requestClass, [Keys::PASSWORD => 'secret_a_lot']);

        $request->assertValidationFailed();
        $request->assertValidationErrors([Keys::PASSWORD]);
        $request->assertValidationMessages([Lang::get('validation.password.numbers', ['attribute' => Keys::PASSWORD])]);
    }

    /** @test */
    public function its_avatar_must_be_an_uuid(): void
    {
        $request = $this->formRequest($this->requestClass, [Keys::AVATAR => 'invalid']);

        $request->assertValidationFailed();
        $request->assertValidationErrors([Keys::AVATAR]);
        $request->assertValidationMessages([Lang::get('validation.uuid', ['attribute' => Keys::AVATAR])]);
    }

    /** @test */
    public function its_avatar_must_exist(): void
    {
        $request = $this->formRequest($this->requestClass, [Keys::AVATAR => '3a4729d1-9df9-45cd-a675-fa780aff4b90']);

        $request->assertValidationFailed();
        $request->assertValidationErrors([Keys::AVATAR]);
        $request->assertValidationMessages([Lang::get('validation.exists', ['attribute' => Keys::AVATAR])]);
    }
}
