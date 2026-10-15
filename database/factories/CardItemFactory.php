<?php

namespace Database\Factories;

use App\Models\CardItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CardItem>
 */
class CardItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
       public function definition(): array
   {
       return [
           'nama' => fake()->words(2, true),
           'kategori' => fake()->word(),
           'gambar' => 'default.jpg',
           'deskripsi' => fake()->sentence(),
       ];
   }
}
