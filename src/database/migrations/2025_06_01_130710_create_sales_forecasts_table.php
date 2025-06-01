<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesForecastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_forecasts', function (Blueprint $table) {
            $table->bigIncrements('id'); // 予測ID（主キー）
            $table->date('date'); // 対象日
            $table->string('product_name', 100)->nullable(); // 商品名
            $table->decimal('forecast_value', 10, 2); // 予測売上金額（円）
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
        Schema::dropIfExists('sales_forecasts');
    }
}
