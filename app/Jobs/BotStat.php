<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Bot_stat;


class BotStat implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    //protected $connector = 'database';
    protected $data;
    public $tries = 2 ;


    public function __construct($request)
    {
        $this->data = $request;
    }


    public function check_to_spam($data){
        info(var_dump($data));
    }


    public function handle()
    {
        if(isset( $this->data['message']['text'])) {
            $data = new Bot_stat;
            $msg_id = $this->data['message']['message_id'];
            $data->message_id = $msg_id;
            $data->user_id = $this->data['message']['from']['id'];
            $data->username = $this->data['message']['from']['username'];
            $data->chat_id = $this->data['message']['chat']['id'];
            $data->text = $this->data['message']['text'];
            $data->save();
            //$this->check_to_spam($data);
        }

    }
}
