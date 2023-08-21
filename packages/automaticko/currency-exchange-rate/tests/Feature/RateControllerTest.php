<?php

namespace Automaticko\CurrencyExchangeRate\Tests\Feature;

use Automaticko\CurrencyExchangeRate\Constants\RouteNames;
use Automaticko\CurrencyExchangeRate\Tests\TestCase;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\Response as ClientResponse;
use Illuminate\Support\Facades\URL;
use Mockery;
use Symfony\Component\HttpFoundation\Response;

/**
 * @covers \Automaticko\CurrencyExchangeRate\Http\Controllers\RateController
 */
class RateControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_unprocessable_entity(): void
    {
        $response = $this->get(URL::route(RouteNames::RATE), ['accept' => 'application/json']);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    function it_returns_service_unavailable_on_any_exception(): void
    {
        $this->withoutExceptionHandling();
        $ecbURL = 'https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml';
        $http   = Mockery::mock(Factory::class);
        $http->shouldReceive('get')->with($ecbURL)->once()->andThrow(new Exception());

        $this->app->bind(Factory::class, fn() => $http);

        $parameters = ['currency' => 'USD', 'amount' => 1];
        $response   = $this->get(URL::route(RouteNames::RATE, $parameters), ['accept' => 'application/json']);

        $response->assertStatus(Response::HTTP_SERVICE_UNAVAILABLE);
        dd($response->content());
    }

    /** @test */
    function it_returns_conversion_rate(): void
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
<gesmes:Envelope xmlns:gesmes="http://www.gesmes.org/xml/2002-08-01"
                 xmlns="http://www.ecb.int/vocabulary/2002-08-01/eurofxref">
    <Cube>
        <Cube time="2023-08-21">
            <Cube currency="USD" rate="10"/>
            <Cube currency="JPY" rate="159.15"/>
            <Cube currency="BGN" rate="1.9558"/>
            <Cube currency="CZK" rate="24.020"/>
            <Cube currency="DKK" rate="7.4524"/>
            <Cube currency="GBP" rate="0.85475"/>
            <Cube currency="HUF" rate="381.73"/>
            <Cube currency="PLN" rate="4.4785"/>
            <Cube currency="RON" rate="4.9406"/>
            <Cube currency="SEK" rate="11.9095"/>
            <Cube currency="CHF" rate="0.9588"/>
            <Cube currency="ISK" rate="143.70"/>
            <Cube currency="NOK" rate="11.5205"/>
            <Cube currency="TRY" rate="29.6305"/>
            <Cube currency="AUD" rate="1.6995"/>
            <Cube currency="BRL" rate="5.4140"/>
            <Cube currency="CAD" rate="1.4723"/>
            <Cube currency="CNY" rate="7.9456"/>
            <Cube currency="HKD" rate="8.5488"/>
            <Cube currency="IDR" rate="16718.49"/>
            <Cube currency="ILS" rate="4.1395"/>
            <Cube currency="INR" rate="90.6615"/>
            <Cube currency="KRW" rate="1460.32"/>
            <Cube currency="MXN" rate="18.5927"/>
            <Cube currency="MYR" rate="5.0706"/>
            <Cube currency="NZD" rate="1.8407"/>
            <Cube currency="PHP" rate="61.543"/>
            <Cube currency="SGD" rate="1.4791"/>
            <Cube currency="THB" rate="38.314"/>
            <Cube currency="ZAR" rate="20.6760"/>
        </Cube>
    </Cube>
</gesmes:Envelope>
';

        $response = Mockery::mock(ClientResponse::class);
        $response->shouldReceive('body')->withNoArgs()->once()->andReturn($xml);

        $ecbURL = 'https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml';
        $http   = Mockery::mock(Factory::class);
        $http->shouldReceive('get')->with($ecbURL)->once()->andReturn($response);

        $this->app->bind(Factory::class, fn() => $http);

        $parameters = ['currency' => 'USD', 'amount' => 10];
        $response   = $this->get(URL::route(RouteNames::RATE, $parameters), ['accept' => 'application/json']);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonPath('total', 100);
    }
}
