<?php

namespace App\Http\Controllers;

use App\Bot6Data;
use App\BotQ5;
use Illuminate\Support\Facades\Redis;
use App\Jobs\saveBot5;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramResponseException;

class Bot6Controller extends Controller
{
    //PrepayWay_statbot
    protected $user;
    protected $lang_code;
    protected  $to_send = '126045704';
    protected $bot_admin = '613856361';

    protected function Telegram()
    {
        $telegram = new Api('666158865:AAHe1WW7B-4VkQfe0FhCyad2qwrb7_Yvc4I');
        return $telegram;
    }


    public function trans($value){
       $dict =[
               "en" => [
                   "join_btn" => "Join our channels",
                   'special_offers_btn' => 'Special offers',
                   "thanks_btn" => "No, thanks!",
                   "how_it_work_btn" => "How does it work?",
                   "back_btn" => "Back",
                   "features_btn" => "Features",
                   "what_is_btn" => "What’s PrepayWay?",
                   "solutions_btn" => "Solutions",
                   //
                   "airdrop_btn" => "AirDrops",
                   "contest_btn" => "Contest",
                   "limited_sales_btn" => "Limited Sales",
                   "vip_btn" => "Vip",
                   //
                   "real_estate_btn" => "Real Estate",
                   // add 1
                   "global_trade_btn" => "Global Trade",
                   "smart_arb_btn" => 'SmartArb',
                   "invest_bot_btn" => 'InvestBot',
                   "inbit_token_btn" => 'InBit token',
                   "demand_btn" => 'Demand',
                   "supply_btn" => 'Supply',
                   "main_menu_btn" => "Main Menu",
                   //Start message
                   'start_text' => 'Great! Let’s start then. There are 4 buttons below. Just click any of them!'. "\u{1F609}",
                   //Join Channels
                   'join_channel_text' => "Join our growing community in multiple channels!  \u{1F60E}

                    @PrepayWay in Telegram – for conversations
                    @PrepayWay on Twitter – for getting updates
                    …  
                    ",
                   //3 Special Offers
                   'special_offers_text' => "Here will be listed special offers for PrepayWay community, such as airdrops, bounty programs, contests and pre-sales.
Currently, there are none of them  \u{1F614}. I’ll notify you if there are any updates on that  \u{1F609}
",
                   //4 No Thanks
                   'thanks_text' => "Well, it was glad to have a chat with you! Anyway, I will be here waiting for you…  \u{1F625}",

                   'how_it_work_text' => "
Let’s take the case of a simple international commercial transaction.

First, parties conclude legally binding and fully enforceable contracts online in languages they understand using customizable contract templates developed by our lawyers for every country.

Then, the Buyer makes a deposit in crypto or fiat using our fiat gateway and escrow service providers.

After that, the Seller ships the goods or provides services.

Finally, as soon as receipt of the goods or services is confirmed, the money is released to the Seller.

So, Blockchain provides a new standard for transparency and traceability that coexists with privacy. Information can be verified without violating data confidentiality.

Simple as that, isn’t it?  \u{1F601}",

                   //5 What_is,
                   'what_is_text' => "PrepayWay is the next Bitcoin! Haha, I’m kidding. \u{1F602}

Actually, PrepayWay is a blockchain ecosystem that simplifies and streamlines international collaboration, contracting and payments for companies across multiple industries.

Click buttons below to learn more!",
                   //6 Solutions
                   'solutions_text' => "
            Currently, we have 4 amazing  \u{1F635} solutions in our ecosystem:
            
*PrepayWay \u{1F1E8}\u{1F1ED} Real Estate 
*PrepayWay \u{1F1E8}\u{1F1ED}  Global Trade
*PrepayWay \u{1F1E8}\u{1F1ED} InvestBot
*SmartArb  \u{1F913}

Click the buttons below for more info on that!
                                      ",                   //7 Real Estate,
                   'real_estate_text' => "Our solution for real estate is a contracting and escrow tool for real estate transactions. So, it makes the real estate reservation process direct, flexible, transparent, and secure.  \u{1F60C}

It’s explained really well in a cartoon we prepared for you. Check it out! Or visit our website for more info: https://prepayway.ru.  \u{1F609}
",
                   //8 Global Trade
                   'global_trade_text' => "Coming soon! \u{1F51C}",
                   //9 SmartArb
                   'smartarb_text' =>"Smart contracts and blockchain are great! It’s even said that it will replace lawyers in some time.  \u{1F635}

But what would you do NOW if you have a dispute with your smart contract on the Blockchain?! Go to judge and spend thousands of dollars?  \u{1F602} Not good at all.  \u{1F615}

That’s why we developed SmartArb - International Smart Mediation and Arbitration Institute that will resolve any disputes arose out of smart contracts much faster and cheaper.  \u{1F60C}

Have a dispute? Click the link for more info: [link]  \u{1F609}
",
                   //10
                   'invest_bot_text' => "Coming soon! \u{1F51C}",
                   //11
                   'inbit_token_text' => "The InBit tokens are required to access and activate Smart Contracts, and while the Smart Contract is active, the service fee paid in tokens is locked as part of the Smart Contract.",
                   'demand_text' => "
                   The more Smart Contracts are in use at any point in time, the more tokens are locked. What means that the number of the InBit tokens frozen at any point in time has a direct correlation with the demand for our Smart Contracts.
                   
Here are the 4 key demand factors:
    1. Demand of the services delivered by the PrepayWay Ecosystem;
    2. Development of a proprietary Blockchain;
    3. Growing volume of transactions concluded in the InBit tokens;
    4. Expansion of the PrepayWay Ecosystem by attracting businesses from multiple industries and regions.

So, InBit token intrinsic value changes over time with the usage of the PrepayWay Ecosystem in real economy.  \u{1F4C8}
",
                   'supply_text' => "TYPE: UTILITY TOKEN / Token Generation Event is designed in full compliance with Swiss \u{1F1E8}\u{1F1ED} regulations

STANDARD: ERC20 / Tokens will be swapped once we launch our Proof of Use (PoU) mechanism on proprietary Blockchain

PRICE: 0.01 USD / Initial price in TGE in 2019. Different presale tiers. Available on crypto exchanges in 2019

Hard cap: 50.000.000 USD / Limited Supply for TGE and PoU Emissions. More information about supply available upon request",


                   'features_text'=> "So, there are 6  \u{1F635} main features in the PrepayWay ecosystem.

<b>Tamper-Proof Transactions</b>  \u{1F512}
The combination of self-executing smart contracts with decentralized storage of all transaction data on the blockchain ensures complete transparency and lowers fraud loss. 

<b>Smart Dispute Resolution</b>  \u{1F9D0}
Efficient and enforceable dispute resolution by SmartArb, our International Smart Mediation and Arbitration Institute.

<b>Integrated Payment Gateway </b> \u{1F4B8}
Embedded secure money transfer mechanism and integrated gateway for transactions in both digital and fiat currencies powered by licensed escrow partners. 

<b>Enforceable Agreements </b> \u{1F4C4}
Legally binding agreement templates developed by legal experts in accordance with national laws and regulations. 

<b>Agreement Customization</b> \u{1F4D1}
User-friendly interface for agreements customization with detailed explanations and recommendations. Availability in multiple languages.

<b>Smart Contracts</b>  \u{1F913}
Automated enforcement of contractual conditions minimizes fraud risk and the need for third party intermediaries, reducing legal fees, arbitration, and other transaction costs.

Cool, right?  \u{1F600}",
               ]
       ];
          $res = $dict["en"][$value];
      return $res;
    }


