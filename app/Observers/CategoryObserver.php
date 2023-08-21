<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
    use SetsEmptyUuid;

    public function creating(Category $category): void
    {
        $this->setEmptyUuidOn($category);
    }
}
