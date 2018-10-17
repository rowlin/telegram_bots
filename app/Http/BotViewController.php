<?php

namespace App\Http\Controllers;

use App\Bot;
use Illuminate\Http\Request;
use Telegram\Bot\Api;
class BotViewController extends Controller
{


    protected function Telegram($token)
    {
        $telegram = new Api($token);
        return $telegram;
    }

    public function index(){
        $bots = Bot::all();

        return view('admin.section.bot.bots', compact('bots'));
    }
    
    public function create(){
        return view('admin.section.bot.edit');
    }
    
    
    public function show($id){
       $bot =   Bot::where('id' , $id)->first();
       return view('admin.section.bot.edit' , compact('bot'));
        
    }


    public function save(Request $request){
        $bot = new Bot;
        $bot->name = $request->name;
        $bot->desc = $request->desc;
        $bot->token = $request->token;
        $bot->http_client_handler = $request->http_client_handler;
        $bot->commands = json_encode($request->commands) ;
        $bot->function = json_encode($request->function);
        $bot->save();
        return redirect()->back();

    }

    
    public function save_edit($id , Request $request){
        $bot =  Bot::where('id' , $id)->first();
        $bot->name = $request->name;
        $bot->desc = $request->desc;
        $bot->token = $request->token;
        $bot->http_client_handler = $request->http_client_handler;
        $bot->commands = json_encode($request->commands) ;
        $bot->function = json_encode($request->function);
        $bot->save();
        return redirect('admin/bots');

    }


    public function start($id){
        $bot = Bot::where('id', $id)->first();
        $this->Telegram($bot->token)->setWebhook(['url' => 'https://friendshipmuseum.ru/'.$bot->token.'/webhook']);
        $bot->status = 1 ;
        $bot->save();
        return redirect()->back();
    }
    

    public  function stop($id){
        $bot = Bot::where('id', $id)->first();
        $this->Telegram($bot->token)->removeWebhook();
        $bot->status = 0 ;
        $bot->save();
        return redirect()->back();
    }

    public function bot_stat(){
        return view('admin.section.bot.stat');
    }

    public function settings($id){
        $bot = Bot::where('id', $id)->first();
        return view('admin.section.bot.settings', compact('bot'));
    }

    public function delete_sticker_set($id, $chat_id = '@public_grabber'){
        $bot = Bot::where('id', $id)->first();
        $result =  $this->Telegram($bot->token)->deleteChatSticker($chat_id);
        dd($result);
        //return redirect()->back();
    }

    /*not job*/
    public function get_admins($id, $chat_id = '@public_grabber'){
        $bot = Bot::where('id', $id)->first();
        $result = $this->Telegram($bot->token)->post('getChatAdministrators', ['chat_id' => $chat_id]);
        dd($result);
    }

    /*return false*/
    public function get_chat($id ,$chat_id = "@public_grabber"){
        $bot = Bot::where('id', $id)->first();
        $result = $this->Telegram($bot->token)->post('getChat', ['chat_id' => $chat_id]);
        dd($result);
    }

    public function getMe(){
        $bot = Bot::where('id', 1)->first();
        $result = $this->Telegram($bot->token)->post('unbanChatMember' , ['chat_id' => '1332733639' , 'user_id' => 'leksander0']);
        dd($result);


    }

    
    public function getWebhookinfo($id){
        $bot = Bot::where('id', $id)->first();
        $result = $this->Telegram($bot->token)->get();
        //post('', ['chat_id' => $chat_id]);
        dd($result);
    }

    
    
}


