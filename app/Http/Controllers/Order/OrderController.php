<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\OrderModel;
use App\Model\CartModel;
use App\Model\GoodsModel;
class OrderController extends Controller
{
    //
    public function createOrder(){
        $cart_id=$_POST['cart_id'];
        $res=CartModel::where(['cart_id'=>$cart_id])->first()->toArray();
        $order_sn='one'.time();
        $data=[
                'order_sn'=>$order_sn,
                'user_id'=>$res['user_id'],
                'add_price'=>$res['add_price'],
                'add_time'=>time(),
        ];
        $arr=OrderModel::insert($data);
        if($arr){
            $cart_where=[
                'cart_id'=>$cart_id
            ];
            CartModel::where($cart_where)->update(['is_del'=>2]);
            $goods_store=GoodsModel::where(['goods_id'=>$res['goods_id']])->value('goods_num');//查询商品库存
            GoodsModel::where(['goods_id'=>$res['goods_id']])->update(['goods_num'=>$goods_store-$res['buy_number']]);//下单减库存
            $res_data=[
                'errno'=>0,
                'msg'=>'下单成功'
            ];
            header("Refresh:3;url=/order");
        }else{
            $res_data=[
                'errno'=>5001,
                'msg'=>'下单失败'
            ];
        }
        return json_encode($res_data);
    }
    public function Order()
    {
        $add=$_POST['user_id'];
        $com_info=CompanyModel::where(['uid'=>$add])->first();
//                $data=[
//                    'com_info'=>$com_info
//                ];
        return view('order.order',['com_info'=>$com_info]);
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
            'id'=>$user_id,
            'is_delete'=>1,
        ];
//        $order_data=OrderModel::join('api_goods','api_goods.goods_id','=','api_order.goods_id')->where($order_where)->get();
        $res=CartModel::where($order_where)->first()->toArray();
        return json_encode($res);
    }
}
