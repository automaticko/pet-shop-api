<?php

namespace Automaticko\PetShopStripe;

use Illuminate\Support\ServiceProvider;

class PetShopStripeProvider extends ServiceProvider
{

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }
}
