<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * @return array<string, int|string|bool|null|\Illuminate\Database\Eloquent\Factories\Factory>
     */
    public function definition(): array
    {
        return [
            'uuid'  => $this->faker->unique()->uuid,
            'title' => $this->faker->unique()->title,
        ];
    }
}
