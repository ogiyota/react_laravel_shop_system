<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->bigIncrements('cart_id');
            $table->string('item_name');
            $table->text('item_detail');
            $table->string('item_image');
            $table->decimal('item_price');
            $table->unsignedBigInteger('item_id');
            $table->integer('item_num');
            $table->integer('item_total_num');
            $table->unsignedBigInteger('user_id');
            $table->integer('cart_flg')->default(0);
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
        Schema::dropIfExists('carts');
    }
}
