<?php

namespace App\Observers;

use App\Models\OrderStatus;

class OrderStatusObserver
{
    public function __construct(private readonly UuidSetter $uuidSetter)
    {
    }

    public function creating(OrderStatus $orderStatus): void
    {
        $this->uuidSetter->assignUuid($orderStatus);
    }
}
