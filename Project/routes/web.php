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

$app->get('', ['as' => 'dashboard', 'uses' => 'ViewController@dashboard']);

$app->get('blade', 'ViewController@blade');
$app->get('login', 'ViewController@login');

$app->get('api', function() {
    return response()->json(['COW' => 'YES I AM REAL MAN YOU WANT TO GO SKATEBOARDS']);
});

$app->get('api/login', 'UserController@authenticate');

$app->group(['middleware' => 'auth'], function() use ($app) {
    // User routes
    $app->get('logout', 'UserController@logout');
    $app->get('api/me', 'UserController@me');
    $app->get('api/logout', 'UserController@logout');
    
    // Note routes
    $app->get('notes', ['as' => 'notes', 'uses' => 'NoteController@index']);
    $app->get('notes/new', 'NoteController@createView');
    $app->get('notes/{id}', 'NoteController@view');
    $app->get('notes/{id}/edit', 'NoteController@updateView');
    $app->get('notes/{id}/delete', 'NoteController@deleteView');
    $app->get('api/notes', 'NoteController@all');
    $app->get('api/notes/create', 'NoteController@create');
    $app->get('api/notes/{id}', 'NoteController@one');
    $app->get('api/notes/{id}/update', 'NoteController@update');
    $app->get('api/notes/{id}/delete', 'NoteController@delete');
});