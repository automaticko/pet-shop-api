<?php

namespace App\Observers;

use App\Models\Payment;

class PaymentObserver
{
    public function __construct(private readonly UuidSetter $uuidSetter)
    {
    }

    public function creating(Payment $payment): void
    {
        $this->uuidSetter->assignUuid($payment);
    }
}
