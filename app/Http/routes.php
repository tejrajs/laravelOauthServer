<?php

use App\Clients;

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
	$api->get('clients', 'ClientsController@index');
	$api->get('clients/{id}', 'ClientsController@show');
});

$api->version('v1', ['middleware' => 'api.auth'/*, 'scopes' => ['read_client_data', 'write_client_data']*/], function ($api) {
	$api->post('clients/store', 'App\Http\Controllers\ClientsController@store');
	$api->delete('clients/{id}', 'App\Http\Controllers\ClientsController@destroy');
	$api->put('clients/{id}', 'App\Http\Controllers\ClientsController@update');
});
//Just a test with auth check.
// $api->version('v1', ['middleware' => 'api.auth'] , function ($api) {
// 	$api->put('clients/{id}', 'ClientsController@update');
// 	$api->delete('clients/{id}', 'ClientsController@destroy');
// 	$api->post('clients/store', 'ClientsController@store');
// });