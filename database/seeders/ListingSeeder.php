<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Listing;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ListingSeeder extends Seeder
{
    public function run(): void
    {
        // Create demo users if not present
        $user1 = User::firstOrCreate(
            ['email' => 'rahul.sharma@example.com'],
            ['name' => 'Rahul Sharma', 'password' => bcrypt('password')]
        );

        $user2 = User::firstOrCreate(
            ['email' => 'priya.verma@example.com'],
            ['name' => 'Priya Verma', 'password' => bcrypt('password')]
        );

        $user3 = User::firstOrCreate(
            ['email' => 'amit.patel@example.com'],
            ['name' => 'Amit Patel', 'password' => bcrypt('password')]
        );

        $user4 = User::firstOrCreate(
            ['email' => 'sneha.reddy@example.com'],
            ['name' => 'Sneha Reddy', 'password' => bcrypt('password')]
        );

        $demoListings = [
            [
                'category' => 'Cars',
                'subcategory' => 'Sedan',
                'name' => 'Honda City ZX i-VTEC 2021 Automatic - Sunroof',
                'type' => 'product',
                'price' => 1145000,
                'detail' => 'Single owner, pristine condition, full company service history available. 24,000 km driven. Includes sunroof, leather upholstery, 360-degree camera, and push-button start.',
                'country' => 'India',
                'state' => 'Maharashtra',
                'city' => 'Mumbai',
                'area' => 'Bandra West',
                'image' => 'https://images.unsplash.com/photo-1590362891991-f776e747a588?q=80&w=800&auto=format&fit=crop',
                'user' => $user1,
            ],
            [
                'category' => 'Cars',
                'subcategory' => 'SUV',
                'name' => 'Mahindra Thar LX Diesel Automatic 4WD 2023',
                'type' => 'product',
                'price' => 1580000,
                'detail' => 'Hard top edition Thar in Napoli Black. Hardly 12,000 km driven. Fitted with upgraded off-road bumpers, alloy wheels, and touchscreen infotainment system with Android Auto & Apple CarPlay.',
                'country' => 'India',
                'state' => 'Delhi',
                'city' => 'Delhi',
                'area' => 'Vasant Kunj',
                'image' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?q=80&w=800&auto=format&fit=crop',
                'user' => $user2,
            ],
            [
                'category' => 'Mobiles',
                'subcategory' => 'Smartphones',
                'name' => 'iPhone 15 Pro Max 256GB Titanium Blue (Under Warranty)',
                'type' => 'product',
                'price' => 1089000,
                'detail' => 'Original Indian invoice available, 4 months official Apple Warranty remaining. 98% Battery Health. Spotless condition with original box, cable, and ESR armor case included.',
                'country' => 'India',
                'state' => 'Karnataka',
                'city' => 'Bengaluru',
                'area' => 'Indiranagar',
                'image' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?q=80&w=800&auto=format&fit=crop',
                'user' => $user3,
            ],
            [
                'category' => 'Mobiles',
                'subcategory' => 'Smartphones',
                'name' => 'Samsung Galaxy S24 Ultra 521GB Titanium Gray',
                'type' => 'product',
                'price' => 99999,
                'detail' => 'Just 2 months used. Packed with Galaxy AI features, S-Pen included, 200MP camera setup. Comes with bill, box, and Spigen screen guard applied.',
                'country' => 'India',
                'state' => 'Maharashtra',
                'city' => 'Pune',
                'area' => 'Koregaon Park',
                'image' => 'https://images.unsplash.com/photo-1610945265064-0e34e5519bbf?q=80&w=800&auto=format&fit=crop',
                'user' => $user4,
            ],
            [
                'category' => 'Electronics & Appliances',
                'subcategory' => 'Laptops',
                'name' => 'Apple MacBook Pro 16" M3 Pro 36GB RAM 512GB SSD',
                'type' => 'product',
                'price' => 195000,
                'detail' => 'Space Black MacBook Pro for video editors & developers. Only 18 battery cycles, immaculate condition. Includes M3 Pro chip, original 140W MagSafe charger, and box.',
                'country' => 'India',
                'state' => 'Telangana',
                'city' => 'Hyderabad',
                'area' => 'HITEC City',
                'image' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?q=80&w=800&auto=format&fit=crop',
                'user' => $user1,
            ],
            [
                'category' => 'Electronics & Appliances',
                'subcategory' => 'TVs',
                'name' => 'Sony Bravia 55 Inch 4K Ultra HD Smart OLED TV',
                'type' => 'product',
                'price' => 68500,
                'detail' => 'XR Cognitive Processor, 120Hz Refresh Rate for PS5 gaming, Dolby Vision & Atmos sound. Selling due to relocation. Wall mount & magic remote included.',
                'country' => 'India',
                'state' => 'Maharashtra',
                'city' => 'Mumbai',
                'area' => 'Powai',
                'image' => 'https://images.unsplash.com/photo-1593784991095-a205069470b6?q=80&w=800&auto=format&fit=crop',
                'user' => $user2,
            ],
            [
                'category' => 'Properties',
                'subcategory' => 'For Sale: Houses & Apartments',
                'name' => 'Modern 3 BHK Luxury Apartment in Seawoods Darave',
                'type' => 'product',
                'price' => 18500000,
                'detail' => '1450 sqft carpet area, East-facing, fully furnished apartment with modular kitchen, private balcony with sea view, gym, swimming pool, and 2 reserved car parking spots.',
                'country' => 'India',
                'state' => 'Maharashtra',
                'city' => 'Navi Mumbai',
                'area' => 'Seawoods',
                'image' => 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?q=80&w=800&auto=format&fit=crop',
                'user' => $user3,
            ],
            [
                'category' => 'Properties',
                'subcategory' => 'For Rent: Houses & Apartments',
                'name' => 'Spacious 2 BHK Fully Furnished Flat near Manyata Tech Park',
                'type' => 'product',
                'price' => 38000,
                'detail' => 'Available for immediate rent. High-speed fiber internet, power backup, ACs in both bedrooms, washing machine, refrigerator, sofa set, and 24/7 security.',
                'country' => 'India',
                'state' => 'Karnataka',
                'city' => 'Bengaluru',
                'area' => 'Hebbal',
                'image' => 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?q=80&w=800&auto=format&fit=crop',
                'user' => $user4,
            ],
            [
                'category' => 'Furniture',
                'subcategory' => 'Sofa',
                'name' => 'L-Shaped 6-Seater Royal Velvet Sofa with Lounger',
                'type' => 'product',
                'price' => 24500,
                'detail' => 'Custom made navy blue premium velvet sofa with high density foam cushions. Barely 6 months old, no stain or wear. Selling because of living room remodeling.',
                'country' => 'India',
                'state' => 'Delhi',
                'city' => 'Delhi',
                'area' => 'South Extension',
                'image' => 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?q=80&w=800&auto=format&fit=crop',
                'user' => $user1,
            ],
            [
                'category' => 'Furniture',
                'subcategory' => 'Beds',
                'name' => 'Solid Teak Wood King Size Bed with Storage & Mattress',
                'type' => 'product',
                'price' => 32000,
                'detail' => 'Handcrafted solid teak wood bed frame with hydraulic storage under bed. Comes with Sleepwell 8-inch orthopedic memory foam mattress.',
                'country' => 'India',
                'state' => 'Maharashtra',
                'city' => 'Pune',
                'area' => 'Aundh',
                'image' => 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?q=80&w=800&auto=format&fit=crop',
                'user' => $user2,
            ],
            [
                'category' => 'Services',
                'subcategory' => 'Home Renovation',
                'name' => 'Professional Interior Design & Home Painting Services',
                'type' => 'service',
                'price' => 1500,
                'detail' => '3D design consultation, waterproof interior & exterior painting, false ceiling, modular kitchen setups, and custom furniture woodwork. Free site inspection!',
                'country' => 'India',
                'state' => 'Maharashtra',
                'city' => 'Mumbai',
                'area' => 'Andheri East',
                'image' => 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?q=80&w=800&auto=format&fit=crop',
                'user' => $user3,
            ],
            [
                'category' => 'Services',
                'subcategory' => 'Packers & Movers',
                'name' => 'Express Packers & Movers - Interstate & Local Shifting',
                'type' => 'service',
                'price' => 4500,
                'detail' => 'Hassle-free household relocation, vehicle transport, bubble wrapping, insurance coverage, and professional loading/unloading team. 100% safe guarantee.',
                'country' => 'India',
                'state' => 'Karnataka',
                'city' => 'Bengaluru',
                'area' => 'Koramangala',
                'image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=800&auto=format&fit=crop',
                'user' => $user4,
            ],
            [
                'category' => 'Jobs',
                'subcategory' => 'IT / Software',
                'name' => 'Senior Full Stack Laravel & Vue.js Developer',
                'type' => 'service',
                'price' => 120000,
                'detail' => 'Looking for experienced Laravel + Vue/React developers for high-scale SaaS product. Remote / Hybrid option available in Bengaluru. Competitive salary + ESOPs.',
                'country' => 'India',
                'state' => 'Karnataka',
                'city' => 'Bengaluru',
                'area' => 'HSR Layout',
                'image' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?q=80&w=800&auto=format&fit=crop',
                'user' => $user1,
            ],
            [
                'category' => 'Books, Sports & Hobbies',
                'subcategory' => 'Musical Instruments',
                'name' => 'Yamaha FG800 Acoustic Guitar with Gig Bag & Tuner',
                'type' => 'product',
                'price' => 14000,
                'detail' => 'Solid Sitka Spruce top acoustic guitar. Warm acoustic tone, low action setup done recently. Includes padded gig bag, digital tuner, D\'Addario spare strings, and picks.',
                'country' => 'India',
                'state' => 'West Bengal',
                'city' => 'Kolkata',
                'area' => 'Park Street',
                'image' => 'https://images.unsplash.com/photo-1510915361894-db8b60106cb1?q=80&w=800&auto=format&fit=crop',
                'user' => $user2,
            ],
            [
                'category' => 'Pets',
                'subcategory' => 'Dogs',
                'name' => 'Friendly Golden Retriever Puppies (KCI Registered)',
                'type' => 'product',
                'price' => 22000,
                'detail' => 'Vaccinated, dewormed, healthy 60-day old Golden Retriever puppies. Very playful and trained around kids. Microchipped with KCI pedigree certificate.',
                'country' => 'India',
                'state' => 'Telangana',
                'city' => 'Hyderabad',
                'area' => 'Jubilee Hills',
                'image' => 'https://images.unsplash.com/photo-1552053831-71594a27632d?q=80&w=800&auto=format&fit=crop',
                'user' => $user3,
            ],
            [
                'category' => 'Fashion',
                'subcategory' => 'Men',
                'name' => 'Original Leather Biker Jacket - Handcrafted Classic',
                'type' => 'product',
                'price' => 7500,
                'detail' => '100% Genuine Lambskin leather jacket in deep tan brown. YKK zippers, quiled interior lining. Size L, brand new condition.',
                'country' => 'India',
                'state' => 'Rajasthan',
                'city' => 'Jaipur',
                'area' => 'C Scheme',
                'image' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?q=80&w=800&auto=format&fit=crop',
                'user' => $user4,
            ],
        ];

        foreach ($demoListings as $item) {
            $cat = Category::firstOrCreate(
                ['name' => $item['category']],
                ['slug' => Str::slug($item['category'])]
            );

            $subcat = Subcategory::firstOrCreate(
                ['category_id' => $cat->id, 'name' => $item['subcategory']],
                ['slug' => Str::slug($item['subcategory'])]
            );

            Listing::firstOrCreate(
                ['name' => $item['name']],
                [
                    'user_id' => $item['user']->id,
                    'category_id' => $cat->id,
                    'subcategory_id' => $subcat->id,
                    'type' => $item['type'],
                    'detail' => $item['detail'],
                    'price' => $item['price'],
                    'country' => $item['country'],
                    'state' => $item['state'],
                    'city' => $item['city'],
                    'area' => $item['area'],
                    'image' => $item['image'],
                    'is_active' => true,
                ]
            );
        }
    }
}
