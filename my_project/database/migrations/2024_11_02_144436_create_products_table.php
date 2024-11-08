<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_type')->constrained('type_products');
            $table->string('name');
            $table->text('description');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('promotion_price', 10, 2);
            $table->string('image');
            $table->integer('new')->default(0);
            $table->integer('quantity')->default(0);
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
}
