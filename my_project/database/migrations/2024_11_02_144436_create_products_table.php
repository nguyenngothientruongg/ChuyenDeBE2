<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('id_type');
            $table->string('name');  // Tên sản phẩm
            $table->string('image')->nullable();  // Anh san pham
            $table->text('description');  // Mô tả sản phẩm
            $table->integer('price');  // Giá sản phẩm
            $table->integer('quantity');  // Số lượng sản phẩm
            $table->timestamps();  // Thời gian tạo và cập nhật
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
