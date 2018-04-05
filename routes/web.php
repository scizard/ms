<?php

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
Route::get('/', [
    'uses' => 'PageController@index',
    'as' => 'index'
]);
Route::get('/test', [
    'uses' => 'PageController@test',
    'as' => 'test'
]);
Route::get('/rentals', [
    'uses' => 'PageController@getRentals',
    'as' => 'rentals'
]);
Route::get('/hostels', [
    'uses' => 'PageController@getHostels',
    'as' => 'hostels'
]);
Route::get('/commercials', [
    'uses' => 'PageController@getCommercials',
    'as' => 'commercials'
]);
Route::get('/apartments', [
    'uses' => 'PageController@getApartments',
    'as' => 'apartments'
]);
Route::get('/reset',[
    'uses'=>'PageController@getResetPassword',
    'as'=>'reset'
]);
Route::post('/reset',[
    'uses'=>'PageController@postResetPassword',
    'as'=>'reset'
]);

Auth::routes();
/**
 * Users routes
 */

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/coming-soon', [
    'uses' => 'PageController@comingSoon',
    'as' => 'comingSoon'
]);
Route::get('/show/{id}', [
    'uses' => 'PageController@showHouse',
    'as' => 'showHouse'
]);
Route::get('/checkout/{id}',[
    'uses'=>'HomeController@getBook',
    'as'=>'book'
]);
Route::post('/checkout',[
    'uses'=>'PaymentController@checkOut',
    'as'=>'checkout'
]);
Route::get('/inbox',[
    'uses'=>'HomeController@getInbox',
    'as'=>'inbox'
]);
Route::get('/logout',[
    'uses'=>'HomeController@logout',
    'as'=>'user.logout'
]);
Route::get('/statement',[
    'uses'=>'HomeController@getStatement',
    'as'=>'statements'
]);
Route::get('/booked',[
    'uses'=>'HomeController@getBooked',
    'as'=>'booked'
]);

Route::get('/change/password',[
    'uses'=>'HomeController@getChangePassword',
    'as'=>'changePassword'
]);

Route::post('/change/password',[
    'uses'=>'HomeController@updatePassword',
    'as'=>'changePassword'
]);
Route::get('/preview/{id}', [
    'uses' => 'HomeController@showHouse',
    'as' => 'showHouse'
]);

/**
 * admins actions
 */
Route::prefix('admin')->group(function () {
    Route::get('/login', [
        'uses' => 'PageController@getAdminLogin',
        'as' => 'admin.login'
    ]);
    Route::post('/login', [
        'uses' => 'PageController@postAdminLogin',
        'as' => 'admin.login'
    ]);
    Route::get('/home', [
        'uses' => 'AdminController@getAdminHome',
        'as' => 'admin.home'
    ]);
    Route::get('/requests', [
        'uses' => 'AdminController@getLeaseRequests',
        'as' => 'admin.leaseRequests'
    ]);
    Route::get('/statements', [
        'uses' => 'AdminController@statements',
        'as' => 'admin.statements'
    ]);
    Route::get('/requests/accept/{id}', [
        'uses' => 'AdminController@acceptLease',
        'as' => 'admin.requestActions'
    ]);
    Route::get('/requests/reject/{id}', [
        'uses' => 'AdminController@rejectLease',
        'as' => 'admin.requestActions'
    ]);
    Route::get('/requests/preview/{id}', [
        'uses' => 'AdminController@previewHouses',
        'as' => 'admin.previewHouses'
    ]);
    Route::get('/rejected/requests', [
        'uses' => 'AdminController@rejectedRequests',
        'as' => 'admin.rejectedRequests'
    ]);

    Route::get('/accepted/requests', [
        'uses' => 'AdminController@acceptedRequests',
        'as' => 'admin.acceptedRequests'
    ]);
    Route::get('/requests/cancel/{id}', [
        'uses' => 'AdminController@revokedRequests',
        'as' => 'admin.revokedRequests'
    ]);
    Route::get('/new/houses', [
        'uses' => 'AdminController@getHouseRegister',
        'as' => 'admin.addHouse'
    ]);
    Route::get('/inbox', [
        'uses' => 'AdminController@getInbox',
        'as' => 'admin.inbox'
    ]);
    Route::post('/new/houses', [
        'uses' => 'AdminController@addHouse',
        'as' => 'admin.addHouse'
    ]);
    Route::get('compose',[
        'uses'=>'AdminController@getCompose',
        'as'=>'admin.compose'
    ]);
    Route::post('compose',[
        'uses'=>'AdminController@postCompose',
        'as'=>'admin.composes'
    ]);
    Route::get('broadcast',[
        'uses'=>'AdminController@getBroadcast',
        'as'=>'admin.broadcast'
    ]);
    Route::post('broadcast',[
        'uses'=>'AdminController@postBroadcast',
        'as'=>'admin.broadcast'
    ]);
    Route::get('change/password',[
        'uses'=>'AdminController@getChangePassword',
        'as'=>'admin.changePassword'
    ]);

    Route::post('change/password',[
        'uses'=>'AdminController@updatePassword',
        'as'=>'admin.changePassword'
    ]);

    //logout
    Route::get('/logout', [
        'uses' => 'AdminController@getAdminLogout',
        'as' => 'admin.logout'
    ]);
});


