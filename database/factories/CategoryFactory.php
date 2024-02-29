<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $parentCategory = Category::inRandomOrder()->first();
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph(),
            'parentCategory' => $parentCategory ? $parentCategory->id : null
        ];
    }
}
