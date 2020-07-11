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
    $router->post('smc/{username}', ['uses' => 'UserController@sendEmailConfirmation']);
    $router->get('confirm/{username}/{code}', ['uses' => 'UserController@confirmEmail']);

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
        $router->get('/user', 'AnnonceController@getUserAnnounces');
        $router->get('/premium', 'AnnonceController@getPremiumAnnonces');
        $router->post('/', 'AnnonceController@store');
        $router->get('/{id}', 'AnnonceController@show');
        $router->put('/{id}', 'AnnonceController@update');
        $router->delete('/{id}', 'AnnonceController@destroy');
    });
});

$router->group(['prefix' => 'admin'], function () use ($router) {

    $router->post('screate', ['uses' => 'AdminController@superCreate']);
    $router->post('create', ['uses' => 'AdminController@create']);
    $router->get('update', ['uses' => 'AdminController@update']);
    $router->get('admins', ['uses' => 'AdminController@all']);
    $router->get('profile', ['uses' => 'AdminController@profile']);

});


$router->group(['prefix' => 'contact'], function () use ($router) {
    $router->post('/', ['uses' => 'ContactController@contact']);
});
