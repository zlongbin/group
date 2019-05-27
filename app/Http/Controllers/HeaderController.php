<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\OrderModel;
use App\Model\CartModel;
use App\Model\GoodsModel;
use Illuminate\Support\Facades\Redis;
class HeaderController extends Controller{
    public function header(){
        return view('layout.header');
    }
    public function client(){
        return view('layout.client');
    }
}
