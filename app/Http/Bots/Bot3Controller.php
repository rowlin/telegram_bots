<?php

namespace App\Http\Controllers\Bots;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Telegram\Bot\Api;
//use App\Jobs\BotStat;
use App\Bot_stat;
use App\Bot_bans;

class Bot3Controller extends Controller
{

    /*
     * Бот для сбора статистики о пользователе
     *
     * и бана
     */
    protected $is_admin= ['152308042'];
    protected $channels_to_job =  ['-1001332733639'];
    protected $name  = '';
    protected $bot_id = 3;

    protected function Telegram()
    {
        $telegram = new Api('666158865:AAHe1WW7B-4VkQfe0FhCyad2qwrb7_Yvc4I');
        return $telegram;
    }

    public function to_save($req){
        $data = new Bot_stat;
        $data->update_id = $req['update_id'];
        $data->message_id = $req['message']['message_id'];
        $data->user_id = $req['message']['from']['id'];
        $data->username = $req['message']['from']['username'];
        $data->chat_id = $req['message']['chat']['id'];
        $data->text = $req['message']['text'];
        $data->date = $req['message']['date'];
        $data->deleted = false;
        $data->save();
        return $data;
    }

    public function save_about_ban($chat_id, $user_id , $start_date =  null ){
        $ban =  new Bot_bans;
        $ban->channel_id = $chat_id;
        $ban->bot_id = $this->bot_id;
        $ban->user_id = $user_id;
        $ban->start_date  = $start_date;
        $count  = Bot_bans::where('user_id' , $user_id)->count();
        $ban->count += (integer) $count;
        $ban->mark = "banned";
        $ban->save();
        return $count;
    }

    public function ban_user($user_id , $chat_id , $current_time){
        $param = [ 'chat_id' => $chat_id ,
            'user_id' => $user_id ,
            'until_date' => (integer) $current_time + 300,
            'can_send_messages' => false,
            'can_send_media_messages' => false,
            'can_send_other_messages' => false,
            'can_add_web_page_previews' => false
        ];
        $r =  $this->Telegram()->restrictChatMember($param);
        return $r;
    }




    //(5)
    public function  find_words($msg ){
        $bad_words = ['Bounty', 'Airdrop'];
        $result = false;
        foreach ($bad_words as $w) {
            if (strpos($msg, $w) !== false) {
                $result = true;
                break;
            }
        }

        return $result;
    }

    //(1)
    public function find_links($text ){
        $out = array();
        $re = '/(\.ru|\.io|\.me|\.fi|\.cn|\.eu|\.ee|\.net|\.onion|\.org|\.com|www\s?\.|http:|https:)/i';
        $num_found = preg_match_all($re, $text, $out, PREG_SET_ORDER, 0);
        $result = false;
        if($num_found) {
            $result = true;
            foreach ($out as $o)
                $array_msg = explode(' ', $text);
            foreach ($array_msg as $m) {
                $pos = strpos($m, $o[0]);
                if ($pos !== false) {
                    $white_list = ['twitter.com', 'linkedin.com', 'prepayway.com'];
                    foreach ($white_list as $w) {
                        if (strpos($m, $w) !== false) {
                            $result = false;
                            break;
                        }
                    }
                }
            }
        }
        return $result;
    }



    public function delete_msg($chat_id , $message_id ){
        $deleted = Bot_stat::where('chat_id', $chat_id)->where('message_id', $message_id)->first();
        info('Del :  chat_id : '. $chat_id .' mess_id : '. $message_id);
        $response = $this->Telegram()->deleteMessage([
            'chat_id' => $chat_id,
            'message_id' => $message_id,
        ]);
        if(isset($deleted->deleted)){
            if($deleted->deleted == false) {
                    $deleted->deleted = true;
                    $deleted->save();
            }
        }
        return $response;
    }
    
    
    public function check_last($data){
        $result = 0;
        $current_user_id = $data->user_id;
        $current_update_id = $data->update_id;
        $prev_id = (integer)$current_update_id - 2; /*Todo: ???*/
        $current_time =  $data->date;
        $chat_id = $data->chat_id;
        //$count_chat_member  = $this->Telegram()->getChatMembersCount( $chat_id);
        //check user role
       if(!in_array($data->user_id, $this->is_admin)) {
           $step1 = Bot_stat::where('update_id', $prev_id)->where('chat_id', $chat_id)->first();
           if (isset($step1->user_id)) {
               if ($step1->user_id == $current_user_id) {
                   $diff_time = (integer)$current_time - (integer)$step1->date;
                   if ($diff_time < 4) {
                       //dispatch()
                       $result = 1;
                       $this->ban_user($current_user_id, $chat_id, $current_time);
                   }
               }

           }
       }
        return $result;
    }


     /*
     kickChatMember
     unbanChatMember
     restrictChatMember
     promoteChatMember
     */

    
    public function rules_to_del($msg_data, $chat_data){
        //(2)
        if (isset($msg_data['sticker'])) {
            $this->delete_msg($chat_data['id'], $msg_data['message_id']);
        }
        if (isset($msg_data['text'])) {
            //(1)
            if ($this->find_links($msg_data['text'])) {
                $this->delete_msg($chat_data['id'], $msg_data['message_id']);
            }
            //(3)
            if ($msg_data['text'][0] == '/') {
                $this->delete_msg($chat_data['id'], $msg_data['message_id']);
            }
            //(5)
            if ($this->find_words($msg_data['text'])) {
                $this->delete_msg($chat_data['id'], $msg_data['message_id']);
            }

        }
    }


    public function update(Request $request){
        if(in_array($request['message']['chat']['id'], $this->channels_to_job)) {
            info("BOT 3  > SEND TO QUEUE.. ");

            if(isset($request['message'])) {
                $this->rules_to_del($request['message'], $request['message']['chat']);
            }

            if (isset($request['message']['text'])) {
               $data =   $this->to_save($request);
               $check_status =  $this->check_last($data);
               if($check_status == 1){
                   $i = $data->message_id;
                   for ($i;$data->message_id - 3 <= $i; $i--) { // 3 потому что 2 ))))
                       //пологаем что message_id порядковые __
                       $this->delete_msg($data->chat_id , $i );
                   }
                }
            }//

            if(isset($request['edited_message'])){
                if ($request['edited_message']['from']['is_bot'] == false) {
                    $this->rules_to_del($request['edited_message'], $request['edited_message']['chat'] );
                }
            }

        }
        return 'ok';
    }
}
