<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Book;
use Faker\Factory;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        foreach (range(1, 20) as $index) {
            Book::create([
                'title' => $faker->name,
                'author' => $faker->name,
                'available_copies' => $faker->randomNumber(1),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
