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
//    dd(array_merge(\Illuminate\Sup,['d','c']));
    dd(request()->all());
    return view('welcome');
});
Route::post('login','UserController@login');

Route::get('login','UserController@login');
Route::get('logout','UserController@logout');