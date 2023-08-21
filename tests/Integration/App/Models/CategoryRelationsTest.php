<?php

namespace Integration\App\Models;

use App\Models\Category;
use App\Models\Product;
use Tests\Integration\App\Models\RelationsTestCase;

class CategoryRelationsTest extends RelationsTestCase
{
    /** @test */
    public function it_has_products(): void
    {
        $model = Category::factory()->create();
        Product::factory()->usingCategory($model)->count(parent::COUNT)->create();

        $related = $model->products()->get();

        $this->assertCorrectRelation($related, Product::class);
    }
}
