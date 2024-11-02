<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            [
                'id_type' => 1,
                'name' => 'Iphone 11',
                'description' => 'Mô tả sản phẩm 1',
                'price' => 19.99,
                'quantity' => 100,
                'image' => 'images/products/iphone_a.jpg',  // Đường dẫn hình ảnh
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_type' => 2,
                'name' => 'Iphone 15',
                'description' => 'Mô tả sản phẩm 2',
                'price' => 29.99,
                'quantity' => 150,
                'image' => 'images/products/iphone_b.jpg',  // Đường dẫn hình ảnh
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_type' => 1,
                'name' => 'Iphone 16',
                'description' => 'Mô tả sản phẩm 3',
                'price' => 39.99,
                'quantity' => 200,
                'image' => 'images/products/iphone_c.jpg',  // Đường dẫn hình ảnh
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
