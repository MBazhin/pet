<?php

use App\Http\Controllers\Chat\FetchChatsController;
use App\Http\Controllers\Chat\FetchMessagesController;
use App\Http\Controllers\Chat\StoreMessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('chat')
    ->name('chat.')
    ->middleware('auth:sanctum')
    ->group(function () {
       Route::get('/', FetchChatsController::class)->name('fetch');
       Route::prefix('/{chat}/messages')
           ->name('messages.')
           ->group(function () {
               Route::get('/', FetchMessagesController::class)->name('fetch');
               Route::post('/', StoreMessageController::class)->name('store');
           });
    });
