<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Http\Resources\Chat\ChatResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Throwable;

class FetchChatsController extends Controller
{
    /**
     * @throws Throwable
     */
    public function __invoke(Request $request): ResourceCollection
    {
        /** @var User $user */
        $user = auth()->user();

        return ChatResource::collection(
            $user
                ->chats()
                ->withMax('messages as last_message_id', 'id')
                ->with([
                    'users' => fn ($query) => $query
                        ->whereKeyNot($user)
                        ->select('users.id', 'users.name'),
                    'users.media',
                    'lastMessage'
                ])
                ->latest('last_message_id')
                ->latest('chats.id')
                ->cursorPaginate(15)
        );
    }
}
