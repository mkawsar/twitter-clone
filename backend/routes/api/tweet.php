<?php

use App\Http\Controllers\APIs\TweetController;
use Illuminate\Support\Facades\Route;

Route::name('tweet.')->prefix('tweet')->middleware('api')->group(function () {
    Route::middleware('jwt.verify')->group(function () {
        Route::get('list', [TweetController::class, 'list'])->name('list');
        Route::post('store', [TweetController::class, 'store'])->name('store');
        Route::post('{uuid}/like', [TweetController::class, 'like'])->name('like');
    });
});
