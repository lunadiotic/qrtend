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

Route::get('/success', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('pages.attend.index');
});

Route::post('/attend', 'AttendController@postScan')->name('attend.post');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
