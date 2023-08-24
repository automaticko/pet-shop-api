<?php

namespace Tests\Integration\App\Http\Requests\Payment;

use App\Http\Requests\Keys;
use App\Http\Requests\Payment\StoreRequest;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use MohammedManssour\FormRequestTester\TestsFormRequests;
use Tests\Integration\App\Http\Requests\FormRequestsTestCase;

class StoreRequestTest extends FormRequestsTestCase
{
    use TestsFormRequests;
    use RefreshDatabase;

    protected string $requestClass = StoreRequest::class;

    /** @test
     *
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
            Keys::TYPE    => [Keys::TYPE],
            Keys::DETAILS => [Keys::DETAILS],
        ];
    }

    /** @test */
    public function its_type_must_be_a_string(): void
    {
        $this->assertRequestKeyIsString($this->requestClass, Keys::TYPE);
    }

    /** @test */
    public function its_type_must_be_valid(): void
    {
        $message = $this->translateValidation('validation.in', ['attribute' => $this->readable(Keys::TYPE)]);
        $this->fails($this->requestClass, Keys::TYPE, 'invalid', $message);
    }

    /**
     * @test
     *
     * @dataProvider detailsRequiredDataProvider
     */
    public function its_details_must_be_required_depending_on_type(string $type, string $key): void
    {
        $field   = Keys::DETAILS . '.' . $key;
        $message = $this->translateValidation('validation.required', ['attribute' => $this->readable($field)]);

        $request = $this->formRequest($this->requestClass, [Keys::TYPE => $type]);

        $request->assertValidationFailed();
        $request->assertValidationErrors([$field]);
        $request->assertValidationMessages([$message]);
    }

    /**
     * @return array<int|string, array<int, mixed>>
     */
    public static function detailsRequiredDataProvider(): array
    {
        return [
            Keys::DETAILS . '.' . Keys::HOLDER     => [Payment::TYPE_CREDIT_CARD, Keys::HOLDER],
            Keys::DETAILS . '.' . Keys::NUMBER     => [Payment::TYPE_CREDIT_CARD, Keys::NUMBER],
            Keys::DETAILS . '.' . Keys::CCV        => [Payment::TYPE_CREDIT_CARD, Keys::CCV],
            Keys::DETAILS . '.' . Keys::EXPIRATION => [Payment::TYPE_CREDIT_CARD, Keys::EXPIRATION],
            Keys::DETAILS . '.' . Keys::FIRST_NAME => [Payment::TYPE_CASH_ON_DELIVERY, Keys::FIRST_NAME],
            Keys::DETAILS . '.' . Keys::LAST_NAME  => [Payment::TYPE_CASH_ON_DELIVERY, Keys::LAST_NAME],
            Keys::DETAILS . '.' . Keys::ADDRESS    => [Payment::TYPE_CASH_ON_DELIVERY, Keys::ADDRESS],
        ];
    }

    /**
     * @test
     *
     * @dataProvider detailsStringDataProvider
     */
    public function its_details_must_a_string(string $key): void
    {
        $field   = Keys::DETAILS . '.' . $key;
        $message = $this->translateValidation('validation.string', ['attribute' => $this->readable($field)]);

        $request = $this->formRequest($this->requestClass, [Keys::DETAILS => [$key => ['array']]]);

        $request->assertValidationFailed();
        $request->assertValidationErrors([$field]);
        $request->assertValidationMessages([$message]);
    }

    /**
     * @return array<int|string, array<int, mixed>>
     */
    public static function detailsStringDataProvider(): array
    {
        return [
            Keys::DETAILS . '.' . Keys::HOLDER     => [Keys::HOLDER],
            Keys::DETAILS . '.' . Keys::NUMBER     => [Keys::NUMBER],
            Keys::DETAILS . '.' . Keys::CCV        => [Keys::CCV],
            Keys::DETAILS . '.' . Keys::EXPIRATION => [Keys::EXPIRATION],
            Keys::DETAILS . '.' . Keys::FIRST_NAME => [Keys::FIRST_NAME],
            Keys::DETAILS . '.' . Keys::LAST_NAME  => [Keys::LAST_NAME],
            Keys::DETAILS . '.' . Keys::ADDRESS    => [Keys::ADDRESS],
        ];
    }
}
