<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\BotQ5;

class saveBot5 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $data;
    protected $id;
    public $tries = 2;

    public function __construct($id ,$request)
    {
        $this->id = $id;
        $this->data = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
        /*

        $table->string('tg_id');
        $table->string('tg_language_code')->default(' ');
        $table->string('tg_first_name')->default(' ');
        $table->string('tg_username')->default(' ');
        $table->boolean('q0')->default(false);
        $table->string('q1')->default(' ');
        $table->string('m1')->default(' ');
        $table->string('m2')->default(' ');
        $table->string('m3')->default(' ');
        $table->string('q3')->default(' ');
        $table->boolean('q4')->default(false);
        $table->integer('step')->default(0);
          */



    public function handle()
    {
        info(__CLASS__ . ' start ');
         $user = BotQ5::where('tg_id', $this->id )->first();
            if($user != null){

            $user->update( $this->data);

            }else{
               $user =   new BotQ5();
               $user->tg_id = $this->id;
               $user->tg_language_code = $this->data['tg_language_code'] ?? " ";
               $user->tg_first_name = $this->data['tg_first_name'] ?? " ";
               $user->tg_username = $this->data['tg_username'] ?? " ";
               $user->save();
            }


          info(__CLASS__. 'end');
    }
}
