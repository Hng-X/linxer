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
    return view('home');
});


//---- bot events route
Route::post('/links', 'BotController@receive');

//Route::get('/links/{team-name}', 'WebController@viewLinks');

// $router->group(['prefix' => 'auth/slack', 'namespace' => 'Auth'], function ($router) {
//     $router->get('/callback/user', ['as' =>'auth.slack.callback.user', 'uses' => 'AuthController@handleProviderCallbackUser']);
//     $router->get('/callback', 'AuthController@handleProviderCallback');
//     $router->get('/', ['as' => 'auth.slack', 'uses' => 'AuthController@redirectToProvider']);
// });
	Route::get('/authorize', 'AuthController@handleProviderCallback');