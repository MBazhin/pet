<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Http\Resources\Chat\ChatResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Throwable;

class ChatListController extends Controller
{
    /**
     * @throws Throwable
     */
    public function __invoke(Request $request): ResourceCollection
    {
        /** @var User $user */
        $user = auth()->user() ?? User::query()->first(); //todo временно

        return ChatResource::collection(
            $user
                ->chats()
                ->with([
                    'users' => fn ($query) => $query
                        ->whereKeyNot($user)
                        ->select('users.id', 'users.name'),
                    'users.media'
                ])
                ->withMax('messages as last_message_id', 'id')
                ->with('lastMessage:id,sender_id,text,created_at')
                ->latest('last_message_id')
                ->latest('chats.id')
                ->cursorPaginate(15)
        );
    }
}
