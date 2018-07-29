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
Route::get('/test','Api\UserController@test');
Route::post('/v1/getprofile', 'Api\p1\MainController@getprofile');
