<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngredientUsagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingredient_usages', function (Blueprint $table) {
            $table->bigIncrements('id'); // 使用履歴ID（主キー）
            $table->unsignedBigInteger('ingredient_id'); // 食材ID（外部キー）
            $table->decimal('quantity_used', 6, 2); // 使用量（kg, 個, L など）
            $table->date('used_at'); // 使用日
            $table->timestamps();

            // 外部キー制約
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
        Schema::dropIfExists('ingredient_usages');
    }
}