    public function just_msg($chat_id ,$text){
        $response = $this->Telegram()->sendMessage([
            'chat_id' => $chat_id,
            'text' => $text
        ]);
        return $response;
    }


    public function msg($chat_id , $step ){
            $data = $this->questions($step);

            //info($data['body']);
            if (isset($data['buttons'])) {

                $reply_markup = $this->Telegram()->replyKeyboardMarkup([
                    'keyboard' => $data['buttons'],
                    'resize_keyboard' => true,
                    'one_time_keyboard' => true
                ]);
                try{
                 $this->Telegram()->sendMessage([
                    'parse_mode' => 'HTML',
                    'chat_id' => $chat_id,
                    'text' => $data['body'],
                    'reply_markup' => $reply_markup
                ]);
                $response = $data['level'];
                } catch (TelegramResponseException $e) {

                    $errorData = $e->getResponseData();
                    if ($errorData['ok'] === false) {
                        $this->Telegram()->sendMessage([
                            'chat_id' => $this->bot_admin,
                            'text'    => 'There was an error for a user. ' . $errorData['error_code'] . ' ' . $errorData['description'],
                        ]);
                        $response = 999;
                    }
                }
            } else {
                $this->just_msg($chat_id, 'Unfortunately, i can speak only english language ( ');
                $response = $data['level'] ?? 0;
            }
        return $response;
    }

