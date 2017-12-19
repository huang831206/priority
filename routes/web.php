<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/boards', function () {
    return view('board');
});

Route::get('/board/{board_id}', function () {
    return view('board');
});

Route::get('/priority', 'UserController@priority');

Route::get('/test', function () {
    return view('board');
});

Route::get('/tt', function () {
    return 'tttttttttttttt';
});

Route::prefix('a')->group(function () {
    Route::get('/user', function () {

    });

    Route::get('/priority', 'UserController@getPriorityJSON');
    Route::post('/priority/update', 'UserController@updatePriorityJSON');

    Route::get('/tt', function () {
        return 'tttttttttttttt';
    });
});
