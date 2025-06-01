<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDestroysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('destroys', function (Blueprint $table) {
            $table->bigIncrements('id'); // 廃棄記録のID（主キー）
            $table->string('spec_code', 10); // 廃棄対象商品の製造番号
            $table->decimal('destroyed_weight', 6, 2); // 廃棄した重量
            $table->date('destroy_date'); // 廃棄した日
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
        Schema::dropIfExists('destroys');
    }
}
