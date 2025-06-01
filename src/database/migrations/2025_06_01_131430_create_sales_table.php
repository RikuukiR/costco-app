<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id'); // 売上記録のID（主キー）
            $table->string('spec_code', 10); // 売上対象商品の製造番号
            $table->decimal('sales_amount', 10, 2); // 売上金額（円）
            $table->date('sales_date'); // 売上日
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
        Schema::dropIfExists('sales');
    }
}
