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

    $router->get('/user', ['uses' => 'UserController@getUser']);
    $router->post('login', ['uses' => 'UserController@authenticate']);
    $router->post('subscribe', ['uses' => 'UserController@subscribe']);
    $router->post('smc/{username}', ['uses' => 'UserController@sendEmailConfirmation']);
    $router->get('confirm/{username}/{code}', ['uses' => 'UserController@confirmEmail']);
    $router->put('/cc/{id}', ['uses' => 'UserController@cancelCode']);

    $router->group(['prefix' => 'annoncer'], function () use ($router) {
        $router->get('/', 'AnnoncerController@index');
        $router->get('/user', 'AnnoncerController@getUserAnnouncer');
        $router->get('/getAnnonces', 'AnnoncerController@getAnnonces');
        $router->post('/', 'AnnoncerController@store');
        $router->get('/{id}', 'AnnoncerController@show');
        $router->put('/{id}', 'AnnoncerController@update');
        $router->delete('/{id}', 'AnnoncerController@destroy');
        $router->post('uimage/{id}', 'AnnoncerController@setImage');
    });

    $router->group(['prefix' => 'annonces'], function () use ($router) {
        $router->get('/', 'AnnonceController@index');
        $router->get('/user', 'AnnonceController@getUserAnnounces');
        $router->get('/{id}/user', 'AnnonceController@getAnnoncesUser');
        $router->get('/{id}/annoncer', 'AnnonceController@getAnnoncesAnnoncer');
        $router->get('/premium', 'AnnonceController@getPremiumAnnonces');
        $router->get('/coordinates', 'AnnonceController@getPositions');
        $router->post('/', 'AnnonceController@store');
        $router->post('/byFilters/', 'AnnonceController@getAnnoncesByFilters');
        $router->get('/{id}', 'AnnonceController@show');
        $router->put('/{id}', 'AnnonceController@update');
        $router->delete('/{id}', 'AnnonceController@destroy');

    });

    $router->group(['prefix' => 'users/', 'middleware' => 'cors'], function () use ($router) {
        $router->get('{username}/announces', 'AnnouncerAnnounceController@index');
        $router->post('{username}/announces', 'AnnouncerAnnounceController@store');
        $router->get('{username}/announces/{announce_id}', 'AnnouncerAnnounceController@show');
        $router->put('{username}/announces/{announce_id}', 'AnnouncerAnnounceController@update');
        $router->delete('{username}/announces/{announce_id}', 'AnnouncerAnnounceController@destroy');
        $router->post('utstimage/{id}', 'AnnouncerAnnounceController@storeTSTImages');
        $router->get('gtstimage/{id}', 'AnnouncerAnnounceController@getTSTImages');
        $router->get('test', 'AnnouncerAnnounceController@downloadImages');
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



//Auth::routes();

$router->group(['prefix' => 'socialite'], function () use ($router) {

    $router->get('login/facebook', ['uses' => 'LoginFacebookController@redirectToProvider']);
    $router->get('login/facebook/callback', ['uses' => 'LoginFacebookController@handleProviderCallback']);

    $router->get('login/google', ['uses' => 'Auth\LoginGoogleController@redirectToProvider']);
    $router->get('login/google/callback', ['uses' => 'Auth\LoginGoogleController@handleProviderCallback']);

});



