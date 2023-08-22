<?php

namespace Automaticko\CurrencyExchangeRate\Http\Controllers;

use Automaticko\CurrencyExchangeRate\Http\Requests\Keys;
use Automaticko\CurrencyExchangeRate\Http\Requests\RateRequest;
use Automaticko\CurrencyExchangeRate\Services\RatesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Throwable;

class RateController extends Controller
{
    public function __invoke(
        RatesService $ratesService,
        RateRequest $request,
        JsonResponse $jsonResponse
    ): SymfonyResponse {
        try {
            $rates = $ratesService->rates();

            $calculated = $rates->calculate($request->get(Keys::CURRENCY), $request->get(Keys::AMOUNT));
        } catch (Throwable) {
            return $jsonResponse->setContent('')->setStatusCode(SymfonyResponse::HTTP_SERVICE_UNAVAILABLE);
        }

        $content = (string) json_encode([
            'base'  => $request->get(Keys::CURRENCY),
            'date'  => Carbon::now()->format('Y-m-d'),
            'rates' => $calculated->toArray(),
        ]);

        return $jsonResponse->setContent($content);
    }
}
