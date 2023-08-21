<?php

namespace Automaticko\CurrencyExchangeRate\Http\Controllers;

use Automaticko\CurrencyExchangeRate\Http\Requests\RateRequest;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Throwable;

class RateController extends Controller
{
    public function __invoke(Factory $http, RateRequest $request, JsonResponse $jsonResponse): SymfonyResponse
    {
        try {
            $response = $http->get('https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml');
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
            $rates     = $attribute->pluck('@attributes.rate', '@attributes.currency');
        } catch (Throwable) {
            return $jsonResponse->setContent('')->setStatusCode(SymfonyResponse::HTTP_SERVICE_UNAVAILABLE);
        }

        $amount   = $request->get('amount');
        $currency = $request->get('currency');
        $rate     = $rates->get(strtoupper($currency));

        /** @var string $total */
        $total = json_encode(['total' => $rate * $amount]);

        return $jsonResponse->setContent($total);
    }
}
