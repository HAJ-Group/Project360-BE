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



$router->group(['prefix' => 'smtp'], function () use ($router) {
    $router->get('', function ()  {
        return view('sender');
    });
    $router->post('config', ['uses' => 'UserController@config']);
    $router->post('send', ['uses' => 'UserController@send']);
    $router->post('init', ['uses' => 'UserController@init']);
});




