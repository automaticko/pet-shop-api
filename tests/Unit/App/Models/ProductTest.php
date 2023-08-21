<?php

namespace Tests\Unit\App\Models;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /** @test */
    public function it_defines_a_category_relation(): void
    {
        $model    = new Product();
        $relation = $model->category();

        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertInstanceOf(Category::class, $relation->getRelated());
        $this->assertSame('uuid', $relation->getOwnerKeyName());
        $this->assertSame('category_uuid', $relation->getForeignKeyName());
        $this->assertSame('category', $relation->getRelationName());
    }
}
