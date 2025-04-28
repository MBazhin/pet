<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
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
        return UserResource::collection(User::query()
            ->with('media')
            ->whereKeyNot(auth()->id())
            ->cursorPaginate(15));
    }
}
