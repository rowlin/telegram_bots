<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Pinned_message;
use App\PmsgLinks;

class SavePmsg implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;
    public $timeout = 10;

    protected $pms;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($pms)
    {
        $this->pms = $pms;
        info(__CLASS__ );
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $haspms = Pinned_message::where('channel_name',  $this->pms['channel_name'])
            ->where('pmsg_id', $this->pms['pmsg_id'])->first();
        if($haspms == null) {
            $p = new Pinned_message;
            $p->text = $this->pms['text'];
            $p->channel_name = $this->pms['channel_name'];
            $p->pmsg_id = $this->pms['pmsg_id'];
            $p->save();
            info('saved new pmsg for ' . $this->pms['channel_name']);
            foreach ($this->pms['links'] as $link) {
                $l = new PmsgLinks;
                $l->channel = $this->pms['channel_name'];
                $l->pmsg_id = $this->pms['pmsg_id'];
                $l->link = $link;
                $l->joined = 0;
                $l->mark = '';
                $l->save();
                info('link _ saved');
            }
        }
    }
}
