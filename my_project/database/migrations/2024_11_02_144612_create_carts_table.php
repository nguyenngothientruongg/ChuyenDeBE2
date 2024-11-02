<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');  // Khóa ngoại liên kết đến bảng products
            $table->integer('quantity');  // Số lượng sản phẩm trong giỏ hàng
            $table->timestamps();  // Thời gian tạo và cập nhật
        });
    }

    public function down()
    {
        Schema::dropIfExists('carts');
    }
}
