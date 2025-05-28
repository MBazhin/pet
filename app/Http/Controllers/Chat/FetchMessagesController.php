<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Http\Resources\Chat\MessageResource;
use App\Models\Chat\Chat;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FetchMessagesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Chat $chat): AnonymousResourceCollection
    {
        return MessageResource::collection(
            $chat
                ->messages()
                ->cursorPaginate(20)
        );
    }
}
