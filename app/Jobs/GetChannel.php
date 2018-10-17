<?php

namespace App\Jobs;

use App\Helper\MPHelp;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


class GetChannel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $channel;
    public $tries = 3 ;
    public $timeout = 20;


    public function __construct($channel)
    {
        $this->channel = $channel;
    }


    public function handle()
    {
        info("I am Here >" . $this->channel );

        
    }
}
