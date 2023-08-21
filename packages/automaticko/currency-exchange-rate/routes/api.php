<?php

use Automaticko\CurrencyExchangeRate\Http\Controllers\RateController;
use Illuminate\Support\Facades\Route;

Route::get('/rate', RateController::class)->name(\Automaticko\CurrencyExchangeRate\Constants\RouteNames::RATE);
