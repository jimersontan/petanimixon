<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run()
    {
        $brands = [
            ['name' => 'Royal Canin', 'description' => 'Premium natural dog foods since 1985'],
            ['name' => 'Blue Buffalo', 'description' => 'Natural ingredients for healthier pets'],
            ['name' => 'Kong', 'description' => 'Durable toys for active pets'],
            ['name' => 'Fluval', 'description' => 'Premium aquarium equipment'],
            ['name' => 'Zoo Med', 'description' => 'Complete reptile care solutions'],
            ['name' => 'Petco', 'description' => 'Trusted general pet supplies'],
            ['name' => 'Oxbow', 'description' => 'Nutrition for small pets'],
            ['name' => 'API', 'description' => 'Aquatic care products'],
        ];

        foreach ($brands as $b) {
            Brand::firstOrCreate(
                ['name' => $b['name']],
                array_merge($b, ['is_active' => true, 'is_featured' => true])
            );
        }
    }
}
