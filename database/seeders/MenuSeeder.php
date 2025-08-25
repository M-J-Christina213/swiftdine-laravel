<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\Restaurant;
use App\Models\Category;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $starter = Category::where('name', 'Starter')->first();
        $main = Category::where('name', 'Main Course')->first();
        $drink = Category::where('name', 'Drinks')->first();

        // Restaurant 1
        $r1 = Restaurant::where('name', 'La Dolce Vita')->first();
        Menu::create([
            'restaurant_id' => $r1->id,
            'category_id' => $starter->id,
            'name' => 'Cheese Kottu Roti',
            'description' => 'Spicy chopped godamba roti with vegetables, chicken...',
            'price' => 850.00,
            'image_url' => 'images/cheese_kottu_roti.jpg',
            'tags' => 'spicy,gluten',
        ]);

        Menu::create([
            'restaurant_id' => $r1->id,
            'category_id' => $main->id,
            'name' => 'Egg Hoppers',
            'description' => 'Crispy bowl-shaped pancakes with a soft egg center...',
            'price' => 450.00,
            'image_url' => 'images/egg_hoppers.jpg',
            'tags' => 'vegetarian,gluten-free',
        ]);

        // Restaurant 2
        $r2 = Restaurant::where('name', 'Spicy Aroma')->first();
        Menu::create([
            'restaurant_id' => $r2->id,
            'category_id' => $main->id,
            'name' => 'Jaffna Crab Curry',
            'description' => 'Fresh lagoon crab simmered in a fiery Jaffna-style...',
            'price' => 1950.00,
            'image_url' => 'images/jaffna_crab_curry.jpg',
            'tags' => 'spicy,gluten-free',
        ]);

        Menu::create([
            'restaurant_id' => $r2->id,
            'category_id' => $main->id,
            'name' => 'Paneer Butter Masala',
            'description' => 'Indian cottage cheese cubes in rich, creamy tomato...',
            'price' => 980.00,
            'image_url' => 'images/paneer_butter_masala.jpg',
            'tags' => 'vegetarian,gluten-free',
        ]);

        // Restaurant 3
        $r3 = Restaurant::where('name', 'Seafood Haven')->first();
        Menu::create([
            'restaurant_id' => $r3->id,
            'category_id' => $main->id,
            'name' => 'Devilled Prawns',
            'description' => 'Wok-tossed prawns in tangy, spicy sauce with bell...',
            'price' => 1750.00,
            'image_url' => 'images/devilled_prawns.jpg',
            'tags' => 'spicy,gluten-free',
        ]);

        Menu::create([
            'restaurant_id' => $r3->id,
            'category_id' => $main->id,
            'name' => 'Chinese Fried Rice with Chicken',
            'description' => 'Stir-fried rice with egg, chicken, spring onions...',
            'price' => 790.00,
            'image_url' => 'images/chinese_fried_rice_chicken.jpg',
            'tags' => 'gluten',
        ]);
    }
}
