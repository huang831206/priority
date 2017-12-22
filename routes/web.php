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

Route::middleware(['auth'])->group(function () {

    Route::get('/home', 'BoardsController@index')->name('home');

    Route::get('/boards', 'BoardsController@index');

    Route::get('/board/{board}', 'BoardsController@show')->name('board');

    Route::get('/priority', 'UserController@priority')->name('priority');

    Route::get('/test', function () {
        return view('board');
    });

    Route::get('/tt', function () {
        return 'tttttttttttttt';
    });

});

Route::prefix('a')->group(function () {
    Route::get('/user', function () {

    });

    Route::get('/priority', 'UserController@getPriorityJSON');
    Route::post('/priority/update', 'UserController@updatePriorityJSON');

    // Route::get('/list', '');
    // Route::post('/list/update', '');
    //
    // Route::prefix('cards/{card_hash}')->group(function () {
    //     Route::get('/', '');
    //     Route::post('/update', '');
    //     Route::post('/member/add', '');
    //     Route::post('/member/delete', '');
    // });
    //
    // Route::prefix('tags/{tag_hash}')->group(function () {
    //     Route::get('/', '');
    //     Route::post('/create', '');
    //     Route::post('/update', '');
    // });
});
