<?php

namespace Database\Seeders;

use App\Models\CardItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CardItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CardItem::factory()->count(50)->create();
    }
}