<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Publisher\UserController;
use App\Http\Controllers\Publisher\PublisherController;

Route::group(['prefix' => 'publisher', 'namespace' => 'Publisher', 'as' => 'publisher.'], function(){
    Route::middleware(['auth:web'])->group(function (){
        Route::get('/', 'UserController@profile')->name('user.profile');
        Route::resource('coupons', CouponController::class);
        Route::get('coupons/clear/sessions', 'CouponController@clearFilterSeassoions')->name('coupons.clear.sessions');
        Route::get('coupons/load/payout', 'CouponController@loadPayout');

    });
});
