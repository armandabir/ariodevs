<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PublicationTranslation>
 */
class PublicationTranslationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'locale' => fake()->randomElement(['fa', 'en']),
            'title' => fake()->sentence(6),
            'venue' => fake()->company(),
            'category' => fake()->randomElement(['Frontend', 'Backend', 'SEO', 'API Design', 'Performance']),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(['draft', 'published']),
        ];
    }
}
