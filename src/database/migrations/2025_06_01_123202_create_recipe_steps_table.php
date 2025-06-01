<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipeStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_steps', function (Blueprint $table) {
            $table->bigIncrements('id'); // 手順（主キー）
            $table->string('spec_code', 10); // 対象商品の製造番号
            $table->integer('step_order'); // 手順の順番（1,2,3…）
            $table->text('step_description'); // 手順の説明文
            $table->string('step_image_path', 255)->nullable(); // 調理途中の画像パス（任意）
            $table->timestamps();

            // 外部キー制約
            $table->foreign('spec_code')->references('spec_code')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipe_steps');
    }
}
