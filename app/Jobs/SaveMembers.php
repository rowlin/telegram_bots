<?php

namespace App\Jobs;
use App\UserData;
use Illuminate\Support\Facades\DB;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;

class SaveMembers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $data;
    protected $channel;


    public $tries = 3 ;


    public function __construct($data)
    {
        $this->channel = $data['channel'];
        $this->data = $data['data'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

            info('start SaveMembers');
        try {
            $message = $this->channel . ' added. End  SaveMembers.';
            $path = './data/' . $this->channel . '.json';
            $store = Storage::disk('local')->put($path, json_encode($this->data));
            if ($store) {
                DB::table('saved_userdata')->insert([
                    'channel' => $this->channel,
                    'path' => $path, 'parsed' => 0,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()]);
            } else {
                $message = 'Oops. ' . $this->channel . ' !';
            }
        }catch (Exception $e){
            info('error ( ' . $this->cahnnel .' ) : '. $e);
            return;
        }
        /*finally{
            DB::table('saved_userdata')->insert([
                'channel' => $this->channel,
                'path' => 'exception',
                'parsed' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()]);
        }*/

        info($message);

    }


        /*
        foreach ($this->data as $item){
            if(isset($item)){
                $has_user =  UserData::where('channel_name' , $this->channel)->where('user_id' , $item['user']['id'] )->first();
                if($has_user == null)
                    $data = new UserData();
                    $data->user_id = $item['user']['id'];
                    $data->channel_name = $this->channel;
                    $data->user_first_name = isset($item['user']['first_name']) ? $item['user']['first_name'] : '';
                    $data->user_last_name = isset($item['user']['last_name']) ? $item['user']['last_name'] : '';
                    $data->username = isset($item['user']['username']) ? $item['user']['username'] : " ";
                    $data->type = $item['user']['type'] or '';
                    $data->verified = $item['user']['verified'];
                    $data->role = $item['role'] or " ";
                    $data->phone = isset($item['user']['phone']) ? $item['user']['phone'] : " ";
                    $res = $data->save();
                    info('added : '.$item['user']['id'] . ' from group '. $this->channel);
                    if (!$res) {
                        info('Oops : cant save to database' . $res);
                    }

                }

            }
        */


}
