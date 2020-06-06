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
    $router->post('subscribe', ['uses' => 'UserController@subscribe']);

    $router->group(['prefix' => 'annoncer'], function () use ($router) {
        $router->get('/', 'AnnoncerController@index');
        $router->get('/getAnnonces', 'AnnoncerController@getAnnonces');
        $router->post('/', 'AnnoncerController@store');
        $router->get('/{id}', 'AnnoncerController@show');
        $router->put('/{id}', 'AnnoncerController@update');
        $router->delete('/{id}', 'AnnoncerController@destroy');
    });

    $router->group(['prefix' => 'annonce'], function () use ($router) {
        $router->get('/', 'AnnonceController@index');
        $router->post('/', 'AnnonceController@store');
        $router->get('/{id}', 'AnnonceController@show');
        $router->put('/{id}', 'AnnonceController@update');
        $router->delete('/{id}', 'AnnonceController@destroy');
    });
});

$router->group(['prefix' => 'admin'], function () use ($router) {

//    $router->post('create', ['uses' => 'AdminController@superCreate']);
    $router->post('create', ['uses' => 'AdminController@create']);
    $router->get('update', ['uses' => 'AdminController@update']);
    $router->get('admins', ['uses' => 'AdminController@all']);
    $router->get('profile', ['uses' => 'AdminController@profile']);

});
