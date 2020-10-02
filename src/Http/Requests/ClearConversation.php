<?php

namespace Iperson1337\Chat\Http\Requests;

class ClearConversation extends BaseRequest
{
    public function authorized()
    {
        return true;
    }

    public function rules()
    {
        return [
            'participant_id'   => 'required',
            'participant_type' => 'required|string',
        ];
    }
}
