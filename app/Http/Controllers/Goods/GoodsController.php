<?php

namespace App\Http\Controllers\Goods;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\GoodsModel;

class GoodsController extends Controller
{
    public function goods(){
        $goodsInfo = GoodsModel::paginate(6);
        $data = [
            'goods' => $goodsInfo
        ];
        return view("goods/goodslist",$data);
    }
    public function goodsDetail(Request $request){
        $goods_id = $request->input("goods_id");
        $goodsInfo = GoodsModel::where(['goods_id' => $goods_id])->first();
        $data = [
            'goods' => $goodsInfo
        ];
        return view("goods/goodsdetail",$data);
    }
}
