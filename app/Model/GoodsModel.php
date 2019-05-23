<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GoodsModel extends Model
{
    protected $table="goods";
    public $timestmps=false;
    protected $primaryKey = 'goods_id';
}
