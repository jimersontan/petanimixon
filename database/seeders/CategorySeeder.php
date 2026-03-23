<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['category_name' => 'Food & Nutrition', 'description' => 'Premium foods for healthy, happy pets', 'is_active' => true, 'is_featured' => true],
            ['category_name' => 'Habitats & Housing', 'description' => 'Comfortable homes for every species', 'is_active' => true, 'is_featured' => true],
            ['category_name' => 'Health & Care', 'description' => 'Medical supplies and wellness products', 'is_active' => true, 'is_featured' => true],
            ['category_name' => 'Toys & Enrichment', 'description' => 'Fun and engaging toys for active pets', 'is_active' => true, 'is_featured' => true],
            ['category_name' => 'Grooming & Hygiene', 'description' => 'Keep your pet clean and beautiful', 'is_active' => true, 'is_featured' => true],
            ['category_name' => 'Travel & Safety', 'description' => 'Safe adventures with your companion', 'is_active' => true, 'is_featured' => true],
            ['category_name' => 'Aquatic Supplies', 'description' => 'Everything for water-loving pets', 'is_active' => true, 'is_featured' => true],
            ['category_name' => 'Reptile & Exotic Care', 'description' => 'Specialized supplies for unique pets', 'is_active' => true, 'is_featured' => true],
            ['category_name' => 'Invertebrate Care', 'description' => 'Products for insects and invertebrates', 'is_active' => true, 'is_featured' => true],
            ['category_name' => 'Training & Behavior', 'description' => 'Tools for better pet behavior', 'is_active' => true, 'is_featured' => true],
        ];

        foreach ($categories as $c) {
            Category::firstOrCreate(
                ['category_name' => $c['category_name']],
                $c
            );
        }
    }
}
