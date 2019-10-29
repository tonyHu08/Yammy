<?php

namespace app\index\model;

use think\Model;

class Deal extends Model
{
    //插入交易信息
    public function insertGoodsDeal($goodsid, $goodsname, $shopname, $shopid, $sellername, $username, $goodsclassifyid, $dealprice, $count, $goodsimg, $classify)
    {
        $info = db('deal')->insert(['goodsid' => $goodsid, 'goodsname' => $goodsname, 'shopname' => $shopname, 'shopid' => $shopid, 'sellername' => $sellername, 'username' => $username, 'dealprice' => $dealprice, 'count' => $count, 'goodsclassifyid' => $goodsclassifyid, 'dealtime' => time(), 'goodsimg' => $goodsimg, 'goodsclassify' => $classify, 'dealstate' => '已下单','deletestate' => 0]);
        return $info;
    }

    //按订单号查询订单信息
    public function selectDealInfoByDealId($dealid)
    {
        $info = db('deal')->where('dealid', $dealid)->find();
        return $info;
    }

    //查询当前用户交易信息
    public function selectDealInfoByUsername($username)
    {
        $info = db('deal')->where('username', $username)->where('deletestate','<>','1')->order('dealid desc')->paginate(15);
        return $info;
    }

    //查找当前卖家的出售交易信息
    public function selectSellerDealInfo($sellername)
    {
        $info = db('deal')->where('sellername', $sellername)->order('dealid desc')->select();
        return $info;
    }

    //查找当前卖家的要发货信息
    public function selectSellerDeliver($sellername)
    {
        $info = db('deal')->where('sellername', $sellername)->where('dealstate','已下单')->order('dealid desc')->select();
        return $info;
    }

    //查找当前卖家的退款管理
    public function selectSellerReturn($sellername)
    {
        $info = db('deal')->where('sellername', $sellername)->where('dealstate','申请退货')->order('dealid desc')->select();
        return $info;
    }


    //卖家发货
    public function deliverGoods($dealid)
    {
        $info = db('deal')->where('dealid', $dealid)->update(['dealstate' => '已发货']);
        return $info;
    }

    //卖家取消交易
    public function cancelGoods($dealid)
    {
        $info = db('deal')->where('dealid', $dealid)->update(['dealstate' => '交易已取消']);
        return $info;
    }

    //买家删除交易
    public function deleteDeal($dealid)
    {
        $info = db('deal')->where('dealid', $dealid)->update(['deletestate' => 1]);
        return $info;
    }

    //买家申请退货
    public function goodsReturn($dealid,$reason)
    {
        $info = db('deal')->where('dealid', $dealid)->update(['dealstate' => '申请退货','returnreason' => $reason]);
        return $info;
    }

    //买家申请退货
    public function goodsReturnDispose($dealid)
    {
        $info = db('deal')->where('dealid', $dealid)->update(['dealstate' => '已退款']);
        return $info;
    }

    //买家确认收货
    public function goodsTakeOver($dealid)
    {
        $info = db('deal')->where('dealid', $dealid)->update(['dealstate' => '已收货']);
        return $info;
    }

}