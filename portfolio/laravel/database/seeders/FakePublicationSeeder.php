<?php

namespace Database\Seeders;

use App\Models\Publication;
use Illuminate\Database\Seeder;

class FakePublicationSeeder extends Seeder
{
    public function run(): void
    {
        Publication::factory()
            ->count(10)
            ->create()
            ->each(function (Publication $publication) {
                $publication->translations()->createMany([
                    [
                        'locale' => 'fa',
                        'title' => fake('fa_IR')->sentence(6),
                        'venue' => fake('fa_IR')->company(),
                        'category' => 'وب',
                        'description' => fake('fa_IR')->paragraph(),
                        'status' => 'published',
                    ],
                    [
                        'locale' => 'en',
                        'title' => fake()->sentence(6),
                        'venue' => fake()->company(),
                        'category' => fake()->randomElement(['Frontend', 'Backend', 'SEO', 'API Design', 'Performance']),
                        'description' => fake()->paragraph(),
                        'status' => 'published',
                    ],
                ]);
            });
    }
}
