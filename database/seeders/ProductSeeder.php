<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => 'Iphone 11 64GB Inter',
                'price' => 999.99,
                'stock' => 8,
                'image' => 'image_path_1',
                'description' => 'Description for Iphone 11 64GB',
            ],
            [
                'name' => 'Iphone 11 256GB Inter',
                'price' => 1099.99,
                'stock' => 3,
                'image' => 'image_path_2',
                'description' => 'Description for Iphone 11 256GB',
            ],
            [
                'name' => 'Iphone 11 Pro 256GB Inter',
                'price' => 1299.99,
                'stock' => 0,
                'image' => 'image_path_3',
                'description' => 'Description for Iphone 11 Pro 256GB',
            ],
        ]);
    }
}
