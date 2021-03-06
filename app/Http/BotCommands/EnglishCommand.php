<?php

namespace App\Http\BotCommands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class EnglishCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "english";

    /**
     * @var string Command Description
     */
    protected $description = "To choose an English language";

    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {
        $this->replyWithMessage(['parse_mode' => 'HTML','text' => '<b>English Language set default</b>']);

        // This will update the chat status to typing...
        $this->replyWithChatAction(['action' => Actions::TYPING]);
        // This will prepare a list of available commands and send the user.
        // First, Get an array of all registered commands
        // They'll be in 'command-name' => 'Command Handler Class' format.
        // Trigger another command dynamically from within this command
        // When you want to chain multiple commands within one or process the request further.
        // The method supports second parameter arguments which you can optionally pass, By default
        // it'll pass the same arguments that are received for this command originally.
        $this->triggerCommand('subscribe');
    }
}