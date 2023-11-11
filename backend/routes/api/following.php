<?php

use App\Http\Controllers\APIs\PeopleFollowingController;
use Illuminate\Support\Facades\Route;

Route::name('following.')->prefix('people/following')->middleware('api')->group(function () {
    Route::middleware('jwt.verify')->group(function () {
        Route::get('all/list', [PeopleFollowingController::class, 'getPeopleList'])->name('people.all.list');
        Route::post('{userID}/store', [PeopleFollowingController::class, 'storeFollowing'])->name('store');
    });
});
