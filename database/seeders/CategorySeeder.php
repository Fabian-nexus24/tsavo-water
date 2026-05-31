<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Bottled Water', 'description' => 'Premium bottled water for home and office.'],
            ['name' => 'Water Dispensers', 'description' => 'High quality water dispensers.'],
            ['name' => 'Water Refills', 'description' => 'Eco-friendly water refills.'],
            ['name' => 'Accessories', 'description' => 'Pumps, caps, and other accessories.'],
        ];

        foreach ($categories as $index => $cat) {
            Category::create([
                'name' => $cat['name'],
                'slug' => Str::slug($cat['name']),
                'description' => $cat['description'],
                'sort_order' => $index,
                'is_active' => true,
            ]);
        }
    }
}
