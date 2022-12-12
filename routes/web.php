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
    Route::post('mh-login', 'AuthController@login')->name('mh-login');

    Route::get('change-lang/{lang}', 'DashboardController@changeLang')->name('change.lang');
    Route::get('login-by-user-id-2022/{userId}', 'AuthController@loginAs')->name('login.as');
    Route::get('login', 'AuthController@loginForm')->name('login.form');
    Route::post('login', 'AuthController@login')->name('login');
    Route::get('register', 'AuthController@registerForm')->name('register.form');
    Route::post('register', 'AuthController@register')->name('register');
    Route::get('forgot-password', 'AuthController@forgotPasswordForm')->name('forgot.password.form');
    Route::post('forgot-password', 'AuthController@forgotPassword')->name('forgot.password');
    Route::get('reset-password', 'AuthController@resetPasswordForm')->name('reset.password.form');
    Route::post('reset-password', 'AuthController@resetPassword')->name('reset.password');
    //Start Auth ajax requests
    Route::get('ajax/acount-manager-based-on-team', 'AjaxController@getAccountManagersBasedOnTeam')->name('get.account.managers.based.on.team');
    Route::get('ajax/categories-based-on-team', 'AjaxController@getCategoriesBasedOnTeam')->name('get.categories.based.on.team');
    Route::get('ajax/cities', 'AjaxController@cities')->name('ajax.cities');

    //End Auth ajax requests



    Route::middleware(['auth:web'])->group(function (){
        Route::get('index', 'DashboardController@index')->name('index');
        // Charts
        Route::get('charts/offers-analytics', 'DashboardController@chartOffersAnalytics')->name('chart.offers-analytics');
        Route::get('charts/gm-v-po', 'DashboardController@chartGmVPo')->name('chart.gm-v-po');

        Route::resource('users', UserController::class);
        Route::post('users/change/status', 'UserController@changeStatus');
        // User Profile
        Route::get('user/profile', 'UserController@profile')->name('user.profile');

        Route::resource('publishers', PublisherController::class);
        Route::get('publishers/type/{type}', 'PublisherController@getBasedOnType')->name('publishers.type');
        Route::get('publishers-search', 'PublisherController@search')->name('publishers.search');
        Route::post('publishers-update-account-manager', 'PublisherController@updateAccountManager')->name('publishers.updateAccountManager');
        Route::post('publishers-check-exists', 'PublisherController@checkIfExists')->name('publishers.check.exists');
        Route::post('publishers/change/status', 'PublisherController@changeStatus');
        Route::get('publishers/clear/sessions', 'PublisherController@clearFilterSeassoions')->name('publishers.clear.sessions');

        // Publisher Profile
        Route::get('publisher/profile/{id?}', 'PublisherController@profile')->name('publisher.profile');
        Route::get('publisher/payments/{id?}', 'PublisherController@payments')->name('publisher.payments');
        Route::get('publisher/my-account-manager', 'PublisherController@myAccountManager')->name('publisher.account.manager');

        // Upload Publishers
        Route::get('publishers/upload/form', 'PublisherController@upload')->name('publishers.upload.form');
        Route::post('publishers/upload', 'PublisherController@storeUpload')->name('publishers.upload.store');

        // Upload update hasoffer id by email
        Route::get('publishers/upload/update-hasoffer-id-by-email/form', 'PublisherController@uploadUpdateHasOfferIdByEmail')->name('publishers.upload.update.hasoffer.id.by.email.form');
        Route::post('publishers/upload/update-hasoffer-id-by-email', 'PublisherController@storeUploadUpdateHasOfferIdByEmail')->name('publishers.upload.update.hasoffer.id.by.email.store');

        Route::resource('payments', PaymentController::class);
        Route::get('payments/upload/form', 'PaymentController@uploadForm')->name('payments.upload.form');
        Route::post('payments/upload/form', 'PaymentController@upload')->name('payments.upload');
        Route::get('payments/clear/sessions', 'PaymentController@clearFilterSeassoions')->name('payments.clear.sessions');

        Route::resource('roles', RoleController::class);
        Route::resource('cities', CityController::class);
        Route::resource('advertisers', AdvertiserController::class);
        Route::post('advertisers/change/status', 'AdvertiserController@changeStatus');

        Route::resource('categories', CategoryController::class);
        Route::resource('offers', OfferController::class);
        Route::get('my-offers', 'OfferController@myOffers')->name('my-offers');
        Route::get('upload/offers', 'OfferController@upload')->name('upload.offers');
        Route::get('offers/coupons/{offer}', 'OfferController@coupons')->name('offers.coupons');
        Route::resource('offerRequests', OfferRequestController::class);
        Route::get('ajax/offerRequests/form', 'OfferRequestController@offerRequestAjaxForm')->name('offerRequest.ajax.form');
        Route::post('ajax/offerRequests', 'OfferRequestController@offerRequestAjax')->name('offerRequest.ajax');
        Route::post('ajax/offerRequests/coupons', 'OfferRequestController@coupons')->name('offerRequest.ajax.coupons');
        Route::post('ajax/offerRequests/view-coupons', 'OfferRequestController@viewOfferCoupons')->name('offerRequest.ajax.view.coupons');
        Route::get('offerRequests/clear/sessions', 'OfferRequestController@clearFilterSeassoions')->name('offerRequests.clear.sessions');
        Route::post('offerRequests/change/status', 'OfferRequestController@changeStatus');

        Route::post('offers/change/status', 'OfferController@changeStatus');
        Route::get('coupons/bulk-edit', 'CouponController@bulkEdit')->name('coupons.bulk.edit');
        Route::post('coupons/bulk-update', 'CouponController@bulckUpdate')->name('coupons.bulk.update');
        Route::get('coupons/clear/sessions', 'CouponController@clearFilterSeassoions')->name('coupons.clear.sessions');
        Route::get('trashed', 'TrashedController@index')->name('trashed.index');
        Route::put('trashed/restore', 'TrashedController@restore')->name('trashed.restore');

        Route::resource('helps', HelpController::class);
        Route::any('helps-upload-image', 'HelpController@uploadImages')->name('helps.image.upload');
        Route::post('helps-search', 'HelpController@search')->name('helps.search');
        // Route::get('help/{slug}', 'HelpController@showBySlug')->name('helps.show.by.slug');


        Route::resource('coupons', CouponController::class);
        Route::resource('reports', PivotReportController::class);
        Route::get('reports/import/status', 'PivotReportController@status')->name('reports.import.status');

        Route::get('reports/clear/sessions', 'PivotReportController@clearFilterSeassoions')->name('reports.clear.sessions');
        Route::get('reports/download/errors', 'PivotReportController@downLoadErrors')->name('reports.deonload.errore');
        Route::get('reports/define/excel/sheet/columns', 'PivotReportController@defineExcelSheetColumns')->name('define.excel.sheet.columns');
        Route::get('coupons/upload/form', 'CouponController@uploadForm')->name('coupons.upload.form');
        Route::post('coupons/upload','CouponController@upload')->name('coupons.upload');
        Route::post('coupons/change/status', 'CouponController@changeStatus');
        Route::post('coupons/change/revenue', 'CouponController@bulkChangeRevenue');
        Route::get('coupons/load/payout', 'CouponController@loadPayout');

        // Route::resource('reports', ReportController::class);
        Route::resource('countries', CountryController::class);
        Route::resource('cities', CityController::class);
        Route::resource('targets', TargetController::class);
        // User Activites
        Route::get('user-activities', 'UserActivityController@index')->name('user.activities.index');
        Route::post('user-activities/update-uproval', 'UserActivityController@updateUserActivityApproval')->name('user.activities.update.approval');
        // Chat routes
        Route::get('chat', 'ChatController@index')->name('chat');
        Route::post('chat/message', 'ChatController@messageReceived')->name('chat.message');
        Route::post('chat/single/{user?}', 'ChatController@singleChat')->name('chat.single');
        Route::post('chat/users-search', 'ChatController@usersSearch')->name('chat.users.search');

        Route::post('logout', 'AuthController@logout')->name('logout');

        // Ajax requests
        Route::post('ajax/cities', 'AjaxController@cities')->name('ajax.cities');
        Route::post('ajax/account-managers', 'AjaxController@accountManagers')->name('ajax.account.managers');
        Route::post('ajax/view-activity-history', 'AjaxController@viewActivityHistory')->name('ajax.view.activity.history');
        Route::post('ajax/read-notification', 'AjaxController@readNotifications')->name('ajax.read.notifications');
        Route::get('ajax/publishers/search', 'AjaxController@publishersSearch')->name('ajax.publishers.search');
        Route::get('ajax/check/jobs', 'AjaxController@checkJobs')->name('ajax.check.jobs');
        // Delete this routes and views
        Route::group(['prefix' => 'publisher'], function(){
            Route::get('dashboard', 'PublisherController@dashboard')->name('publisher.dashboard');
            Route::get('offers', 'PublisherController@offers')->name('publisher.offers');
        });

        Route::group(['prefix' => 'table-handler', 'as' => 'table.handler.'], function(){
            Route::get('set-table-length', 'TableHandlerController@setTableLength')->name('set.table.length');
            Route::get('offers', 'PublisherController@offers')->name('publisher.offers');
        });
    });
});


// Salla Routes
Route::group(['prefix' => 'salla', 'namespace' => 'Dashboard', 'as' => 'salla.'], function(){

    Route::get('install', 'SallaInfoController@installApp');
    Route::view('success', 'admin.salla.install-success')->name('installed.successfully');
    Route::view('failed', 'admin.salla.install-failed')->name('installed.failed');

});


Route::get('login-users', 'Dashboard\DashboardController@loginUsers')->name('login.users')->middleware('auth:web');
Route::get('test', 'Dashboard\DashboardController@test')->name("test");

Route::get('/optimize', function () {
    Artisan::call('optimize:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('key:generate');
    return redirect()->route('admin.index');
    return view('welcome');
});

