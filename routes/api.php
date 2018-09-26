<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Arquivo de rotas padrão da documentação do JWT-Auth não funcionou muito bem na aplicação
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    //Route::post('me', 'AuthController@me');
    Route::get('me', 'AuthController@me');
});
*/

Route::group(['middleware' => 'cors'], function () {

//Route::get('client', 'ClientController@index');

Route::post('logout', 'AuthController@logout');
Route::post('auth/login', 'AuthController@login');
Route::group(['middleware' => 'jwt'], function () {
    // Protected routes
    Route::resource('client', 'ClientController', ['except' =>['create', 'edit']]);
    Route::resource('project', 'ProjectsController', ['except' => ['create', 'edit']]);
    Route::resource('user', 'UserController', ['except' => ['create', 'edit']]);
    //Route::get('user', 'UserController@index');

    Route::group(['prefix'=>'project'], function(){

        Route::get('{id}/note', 'ProjectNotesController@index');
        Route::post('{id}/note', 'ProjectNotesController@store');
        Route::get('{id}/note/{noteId}', 'ProjectNotesController@show');
        Route::put('{id}/note/{noteId}', 'ProjectNotesController@update');
        Route::delete('note/{id}', 'ProjectNotesController@destroy');

       // Route::post('{id}/file', 'ProjectFileController@store');

    });

});
});