    /*?*/
    public function get_redis($id){
        //HGETALL myhash
        return Redis::hGetAll($id);
    }


    public function get_step($id){
        return Redis::hGet($id , 'step');
    }

    public function get_lang($id){
        return Redis::hGet($id , 'language_code');
    }


    public function start_redis($id , $value){
        foreach ($value as $v ) {
            Redis::hSet($id, key($v), $v[key($v)]);
        }
    }



    public function del_redis($id){
        return Redis::hDel($id , 'language_code');
    }


    public function ban_user($user_id , $chat_id , $time){
        $param = [ 'chat_id' => $chat_id ,
            'user_id' => $user_id ,
            'until_date' => $time ,
            'can_send_messages' => false,
            'can_send_media_messages' => false,
            'can_send_other_messages' => false,
            'can_add_web_page_previews' => false
        ];
        $r =  $this->Telegram()->restrictChatMember($param);
        return $r;
    }



    public function save_in_db($request , $ban_time = 0){
        $data = new Bot6Data();
        $from = $request['message']['from'] ?? $request['edited_message']['from'];
        $data->user_id = $from['id'];
        $data->tg_username = $from['username'];
        $data->language_code =  Redis::hGet($from['id'] , 'language_code');
        $data->chat_id = $request['message']['chat']['id'] ?? $request['edited_message']['chat']['id'];
        $data->text = $request['message']['text'] ?? $request['edited_message']['text'];
        $data->update_id = $request['update_id'];
        $data->date = $request['message']['date'] ??  $request['edited_message']['date'];
        $data->ban_time = $ban_time;
        $data->save();
        return $data;
    }


    public function check_last($data){
        $result = 0;
        $current_user_id = $data->user_id;
        $current_update_id = $data->update_id;
        $prev_id = (integer)$current_update_id - 2;
        $current_time =  $data->date;
        $chat_id = $data->chat_id;
            $step1 = Bot6Data::where('update_id', $prev_id)->where('chat_id', $chat_id)->first();
            if (isset($step1->user_id)) {
                if ($step1->user_id == $current_user_id) {
                    $diff_time = (integer)$current_time - (integer)$step1->date;
                    if ($diff_time < 2) {
                        $result = 1;
                        $ban_time =  (integer)$current_time + 5 * 60; // 5 minutes
                        $this->start_redis($current_user_id , [['ban' => 1], ['ban_time' => $ban_time]]);
                        $this->ban_user($current_user_id, $chat_id, $ban_time);
                    }
                }
            }
        return $result;
    }


    public function check_lang_func($id, $lang){
        if ($this->get_lang($id) == NULL) {
            $pos = stripos($lang, "ru");
            $pos2 = stripos($lang, "ch");
            if ($pos !== false) {
                $this->lang_code = 'ru';
            } elseif ($pos2 !== false) {
                $this->lang_code = 'ch';
            } else {
                $this->lang_code = 'en';
            }
        }

    }

    public function check_ban_func($chat_id,  $id , $c_date){
        if(Redis::exists($id)) {
            $ban =  Redis::hGet($id, 'ban');
            if($ban == 1 ){
                $ban_time = $ban =  Redis::hGet($id, 'ban_time');
                if($ban_time > $c_date){
                    $msg = "Your account is banned for 5 minutes";
                    $this->just_msg($chat_id,  $msg );
                    die();
                }else{
                    $this->start_redis($id , [['ban' => 0]]);
                }
            }
        }

    }

