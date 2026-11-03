<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->sentence(3),
            'description' => fake()->paragraph(2),
            'price' => fake()->numberBetween(20, 250) * 1000,
            'stock' => fake()->numberBetween(0, 50),
            'cover_photo' => fake()->slug(2) . '.jpg',
            'genre_id' => Genre::factory(),
            'author_id' => Author::factory(),
        ];
    }
}
