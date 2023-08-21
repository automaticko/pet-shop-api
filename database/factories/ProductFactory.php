<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_uuid' => fn() => Category::factory()->create()->uuid,
            'uuid'          => $this->faker->unique()->uuid,
            'title'         => 'asd',
            'price'         => rand(1000, 999999),
            'description'   => 'asd',
            'metadata'      => '{}',
        ];
    }

    public function usingCategory(Category $category): self
    {
        return $this->state(fn() => ['category_uuid' => $category->uuid]);
    }
}
