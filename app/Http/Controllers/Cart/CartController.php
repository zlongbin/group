<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Weixin\JssdkController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Model\GoodsModel;

class CartController extends Controller
{
    /*购物车
        加入购物车
    */
    public function cartAdd(Request $request){
        $goods_id = $request->input('goods_id');
        //$user_id = $request->input('user_id');
        $user_id = 1;
        $goodsData = DB::table('goods')->where('goods_id',$goods_id)->get(['goods_selfprice'])->toArray();
        $goods_selfprice = $goodsData[0]->goods_selfprice;
        //var_dump($goods_selfprice);exit;

        $cartInfo = DB::table('cart')->where(['goods_id'=>$goods_id])->first();
        //var_dump($cartInfo);exit;
        if(empty($cartInfo)){
            $data = [
                'goods_id'=>$goods_id,
                'user_id'=>$user_id,
                'buy_number'=>1,
                'add_price'=>$goods_selfprice,
                'is_del'=>1,
                'create_time'=>time()
            ];
            $res = DB::table('cart')->insert($data);
            if($res){
                $response = [
                    'error'=>0,
                    'msg'=>'加入购物车成功'
                ];
                die(json_encode($response,JSON_UNESCAPED_UNICODE));
            }
        }else{
            $cartInfo = DB::table('cart')->where(['goods_id'=>$goods_id])->get()->toArray();
            $buy_number = $cartInfo[0]->buy_number;
            //dump($buy_number);exit;
            $update = [
                'buy_number'=>$buy_number+1,
                'add_price'=>$goods_selfprice*($buy_number+1),
                'update_time'=>time()
            ];
            $updateInfo = DB::table('cart')->where('goods_id',$goods_id)->update($update);
            if($updateInfo){
                $response = [
                    'error'=>0,
                    'msg'=>'加入购物车成功'
                ];
                die(json_encode($response,JSON_UNESCAPED_UNICODE));
            }
        }
    }

    public function cartList(){
        $user_id = 1;
        //var_dump($goods_id);exit;
        $where=[
            'user_id'=>$user_id,
            'is_del'=>1
        ];
        $cartInfo=DB::table('cart')->join('goods','cart.goods_id','=','goods.goods_id')->where($where)->get();
        //var_dump($cartInfo);exit;
        $data = [
            'cartInfo'=>$cartInfo
        ];
        return view('cart.cartList',$data);
    }
}
