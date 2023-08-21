<?php

use App\Constants\RouteNames;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\StoreController;
use App\Models\User;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (Router $route): void {
    $route->group(['prefix' => 'admin'], function (Router $route): void {
        $route->post('login', LoginController::class)->name(RouteNames::V1_ADMIN_LOGIN);
        $route->post('/', StoreController::class)
            ->name(RouteNames::V1_ADMIN_STORE)
            ->middleware('auth')
            ->can('createAdmin', User::class);
    });
});
