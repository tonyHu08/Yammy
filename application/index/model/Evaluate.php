<?php


namespace app\index\model;

use think\Model;

class Evaluate extends Model
{
    //插入评论信息
    public function insertEvaluation($dealid, $goodsid, $username, $seller_uid, $evaluation, $rate)
    {
        $info = db('evaluation')->insert(['dealid' => $dealid, 'goodsid' => $goodsid, 'username' => $username, 'uid' => session('uid'), 'seller_uid' => $seller_uid, 'evaluation' => $evaluation, 'rate' => $rate, 'evaluate_time' => time(), 'is_read' => 0]);
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
        $info = db('evaluation')->alias('e')->join('deal d', 'e.dealid=d.dealid')->where('shopid', $shopid)->order('d.dealid desc')->select();
        return $info;
    }

    //将一条评论标注为已读
    public function markReadEvaluation($evaluation_id)
    {
        $info = db('evaluation')->where('evaluation_id', $evaluation_id)->update(['is_read' => 1]);
        if ($info) {
            $userInfo = db('userlist')->where('uid', session('uid'))->find();
            $informNum = $userInfo['inform'];
            db('userlist')->where('uid', session('uid'))->update(['inform' => $informNum - 1]);
        }
        return $info;
    }

    //查找未读评论数量
    public function selectEvaluationUnreadNum($seller_uid)
    {
        $info = db('evaluation')->where('seller_uid', $seller_uid)->where('is_read', 0)->count();
        return $info;
    }
}