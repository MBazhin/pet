<?php

namespace App\Http\Resources\Chat;

use App\Models\Chat\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Message $this */
        return $this->only('id', 'sender_id', 'text', 'created_at');
    }
}
