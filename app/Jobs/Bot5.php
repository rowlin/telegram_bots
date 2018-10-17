<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\BotQ5;

class Bot5 implements ShouldQueue
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
    public function handle()
    {
        info('tg_id : '. $this->id);
        $user= BotQ5::where('tg_id' , $this->id )->first();
        if($user == null) {
            BotQ5::create(['tg_id' => $this->data['tg_id']],
                ['tg_first_name' => $this->data['tg_first_name']],
                ['tg_username' => $this->data['username']],
                ['tg_language_code' => $this->data['tg_language_code']]);
        }else{
            $user->update($this->data);
        }
        
    }
}
