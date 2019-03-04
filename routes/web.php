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

Route::get('books', 'BookController@index');
Route::get('books/{uuid}', 'BookController@show');
Route::post('books/{uuid}', 'BookController@store');
Route::put('books/{uuid}', 'BookController@update');
Route::delete('books/{uuid}', 'BookController@destroy');