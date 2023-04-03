<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('item_id');
            $table->string('item_name');
            $table->text('item_detail');
            $table->decimal('item_price');
            $table->string('item_image');
            $table->integer('item_num');
            $table->integer('item_total_num');
            $table->integer('buy_num');
            $table->unsignedBigInteger('ctg_id');
            $table->unsignedBigInteger('user_id');
            $table->string('user_name');
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
        Schema::dropIfExists('items');
    }
}
