<?php

namespace Database\Seeders;

// use Database\Seeders\CategorySeeder;
// use Database\Seeders\ArticleSeeder;
// use Database\Seeders\productcatsSeeder;
use Database\Seeders\ProductSeeder;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

      $this->call([
            ProductSeeder::class,
      ]);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
