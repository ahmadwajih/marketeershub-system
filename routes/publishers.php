<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'publisher', 'namespace' => 'Publisher', 'as' => 'publisher.'], function(){

    Route::middleware(['auth:web'])->group(function (){
        Route::get('/', 'UserController@profile')->name('user.profile');

        Route::resource('coupons', CouponController::class);
        Route::get('coupons/clear/sessions', 'CouponController@clearFilterSeassoions')->name('coupons.clear.sessions');

    });
});
