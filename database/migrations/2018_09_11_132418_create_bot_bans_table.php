<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBotBansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bot_bans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('channel_id');
            $table->integer('bot_id');
            $table->string('user_id');
            $table->string('start_date', 20)->nullable() ;
            $table->integer('count')->default('0');
            $table->string('mark')->nullable();
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
        Schema::dropIfExists('bot_bans');
    }
}
