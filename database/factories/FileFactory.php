<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => $this->faker->unique()->uuid,
            'name' => $this->faker->name,
            'size' => rand(1000, 9999),
            'path' => $this->faker->filePath(),
            'type' => $this->faker->mimeType()
        ];
    }
}
