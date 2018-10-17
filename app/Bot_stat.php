<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bot_stat extends Model
{
            protected $fillable = [ 'update_id' ,'date', 'user_id','username', 'chat_id','text','message_id' , 'deleted' ];
            protected $table = 'bot_stats';

}
