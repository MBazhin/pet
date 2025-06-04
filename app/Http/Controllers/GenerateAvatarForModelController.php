<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class GenerateAvatarForModelController extends Controller
{
    public function __invoke($modelId, string $modelClass, string $field, bool $thumb = false): Response
    {
        /** @var Model $model */
        $model = app($modelClass);

        $valueForAvatar = $model->query()->findOrFail($modelId)->{$field};

        //todo кеширование

        $avatarSvg = \Avatar::create($valueForAvatar)
            ->setFontFamily('Segoe UI')
            ->toSvg();

        return response($avatarSvg)
            ->header('Content-Type', 'image/svg+xml');
    }
}
