<?php

namespace Tests\Integration\App\Http\Requests;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use MohammedManssour\FormRequestTester\TestsFormRequests;
use Tests\TestCase;

class FormRequestsTestCase extends TestCase
{
    use TestsFormRequests;

    public function assertRequestKeyIsRequired(string $requestClass, string $key): void
    {
        $message = $this->translateValidation('validation.required', ['attribute' => $this->readable($key)]);
        $this->fails($requestClass, $key, null, $message);
    }

    public function assertRequestKeyIsString(string $requestClass, string $key): void
    {
        $message = $this->translateValidation('validation.string', ['attribute' => $this->readable($key)]);
        $this->fails($requestClass, $key, ['array value'], $message);
    }

    public function assertRequestKeyIsValidEmail(string $requestClass, string $key): void
    {
        $message = $this->translateValidation('validation.email', ['attribute' => $this->readable($key)]);
        $this->fails($requestClass, $key, 'invalid.email', $message);
    }

    public function assertRequestKeyIsStrictlyValidEmail(string $requestClass, string $key): void
    {
        $message = $this->translateValidation('validation.email', ['attribute' => $this->readable($key)]);
        $this->fails($requestClass, $key, 'invalid@email', $message);
    }

    /**
     * @param string                               $requestClass
     * @param string                               $key
     * @param array<int|string, mixed>|string|null $value
     * @param array<int, string>|string            $message
     *
     * @return void
     */
    protected function fails(string $requestClass, string $key, array|string|null $value, array|string $message): void
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
