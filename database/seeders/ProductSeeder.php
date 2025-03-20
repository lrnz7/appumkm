<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\Log; // Import Log facade

class ProductSeeder extends Seeder
{
    public function run()
    {
        Log::info('Running ProductSeeder...'); // Log statement to confirm execution

        Product::create([
            'name' => 'Iphone 11 64GB Inter',
            'price' => 999.99,
            'stock' => 10,
            'image' => 'image_path_1',
            'description' => 'Description for Iphone 11 64GB',
        ]);

        Product::create([
            'name' => 'Iphone 11 256GB Inter',
            'price' => 1099.99,
            'stock' => 5,
            'image' => 'image_path_2',
            'description' => 'Description for Iphone 11 256GB',
        ]);

        Product::create([
            'name' => 'Iphone 11 Pro 256GB Inter',
            'price' => 1299.99,
            'stock' => 3,
            'image' => 'image_path_3',
            'description' => 'Description for Iphone 11 Pro 256GB',
        ]);
    }
}
