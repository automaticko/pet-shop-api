<?php

namespace Automaticko\CurrencyExchangeRate\Tests;

use Automaticko\CurrencyExchangeRate\CurrencyExchangeRateServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            CurrencyExchangeRateServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
    }
}
