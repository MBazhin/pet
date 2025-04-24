<?php

use App\Http\Controllers\Chat\ChatListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('chat')
    ->name('chat.')
    ->group(function () {
       Route::get('/', ChatListController::class)->name('chat_list');
    });