    public function back_step($request)
    {
        $collect = Bot6Data::where('user_id', $request['message']['from']['id'])
            ->where('chat_id',$request['message']['chat']['id'] )->pluck('text');
        $array = $collect->toArray();
        $size =  sizeof($array);
        //info(array('text' => (string) array_pop($array)));
        if($array[$size-1] == 'Back'){
            $text =  '/start';
        }else {
            if (isset($array[$size - 2]) & $array[$size - 2] != "Back") {
                $text = (string)$array[$size - 2];
            } else
                $text = '/start';
        }

        $message  = ["update_id" => $request['update_id'],
        'message' => [
            'message_id' => $request['message']['message_id'],
            'chat' => ['id' =>  $request['message']['chat']['id'] ],
            'from' => [
                'id' => $request['message']['from']['id'],
                'username' => $request['message']['from']['username'],
                'language_code' => $request['message']['from']['language_code'],
                ],
            'date' => $request['message']['date'],
            'text' =>  $text,
        ]];


      //  info('message to back '.$message);
  // $myRequest->request->add(['parameter' => 'back']);

       // $myRequest->request
        //$myRequest->route()->parameters('route' , 'back');
        //info('message : ' . json_encode($message));
      // $request['message'] += array('text' => (string) array_pop($array));
       //info('request from back function :'. $request['message']['date']);
       $this->update($message);
   //return redirect('stat')->with($myRequest);

    }



