<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'Api\UserController@login'); //login
Route::post('/register', 'Api\UserController@register'); //register

Route::post('/v1/login', 'Api\UserController@login'); //login
Route::post('/v1/register', 'Api\UserController@register'); //register
Route::post('/v1/change_password', 'Api\UserController@changePassword');
Route::post('/v1/getprofile', 'Api\p1\MainController@getprofile');
Route::post('/v1/get_categories','Api\p1\MainController@get_categories');
Route::post('/v1/get_vehicles','Api\p1\MainController@get_vehicles');
Route::post('/v1/add_vehicles','Api\p1\MainController@add_vehicles');
