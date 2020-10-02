<?php

namespace Iperson1337\Chat\Http\Controllers;

use Chat;
use Iperson1337\Chat\Http\Requests\StoreParticipation;
use Iperson1337\Chat\Http\Requests\UpdateParticipation;
use Iperson1337\Chat\Models\Conversation;
use Iperson1337\Chat\Models\Participation;
use Symfony\Component\HttpFoundation\Response;

class ConversationParticipationController extends Controller
{
    public function store(StoreParticipation $request, $conversationId)
    {
        $conversation = Chat::conversations()->getById($conversationId);
        Chat::conversation($conversation)->addParticipants($request->participants());

        return response($conversation->participants);
    }

    public function index($conversationId)
    {
        /** @var Conversation $conversation */
        $conversation = Chat::conversations()->getById($conversationId);

        return response($conversation->getParticipants());
    }

    public function show($conversationId, $participationId)
    {
        $participation = Participation::find($participationId);

        return response($participation);
    }

    public function update(UpdateParticipation $request, $conversationId, $participationId)
    {
        $participation = Participation::find($participationId);

        if ($participation->conversation_id != $conversationId) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $participation->update($request->validated());

        return response($participation);
    }

    public function destroy($conversationId, $participationId)
    {
        $conversation = Chat::conversations()->getById($conversationId);
        $participation = Participation::find($participationId);
        $conversation = Chat::conversation($conversation)->removeParticipants([$participation->messageable]);

        return response($conversation->participants);
    }
}
