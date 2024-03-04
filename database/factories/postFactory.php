<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\post>
 */
class postFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo' => fake()->unique()->sentence(),
            'description' => fake()->paragraph(),
            'image' => fake()->imageUrl($width=640, $height = 480),
            'body' => fake()->text(),
            'autor' => fake()->randomElement([1, 2]),
            'borrador' => 0
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Post $post) {
            $category = Category::inRandomOrder()->first();

            $post->categories()->attach($category);
        });
    }

}
