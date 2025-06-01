<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngredientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingredients', function (Blueprint $table) {
            $table->bigIncrements('id'); // 食材ID（主キー）
            $table->string('name', 100); // 食材名
            $table->string('category', 50)->nullable(); // カテゴリー（肉、野菜等）
            $table->string('product_spec_code', 10); // 商品の製造番号（外部キー）
            $table->decimal('stock_quantity', 6, 2)->default(0); // 在庫数（kgや個）
            $table->string('unit', 20)->nullable(); // 単位（kg、個、L など）
            $table->enum('status', ['in_stock', 'low_stock', 'out_of_stock']); // 在庫状態
            $table->timestamps();

            // 外部キー制約
            $table->foreign('product_spec_code')->references('spec_code')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingredients');
    }
}
