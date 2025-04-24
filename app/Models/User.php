<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property int $id
 * @property string $name
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 */
class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, InteractsWithMedia;

    const AVATAR_MEDIA_COLLECTION = 'avatar';
    const THUMB_MEDIA_CONVERSIONS_NAME = 'thumb';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::AVATAR_MEDIA_COLLECTION)
            ->useFallbackUrl('/default_avatar.jpg')
            ->useFallbackUrl('/default_avatar_thumb.jpg', self::THUMB_MEDIA_CONVERSIONS_NAME)
            ->useFallbackPath(public_path('/default_avatar.jpg'))
            ->useFallbackPath(public_path('/default_avatar_thumb.jpg'), self::THUMB_MEDIA_CONVERSIONS_NAME)
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png'])
            ->registerMediaConversions(fn () => $this
                ->addMediaConversion(self::THUMB_MEDIA_CONVERSIONS_NAME)
                ->width(50)
                ->height(50)
            );
    }
}
