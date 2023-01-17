<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Publisher\UserController;
use App\Http\Controllers\Publisher\PublisherController;

Route::group(['prefix' => 'publisher', 'namespace' => 'Publisher', 'as' => 'publisher.'], function(){
    Route::middleware(['auth:web'])->group(function (){
        Route::get('/', [UserController::class, 'profile'])->name('user.profile');

        Route::get('/profile', [PublisherController::class, 'edit_profile'])->name('profile.edit');

        Route::resource('publishers',  'PublisherController');

        Route::resource('offers', OfferController::class);
    });
});
