<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'publisher', 'namespace' => 'publisher', 'as' => 'publisher.'], function(){

    Route::middleware(['auth:web'])->group(function (){
        Route::get('/', 'UserController@profile')->name('user.profile');
    });
});
