<?php

namespace App\Http\Controllers;

use App\BotQ5;
use Illuminate\Support\Facades\Redis;
use App\Jobs\saveBot5;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Telegram\Bot\Api;
class Bot5Controller extends Controller
{

    protected $user;

    protected function Telegram()
    {
        $telegram = new Api('592926707:AAG24GaEc9QPqPqskXELcbIF5LmAziKvvAA');
        return $telegram;
    }


    public function msg($chat_id , $step){
        $data = $this->questions($step);
        $message = $data['question'];
        $messageId = 0;

        if(is_array($data['answers'])){
            $inline_keyboard  = [$data['answers']];
            $keyboard = array("inline_keyboard" => $inline_keyboard);
            $replyMarkup = json_encode($keyboard);
            info('chat_id  ' . $chat_id . '  ' .$message);

            $response = $this->Telegram()->sendMessage([
                'chat_id' =>  $chat_id,
                'text' =>  $message,
                'parse_mode' => 'Markdown',
                'reply_markup' => $replyMarkup
            ]);
            $messageId = $response->getMessageId();
        }elseif($data['answers'] == ''){
            $response = $this->Telegram()->sendMessage([
                'chat_id' => $chat_id,
                'text' => $message,
                'parse_mode' => 'Markdown',
            ]);
            $messageId = $response->getMessageId();
        }

        return $messageId;
    }


    public function start($id , $data , $step, $sub_step = 0 ){
        dispatch(new saveBot5($id, $data));
        Redis::set('id_'.$id , $step);
        Redis::set('sub_' .$id, $sub_step);
        return $step;
    }

    public function update_info($id , $data){
        $step = Redis::get('id_'.$id);
        $sub_step = Redis::get('sub_'.$id);
        info('Update info > step value :' .$step);
        $next = 0;
        switch ($step){
            case '0':
                $next = $this->start($id, ['q0'=> (bool)$data] ,1 );
                break;
            case '1':
                $next =  $this->start($id, ['q1'=> $data] ,2 );
                break;
            case '2':
                if($sub_step == 0) {
                    $next =  $this->start($id, ['m1'=> $data] ,2 ,1 );
                }else if($sub_step == 1) {
                    $next =  $this->start($id, ['m2'=> $data] ,2 ,2 );
                }else {
                    $next =  $this->start($id, ['m3'=> $data] ,3 );
                }
                break;
            case '3':
                $next =  $this->start($id, ['q3'=> $data] ,4 );
                break;
            case '4':
                $next =  $this->start($id, ['q4'=> $data] ,5 );
                break;
            case '5':
                $next = 5;
                Redis::del('id_'.$id);
                Redis::del('sub_'. $id);
                break;
            default :
                $next = 5;
                break;
        }

        return $next;
    }


    public function update(Request $request)
    {
        info($request);

        $from = $request['message']['from'];
        $chat_id = $request['message']['chat']['id'];
        $id = $from['id'];
        info('id'. $id );
        $tg_first_name = $from['first_name'] ?? " ";
        $username = $from['username'] ?? " ";
        $tg_language_code = $from['language_code'] ?? " ";
        info('uname '. $username );
        info('fname ' . $tg_first_name);
        info('lang_code ' . $tg_language_code);
            if (isset($request['message']['text'])) {
                if ($request['message']['text'] == '/start') {
                    $this->start($from['id'],
                        ['tg_id' => $id,
                            'tg_first_name' => $tg_first_name,
                            'tg_username' => $username,
                            'tg_language_code' => $tg_language_code], 0 , 0);



                    $this->msg($chat_id, 0);
                } else {
                    $chat_id = $request['message']['chat']['id'];
                    $next_step = $this->update_info($request['message']['from']['id'], $request['message']['text']);
                    $this->msg($chat_id, $next_step);
                }
            } else if (isset($request['callback_query'])) {
                $data = $request['callback_query']['data'];
                $chat_id = $request['callback_query']['message']['chat']['id'];
                $id = $request['callback_query']['from']['id'];
                $next_step = $this->update_info($id, $data);
                info($next_step);
                $this->msg($chat_id, $next_step);
            }
                $r1 = Redis::get('id_' . $id);
                $r2 =  Redis::get('sub_' . $id);
                info(' R1 : '. $r1);
                info('R2 : '. $r2);

    }


    public function questions($i){
     $data = [
         [
              'question' => '1) Вы проживаете в России ?',
              'answers' => [
                  ["text" => "Да", "callback_data" => 1],
                  ["text" => "Нет", "callback_data" => 0]
              ]
         ],
         [
             'question' => '2) Вы говорите по-английски ? ',
             'answers' => [
                 ["text" => "Да" ,  "callback_data" => 'true' ],
                 ["text" => "Учу", "callback_data" => 'study' ],
                 ['text' => 'Нет', "callback_data" => 'false' ],
            ]
         ],
         [
             'question' => '3)Как Вы проводите свободное время *(приведите 3 метода одним словом ( Задам вопрос 3 раза))*?',
             'answers' => ''
         ],[
             'question' => '4) Довольны ли Вы общественными мероприятиями ?',
             'answers' => [
                 ["text" => "Да" ,  "callback_data" => 'true' ],
                 ["text" => "Хочу больше", "callback_data" => 'more' ],
                 ['text' => 'Нет', "callback_data" => 'false' ],
             ]
         ],[
             'question' => '5)Желаете получить результат(статистику) данного опроса ?',
             'answers' => [
                 ["text" => "Да", "callback_data" => 1],
                 ["text" => "Нет", "callback_data" => 0]
             ]
         ],[
             'question' => 'Спасибо за участие.',
             'answers' => '',
         ]
     ];
        return $data[$i];
    }

}
