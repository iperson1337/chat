<?php

namespace Iperson1337\Chat\Eventing;

use Iperson1337\Chat\Models\Message;

class AllParticipantsDeletedMessage extends Event
{
    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }
}
