<?php
namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::truncate();

        Product::create([
            'name' => 'Wireless Mouse',
            'description' => '2.4G ergonomic mouse',
            'price' => 12.99,
            'stock' => 50,
            'is_active' => true,
        ]);

        Product::create([
            'name' => 'Mechanical Keyboard',
            'description' => 'Blue switches, RGB',
            'price' => 49.90,
            'stock' => 20,
            'is_active' => true,
        ]);

        Product::create([
            'name' => 'USB-C Cable',
            'description' => 'Fast charging 1m',
            'price' => 5.50,
            'stock' => 200,
            'is_active' => true,
        ]);

        Product::create([
            'name' => 'Gaming Headset',
            'description' => 'Surround sound, noise-cancelling mic',
            'price' => 29.99,
            'stock' => 15,
            'is_active' => true,
        ]);

        Product::create([
            'name' => 'Webcam',
            'description' => '1080p HD, built-in mic',
            'price' => 39.95,
            'stock' => 30,
            'is_active' => true,
        ]);

        Product::create([
            'name' => 'External Hard Drive',
            'description' => '1TB USB 3.0',
            'price' => 59.99,
            'stock' => 25,
            'is_active' => true,
        ]);
    }
}