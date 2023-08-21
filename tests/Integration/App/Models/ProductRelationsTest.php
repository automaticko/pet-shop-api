<?php

namespace Integration\App\Models;

use App\Models\Category;
use App\Models\Product;
use Tests\Integration\App\Models\RelationsTestCase;

class ProductRelationsTest extends RelationsTestCase
{
    /** @test */
    public function it_belongs_to_a_category(): void
    {
        $model = Product::factory()->create();

        $related = $model->category()->first();

        $this->assertInstanceOf(Category::class, $related);
    }
}
