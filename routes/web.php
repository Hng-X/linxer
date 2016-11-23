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

Route::get('/links/{teamSlug}', 'WebController@viewLinks');

//---- bot events route
Route::post('/links', 'BotController@receive');

//test route to test bot response
Route::get('/'text', 'BotController@test');

// $router->group(['prefix' => 'auth/slack', 'namespace' => 'Auth'], function ($router) {
//     $router->get('/callback/user', ['as' =>'auth.slack.callback.user', 'uses' => 'AuthController@handleProviderCallbackUser']);
//     $router->get('/callback', 'AuthController@handleProviderCallback');
//     $router->get('/', ['as' => 'auth.slack', 'uses' => 'AuthController@redirectToProvider']);
// });


/* Slack Authorization Routers */

Route::get('/authorize', 'AuthController@authorizeSlack');
Route::get('/signin', 'AuthController@redirectUsertoTeamLinks');
