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

Route::get('/artisan', function () {
    Artisan::call('migrate:fresh');
    Artisan::call('db:seed');
    return redirect()->route('admin.index');
    return view('welcome');
});
Route::get('/', function () {
    return redirect()->route('admin.index');
    return view('welcome');
});


// Web Routes

// Dashboard Routes
Route::group(['prefix' => 'admin', 'namespace' => 'Dashboard', 'as' => 'admin.'], function(){

    Route::get('change-lang/{lang}', 'DashboardController@changeLang')->name('change.lang');
    Route::get('login', 'AuthController@loginForm')->name('login.form');
    Route::post('login', 'AuthController@login')->name('login');
    Route::middleware(['auth:web'])->group(function (){
        Route::get('index', 'DashboardController@index')->name('index');
        Route::resource('users', UserController::class);
        // User Profile
        Route::get('user/profile', 'UserController@profile')->name('user.profile');

        Route::resource('publishers', PublisherController::class);
        Route::get('publishers/type/{type}', 'PublisherController@getBasedOnType')->name('publishers.type');
        Route::get('publishers-search', 'PublisherController@search')->name('publishers.search');
        Route::post('publishers-update-account-manager', 'PublisherController@updateAccountManager')->name('publishers.updateAccountManager');
        // Publisher Profile
        Route::get('publisher/profile', 'PublisherController@profile')->name('publisher.profile');
        Route::get('publisher/my-account-manager', 'PublisherController@myAccountManager')->name('publisher.account.manager');
        // Upload Publishers
        Route::get('publishers/upload/form', 'PublisherController@upload')->name('publishers.upload.form');
        Route::post('publishers/upload', 'PublisherController@storeUpload')->name('publishers.upload.store');
        // Upload update hasoffer id by email
        Route::get('publishers/upload/update-hasoffer-id-by-email/form', 'PublisherController@uploadUpdateHasOfferIdByEmail')->name('publishers.upload.update.hasoffer.id.by.email.form');
        Route::post('publishers/upload/update-hasoffer-id-by-email', 'PublisherController@storeUploadUpdateHasOfferIdByEmail')->name('publishers.upload.update.hasoffer.id.by.email.store');

        Route::resource('roles', RoleController::class);
        Route::resource('cities', CityController::class);
        Route::resource('advertisers', AdvertiserController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('offers', OfferController::class);
        Route::get('my-offers', 'OfferController@myOffers')->name('my-offers');
        Route::resource('offerRequests', OfferRequestController::class);
        Route::get('ajax/offerRequests/form', 'OfferRequestController@offerRequestAjaxForm')->name('offerRequest.ajax.form');
        Route::post('ajax/offerRequests', 'OfferRequestController@offerRequestAjax')->name('offerRequest.ajax');
        Route::resource('coupons', CouponController::class);
        Route::resource('pivot-report', PivotReportController::class);
        Route::get('coupons/upload/form', 'CouponController@uploadForm')->name('coupons.upload.form');
        Route::post('coupons/upload','CouponController@upload')->name('coupons.upload');
        Route::resource('reports', ReportController::class);
        Route::resource('countries', CountryController::class);
        Route::resource('cities', CityController::class);
        Route::resource('targets', TargetController::class);
        // User Activites
        Route::get('user-activities', 'UserActivityController@index')->name('user.activities.index');

        Route::post('logout', 'AuthController@logout')->name('logout');

        // Ajax requests
        Route::post('ajax/cities', 'AjaxController@cities')->name('ajax.cities');
        Route::post('ajax/account-managers', 'AjaxController@accountManagers')->name('ajax.account.managers');
        Route::post('ajax/view-coupons', 'AjaxController@viewCoupons')->name('ajax.view.coupons');
        Route::post('ajax/view-activity-history', 'AjaxController@viewActivityHistory')->name('ajax.view.activity.history');
        Route::post('ajax/read-notification', 'AjaxController@readNotifications')->name('ajax.read.notifications');

        // Charts
        Route::get('chart/offers-market-share', 'OfferController@chartOffersMarketShare')->name('chart.offers-market-share');
        Route::get('chart/gm-v-po', 'OfferController@chartGmVPo')->name('chart.gm-v-po');



        Route::group(['prefix' => 'publisher'], function(){
            Route::get('dashboard', 'PublisherController@dashboard')->name('publisher.dashboard');
            Route::get('offers', 'PublisherController@offers')->name('publisher.offers');
        });
    });
});

Route::get('test', 'Dashboard\DashboardController@test');

