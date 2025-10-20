<?php

namespace Database\Factories;

use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\Factory;

class StaffFactory extends Factory
{
    protected $model = Staff::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'photo_path' => 'staff/test-' . $this->faker->uuid() . '.jpg',
            'position' => $this->faker->randomElement([1, 2]),
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    public function position(int $position): static
    {
        return $this->state(fn (array $attributes) => [
            'position' => $position,
        ]);
    }
}
