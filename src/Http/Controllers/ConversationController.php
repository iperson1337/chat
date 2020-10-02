<?php

namespace Iperson1337\Chat\Http\Controllers;

use Chat;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Iperson1337\Chat\Exceptions\DeletingConversationWithParticipantsException;
use Iperson1337\Chat\Http\Requests\DestroyConversation;
use Iperson1337\Chat\Http\Requests\StoreConversation;
use Iperson1337\Chat\Http\Requests\UpdateConversation;
use Iperson1337\Chat\Models\Conversation;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class ConversationController extends Controller
{
    protected $conversationTransformer;

    public function __construct()
    {
        $this->setUp();
    }

    private function setUp()
    {
        if ($conversationTransformer = config('iperson1337_chat.transformers.conversation')) {
            $this->conversationTransformer = app($conversationTransformer);
        }
    }

    private function itemResponse($conversation)
    {
        if ($this->conversationTransformer) {
            return fractal($conversation, $this->conversationTransformer)->respond();
        }

        return response($conversation);
    }

    public function index()
    {
        $conversations = Chat::conversations()->conversation->all();

        if ($this->conversationTransformer) {
            return fractal()
                ->collection($conversations)
                ->transformWith($this->conversationTransformer)
                ->respond();
        }

        return response($conversations);
    }

    public function store(StoreConversation $request)
    {
        $participants = $request->participants();
        $conversation = Chat::createConversation($participants, $request->input('data', []));

        return $this->itemResponse($conversation);
    }

    public function show($id)
    {
        $conversation = Chat::conversations()->getById($id);

        return $this->itemResponse($conversation);
    }

    public function update(UpdateConversation $request, $id)
    {
        /** @var Conversation $conversation */
        $conversation = Chat::conversations()->getById($id);
        $conversation->update(['data' => $request->validated()['data']]);

        return $this->itemResponse($conversation);
    }

    /**
     * @param DestroyConversation $request
     * @param $id
     *
     * @throws Exception
     *
     * @return ResponseFactory|Response
     */
    public function destroy(DestroyConversation $request, $id): Response
    {
        /** @var Conversation $conversation */
        $conversation = Chat::conversations()->getById($id);

        try {
            $conversation->delete();
        } catch (Exception $e) {
            if ($e instanceof DeletingConversationWithParticipantsException) {
                abort(HttpResponse::HTTP_FORBIDDEN, $e->getMessage());
            }

            throw $e;
        }

        return response($conversation);
    }
}
