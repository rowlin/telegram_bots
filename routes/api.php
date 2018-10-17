<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//Prepayway_statbot
Route::post('666158865:AAHe1WW7B-4VkQfe0FhCyad2qwrb7_Yvc4I/webhook', 'Bot6Controller@update')->name('stat');

//Tallinn interview bot
Route::post('592926707:AAG24GaEc9QPqPqskXELcbIF5LmAziKvvAA/webhook', 'Bot5Controller@update');


//Route::post('659227418:AAHFUAw2ub08C2NHpL3xQa8H1sfl_1AJVgo/webhook', 'Bots\MyBotController@update');
//Route::post('581292402:AAFsn9URE_I_XqHqw_6jm2FH0G9vd8hhdDs/webhook', 'Bots\BotController@get_updates');
//Route::post('658410446:AAG8WKB7EVZ3kod6KJSXbprelH5XQ32KIpg/webhook', 'Bots\Bot2Controller@update');
//Route::post('666158865:AAHe1WW7B-4VkQfe0FhCyad2qwrb7_Yvc4I/webhook', 'Bots\Bot3Controller@update');
//Route::post('659227418:AAHFUAw2ub08C2NHpL3xQa8H1sfl_1AJVgo/webhook', 'Bots\MyBotController@update');
