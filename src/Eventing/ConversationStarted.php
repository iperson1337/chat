<?php

namespace Iperson1337\Chat\Eventing;

use Iperson1337\Chat\Models\Conversation;

class ConversationStarted extends Event
{
    /**
     * @var Conversation
     */
    public $conversation;

    public function __construct(Conversation $conversation)
    {
        $this->conversation = $conversation;
    }
}
