<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('export', 'UserController@export')->name('export');
Route::get('importExportView', 'UserController@importExportView');
Route::post('import', 'UserController@import')->name('import');

// Web Routes

// Dashboard Routes
Route::group(['prefix' => 'dashboard', 'namespace' => 'Dashboard', 'as' => 'dashboard.'], function(){
    Route::get('login', 'AuthController@loginForm')->name('login.form');
    Route::post('login', 'AuthController@login')->name('login');
    Route::middleware(['auth:web'])->group(function (){
        Route::get('index', 'DashboardController@index')->name('index');
        Route::resource('users', UserController::class);
        Route::resource('publishers', PublisherController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('cities', CityController::class);
        Route::resource('advertisers', AdvertiserController::class);
        Route::resource('offers', OfferController::class);
        Route::resource('coupons', CouponController::class);
        Route::post('logout', 'AuthController@logout')->name('logout');

        // Ajax requests
        Route::post('ajax/cities', 'AjaxController@cities')->name('ajax.cities');
    });
});

