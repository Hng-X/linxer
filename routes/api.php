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
//Route::post('/links/{ $link }', 'BotController@receive');
//Route::post('/verify', 'VerificationController@verify');
//Route::get('/verify', 'VerificationController@verify');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('/slack', 'AuthController@redirectToProvider');
