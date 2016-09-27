<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/**
 * Api
 */
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
	$api->post('oauth/access_token', function() {
		return Authorizer::issueAccessToken();
	});
});

//Show user info via restful service.
$api->version('v1', ['namespace' => 'App\Http\Controllers'], function ($api) {
	$api->get('users', 'UsersController@index');
	$api->get('users/{id}', 'UsersController@show');
});

//Just a test with auth check.
$api->version('v1', ['middleware' => 'api.auth'] , function ($api) {
	$api->get('time', function () {
		return ['now' => microtime(), 'date' => date('Y-M-D',time())];
	});
});