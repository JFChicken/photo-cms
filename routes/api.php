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


Route::post('/foo', 'AuthenticateController@authenticate');

Route::middleware('auth:api')->post('/login', 'AuthenticateController@login');


// Route::post('login', 'AuthenticateController@login');
Route::post('logout', 'AuthenticateController@logout');
Route::post('refresh', 'AuthenticateController@refresh');
Route::post('me', 'AuthenticateController@me');


Route::post('foo', 'ApiDisplayPhotoController@foo');