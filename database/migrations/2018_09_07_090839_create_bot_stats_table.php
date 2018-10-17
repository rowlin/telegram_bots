<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBotStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bot_stats', function (Blueprint $table) {
            $table->increments('id');
            /*Пускай все будет  жирно */
            $table->string('update_id')->default(0);
            $table->string('user_id', 20);
            $table->string('username');
            $table->string('chat_id', 20);
            $table->string('text', 500);
            $table->string('message_id' , 20);
            $table->string('date')->default(0);
            $table->boolean('deleted')->default(false);
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
        Schema::dropIfExists('bot_stats');
    }
}
