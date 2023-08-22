<?php

namespace Automaticko\CurrencyExchangeRate\Tests\Unit\Http\Requests;

use Automaticko\CurrencyExchangeRate\Http\Requests\Keys;
use Automaticko\CurrencyExchangeRate\Http\Requests\RateRequest;
use Automaticko\CurrencyExchangeRate\Tests\TestCase;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use MohammedManssour\FormRequestTester\TestsFormRequests;

class RateRequestTest extends TestCase
{
    use TestsFormRequests;

    protected string $requestClass = RateRequest::class;

    /** @test */
    public function its_currency_must_be_a_string(): void
    {
        $message = $this->translateValidation('validation.string', ['attribute' => $this->readable(Keys::CURRENCY)]);
        $this->fails($this->requestClass, Keys::CURRENCY, ['array'], $message);
    }

    /** @test */
    public function its_currency_must_be_valid(): void
    {
        $message = $this->translateValidation('validation.in', ['attribute' => $this->readable(Keys::CURRENCY)]);
        $this->fails($this->requestClass, Keys::CURRENCY, ['array'], $message);
    }

    /** @test */
    public function its_amount_is_required(): void
    {
        $message = $this->translateValidation('validation.required', ['attribute' => $this->readable(Keys::AMOUNT)]);
        $this->fails($this->requestClass, Keys::AMOUNT, null, $message);
    }

    /** @test */
    public function its_amount_must_be_numeric(): void
    {
        $message = $this->translateValidation('validation.numeric', ['attribute' => $this->readable(Keys::AMOUNT)]);
        $this->fails($this->requestClass, Keys::AMOUNT, 'string', $message);
    }

    /** @test */
    public function its_amount_must_be_greater_than_zero(): void
    {
        $replace = ['attribute' => $this->readable(Keys::AMOUNT), 'value' => 0];
        $message = $this->translateValidation('validation.gt.numeric', $replace);
        $this->fails($this->requestClass, Keys::AMOUNT, 0, $message);
    }

    /**
     * @param string                               $requestClass
     * @param string                               $key
     * @param array<int|string, mixed>|string|null $value
     * @param array<int, string>|string            $message
     *
     * @return void
     */
    private function fails(string $requestClass, string $key, array|string|null $value, array|string $message): void
    {
        $request = $this->formRequest($requestClass, [$key => $value]);

        $request->assertValidationFailed();
        $request->assertValidationErrors([$key]);
        $request->assertValidationMessages([$message]);
    }

    /**
     * @param string                $validation
     * @param array<string, string> $replace
     *
     * @return string|array<int, string>
     */
    protected function translateValidation(string $validation, array $replace): string|array
    {
        return Lang::get($validation, $replace);
    }

    protected function readable(string $key): string
    {
        return Str::lower(str_replace('_', ' ', Str::snake($key)));
    }
}
