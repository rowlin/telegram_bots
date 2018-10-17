<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Bot6Data;
use Illuminate\Support\Facades\Redis;

Route::get('/', function () {
    return view('welcome');
});

Route::get('set_webhook', 'BotController@set_webhook');

Route::get('time' , function(){
    $collect  = Bot6Data::all()->pluck('text');
    $array = $collect->toArray();
    return (string) array_pop($array);

});


Route::get('rpush/{id}', function($id){
    $r = Redis::command( 'rpush' ,  [$id, 'name' , 'Test' , '111', '111', '378', '1212'] );
    return $r;
});

Route::get('lrange/{id}' , function($id){
    return Redis::command('lrange',[$id, 0, 20] );
});

Route::get('last/{id}', function($id){
 $array = Redis::command('lrange',[$id,  0 , -1 ] );
 dd($array);
});

Route::get('cache_get/{id}', function($id){
    return Redis::get($id);
});

Route::get('cache_del/{id}', function($id){
    return Redis::del($id);
});

Route::get('cache_flush', function(){
    return Redis::flushall();
});

/*
Route::get('/rpush', function(){
    Redis::connection()
    rpush test:1:messages "Hello, world!"
});
*/
