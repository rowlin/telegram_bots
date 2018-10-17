<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bot_bans extends Model
{
    protected $table = 'bot_bans';
    protected $fillable = ['channel_id' , 'bot_id' , 'user_id' , 'start_date' , 'count' , 'mark'];
    



}
