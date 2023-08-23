<?php

namespace Automaticko\CurrencyExchangeRate\Services;

use Exception;
use Illuminate\Support\Collection;

class Rates
{
    public const CURRENCIES = [
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

    /**
     *
     * @param \Illuminate\Support\Collection<string, float> $sourceRates
     *
     * @throws \Exception
     */
    public function __construct(private readonly Collection $sourceRates)
    {
        $this->validateSourceRates();
    }

    /**
     * @throws \Exception
     */
    private function validateSourceRates(): void
    {
        if (array_diff(self::CURRENCIES, $this->sourceRates->keys()->toArray())) {
            throw new Exception('Invalid rates received');
        }
    }

    /**
     * @throws \Exception
     */
    private function validateCurrency(string $currency): void
    {
        if (!$this->sourceRates->keys()->contains($currency)) {
            throw new Exception('Invalid currency');
        }
    }

    /**
     * @return Collection<string, float>
     *
     * @throws \Exception
     */
    public function calculate(string $currency, float $amount): Collection
    {
        $this->validateCurrency($currency);

        $adjustedRate = $this->sourceRates->get($currency);

        return $this->sourceRates->map(function (float $rate) use ($amount, $adjustedRate): float {
            return !$adjustedRate ? 0.0 : round($rate / $adjustedRate * $amount, 4);
        });
    }
}
