<?php

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {

    $router->post('login', ['uses' => 'UserController@authenticate']);
    $router->post('test', ['uses' => 'UserController@test']);

});

$router->group(['prefix' => 'admin'], function () use ($router) {

    $router->post('create', ['uses' => 'AdminController@create']);
    $router->get('update', ['uses' => 'AdminController@update']);
    $router->get('admins', ['uses' => 'AdminController@all']);
    $router->get('profile', ['uses' => 'AdminController@profile']);

});
