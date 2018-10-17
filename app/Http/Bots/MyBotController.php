<?php

namespace App\Http\Controllers\Bots;

use Illuminate\Http\Request;
use Telegram\Bot\Api;
use App\Http\Controllers\Controller;


class MyBotController extends Controller
{

    protected $token = '59227418:AAHFUAw2ub08C2NHpL3xQa8H1sfl_1AJVgo';

    protected $is_admin= ['152308042'];

    protected $channels_to_job =  ['-1001332733639'];

    protected function Telegram()
    {
        $telegram = new Api($this->token);
        return $telegram;
    }


    public function commands($text , $channel_id){
        switch ($text){
            case "/start":
                $this->start($channel_id);
                break;
            case "/select_method":
                $this->select_method();
                break;
            case "/prepare_method" :
                $this->prepare_method();
                break;
            default :
                break;
        }

    }


    public function rules($message , $channel){
        if(isset($msg_data['sticker'])) {//удаляем стикеры
            $this->delete_msg( $channel['id'], $msg_data['message_id']);
        }elseif(isset($message['text'])) {
            $this->commands($message['text'], $channel['id']);
        }


    }

    /*thant is root function*/
    public  function update(){
        info("MYBOT 4 ()>>>");
        if(isset($response['message'])) {
            $this->rules($response['message'], $response['message']['chat']);
        }elseif(isset($response['callback_query'])) {

        }


    }

    /*Commands*/
    public function start($channel_id){
        $text = "Данный бот создан для поиска единомышленников в Вашем городе. Правила пользования ботом .";
        $buttons = [
            array("text" => "Подробнее о проекте", "callback_data" => '/about'),
            array("text" => "Выбрать метод" , "callback_data" => '/select_method' )
        ];
        $this->send_answer_buttons($channel_id, $text , $buttons);
    }

    public function select_method(){
        //inline keyboard
        //loop enter
    }

    public function prepare_method(){
        $text = "Вы можете предложить свой метод. Метод будет доступен после проверки (проверка в течении 15 - 20 минут) модератом. 
        Правила: bla-bla-bla... ";



    }

    public function whom(){

    }

    public  function select_time(){

    }

    public function select_place(){

    }

    public function input_text(){

    }
    /*End Commands*/


    /*Methods*/
    public function send_answer_buttons($chat_id, $text , array $buttons){
        $keyboard = array("inline_keyboard" => [$buttons]);
        $replyMarkup = json_encode($keyboard);
        $response = "cant send";
        if(in_array($chat_id, $this->channels_to_job)) {
            $response = $this->Telegram()->sendMessage([
                'chat_id' => $chat_id,
                'text' => $text,
                'parse_mode' => 'HTML',
                'reply_markup' => $replyMarkup
            ]);
        }
        return $response;
    }


    public function delete_msg($chat_id , $message_id){
        $response = 'cant dell';
        if(in_array($chat_id , $this->channels_to_job)) {
            $response = $this->Telegram()->deleteMessage([
                'chat_id' => $chat_id,
                'message_id' => $message_id,
            ]);
        }
        return $response;
    }




}
