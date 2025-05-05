<?php

namespace App\Models\Chat;

use App\Models\Traits\HasAvatar;
use App\Models\User;
use Carbon\Carbon;
use Database\Factories\Chat\ChatFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property int $id
 * @property string $name
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 *
 * @property Collection<User> $users
 * @property ?Message $lastMessage
 */
class Chat extends Model implements HasMedia
{
    /** @use HasFactory<ChatFactory> */
    use HasFactory, InteractsWithMedia, HasAvatar {
        HasAvatar::registerMediaCollections insteadof InteractsWithMedia;
    }

    protected $fillable = [
        'name',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
        ];
    }

    protected function shouldGenerateAvatar(): bool
    {
        return false;
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function lastMessage(): BelongsTo
    {
        return $this->belongsTo(Message::class);
    }
}
