<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->bigIncrements('chat_id');
            $table->unsignedBigInteger('item_id');
            $table->string('item_name');
            $table->decimal('item_price');
            $table->text('item_detail');
            $table->string('item_image');
            $table->integer('buy_flg')->default(0);
            $table->unsignedBigInteger('user_id');
            $table->string('user_name');
            $table->tinyInteger('chat_user_id');
            $table->tinyInteger('chat_user_name');
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
        Schema::dropIfExists('chats');
    }
}
