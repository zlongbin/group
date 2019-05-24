<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\OrderModel;
use App\Model\CartModel;
use App\Model\GoodsModel;
use Illuminate\Support\Facades\Redis;
class OrderController extends Controller
{
    //
    public function createOrder(){
        $cart_id=$_POST['cart_id'];
        $res=CartModel::where(['id'=>$cart_id])->first()->toArray();
//        var_dump($res);die;
        $goods_id=$res['goods_id'];
        $order_sn='one'.time();
        $data=[
                'order_sn'=>$order_sn,
                'user_id'=>$res['user_id'],
                'add_price'=>$res['add_price'],
                'addtime'=>time(),
        ];
//        var_dump($data);die;
        $arr=OrderModel::insert($data);
        if($arr){
            $cart_where=[
                'id'=>$cart_id
            ];
            $is_cart=[
                'is_del'=>2,
               'update_time'=>time()
            ];
//            var_dump($cart_where);die;
            $cart=CartModel::where($cart_where)->update($is_cart);
//            var_dump($cart);die;
            $goods_store=GoodsModel::where(['goods_id'=>$goods_id])->value('goods_num');//查询商品库存
//            var_dump($goods_store);die;
            GoodsModel::where(['goods_id'=>$res['goods_id']])->update(['goods_num'=>$goods_store-$res['buy_number']]);//下单减库存
            $res_data=[
                'errno'=>0,
                'msg'=>'下单成功'
            ];
//            header("refresh:3;url=/order");
            return json_encode($res_data,JSON_UNESCAPED_UNICODE);
        }else{
            $res_data=[
                'errno'=>5001,
                'msg'=>'下单失败'
            ];
            return json_encode($res_data,JSON_UNESCAPED_UNICODE);
        }

    }
    public function Order()
    {
        $ktoken='user_id';
        $pas=Redis::get($ktoken);

        return view('order.order');
    }
    public function Ordershow()
    {
        $user_id=$_POST['user_id'];
        if(empty($user_id)){
            $data=[
                'errcode'=>4001,
                'msg'=>'请先登录'
            ];
            return $data;
        }
        $order_where=[
            'user_id'=>$user_id,
            'is_delete'=>1,
        ];
        $res=OrderModel::where($order_where)->first()->toArray();
        return json_encode($res);
    }
}
