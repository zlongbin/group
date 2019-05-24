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


//注册跳转
Route::get('reg', 'reg\RegController@reg');
//注册
Route::post('regs', 'reg\RegController@regs');

Route::get('login', 'reg\RegController@login');

Route::post('logins', 'reg\RegController@logins');


