<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecIngredientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spec_ingredients', function (Blueprint $table) {
            $table->bigIncrements('id'); // レコードID（主キー）
            $table->string('spec_code', 10); // 対象商品の製造番号
            $table->unsignedBigInteger('ingredient_id'); // 使用する食材のID
            $table->decimal('quantity_per_unit', 6, 2); // 1単位あたりの使用量
            $table->string('unit', 20)->nullable(); // 単位（kg、g、個など）
            $table->timestamps();

            // 外部キー制約
            $table->foreign('spec_code')->references('spec_code')->on('products')->onDelete('cascade');
            $table->foreign('ingredient_id')->references('id')->on('ingredients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spec_ingredients');
    }
}
