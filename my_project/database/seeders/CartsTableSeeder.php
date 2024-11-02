<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CartsTableSeeder extends Seeder
{
    public function run()
    {
        // Chèn dữ liệu mẫu vào bảng carts
        DB::table('carts')->insert([
            [
                'product_id' => 1, // ID sản phẩm
                'quantity' => 2,    // Số lượng
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 3,
                'quantity' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Thêm nhiều bản ghi khác nếu cần
        ]);
    }
}