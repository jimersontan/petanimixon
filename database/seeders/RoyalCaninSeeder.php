<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoyalCaninSeeder extends Seeder
{
    public function run()
    {
        try {
            // Ensure Animal Type exists
            $animalTypeId = DB::table('animal_types')->insertGetId([
                'animal_type' => 'Dog',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Ensure Seller exists
            $sellerId = DB::table('sellers')->insertGetId([
                'business_name' => 'Royal Canin Official',
                'business_email' => 'sales@royalcanin.com',
                'business_phone' => '1234567890',
                'business_registration_number' => '12345',
                'business_registration_number_type' => 'Tax ID',
                'store_name' => 'Royal Canin Official Store',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Royal Canin brand usually exists in BrandSeeder, but we can query it or rely on ID 1 if BrandSeeder runs first.
            // Same for Category 'Food & Nutrition'. We will query them.
            $brand = DB::table('brands')->where('name', 'Royal Canin')->first();
            $brandName = $brand ? $brand->name : 'Royal Canin';
            
            $category = DB::table('categories')->where('category_name', 'Food & Nutrition')->first();
            $categoryId = $category ? $category->id : 1; // Fallback to 1 if not found

            $products = [
                ['name' => 'Royal Canin Mini Adult', 'price' => 1200, 'short_desc' => 'For small breed adult dogs.'],
                ['name' => 'Royal Canin Medium Adult', 'price' => 1500, 'short_desc' => 'For medium breed adult dogs.'],
                ['name' => 'Royal Canin Maxi Adult', 'price' => 1800, 'short_desc' => 'For large breed adult dogs.'],
                ['name' => 'Royal Canin Puppy Mini', 'price' => 1300, 'short_desc' => 'For small breed puppies.'],
                ['name' => 'Royal Canin Puppy Medium', 'price' => 1600, 'short_desc' => 'For medium breed puppies.'],
                ['name' => 'Royal Canin Puppy Maxi', 'price' => 1900, 'short_desc' => 'For large breed puppies.'],
                ['name' => 'Royal Canin Shih Tzu Adult', 'price' => 1250, 'short_desc' => 'Breed specific food for Shih Tzu.'],
                ['name' => 'Royal Canin Golden Retriever Adult', 'price' => 1850, 'short_desc' => 'Breed specific food for Golden Retriever.'],
                ['name' => 'Royal Canin Dachshund Adult', 'price' => 1250, 'short_desc' => 'Breed specific food for Dachshund.'],
                ['name' => 'Royal Canin Poodle Adult', 'price' => 1250, 'short_desc' => 'Breed specific food for Poodles.'],
                ['name' => 'Royal Canin Yorkshire Terrier Adult', 'price' => 1250, 'short_desc' => 'Breed specific food for Yorkies.'],
            ];

            foreach ($products as $index => $item) {
                $sku = 'RC-' . strtoupper(Str::random(6)) . '-' . rand(100, 999);
                
                $productId = DB::table('products')->insertGetId([
                    'seller_id' => $sellerId,
                    'animal_type' => 'Dog',
                    'animal_category_id' => $categoryId,
                    'product_name' => $item['name'],
                    'price' => $item['price'],
                    'sku' => $sku,
                    'short_description' => $item['short_desc'],
                    'brand_name' => $brandName,
                    'is_featured' => true,
                    'is_active' => true,
                    'product_status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('product_variants')->insert([
                    'product_id' => $productId,
                    'variant_name' => 'Standard Bag',
                    'variant_quantity' => 50,
                    'variant_price' => $item['price'],
                    'sku' => $sku . '-VAR',
                    'uom' => 'Bag',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        } catch (\Exception $e) {
            file_put_contents('seeder_error.txt', $e->getMessage());
        }
    }
}
