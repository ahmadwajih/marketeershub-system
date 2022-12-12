<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['namespace' => 'Api'], function () {
    
    Route::post('login','AuthController@login');
    Route::get('order', 'OrderController@store');
    Route::get('order-update-status', 'OrderController@updateStatus');
    
    Route::group(['middleware' => ['auth:sanctum']], function () {

        // Get All advertisers 
        Route::get('offers', 'OfferController@index');
        Route::get('advertisers', 'AdvertiserController@index');
        Route::get('publishers', 'PublisherController@index');
        Route::get('affiliates/{advertiser_id?}', 'PublisherController@affiliates');
        Route::get('influencers/{advertiser_id?}', 'PublisherController@influencers');

        Route::post('register-merchant', 'UserController@registerAdvertiser');
        Route::post('register-affiliate', 'UserController@registerAffiliate');
        Route::post('register-influencer', 'UserController@registerInfluencer');
        Route::post('logout','AuthController@logout');

    });

});

