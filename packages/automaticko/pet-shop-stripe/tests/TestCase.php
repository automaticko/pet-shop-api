<?php

namespace Automaticko\CurrencyExchangeRate\Tests;

use Automaticko\CurrencyExchangeRate\OrdersStateMachineServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            OrdersStateMachineServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
    }
}
