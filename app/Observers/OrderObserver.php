<?php

namespace App\Observers;

use App\Models\Order;

class OrderObserver
{
    public function __construct(private readonly UuidSetter $uuidSetter)
    {
    }

    public function creating(Order $order): void
    {
        $this->uuidSetter->assignUuid($order);
    }
}
