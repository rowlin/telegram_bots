<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bot6Data extends Model
{

    protected $fillable =[
    'user_id','chat_id','tg_username','language_code','text', 'update_id', 'ban_time','date'
    ];

    protected $table = 'bot6_datas';
    public  $timestamps = false;


}
