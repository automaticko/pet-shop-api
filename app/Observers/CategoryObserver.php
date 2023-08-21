<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
    public function __construct(private readonly UuidSetter $uuidSetter)
    {
    }

    public function creating(Category $category): void
    {
        $this->uuidSetter->assign($category);
    }
}
