<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<\App\Models\Author> */
class AuthorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'title' => fake()->randomElement(['Reporter', 'Senior Reporter', 'Editor', 'Columnist']),
            'avatar_url' => null,
        ];
    }
}

