<?php

use App\Http\Controllers\APIs\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/status', function () {
    return response()->json([
        'message' => 'Welcome to our application',
        'version' => app()->version()
    ], 200);
});

Route::name('auth.')->prefix('auth')->middleware('api')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::middleware('jwt.verify')->group(function () {
        Route::get('me', [AuthController::class, 'me'])->name('me');
        Route::get('refresh/token', [AuthController::class, 'refresh'])->name('refresh.token');
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    });
});
