<?php

namespace Tests\Unit\App\Models;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /** @test */
    public function it_defines_a_products_relation(): void
    {
        $model    = new Category();
        $relation = $model->products();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertInstanceOf(Product::class, $relation->getRelated());
        $this->assertSame('uuid', $relation->getLocalKeyName());
        $this->assertSame('category_uuid', $relation->getForeignKeyName());
    }
}
