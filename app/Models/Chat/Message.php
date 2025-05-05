<?php

namespace App\Models\Chat;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $chat_id
 * @property int $sender_id
 * @property string $text
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 */
class Message extends Model
{
    protected $fillable = [
        'sender_id',
        'text',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'chat_id' => 'integer',
            'sender_id' => 'integer',
        ];
    }
}
