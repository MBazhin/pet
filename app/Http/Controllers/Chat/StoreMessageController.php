<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\StoreMessageRequest;
use App\Http\Resources\Chat\MessageResource;
use App\Models\Chat\Chat;
use App\Models\Chat\Message;
use Illuminate\Support\Facades\DB;

class StoreMessageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreMessageRequest $request, Chat $chat): MessageResource
    {
        $messageText = $request->validated('text');

        /** @var Message $message */
        $message = DB::transaction(function () use ($chat, $messageText) {
            return $chat->messages()->create([
                'text' => $messageText,
                'sender_id' => auth()->id()
            ]);
        });

        return MessageResource::make($message);
    }
}
