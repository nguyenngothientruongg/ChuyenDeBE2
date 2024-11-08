<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        $products = [];
        
        for ($i = 1; $i <= 10; $i++) {
            $products[] = [
                'id_type' => rand(1, 5), // Adjust based on your `type_products` table
                'name' => 'Product ' . $i,
                'description' => Str::random(50),
                'unit_price' => rand(1000, 10000),
                'promotion_price' => rand(500, 9000),
                'image' => 'images/products/iphone_a.jpg',
                'new' => rand(0, 1),
                'quantity' => rand(10, 100),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('products')->insert($products);
    }
}
