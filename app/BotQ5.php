<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BotQ5 extends Model
{
    protected $fillable =[
        'tg_id' ,
        'tg_first_name' ,
        'tg_username',
        'tg_language_code',
        'q0',
        'q1',
        'm1',
        'm2',
        'm3',
        'q3',
        'q4',
        'step' ];

    protected $table = 'bot_q5s';
}
