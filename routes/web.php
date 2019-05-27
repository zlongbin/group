<?php
use Illuminate\Http\Request;
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


// 订单
Route::get('/order','Order\OrderController@order');
Route::post('/createOrder','Order\OrderController@createOrder');
Route::post('/ordershow','Order\OrderController@Ordershow');

Route::get('/pay/alipay/pay', 'Pay\PayController@pay');//去支付
Route::post('/pay/alipay/notify','Pay\PayController@notify');        //支付宝支付 异步通知回调
Route::get('/pay/alipay/return','Pay\PayController@aliReturn');
Route::get('/','Home\HomeController@index');//首页
Route::get('index','Home\HomeController@index');//首页
Route::post('cartAdd','Cart\CartController@cartAdd');//购物车添加
Route::get('cartList','Cart\CartController@cartList');//购物车列表
Route::get('wishList','With\WithController@wishList');//收藏列表
//商品
Route::get('/goods/goods',"Goods\GoodsController@goods");
Route::get('/goods/goodsDetail',"Goods\GoodsController@goodsDetail");

//注册登录
Route::get('reg', 'reg\RegController@reg');
Route::post('regs', 'reg\RegController@regs');
Route::get('login', 'reg\RegController@login');
Route::post('logins', 'reg\RegController@logins');

//关于我们
Route::get('about', 'About\AboutController@about');

//微信支付
Route::get('/weixin/pay/test/{oid}','Pay\WeixinController@test');     //微信支付
Route::post('/weixin/pay/notice','Pay\WeixinController@notice');     //微信支付通知回调


Route::get('header', 'HeaderController@header');
Route::get('client', 'HeaderController@client');
Route::get('footer', 'HeaderController@footer');
Route::get('wxWeb', 'HeaderController@wxWeb');
Route::get('wxWeb/getu', 'HeaderController@getU');
Route::get('wxWeb/bind', 'HeaderController@bind');

Route::post('wxWeb', 'Weixin\WebController@wxWeb');
Route::get('wxWeb/getu', 'Weixin\WebController@getU');
Route::post('wxWeb/bind', 'Weixin\WebController@bind');

Route::get('getCode','Code\CodeController@getCode');
Route::get('telChat','Code\CodeController@telChat');
Route::post('tel','Code\CodeController@tel');