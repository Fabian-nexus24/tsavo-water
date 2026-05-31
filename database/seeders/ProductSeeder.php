<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $bottledCat = Category::where('slug', 'bottled-water')->first()->id;
        $dispenserCat = Category::where('slug', 'water-dispensers')->first()->id;
        $refillCat = Category::where('slug', 'water-refills')->first()->id;
        $accCat = Category::where('slug', 'accessories')->first()->id;

        $products = [
            [
                'category_id' => $bottledCat, 'name' => '500ml Bottled Water (Pack of 24)', 
                'price' => 480, 'sale_price' => null, 'stock' => 100, 'is_featured' => true,
                'description' => 'Perfect for events and individual hydration.',
            ],
            [
                'category_id' => $bottledCat, 'name' => '1L Bottled Water (Pack of 12)', 
                'price' => 360, 'sale_price' => null, 'stock' => 100, 'is_featured' => true,
                'description' => 'Great for daily hydration.',
            ],
            [
                'category_id' => $bottledCat, 'name' => '5L Water Jerrycan', 
                'price' => 150, 'sale_price' => null, 'stock' => 50, 'is_featured' => false,
                'description' => 'Convenient size for small households.',
            ],
            [
                'category_id' => $bottledCat, 'name' => '10L Water Jerrycan', 
                'price' => 250, 'sale_price' => null, 'stock' => 50, 'is_featured' => false,
                'description' => 'Ideal for weekend trips or small offices.',
            ],
            [
                'category_id' => $refillCat, 'name' => '20L Water Bottle (Refill)', 
                'price' => 200, 'sale_price' => 180, 'stock' => 200, 'is_featured' => true,
                'description' => 'Return your empty bottle and get a fresh refill.',
            ],
            [
                'category_id' => $bottledCat, 'name' => '20L New Water Bottle', 
                'price' => 800, 'sale_price' => null, 'stock' => 50, 'is_featured' => true,
                'description' => 'First-time purchase including the bottle container.',
            ],
            [
                'category_id' => $dispenserCat, 'name' => 'Table Top Water Dispenser', 
                'price' => 4500, 'sale_price' => null, 'stock' => 20, 'is_featured' => false,
                'description' => 'Hot and cold water dispenser for countertops.',
            ],
            [
                'category_id' => $dispenserCat, 'name' => 'Floor Standing Water Dispenser', 
                'price' => 12000, 'sale_price' => null, 'stock' => 10, 'is_featured' => false,
                'description' => 'Premium floor standing dispenser with cooling cabinet.',
            ],
            [
                'category_id' => $accCat, 'name' => 'Water Bottle Cap', 
                'price' => 50, 'sale_price' => null, 'stock' => 500, 'is_featured' => false,
                'description' => 'Replacement non-spill caps for 20L bottles.',
            ],
            [
                'category_id' => $accCat, 'name' => 'Water Pump (Manual)', 
                'price' => 350, 'sale_price' => null, 'stock' => 100, 'is_featured' => false,
                'description' => 'Easy to use manual pump for 20L bottles.',
            ]
        ];

        foreach ($products as $index => $prod) {
            Product::create([
                'category_id' => $prod['category_id'],
                'name' => $prod['name'],
                'slug' => Str::slug($prod['name']),
                'description' => $prod['description'],
                'price' => $prod['price'],
                'sale_price' => $prod['sale_price'],
                'stock' => $prod['stock'],
                'is_featured' => $prod['is_featured'],
                'sort_order' => $index,
                'status' => 'active',
            ]);
        }
    }
}
