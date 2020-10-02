<?php

namespace Iperson1337\Chat\Eventing;

use Iperson1337\Chat\Models\Conversation;

class ParticipantsJoined extends Event
{
    /**
     * @var Conversation
     */
    public $conversation;
    public $participants;

    public function __construct(Conversation $conversation, $participants)
    {
        $this->conversation = $conversation;
        $this->participants = $participants;
    }
}
