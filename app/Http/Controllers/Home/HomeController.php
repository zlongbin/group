<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**首页*/
    public function index(){
        $goods_new = DB::table('goods')->orderBy('create_time','desc')->limit(4)->get(['goods_id','goods_name','goods_img','goods_selfprice']);

        $goods_up = DB::table('goods')->where('goods_hot',1)->orderBy('create_time','desc')->limit(6)->get(['goods_id','goods_name','goods_img','goods_selfprice']);
        //var_dump($goods_up);exit;
        $data = [
            'goods_new'=>$goods_new,
            'goods_up'=>$goods_up
        ];
        return view('home.index',$data);
    }
}
