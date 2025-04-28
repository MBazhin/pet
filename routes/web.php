<?php

use App\Http\Controllers\GenerateAvatarForModelController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/avatar-generator/{modelId}/{modelClass}/{field}/{thumb?}', GenerateAvatarForModelController::class)
    ->name('avatar_generator');

Route::view('/chat', 'chat.index');
