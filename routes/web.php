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


Route::get('/order','Order\OrderController@order');
Route::post('/createOrder','Order\OrderController@createOrder');
Route::post('/ordershow','Order\OrderController@Ordershow');

Route::get('/pay/alipay/pay', 'Pay\PayController@pay');//去支付
Route::post('/pay/alipay/notify','Pay\PayController@notify');        //支付宝支付 异步通知回调
Route::get('/pay/alipay/return','Pay\PayController@aliReturn');