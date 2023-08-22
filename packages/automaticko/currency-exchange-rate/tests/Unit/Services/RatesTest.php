<?php

namespace Automaticko\CurrencyExchangeRate\Tests\Unit\Services;

use Automaticko\CurrencyExchangeRate\Services\Rates;
use Automaticko\CurrencyExchangeRate\Tests\TestCase;
use Exception;
use Illuminate\Support\Collection;

class RatesTest extends TestCase
{
    /** @test */
    public function it_throws_exception_when_invalid_source_rates_are_provided(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid rates received');

        $invalid = Collection::make();

        new Rates($invalid);
    }

    /** @test */
    public function it_throws_exception_when_invalid_currency_is_provided(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid currency');

        $sourceRates = Collection::make([
            'EUR' => 1.0,
            'USD' => 1.0,
            'JPY' => 1.0,
            'BGN' => 1.0,
            'CZK' => 1.0,
            'DKK' => 1.0,
            'GBP' => 1.0,
            'HUF' => 1.0,
            'PLN' => 1.0,
            'RON' => 1.0,
            'SEK' => 1.0,
            'CHF' => 1.0,
            'ISK' => 1.0,
            'NOK' => 1.0,
            'TRY' => 1.0,
            'AUD' => 1.0,
            'BRL' => 1.0,
            'CAD' => 1.0,
            'CNY' => 1.0,
            'HKD' => 1.0,
            'IDR' => 1.0,
            'ILS' => 1.0,
            'INR' => 1.0,
            'KRW' => 1.0,
            'MXN' => 1.0,
            'MYR' => 1.0,
            'NZD' => 1.0,
            'PHP' => 1.0,
            'SGD' => 1.0,
            'THB' => 1.0,
            'ZAR' => 1.0,
        ]);

        $rates = new Rates($sourceRates);
        $rates->calculate('invalid', 1);
    }

    /**
     * @test
     *
     * @throws \Exception
     */
    public function it_calculates_rates(): void
    {
        $sourceRates = Collection::make([
            'EUR' => 0.0,
            'USD' => 0.1,
            'JPY' => 0.2,
            'BGN' => 0.3,
            'CZK' => 0.4,
            'DKK' => 0.5,
            'GBP' => 0.6,
            'HUF' => 0.7,
            'PLN' => 0.8,
            'RON' => 0.9,
            'SEK' => 1.0,
            'CHF' => 1.1,
            'ISK' => 2.2,
            'NOK' => 3.3,
            'TRY' => 4.4,
            'AUD' => 5.5,
            'BRL' => 6.6,
            'CAD' => 7.7,
            'CNY' => 8.8,
            'HKD' => 9.9,
            'IDR' => 1.2,
            'ILS' => 2.3,
            'INR' => 3.4,
            'KRW' => 4.5,
            'MXN' => 5.6,
            'MYR' => 6.7,
            'NZD' => 7.8,
            'PHP' => 8.9,
            'SGD' => 9.0,
            'THB' => 1.3,
            'ZAR' => 2.4,
        ]);

        $expectedResponse = [
            'EUR' => 0.0,
            'USD' => 0.0101,
            'JPY' => 0.0202,
            'BGN' => 0.0303,
            'CZK' => 0.0404,
            'DKK' => 0.0505,
            'GBP' => 0.0606,
            'HUF' => 0.0707,
            'PLN' => 0.0808,
            'RON' => 0.0909,
            'SEK' => 0.101,
            'CHF' => 0.1111,
            'ISK' => 0.2222,
            'NOK' => 0.3333,
            'TRY' => 0.4444,
            'AUD' => 0.5556,
            'BRL' => 0.6667,
            'CAD' => 0.7778,
            'CNY' => 0.8889,
            'HKD' => 1.0,
            'IDR' => 0.1212,
            'ILS' => 0.2323,
            'INR' => 0.3434,
            'KRW' => 0.4545,
            'MXN' => 0.5657,
            'MYR' => 0.6768,
            'NZD' => 0.7879,
            'PHP' => 0.899,
            'SGD' => 0.9091,
            'THB' => 0.1313,
            'ZAR' => 0.2424,
        ];

        $rates      = new Rates($sourceRates);
        $calculated = $rates->calculate('HKD', 1);
        $this->assertEqualsCanonicalizing($expectedResponse, $calculated->toArray());
    }
}
