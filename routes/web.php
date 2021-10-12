<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->post('api/v1/login', 'Auth\LoginController@verify');


$router->group(['prefix'=>'api/v1', 'middleware' => 'pbe.auth'], function ($router) {

    #SongController
    #to get all data songs
    $router->get('/songs', 'SongController@getAll');
    #to get data song By Id
    $router->get('/songs/{id}', 'SongController@getById');

    #PlaylistController
    #to insert data playlist
    $router->post('/playlists', 'PlaylistController@createplaylist');
    #to get all data playlists
    $router->get('/playlists', 'PlaylistController@getAll');
    #to get detail playlists By Id user
    $router->get('/playlists/{id}', 'PlaylistController@getdetailplaylistById');

    #PlaylistSongsController
    #to insert data
    $router->post('/playlists/{id}/songs', 'PlaylistSongsController@create');
    #to get all data song playlists
    $router->get('/playlists/{id}/songs', 'PlaylistSongsController@getAll');
    #to get data song playlist By Id
    $router->get('/playlists/{id}/songs', 'PlaylistController@getallplaylistsongById');


    #group route superuser
    $router->group (['middleware' => 'pbe.superuser'], function ($router) {
        #SongController
        #to delete data
        $router->delete('/songs/{id}', 'SongController@delete');
        #to update data
        $router->put('/songs/{id}', 'SongController@update');
        #to insert data song
        $router->post('/songs', 'SongController@create');

        #UserController
        #to get all data users
        $router->get('/users', 'UserController@getAll');
        #to get data user By Id
        $router->get('/users/{id}', 'UserController@getById');
        #to insert data user
        $router->post('/users', 'UserController@create');
        #to get data playlist By Id user
        $router->get('/users/{id}/playlists', 'UserController@getplaylistById');

        #PlaylistController
        #to get song from playlist By Id user
        $router->get('/users/{id}/playlists/{playlist_id}/songs', 'PlaylistController@getplaylistsongById');

    });

});
