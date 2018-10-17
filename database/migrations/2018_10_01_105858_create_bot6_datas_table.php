<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBot6DatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bot6_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('chat_id');
            $table->string('tg_username')->nullable();
            $table->string('language_code')->nullable();
            $table->string('text')->nullable();
            $table->string('update_id')->nullable();
            $table->string('ban_time')->nullable();
            $table->string('date');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bot6_datas');
    }
}
