<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSize;

use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Clear data
        Schema::disableForeignKeyConstraints();
        ProductSize::truncate();
        Product::truncate();
        Category::truncate();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        // 1. Admin User
        User::create([
            'name' => 'Admin KICKSLAB',
            'email' => 'admin@kickslab.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // 2. Categories
        $men = Category::create(['name' => 'Men', 'slug' => 'men', 'image' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=2000']);
        $women = Category::create(['name' => 'Women', 'slug' => 'women', 'image' => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?q=80&w=2000']);
        $sport = Category::create(['name' => 'Sport', 'slug' => 'sport', 'image' => 'https://images.unsplash.com/photo-1556906781-9a412961d289?q=80&w=2000']);

        // 3. Products
        $products = [
            [
                'category_id' => $men->id,
                'name' => 'Nike Air Jordan 1 High OG "Lost & Found"',
                'slug' => 'nike-air-jordan-1-high-og-lost-found',
                'brand' => 'NIKE',
                'thumbnail' => 'https://images.unsplash.com/photo-1597045566677-8cf032ed6634?q=80&w=1000',
                'price' => 3500000,
                'description' => 'The Air Jordan 1 High OG "Lost & Found" brings back the iconic Chicago colorway with a vintage aesthetic. Featuring cracked leather and a pre-yellowed midsole, this sneaker pays homage to the original 1985 release.',
                'status' => 'active',
            ],
            [
                'category_id' => $sport->id,
                'name' => 'New Balance 550 "White Grey"',
                'slug' => 'new-balance-550-white-grey',
                'brand' => 'NEW BALANCE',
                'thumbnail' => 'https://images.unsplash.com/photo-1620786196238-d652968848d7?q=80&w=1000',
                'price' => 1899000,
                'description' => 'Simple and clean, not overbuilt. We created the 550s by paying tribute to the 90s pro ballers and the streetwear that defined a hoops generation.',
                'status' => 'active',
            ],
            [
                'category_id' => $women->id, // Assigning to Women for variety
                'name' => 'Adidas Samba OG "Black White"',
                'slug' => 'adidas-samba-og-black-white',
                'brand' => 'ADIDAS',
                'thumbnail' => 'https://images.unsplash.com/photo-1608231387042-66d1773070a5?q=80&w=1000',
                'price' => 2200000,
                'description' => 'Born on the pitch, the Samba is a timeless icon of street style. This version stays true to the legacy with a soft leather upper and suede overlays.',
                'status' => 'active',
            ],
            [
                'category_id' => $men->id, // Assigning to Men
                'name' => 'Vans Old Skool "Classic Black"',
                'slug' => 'vans-old-skool-classic-black',
                'brand' => 'VANS',
                'thumbnail' => 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?q=80&w=1000',
                'price' => 899000,
                'description' => 'The Old Skool, the Vans classic skate shoe and first to bare the iconic sidestripe, is a low top lace-up featuring sturdy canvas and suede uppers, re-enforced toecaps to withstand repeated wear.',
                'status' => 'active',
            ],
        ];

        foreach ($products as $data) {
            $product = Product::create($data);

            // Add sizes 39-44
            for ($size = 39; $size <= 44; $size++) {
                ProductSize::create([
                    'product_id' => $product->id,
                    'size' => (string)$size,
                    'stock' => rand(5, 20),
                ]);
            }
        }
    }
}