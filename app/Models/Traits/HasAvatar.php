<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * @property string avatar
 * @property string avatar_thumb
 */
trait HasAvatar
{
    protected const AVATAR_MEDIA_COLLECTION = 'avatar';
    protected const THUMB_MEDIA_CONVERSIONS_NAME = 'thumb';

    protected function avatar(): Attribute
    {
        return Attribute::get(fn () => !empty($avatar = $this->getFirstMediaUrl('avatar'))
            ? $avatar
            : route('avatar_generator', [
                'modelId' => $this->id,
                'modelClass' => $this::class,
                'field' => 'name'
            ])
        );
    }

    protected function avatarThumb(): Attribute
    {
        return Attribute::get(fn () => !empty($avatarThumb = $this->getFirstMediaUrl('avatar', 'thumb'))
            ? $avatarThumb
            : route('avatar_generator', [
                'modelId' => $this->id,
                'modelClass' => $this::class,
                'field' => 'name',
                'thumb' => true
            ])
        );
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::AVATAR_MEDIA_COLLECTION)
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png'])
            ->registerMediaConversions(fn () => $this
                ->addMediaConversion(self::THUMB_MEDIA_CONVERSIONS_NAME)
                ->width(50)
                ->height(50)
            );
    }
}
