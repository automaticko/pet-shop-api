<?php

namespace Automaticko\CurrencyExchangeRate\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string|\Illuminate\Contracts\Validation\Rule>>
     */
    public function rules(): array
    {
        return [
            Keys::CURRENCY => ['required', 'string'],
            Keys::AMOUNT   => ['required', 'numeric', 'gt:0'],
        ];
    }
}
