<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bot extends Model
{
    protected $fillable  = ['name', 'desc','token', 'http_client_handler', 'commands','function', 'status'];

    protected $table= 'bots';
    
    
    
}
