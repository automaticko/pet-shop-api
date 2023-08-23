<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\File;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use App\Observers\CategoryObserver;
use App\Observers\FileObserver;
use App\Observers\OrderObserver;
use App\Observers\OrderStatusObserver;
use App\Observers\PaymentObserver;
use App\Observers\ProductObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    public function boot(): void
    {
        parent::boot();

        Category::observe(CategoryObserver::class);
        File::observe(FileObserver::class);
        Order::observe(OrderObserver::class);
        OrderStatus::observe(OrderStatusObserver::class);
        Payment::observe(PaymentObserver::class);
        Product::observe(ProductObserver::class);
        User::observe(UserObserver::class);
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
