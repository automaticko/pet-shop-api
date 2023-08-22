<?php

namespace Automaticko\CurrencyExchangeRate\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $currencies = [
            'EUR',
            'USD',
            'JPY',
            'BGN',
            'CZK',
            'DKK',
            'GBP',
            'HUF',
            'PLN',
            'RON',
            'SEK',
            'CHF',
            'ISK',
            'NOK',
            'TRY',
            'AUD',
            'BRL',
            'CAD',
            'CNY',
            'HKD',
            'IDR',
            'ILS',
            'INR',
            'KRW',
            'MXN',
            'MYR',
            'NZD',
            'PHP',
            'SGD',
            'THB',
            'ZAR',
        ];

        return [
            Keys::CURRENCY => ['string', Rule::in($currencies)],
            Keys::AMOUNT   => ['required', 'numeric', 'gt:0'],
        ];
    }
}
