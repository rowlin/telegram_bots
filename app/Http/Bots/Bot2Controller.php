<?php

namespace App\Http\Controllers\Bots;

use Illuminate\Http\Request;
use Telegram\Bot\Api;
use App\Http\Controllers\Controller;


class Bot2Controller extends Controller
{
    //protected $is_admin= ['152308042'];
    //protected $channels_to_job =  ['-1001332733639'];
    protected $name  = '';
    protected $bot_id = 3;

    protected function Telegram()
    {
        $telegram = new Api('658410446:AAG8WKB7EVZ3kod6KJSXbprelH5XQ32KIpg');
        return $telegram;
    }

    public  function update(Request $request){
        info('Bot2 >>');

        info($request);
        if (isset($request['message']['text'])) {
            if($request['message']['text'] == 'b'){
                $this->send_answer($request['message']['chat']['id'], 'this messages ', true);
            }
        }
        return '200';
    }




    public function send_answer($chat_id , $message= 0, $keyboard = false){
            // if($keyboard) {
            //inline_button
            /*
            $inline_button1 = array("text" => "На офф сайт", "url" => "https://prepayway.com");
            $inline_button2 = array("text" => "Подробнее", "callback_data" => '/about');
            $inline_button3 = array("text" => "Не интересно", "callback_data" => '/exit');
            $inline_keyboard = [[$inline_button1, $inline_button2 ,$inline_button3 ]];
            */
/*
            $keyboard = array(array(
            array("text" => "На офф сайт", "url" => "https://prepayway.com"),
            array("text" => "Подробнее", "callback_data" => '1'),
            array("text" => "Не интересно", "callback_data" => '2'),
            array('text' => 'Сообщить координаты', 'request_location' => true)
            ));
            $resp = array("keyboard" => $keyboard ,"resize_keyboard" => true,"one_time_keyboard" => true);
            $reply = json_encode($resp);
            $response = $this->Telegram()->sendMessage([
                'chat_id' =>  $chat_id,
                'text' =>  $message,
                'parse_mode' => 'HTML',
                'reply_markup' => $reply
            ]);
*/
        $keyboard = [
            [ ['text' => 'a', 'callback_data' =>'1'],
                ['text' => 'b', 'callback_data' =>'2'] ,
        ['text' => 'c', 'callback_data' => '3']],
            ['d', 'e', 'f'],
            ['g', 'j', 'w'],
            ['w']
        ];

        $reply_markup = $this->Telegram()->replyKeyboardMarkup([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ]);

        $response = $this->Telegram()->sendMessage([
            'chat_id' =>  $chat_id,
            'text' =>  $message,
            'parse_mode' => 'HTML',
            'reply_markup' => $reply_markup
        ]);

        $messageId = $response->getMessageId();

        return $messageId;

            //}

        //$messageId = $response->getMessageId();
        //info('>>> '. $messageId);

    }




}
