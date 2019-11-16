<?php


namespace app\index\model;

use think\Model;

class Evaluate extends Model
{
    public function insertEvaluation($dealid, $goodsid, $username, $evaluation, $rate)
    {
        $info = db('evaluation')->insert(['dealid' => $dealid, 'goodsid' => $goodsid, 'username' => $username,'evaluation' => $evaluation, 'rate' => $rate, 'evaluate_time' => time()]);
        return $info;
    }

    //获取一件商品的评论列表
    public function getEvaluationList($goodsid)
    {
        $info = db('evaluation')->alias('e')->join('userlist u', 'e.username=u.username')->where('goodsid', $goodsid)->order('e.evaluate_time desc')->select();
        return $info;
    }

    //获取一条评价的订单信息
    public function getDealOfEvaluation($shopid)
    {
        $info = db('evaluation')->alias('e')->join('deal d','e.dealid=d.dealid')->where('shopid', $shopid)->order('d.dealid desc')->select();
        return $info;
    }
}