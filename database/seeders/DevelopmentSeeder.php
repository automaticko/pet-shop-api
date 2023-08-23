<?php

namespace Database\Seeders;

use Database\Seeders\Development\OrderSeeder;
use Database\Seeders\Development\ProductSeeder;
use Illuminate\Database\Seeder;

class DevelopmentSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            DatabaseSeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
        ]);
    }
}
