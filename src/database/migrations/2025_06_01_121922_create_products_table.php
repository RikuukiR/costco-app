<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->string('spec_code', 10)->primary(); // 製造番号（主キー）
            $table->string('name', 100); // 商品名
            $table->string('image_path', 255)->nullable(); // 商品画像パス
            $table->decimal('price', 10, 2)->nullable(); // 100gあたりの価格
            $table->decimal('target_weight', 6, 2); // 目標重量（g）
            $table->string('category', 50)->nullable(); // カテゴリ
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
