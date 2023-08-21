<?php

namespace Automaticko\CurrencyExchangeRate;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class CurrencyExchangeRateServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/currency-exchange-rate.php', 'currency-exchange-rate');
    }

    public function boot(): void
    {
        Route::group($this->routeConfiguration(), function() {
            $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        });

        $this->publishes([
            __DIR__.'/../config/currency-exchange-rate.php' => config_path('currency-exchange-rate.php')
        ], 'currency-exchange-rate-config');
    }

    /**
     * @return array<string, string>
     */
    protected function routeConfiguration(): array
    {
        return [
            'prefix'     => Config::get('currency-exchange-rate.prefix'),
            'middleware' => Config::get('currency-exchange-rate.middleware'),
        ];
    }
}