/**
 * landlord section
 */
Route::prefix('landlord')->group(function () {
    Route::get('register', [
        'uses' => 'PageController@landlordRegister',
        'as' => 'landlord.register'
    ]);
    Route::post('register', [
        'uses' => 'PageController@postLandlordRegister',
        'as' => 'landlord.register'
    ]);
    Route::get('dashboard', [
        'uses' => 'LandlordController@getLandlordDashboard',
        'as' => 'landlord.dashboard'
    ]);
    Route::get('login', [
        'uses' => 'PageController@landlordLogin',
        'as' => 'landlord.login'
    ]);
    Route::post('login', [
        'uses' => 'PageController@postLandlordLogin',
        'as' => 'landlord.login'
    ]);
    Route::get('request',[
        'uses'=>'LandlordController@addHouse',
        'as'=>'landlord.addHouse'
    ]);
    Route::post('request',[
        'uses'=>'LandlordController@postHouse',
        'as'=>'landlord.addHouse'
    ]);
    Route::get('remove/house',[
        'uses'=>'LandlordController@removeHouse',
        'as'=>'landlord.remove'
    ]);
    Route::get('statements',[
        'uses'=>'LandlordController@getStatement',
        'as'=>'landlord.statement'
    ]);
    Route::get('withdraw',[
        'uses'=>'LandlordController@getWithdraw',
        'as'=>'landlord.withdraw'
    ]);
    Route::post('withdraw',[
        'uses'=>'LandlordController@postWithdraw',
        'as'=>'landlord.withdraw'
    ]);
    Route::get('remove/{id}',[
        'uses'=>'LandlordController@postRemoveHouse',
        'as'=>'landlord.postRemove'
    ]);
    Route::get('removed/houses',[
        'uses'=>'LandlordController@removedHouses',
        'as'=>'landlord.removed'
    ]);
    Route::get('cancel/{id}',[
        'uses'=>'LandlordController@cancelRemove',
        'as'=>'landlord.cancelRemove'
    ]);
    Route::get('/messages', [
        'uses' => 'LandlordController@getInbox',
        'as' => 'landlord.messages'
    ]);
    Route::post('reply', [
        'uses' => 'LandlordController@replyInbox',
        'as' => 'landlord.reply'
    ]);
    Route::get('compose', [
        'uses' => 'LandlordController@getCompose',
        'as' => 'landlord.compose'
    ]);
    Route::post('compose', [
        'uses' => 'LandlordController@postCompose',
        'as' => 'landlord.compose'
    ]);
    Route::get('change/password',[
        'uses'=>'LandlordController@getChangePassword',
        'as'=>'landlord.changePassword'
    ]);

    Route::post('change/password',[
        'uses'=>'LandlordController@updatePassword',
        'as'=>'landlord.changePassword'
    ]);
    //logout
    Route::get('/logout', [
        'uses' => 'LandlordController@getLandlordLogout',
        'as' => 'landlord.logout'
    ]);
});