<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolumeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volume_details', function (Blueprint $table) {
            $table->bigIncrements('id'); // cell情報の一意なID（主キー）
            $table->unsignedBigInteger('volume_id'); // 発注ID（外部キー）
            $table->integer('cell_number'); // 発注したcellの連番
            $table->decimal('actual_weight', 6, 2); // 実際の重量(g)
            $table->decimal('calculated_price', 10, 2)->nullable(); // （単価×重量）の計算結果（円）
            $table->timestamps();

            // 外部キー制約
            $table->foreign('volume_id')->references('id')->on('volumes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('volume_details');
    }
}
