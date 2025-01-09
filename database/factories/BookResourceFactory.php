<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookResource>
 */
class BookResourceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'published_year' => $this->faker->year,
            'isbn' => $this->faker->isbn13(),
            'publisher_id' => \App\Models\Publisher::factory(),
            'course_id' => \App\Models\Course::factory(),
        ];
    }
}
