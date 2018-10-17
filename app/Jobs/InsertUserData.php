<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\UserData;
use App\SavedUserData;
use Illuminate\Support\Facades\Storage;

class InsertUserData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;
    public $timeout = 5;

    protected $channel_name;

    public function __construct($channel_name)
    {
        $this->channel_name =  $channel_name;
        info(__CLASS__ . '>>>' . $channel_name );
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $r = SavedUserData::where('channel' , $this->channel_name)->first();
        $path = $r->path;
        if(isset($path)) {
            if (!file_exists($path)) {
                $data = Storage::disk('local')->get($path);
                foreach (array_chunk(\GuzzleHttp\json_decode($data), 100) as $stack) {
                    $put_data = array();
                    foreach ($stack as $d) {
                        $put_data [] = [
                            'channel_name' => $path,
                            'user_id' => $d->user->id,
                            'user_first_name' => $d->user->first_name ?? ' ',
                            'user_last_name' => $d->user->last_name ?? ' ',
                            'username' => $d->user->username ?? ' ',
                            'type' => $d->user->type ?? ' ',
                            'verified' => 1,
                            'role' => $d->role,
                            'phone' => '',
                        ];
                    }
                    UserData::insert($put_data);
                }
            } else {

                info(__CLASS__ . "Oops - file not found");
            }/*file_exist*/
        }
        info(__CLASS__ . '__end');
        $count = UserData::where('channel_name' , $r->path)->count();
        $msg = 'Added in database user_data ( '. $r->path .' )'. $count .' ....';
        $r->update(['parsed' => 1]);
        info($msg);

    }
}
