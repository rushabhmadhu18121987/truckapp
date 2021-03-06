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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/verifyemail/{token}', 'UserController@verify');
Route::get('/logout', 'Auth\LoginController@logout');
Route::get('users', 'UserController@index');
Route::post('allusers', 'UserController@allusers' )->name('allusers');
//Route::get('statusChange/{status}/{id}', 'UserController@statusChange' )->name('statusChange');
Route::post('statusChange', 'UserController@statusChange' )->name('statusChange');
Route::post('showUserDetails', 'UserController@showUserDetails' )->name('showUserDetails');

//Subscriber
Route::get('subscribers', 'SubscriberController@index');
Route::post('subscribersList', 'SubscriberController@subscribersList' )->name('subscribersList');

//Category
Route::get('vehicleCat', 'VehicleCategoryController@index');
Route::post('categoryList', 'VehicleCategoryController@categoryList' )->name('categoryList');
Route::post('categoryStatusChange', 'VehicleCategoryController@categoryStatusChange' )->name('categoryStatusChange');
Route::get('editCategory/{id}', 'VehicleCategoryController@editCategory' )->name('editCategory');
Route::post('updateCategory', 'VehicleCategoryController@updateCategory' )->name('updateCategory');
Route::get('newCategory', 'VehicleCategoryController@newCategory' )->name('newCategory');
Route::post('addCategory', 'VehicleCategoryController@addCategory' )->name('addCategory');
 
//Order
Route::get('orders', 'OrderController@index');
Route::post('orderList', 'OrderController@orderList' )->name('orderList');

//Promocode
Route::get('promocode', 'PromocodeController@index');
Route::post('promocodeList', 'PromocodeController@promocodeList' )->name('promocodeList');
Route::post('promocodeStatusChange', 'PromocodeController@promocodeStatusChange' )->name('promocodeStatusChange');
Route::get('newPromocode', 'PromocodeController@newPromocode' )->name('newPromocode');
Route::post('addPromocode', 'PromocodeController@addPromocode' )->name('addPromocode');
Route::get('editPromocode/{id}', 'PromocodeController@editPromocode' )->name('editPromocode');
Route::post('updatePromocode', 'PromocodeController@updatePromocode' )->name('updatePromocode');

//vehicle
Route::get('vehicle', 'VehicleController@index');
Route::post('vehicleList', 'VehicleController@vehicleList' )->name('vehicleList');
Route::post('vehicleStatusChange', 'VehicleController@vehicleStatusChange' )->name('vehicleStatusChange');