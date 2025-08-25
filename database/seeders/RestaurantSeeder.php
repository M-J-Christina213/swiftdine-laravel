<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Restaurant;
use App\Models\User;

class RestaurantSeeder extends Seeder
{
    public function run(): void
    {
        $owner1 = User::where('email', 'kamal@example.com')->first();
        $owner2 = User::where('email', 'shanika@example.com')->first();


        Restaurant::create([
            'name' => 'La Dolce Vita',
            'location' => 'Colombo, Sri Lanka',
            'cuisine' => 'Italian',
            'image_url' => 'images/la_dolce_vita.jpg',
            'rating' => 4.5,
            'owner_id' => $owner1->id,
        ]);

        Restaurant::create([
            'name' => 'Spicy Aroma',
            'location' => 'Kandy, Sri Lanka',
            'cuisine' => 'Indian',
            'image_url' => 'images/spicy_aroma.jpg',
            'rating' => 4.7,
            'owner_id' => $owner1->id,
        ]);

        Restaurant::create([
            'name' => 'Seafood Haven',
            'location' => 'Galle, Sri Lanka',
            'cuisine' => 'Seafood',
            'image_url' => 'images/seafood_haven.jpg',
            'rating' => 4.6,
            'owner_id' => $owner1->id,
        ]);

        Restaurant::create([
            'name' => 'ITC Randeepa',
            'location' => 'Colombo, Sri Lanka',
            'cuisine' => 'Sri Lankan special',
            'image_url' => 'images/itc_randeepa.jpg',
            'rating' => 4.8,
            'owner_id' => $owner2->id,
        ]);

        Restaurant::create([
            'name' => 'Kingsbury',
            'location' => 'Colombo, Sri Lanka',
            'cuisine' => 'Continental',
            'image_url' => 'images/kingsbury.jpg',
            'rating' => 4.7,
            'owner_id' => $owner2->id,
        ]);

        Restaurant::create([
            'name' => 'Mount Lavinia Hotel',
            'location' => 'Dehiwala, Sri Lanka',
            'cuisine' => 'Sri Lankan special',
            'image_url' => 'images/mount_lavinia.jpg',
            'rating' => 4.8,
            'owner_id' => $owner2->id,
        ]);
    }
}
