<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'image' => 'news-62d38c509670c-1658031184.jpg',
            'title' => $this->faker->text(20),
            'content' => $this->faker->text(50),
            'article' => $this->faker->text(),
            'created_by' => rand(1, 14),
            'category_id' => 9,
        ];
    }
}
