<?php

namespace App\Http\Resources\Chat;

use App\Models\Chat\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     * @throws Throwable
     */
    public function toArray(Request $request): array
    {
        /** @var Chat $this */
        /** @var User $companion */
        $companion = $this->users->containsOneItem()
            ? $this->users->first()
            : optional();

        return [
            'id' => $this->id,
            'name' => $this->name ?? $companion->name,
            'avatar' => $this->avatar ?? $companion->avatar,
            'avatar_thumb' => $this->avatar_thumb ?? $companion->avatar_thumb,
            'users' => $this->users->toResourceCollection(UserResource::class),
            'last_message' => $this->lastMessage?->toResource(MessageResource::class),
        ];
    }
}
