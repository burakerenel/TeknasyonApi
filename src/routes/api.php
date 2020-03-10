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
Route::get('/', 'ApiController@service');
Route::post('check', 'ApiController@check');


Route::post('login', 'ApiController@login');
Route::post('register', 'ApiController@register');
Route::group(['middleware' => 'auth:api'], function () {
   Route::get('category', 'ApiController@categoryList');
   Route::get('category/{id}', 'ApiController@categorySongs');
   Route::post('favorite', 'ApiController@favorite');
});