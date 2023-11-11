<?php

use App\Http\Controllers\APIs\UserProfileController;
use Illuminate\Support\Facades\Route;

Route::name('auth.')->prefix('auth')->middleware('api')->group(function () {
    Route::prefix('profile')->name('profile.')->middleware('jwt.verify')->group(function () {
        Route::get('info', [UserProfileController::class, 'info'])->name('info');
    });
});
