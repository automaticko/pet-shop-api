<?php

namespace App\Providers;

use App\Services\JwtGuard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string, class-string>
     */
    protected $policies = [];

    public function boot(): void
    {
        Auth::extend('jwt', function($app, $name, array $config) {
            /** @var \Illuminate\Contracts\Auth\UserProvider $provider */
            $provider = Auth::createUserProvider($config['provider']);
            $request  = $app->make('request');

            return new JwtGuard($provider, $request);
        });
    }
}
