<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->bigIncrements('id'); // 製造予定ID（主キー）
            $table->string('spec_code', 10); // 製造予定の商品の製造番号
            $table->date('scheduled_date'); // 製造予定日
            $table->time('scheduled_time')->nullable(); // 製造予定時刻
            $table->integer('quantity_cell'); // 製造予定数(cell)
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
        Schema::dropIfExists('schedules');
    }
}
