<?php

use App\Http\Controllers\PageTokenController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::post('register',[UserController::class, 'register'])->name('register');// punkt 1

Route::prefix('page-tokens')->group(function () {
    Route::get('{id}/page', [PageTokenController::class, 'index'])
        ->name('page-tokens.page.index')
        ->where('id', '[0-9a-fA-F\-]{36}');
    Route::get('{id}/generate-new', [PageTokenController::class, 'generateNew']) // punkt 2
        ->name('page-tokens.generate-new')
        ->where('id', '[0-9a-fA-F\-]{36}');
    Route::post('{id}/deactivate', [PageTokenController::class, 'deactivate']) // punkt 2
        ->name('page-tokens.deactivate')
        ->where('id', '[0-9a-fA-F\-]{36}');
    Route::get('{id}/attempt-lucky', [PageTokenController::class, 'attemptLucky'])
        ->name('page-tokens.attempt-lucky')
        ->where('id', '[0-9a-fA-F\-]{36}');
    Route::get('{id}/attempt-lucky/attempt', [PageTokenController::class, 'getAttemptLuckyHistory'])
        ->name('page-tokens.attempt-lucky.history')
        ->where('id', '[0-9a-fA-F\-]{36}');
});


