<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Publication>
 */
class PublicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $url = fake()->unique()->url();

        return [
            'url' => $url,
            'url_hash' => hash('sha256', $url),
            'icon' => fake()->randomElement(['fas fa-newspaper', 'fas fa-gauge-high', 'fab fa-react', 'fab fa-laravel', 'fas fa-plug']),
            'title' => fake()->sentence(6),
            'venue' => fake()->company(),
            'category' => fake()->randomElement(['Frontend', 'Backend', 'SEO', 'API Design', 'Performance']),
            'description' => fake()->paragraph(),
            'is_published' => true,
        ];
    }

    /**
     * Indicate that the publication is not published.
     *
     * @return static
     */
    public function unpublished()
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
        ]);
    }
}
