<?php

namespace App\Http\BotCommands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Illuminate\Support\Facades\App;

class StartCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "start";

    /**
     * @var string Command Description
     */
    protected $description = "Start Command to get you started";

    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {
        $reply_markup = json_encode([
            'keyboard' => [[ "About","Join Channel"], [ "Special offers", "No thanks"]],
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ]);

         $this->replyWithMessage(['parse_mode' => 'HTML','text' => hex2bin('f09f9880') ."<b>Hi , my name is CoBot ( Contracting Robot ).</b><pre>I’m a telegram bot of Swiss fintech company PrepayWay AG.I help you to explore unique opportunities of nova in blockchain space. </pre>",
             'reply_markup' => $reply_markup]);

        // This will update the chat status to typing...
        $this->replyWithChatAction(['action' => Actions::TYPING]);

        // This will prepare a list of available commands and send the user.
        // First, Get an array of all registered commands
        // They'll be in 'command-name' => 'Command Handler Class' format.
        //$commands = $this->getTelegram()->getCommands();

        // Build the list
        //$response = ' ';

       // foreach ($commands as $name => $command) {
       //     $response .= sprintf('/%s - %s' . PHP_EOL, $name, $command->getDescription());
       // }

        // Reply with the commands list
       // $this->replyWithMessage(['parse_mode' => 'HTML','text' => $response]);

        // Trigger another command dynamically from within this command
        // When you want to chain multiple commands within one or process the request further.
        // The method supports second parameter arguments which you can optionally pass, By default
        // it'll pass the same arguments that are received for this command originally.
        $this->triggerCommand('subscribe');
    }
}