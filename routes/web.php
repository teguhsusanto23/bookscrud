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
Route::get('book-list', 'BookController@index')->name('book-list');
Route::get('book-list/{id}/edit', 'BookController@edit');
Route::post('book-list/store', 'BookController@store')->name('book-list/store');
Route::get('book-list/delete/{id}', 'BookController@destroy');
