<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
    public function __construct(private readonly UuidSetter $uuidSetter)
    {
    }

    public function creating(Product $product): void
    {
        $this->uuidSetter->assignUuid($product);
    }
}
