<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = Collection::make([
            '4c588c71-c881-4b92-b13b-952569214d49' => 'Food',
            '3ea5e75f-0ce2-461b-b0a0-e27d9d3623af' => 'Toys',
        ]);

        $categories->each(function (string $title, string $uuid): void {
            Category::updateOrCreate(['uuid' => $uuid], ['uuid' => $uuid, 'title' => $title]);
        });
    }
}
