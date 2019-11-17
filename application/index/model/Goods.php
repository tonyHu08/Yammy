<?php


namespace app\index\model;
use think\Model;

class Goods extends Model
{
    public function deleteGood($goodsid)
    {
        $info = db('goods')->where('goodsid',$goodsid)->update(['available' => 0]);
        return $info;
    }
}