<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weights', function (Blueprint $table) {
            $table->bigIncrements('id'); // 品質管理記録ID（主キー）
            $table->string('spec_code', 10); // 測定対象商品の製造番号
            $table->decimal('destroyed_weight', 6, 2); // 廃棄した重量(gやkg)
            $table->decimal('actual_weight_1', 6, 2)->nullable(); // 実測値1回目
            $table->decimal('actual_weight_2', 6, 2)->nullable(); // 実測値2回目
            $table->decimal('actual_weight_3', 6, 2)->nullable(); // 実測値3回目
            $table->decimal('actual_weight_4', 6, 2)->nullable(); // 実測値4回目
            $table->decimal('actual_weight_5', 6, 2)->nullable(); // 実測値5回目
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
        Schema::dropIfExists('weights');
    }
}
