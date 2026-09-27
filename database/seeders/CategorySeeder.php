<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Cars' => ['Hatchback', 'Sedan', 'SUV', 'Luxury Cars'],
            'Mobiles' => ['Smartphones', 'Feature Phones', 'Accessories'],
            'Electronics & Appliances' => ['TVs', 'Refrigerators', 'ACs', 'Laptops'],
            'Furniture' => ['Sofa', 'Beds', 'Tables', 'Almirahs'],
            'Properties' => ['For Sale: Houses & Apartments', 'For Rent: Houses & Apartments', 'PG & Guest Houses'],
            'Jobs' => ['Sales & Marketing', 'IT / Software', 'Driver', 'Teacher'],
            'Services' => ['Home Renovation', 'Education & Classes', 'Packers & Movers', 'Wedding & Party'],
            'Fashion' => ['Men', 'Women', 'Kids'],
            'Pets' => ['Dogs', 'Cats', 'Birds', 'Fish'],
            'Books, Sports & Hobbies' => ['Books', 'Gym & Fitness', 'Musical Instruments'],
        ];

        foreach ($data as $categoryName => $subcategories) {
            $category = Category::firstOrCreate([
                'slug' => Str::slug($categoryName),
            ], [
                'name' => $categoryName,
            ]);

            foreach ($subcategories as $subName) {
                $category->subcategories()->firstOrCreate([
                    'slug' => Str::slug($subName),
                ], [
                    'name' => $subName,
                ]);
            }
        }
    }
}