    public function update($my_request = null)
    {

        if ($my_request == null) {

            $request = $this->Telegram()->getWebhookUpdates();
        } else {
            info('back > '. json_encode($my_request));
            $request = $my_request;
        }
       // info(json_encode($request->parameters()));
       //info($request);
            $m_date = $request['message']['date'];
            $from = $request['message']['from'] ?? $request['edited_message']['from'];
            $chat_id = $request['message']['chat']['id'] ?? $request['edited_message']['chat']['id'];
            $id = $from['id'];
            $username = $from['username'] ?? " ";
            $step = $this->get_step($id) ?? 0;
            $text = $request['message']['text'] ?? $request['edited_message']['text'];
            $lang = $from['language_code'] ?? " ";
            $this->check_ban_func($chat_id, $id, $m_date);
            $this->check_lang_func($id, $lang);

        if (isset($text)) {
                switch ($text){
                    case "/russian":
                        $this->lang_code = 'ru';
                        $this->start_redis($id , [['username' => $username ],['language_code' => 'ru'],['step' => '0'],['ban' => '0'], ['date' => $m_date]]);
                        $data = $this->save_in_db($request);
                        $this->msg($chat_id, 'start');
                        break;
                    case "/chinese":
                        $this->lang_code = 'ch';
                        $this->start_redis($id , [['username' => $username ],['language_code' => 'ch'],['step' => '0'],['ban' => '0'], ['date' => $m_date]]);
                        $data = $this->save_in_db($request);
                        $this->msg($chat_id, 'start');
                        break;
                    case "/english":
                        $this->lang_code = 'en';
                        $this->start_redis($id , [['username' => $username ],['language_code' => 'en'],['step' => '0'],['ban' => '0'],['date' => $m_date ]]);
                        $data = $this->save_in_db($request);
                        $this->msg($chat_id, 'start');
                        break;
                    case '/start':
                        $this->start_redis($id ,[['username' => $username ],['language_code' => $this->lang_code],['step' => $step ],['ban' => '0'], ['date' => $m_date]]);
                        $data = $this->save_in_db($request);
                        $this->msg($chat_id , 'start' );
                        break;
                    case $this->trans('how_it_work_btn'):
                        $lvl = $this->msg($chat_id , 'how_it_work' );
                        $data = $this->save_in_db($request);
                        $this->start_redis($id , [['step' => $lvl], ['date' => $m_date]]);
                        break;
                    case $this->trans('join_btn'):
                        $lvl = $this->msg($chat_id , 'join' );
                        $data = $this->save_in_db($request);
                        $this->start_redis($id , [['step' => $lvl], ['date' => $m_date]]);
                        break;
                    case $this->trans('thanks_btn'):
                        $lvl = $this->msg($chat_id , 'thanks' );
                        $data = $this->save_in_db($request);
                        $this->start_redis($id , [['step' => $lvl], ['date' => $m_date]]);
                        break;
                    case $this->trans('features_btn') :
                        $lvl = $this->msg($chat_id , 'features' );
                        $data = $this->save_in_db($request);
                        $this->start_redis($id , [['step' => $lvl], ['date' => $m_date]]);
                        break;
                    case $this->trans('what_is_btn'):
                        $lvl =  $this->msg($chat_id , 'what' );
                        $data =  $this->save_in_db($request);
                        $this->start_redis($id , [['step' => $lvl], ['date' => $m_date]]);
                        break;
                    case  $this->trans('solutions_btn'):
                        $lvl = $this->msg($chat_id , 'solutions');
                        $data =  $this->save_in_db($request);
                        $this->start_redis($id , [['step' => $lvl], ['date' => $m_date]]);
                        break;
                    case $this->trans('real_estate_btn'):
                        $lvl = $this->msg($chat_id , 'real_estate');
                        $data =  $this->save_in_db($request);
                        $this->start_redis($id , [['step' => $lvl], ['date' => $m_date]]);
                        break;
                    case $this->trans("global_trade_btn"):
                        $lvl = $this->msg($chat_id , 'global');
                        $data =  $this->save_in_db($request);
                        $this->start_redis($id , [['step' => $lvl], ['date' => $m_date]]);
                        break;
                    case $this->trans('smart_arb_btn'):
                        $lvl = $this->msg($chat_id , 'smartarb');
                        $data = $this->save_in_db($request);
                        $this->start_redis($id , [['step' => $lvl] ,['date' => $m_date]]);
                        break;
                    case $this->trans('invest_bot_btn'):
                        $lvl = $this->msg($chat_id , 'invest');
                        $data =  $this->save_in_db($request);
                        $this->start_redis($id , [['step' => $lvl], ['date' => $m_date]]);
                        break;
                    case $this->trans('inbit_token_btn'):
                        $lvl = $this->msg($chat_id , 'inbit');
                        $data =  $this->save_in_db($request);
                        $this->start_redis($id , [['step' => $lvl], ['date' => $m_date]]);
                        break;
                    case $this->trans('demand_btn'):
                        $lvl = $this->msg($chat_id , 'demand');
                        $data =  $this->save_in_db($request);
                        $this->start_redis($id , [['step' => $lvl], ['date' => $m_date]]);
                        break;
                    case $this->trans('supply_btn'):
                        $lvl = $this->msg($chat_id , 'supply');
                        $data =  $this->save_in_db($request);
                        $this->start_redis($id , [['step' => $lvl], ['date' => $m_date]]);
                        break;
                    case $this->trans('special_offers_btn'):
                        $lvl = $this->msg($chat_id , 'special');
                        $data =  $this->save_in_db($request);
                        $this->start_redis($id , [['step' => $lvl], ['date' => $m_date]]);
                        break;
                    case ($this->trans('back_btn')) :
                        $this->back_step($request);
                        $data =  $this->save_in_db($request);
                        break;
                    case ($this->trans("airdrop_btn")):
                        $lvl = $this->msg($chat_id, 'start');
                        $data =  $this->save_in_db($request);
                        $this->start_redis($id , [['step' => $lvl], ['date' => $m_date]]);
                        break;
                    case ($this->trans("contest_btn")):
                        $lvl = $this->msg($chat_id, 'start');
                        $data =  $this->save_in_db($request);
                        $this->start_redis($id , [['step' => $lvl], ['date' => $m_date]]);
                        break;
                    case ($this->trans("limited_sales_btn")) :
                        $lvl = $this->msg($chat_id, 'start');
                        $data =  $this->save_in_db($request);
                        $this->start_redis($id , [['step' => $lvl], ['date' => $m_date]]);
                        break;
                    case ($this->trans("vip_btn")) :
                        $lvl = $this->msg($chat_id, 'start');
                        $data =  $this->save_in_db($request);
                        $this->start_redis($id , [['step' => $lvl]]);
                        break;
                    default :
                        //$this->just_msg($chat_id, 'Oops');
                        break;
                }
                if(isset($data)) {
                    $this->check_last($data);
                }
            }
    }


