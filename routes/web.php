<?php
use Laravel\Lumen\Routing\Router;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
/** @var \Laravel\Lumen\Routing\Router $router */
$router->get('/', function () {
    return app()->version();
});


//$router->group(['middleware' => ['client_credentials']], function () use ($router) {
//    $router->get('/test',  [
//        'uses'       => 'UserController@test',
//    ]);
//});

$router->group(['prefix' => 'api/v1'], function () use ($router) {

    $router->group(['prefix' => 'users'], function () use ($router) {

        $router->post('signin', 'AccessTokenController@createAccessToken');

        $router->group(['middleware' => ['auth:api', 'throttle:60']], function () use ($router) {
            $router->post('/', [
                'uses'       => 'UserController@store',
                'middleware' => "scope:users,users:create"
            ]);
            $router->get('/',  [
                'uses'       => 'UserController@index',
                'middleware' => "scope:users,users:list"
            ]);
            $router->get('{id}', [
                'uses'       => 'UserController@show',
                'middleware' => "scope:users,users:read"
            ]);
            $router->put('{id}', [
                'uses'       => 'UserController@update',
                'middleware' => "scope:users,users:write"
            ]);
            $router->delete('{id}', [
                'uses'       => 'UserController@destroy',
                'middleware' => "scope:users,users:delete"
            ]);
        });


    });



});


