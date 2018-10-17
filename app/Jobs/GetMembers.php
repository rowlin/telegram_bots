<?php

namespace App\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Request;


class GetMembers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;

    public $tries = 3 ;

    public function __construct($id)
    {
        $this->id = $id;
    }

    protected function MadelineProto()
    {
        return Request::get('MyVar');
    }




    public function handle()
    {
       while($about = $this->MadelineProto()->get_pwr_chat($this->id)) {
 

            if (isset($about['participants'])) {
                //Queue::push(new SaveMembers(['data' => $about['participants'], 'channel' => $about['username']]));
                info('added a job  ( ' . $about['username'] . ' )');
            }
        }
    }

}
