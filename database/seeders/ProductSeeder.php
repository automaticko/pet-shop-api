<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([CategorySeeder::class]);

        /** @var Category $foodCategory */
        $foodCategory = Category::where('slug', 'food')->first();
        /** @var Category $toysCategory */
        $toysCategory = Category::where('slug', 'toys')->first();

        Product::factory()->count(10)->create(['category_uuid' => $foodCategory->uuid]);
        Product::factory()->count(10)->create(['category_uuid' => $toysCategory->uuid]);
    }
}
