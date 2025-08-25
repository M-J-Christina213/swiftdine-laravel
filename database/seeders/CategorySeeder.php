<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create(['name' => 'Starter']);
        Category::create(['name' => 'Main Course']);
        Category::create(['name' => 'Drinks']);
        Category::create(['name' => 'Desserts']);
    }
}
