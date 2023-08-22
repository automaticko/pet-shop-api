<?php

namespace Automaticko\CurrencyExchangeRate\Services;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;

class RatesService
{
    public function __construct(private readonly Application $app, private readonly Factory $http)
    {
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function rates(): Rates
    {
        $response = $this->fetch();
        $xml      = simplexml_load_string($response->body());
        $encoded  = (string) json_encode($xml);

        /** @var array<string, array<string, array<string, array<string, string>>>> $json */
        $json = json_decode($encoded, true);

        /** @var Collection<string, array<string, array<string, array<string, string>>>> $collection */
        $collection = Collection::make($json);

        /** @var array<string, array<string, array<string, string>>> $rawAttribute */
        $rawAttribute = Collection::make($collection->pluck('Cube.Cube'))->first();

        /** @var Collection<string, array<string, array<string, string>>> $attribute */
        $attribute = Collection::make($rawAttribute);
        $rates     = $attribute->pluck('@attributes.rate', '@attributes.currency')->put('EUR', '1.0');

        return $this->app->make(Rates::class, ['sourceRates' => $rates]);
    }

    private function fetch(): Response
    {
        return $this->http->get('https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml');
    }
}
