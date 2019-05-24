<?php

namespace App\Http\Controllers\With;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class WithController extends Controller
{
    /**收藏*/
    public function wishList(Request $request){
        $user_id=$request->session()->get('user_id');
        //var_dump($user_id);exit;
        if(empty($user_id)){
            $response = [
                'error'=>40019,
                'msg'=>'您还没有登陆'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }

        $goods = DB::table('goods')->where('goods_best',1)->orderBy('create_time','asc')->limit(4)->get(['goods_id','goods_name','goods_img','goods_selfprice','goods_num']);
        $data = [
            'wishInfo'=>$goods
        ];
        return view('wish.wishlist',$data);
    }
}
