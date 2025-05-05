<?php

namespace App\Models\Chat;

use App\Models\User;
use Carbon\Carbon;
use Database\Factories\Chat\MessageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    /** @use HasFactory<MessageFactory> */
    use HasFactory;

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

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
