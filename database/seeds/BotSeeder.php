<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class BotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bots')->insert([
            'name' => 'Test_bot' ,
            'desc' => 'Первый тестовый бот',
            'token' =>'',
            'http_client_handler'=> '',
            'commands' => '',
            'function' => '',
            //'status' => false
        ]);
    }
}