    public function questions($i){
     $data = [
        'start' =>  [
             'level' => '0',
              'body' =>  $this->trans( 'start_text'),
              'buttons' => [
                 [  $this->trans('what_is_btn'), $this->trans('join_btn'),
                   $this->trans('special_offers_btn'),  $this->trans('thanks_btn')]
              ]
         ],
        'what' =>  [
             'level' => '1',
             'body' => $this->trans('what_is_text'),
             'buttons' => [
                 [$this->trans('how_it_work_btn'), $this->trans('features_btn'),$this->trans('solutions_btn'), $this->trans('inbit_token_btn') ],
                 [$this->trans('back_btn')]
             ]

         ],
         'join' =>  [
             'level' => '1',
             'body' => $this->trans('join_channel_text') ,
             'buttons' => [
                 [  $this->trans('what_is_btn'), $this->trans('join_btn'),
                     $this->trans('special_offers_btn'),  $this->trans('thanks_btn')],
                 [$this->trans('back_btn')]
             ]

         ],
        'offers' => [
             'level' => '1',
             'body' => $this->trans('special_offers_text'),
             'buttons' => [
                 [$this->trans('airdrop_btn'), $this->trans('limited_sales_btn'),
                     $this->trans('contest_btn'), $this->trans('vip_btn')],
                 [$this->trans('back_btn')]
             ]
         ],
        'thanks' =>  [
             'level' => '1',
             'body' => $this->trans('thanks_text'),
             'buttons' => [
                 [  $this->trans('what_is_btn'), $this->trans('join_btn'),
                     $this->trans('special_offers_btn'),  $this->trans('thanks_btn')],
             ]
         ],
         'features' => [
             'level' => '2',
             'body' => $this->trans('features_text'),
             'buttons' => [
                 [$this->trans('how_it_work_btn'), $this->trans('solutions_btn') , $this->trans('inbit_token_btn')],
                 [$this->trans('back_btn')]
             ]
         ],
         'solutions' => [
             'level' => '2',
             'body' => $this->trans('solutions_text'),
             'buttons' => [
                 [$this->trans('real_estate_btn'), $this->trans( "global_trade_btn"),
                  $this->trans( "invest_bot_btn") , $this->trans('smart_arb_btn')],
                 [$this->trans('back_btn')]
             ]
         ],
         'real_estate' => [
             'level' => '3',
             'body' => $this->trans('real_estate_text'),
              'buttons' => [

                  [$this->trans('real_estate_btn'), $this->trans('global_trade_btn'),
                      $this->trans( "invest_bot_btn") , $this->trans('smart_arb_btn')],
                  [$this->trans('back_btn')]
              ]

         ],
        'global'=> [
             'level' => '3',
             'body' => $this->trans('global_trade_text'),
             'buttons' => [
                 [$this->trans('special_offers_btn')],
                 [$this->trans('back_btn')]
             ]
         ],
         'smartarb' => [
         'level' => '3',
             'body' => $this->trans('smartarb_text'),
             'buttons' => [
                 [$this->trans('special_offers_btn')],
                 [$this->trans('back_btn')]
             ]
         ],
         'invest' => [
             'level' => '3',
             'body' => $this->trans('invest_bot_text'),
             'buttons' => [
                 [$this->trans('special_offers_btn')],
                 [$this->trans('back_btn')]
                 ]
        ],
         'inbit'=> [
             'level' => '3',
             'body' =>  $this->trans('inbit_token_text'),
             'buttons' => [
                 [$this->trans('demand_btn'), $this->trans('supply_btn')],
                 [$this->trans('back_btn')]
             ]
         ],
          'demand'   =>   [
            'level' => '3',
            'body' => $this->trans('demand_text'),
            'buttons' => [
                [$this->trans('demand_btn'), $this->trans('supply_btn')],
                [$this->trans('back_btn')]
            ]

        ],
        'supply' =>     [
             'level' => '3',
             'body' => $this->trans('supply_text'),
             'buttons' => [
                 [$this->trans('demand_btn'), $this->trans('supply_btn')],
                    [$this->trans('back_btn')]
             ]
         ],
         'special'  =>  [
             'level' => '3',
             'body' => $this->trans('special_offers_text'),
             'buttons' => [
                 [ $this->trans("airdrop_btn"),
                 $this->trans("contest_btn"),
                 $this->trans("limited_sales_btn"),
                 $this->trans("vip_btn")],
                 [$this->trans('back_btn')]
             ]

         ],
         'how_it_work' => [
             'level' => '2',
             'body' => $this->trans('how_it_work_text'),
             'buttons' => [
                     [ $this->trans('how_it_work_btn'), $this->trans('features_btn'),$this->trans('solutions_btn'), $this->trans('inbit_token_btn') ],
                     [$this->trans('back_btn')]
             ]
         ]
     ];
        return $data[$i];
    }


}
