<?php

namespace Database\Seeders;

use Database\Seeders\Production\AdminSeeder;
use Database\Seeders\Production\CategorySeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            CategorySeeder::class,
        ]);
    }
}
