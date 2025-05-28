<?php

use App\Http\Controllers\GenerateAvatarForModelController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/avatar-generator/{modelId}/{modelClass}/{field}/{thumb?}', GenerateAvatarForModelController::class)
    ->name('avatar_generator');

Route::view('/chat', 'chat.index')
    ->middleware('auth')
    ->name('chat.index');

Route::prefix('auth')
    ->name('auth.')
    ->group(function () {
        Route::middleware('guest')
            ->group(function () {
                Route::view('/login', 'auth.login')->name('login');
                Route::post('/login/{user}', function (\App\Models\User $user, \Illuminate\Http\Request $request) {
                    auth()->loginUsingId($user->id);
                    $request->session()->regenerate();
                    return redirect()->intended();
                })->name('authenticate');
            });
        Route::post('/logout', function (\Illuminate\Http\Request $request) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/');
        })->middleware('auth')->name('logout');
    });
