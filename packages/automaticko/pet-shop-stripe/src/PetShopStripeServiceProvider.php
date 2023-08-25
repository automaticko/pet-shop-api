<?php

namespace Automaticko\PetShopStripe;

use Illuminate\Support\ServiceProvider;

class PetShopStripeServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes.php');
    }
}
