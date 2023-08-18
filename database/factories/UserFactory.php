<?php

namespace Database\Factories;

use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'avatar_id'    => File::factory(),
            'uuid'         => $this->faker->unique()->uuid,
            'first_name'   => $this->faker->firstName,
            'last_name'    => $this->faker->lastName,
            'address'      => $this->faker->address,
            'phone_number' => $this->faker->phoneNumber,
            'email'        => $this->faker->unique()->safeEmail(),
            'password'     => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ];
    }

    public function usingFile(File $file): self
    {
        return $this->state(fn() => ['avatar_id' => $file]);
    }

    public function admin(): self
    {
        return $this->state(fn() => ['is_admin' => true]);
    }
}
