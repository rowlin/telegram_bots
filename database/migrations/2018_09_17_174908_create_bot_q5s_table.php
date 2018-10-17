<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBotQ5sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bot_q5s', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tg_id');
            $table->string('tg_language_code')->default(' ');
            $table->string('tg_first_name')->default(' ');
            $table->string('tg_username')->default(' ');
            $table->boolean('q0')->default(false);
            $table->string('q1')->default(' ');
            $table->string('m1')->default(' ');
            $table->string('m2')->default(' ');
            $table->string('m3')->default(' ');
            $table->string('q3')->default(' ');
            $table->boolean('q4')->default(false);
            $table->integer('step')->default(0);
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
        Schema::dropIfExists('bot_q5s');
    }
}
