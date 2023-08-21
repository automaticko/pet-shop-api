<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * @return array<string, string>
     */
    public function definition(): array
    {
        return [
            'uuid'  => $this->faker->unique()->uuid,
            'slug'  => $this->faker->unique()->slug,
            'title' => $this->faker->unique()->sentence(3),
        ];
    }
}
