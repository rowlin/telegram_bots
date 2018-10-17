<?php

namespace App\Http\Controllers;
use App\Bot_stat;
use Illuminate\Http\Request;
use Telegram\Bot\Api;


class BotController extends Controller
{
    protected $channels_to_job = ['-1001332733639'];

    protected function Telegram()
      {
        $telegram = new Api('581292402:AAFsn9URE_I_XqHqw_6jm2FH0G9vd8hhdDs');
        return $telegram;
      }

    public function rules($msg_data , $chat_data){
        if(isset( $msg_data['text'])) {
            if($msg_data['text'] == '/start'){
                $this->send_answer($chat_data['id'],"*Привет _". $msg_data['from']['username'] ."_ !* 
                _Рад, что Вы здесь)_ 
                1) Вы проживаете в Таллинне?", 1 );
            }
        }
    }




    public function get_updates(Request $response)
    {
        info("BOT1 > ...");

        info($response);
        if(isset($response['message'])) {
                $this->rules($response['message'], $response['message']['chat']);
            }elseif(isset($response['callback_query'])){
                $chatId = $response["callback_query"]["message"]["chat"]["id"];
                switch($response['callback_query']['data']){
                    case "y0" || "n0" :
                        info($response);
                        $this->send_answer( $chatId, "<b>Тут инфа про нас</b>");
                        break;
                    case "/exit":
                        $this->send_answer( $chatId, "Спасибо за Ваше время..");
                        break;
                    case "/channels":
                        $this->send_answer( $chatId, "<b>Bla-bla-bla </b><pre>Сылки на наши каналы</pre>");
                        break;
                    default:
                        $this->send_answer( $chatId, "Не понял , что это ");
                }
            }
            if(isset($response['edited_message'])){
                if ($response['edited_message']['from']['is_bot'] == false) {
                    $this->rules($response['edited_message'], $response['edited_message']['chat'] );
                }
            }
    }


    public function send_answer($chat_id , $message= 0, $keyboard = false){
        if($keyboard) {
            $inline_keyboard = [];

            if($keyboard == 1){
                $inline_button1 = array("text" => "Да", "callback_data" => 'y0');
                $inline_button2 = array("text" => "Нет", "callback_data" => 'n0');
                $inline_keyboard = [[$inline_button1, $inline_button2]];
            }
            elseif($keyboard == 2){
                $inline_button1 = array("text" => "Да", "callback_data" => 'y1');
                $inline_button2 = array("text" => "Нет", "callback_data" => 'n1');
                $inline_button3 = array("text" => "Нет", "callback_data" => 's1');
                $inline_keyboard = [[$inline_button1,$inline_button3, $inline_button2]];
            }

            $keyboard = array("inline_keyboard" => $inline_keyboard);
            $replyMarkup = json_encode($keyboard);
            $response = $this->Telegram()->sendMessage([
                'chat_id' =>  $chat_id,
                'text' =>  $message,
                'parse_mode' => 'Markdown',
                'reply_markup' => $replyMarkup
            ]);
        }
        else {
            $response = $this->Telegram()->sendMessage([
                'chat_id' => $chat_id,
                'text' => $message,
                'parse_mode' => 'Markdown',
            ]);
        }

        $messageId = $response->getMessageId();
        return $messageId;
    }




    /* не удаляет из лички*/
    public function delete_msg($chat_id , $message_id){
        $response = 'none';
        if(in_array($chat_id , $this->channels_to_job)) {
            $response = $this->Telegram()->deleteMessage([
                'chat_id' => $chat_id,
                'message_id' => $message_id,
            ]);
    /* TODO: create Event () where i can update Bot_stat*/
            $update = Bot_stat::where('chat_id', $chat_id)->where('message_id' , $message_id)->first();
            if($update != null){
                $update->deleted = true;
                $update->save();
            }
        }
        return $response;
    }

    
    /*get('/bot/get_self')*/
    public function get_self(){
        $response = $this->Telegram()->getMe();
        return $response;
    }


    /**/
    public function set_webhook($url= '666158865:AAHe1WW7B-4VkQfe0FhCyad2qwrb7_Yvc4I'){
        $response = $this->Telegram()->setWebhook(['url' => 'https://friendshipmuseum.ru/'.$url.'/webhook']);
        info('set webhook : ' . $url.'/webhook');
        dd($response);
        //return redirect()->back();
    }

    /**/
    public function remove_webhook(){
        $this->Telegram()->removeWebhook();
        return redirect()->back();
    }


    /*webhook _ */
    public function webhook(){
        $updates = $this->Telegram()->getWebhookUpdates();
        //kill_me
        return 'ok';
    }
    
    
    

}
