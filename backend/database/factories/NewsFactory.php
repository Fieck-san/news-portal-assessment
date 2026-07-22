<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<\App\Models\News> */
class NewsFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence(8);

        return [
            'category_id' => Category::factory(),
            'author_id' => Author::factory(),
            'title' => $title,
            'title_en' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(1000, 9999),
            'summary' => fake()->paragraph(),
            'summary_en' => fake()->paragraph(),
            'body' => fake()->paragraphs(6, true),
            'body_en' => fake()->paragraphs(6, true),
            'image_url' => fake()->imageUrl(960, 540, 'news', true),
            'is_featured' => fake()->boolean(20),
            'published_at' => fake()->dateTimeBetween('-5 days', 'now'),
        ];
    }
}
