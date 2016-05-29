<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
// home
//Route::get('home', [
//    'uses' => 'AccountController@home'
//]);
Route::group(['middleware' => ['web']], function () {
    Route::get('/', 'AccountController@index')->name('home');
    // login
    Route::get('login', function() {
       return View::make('login'); 
    });
    //logout
    Route::get('logout', 'AccountController@doLogout')->name('logout');

    Route::post('login','AccountController@doLogin')->name('login');

    Route::get('home', function() {
       return View::make('home');
    });
});

//Route::post('/','AccountController@index');