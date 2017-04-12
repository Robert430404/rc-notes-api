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

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->group(['prefix' => 'api/v1'], function () use ($app) {
    $app->get(   'notes', 'NoteController@get');
    $app->put(   'notes', 'NoteController@put');
    $app->post(  'notes', 'NoteController@post');
    $app->patch( 'notes', 'NoteController@patch');
    $app->delete('notes', 'NoteController@delete');

    $app->get(   'types', 'TypeController@get');
    $app->put(   'types', 'TypeController@put');
    $app->post(  'types', 'TypeController@post');
    $app->patch( 'types', 'TypeController@patch');
    $app->delete('types', 'TypeController@delete');
});