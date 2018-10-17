<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Channels;
class SaveChannel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $tries = 3 ;
    public $timeout = 20;


    protected $peer;
    protected $company;

    public function __construct($peer, $company_id)
    {
        $this->peer = $peer;
        $this->company = $company_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if(isset($this->peer['Chat']) & isset($this->peer['full'])) {
            $channel = new Channels();
            $channel->type = $this->peer['Chat']['_'];;
            $channel->channel_id = $this->peer['full']['id'];
            $channel->company_id = isset($this->company) ? $this->company : 0;
            $channel->username = isset($this->peer['Chat']['username']) ? $this->peer['Chat']['username'] : ' ';
            $channel->about = isset($this->peer['full']['about']) ? $this->peer['full']['about'] : " ";
            $channel->participants_count = $this->peer['full']['participants_count'];
            $channel->can_get = $this->peer['full']['can_view_participants'];
            $channel->pinned_msg = isset($this->peer['full']['pinned_msg_id']) ? $this->peer['full']['pinned_msg_id'] : 0;
            //that is ...
            $channel->has_photo = 1;
            $channel->photo = ' ';
            $channel->more_info = 1;
            $channel->save();
            info('channel ' . $channel->username . ' saved');
        }else
            info('Oops...');
    }




}
