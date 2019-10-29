<?php


namespace app\index\model;

use think\Model;

class Evaluate extends Model
{
    public function insertEvaluation($dealid, $goodsid, $username, $evaluation, $rate)
    {
        $info = db('evaluation')->insert(['dealid' => $dealid, 'goodsid' => $goodsid, 'username' => $username, 'evaluation' => $evaluation, 'rate' => $rate, 'evaluate_time' => time()]);
        return $info;
    }

    //获取一件商品的评论列表
    public function getEvaluationList($goodsid)
    {
//        $info = db('evaluation')->where('goodsid', $goodsid)->select();
//        return $info;
        $info = db('evaluation')->alias('e')->join('userlist u', 'e.username=u.username')->where('goodsid', $goodsid)->select();
        return $info;
    }
}