<?php

namespace app\index\model;

use think\Model;

class Deal extends Model
{
    //插入交易信息
    public function insertGoodsDeal($goodsid, $goodsname, $shopname, $shopid, $sellername, $seller_uid, $username, $goodsclassifyid, $dealprice, $count, $goodsimg, $classify)
    {
        $info = db('deal')->insert(['goodsid' => $goodsid, 'goodsname' => $goodsname, 'shopname' => $shopname,
            'shopid' => $shopid, 'sellername' => $sellername, 'seller_uid' => $seller_uid, 'uid' => session('uid'),
            'username' => $username, 'dealprice' => $dealprice, 'count' => $count, 'goodsclassifyid' => $goodsclassifyid,
            'dealtime' => time(), 'goodsimg' => $goodsimg, 'goodsclassify' => $classify, 'dealstate' => '已下单',
            'deletestate' => 0, 'return_apply_time' => 0, 'return_time' => 0, 'take_time' => 0, 'deliver_time' => 0]);
        if ($info) {
            //返回刚刚插入的值的id
            return db('deal')->getLastInsID();
        }
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
        $info = db('deal')->where('username', $username)->where('deletestate', '<>', '1')->order('dealid desc')->paginate(15);
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
        $info = db('deal')->where('sellername', $sellername)->where('dealstate', '已下单')->order('dealid desc')->select();
        return $info;
    }

    //查找当前卖家的退款管理
    public function selectSellerReturn($sellername)
    {
        $info = db('deal')->where('sellername', $sellername)->where('dealstate', '申请退货')->order('dealid desc')->select();
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
    public function goodsReturn($dealid, $reason)
    {
        $info = db('deal')->where('dealid', $dealid)->update(['dealstate' => '申请退货', 'returnreason' => $reason]);
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

    //增加一笔订单状态信息
    public function insertDealStatusInfo($dealid, $sender_uid, $receiver_uid, $status)
    {
        $info = db('dealStatus')->insert(['dealid' => $dealid, 'sender_uid' => $sender_uid, 'receiver_uid' => $receiver_uid, 'deal_status' => $status, 'time' => time(), 'is_read' => 0]);
        return $info;
    }

    //查找未读交易信息数量
    public function selectDealUnreadNum()
    {
        $info = db('dealStatus')->where('receiver_uid', session('uid'))->where('is_read', 0)->count();
        return $info;
    }

    //读取全部交易消息
    public function selectDealInfo($receiver_uid)
    {
        $info = db('dealStatus')->alias('ds')->join('deal d', 'ds.dealid=d.dealid')->where('receiver_uid', $receiver_uid)->order('ds.time desc')->select();
        return $info;
    }

    //读取全部未读交易消息
    public function selectUnreadDealInfo($receiver_uid)
    {
        $info = db('dealStatus')->alias('ds')->join('deal d', 'ds.sender_uid=d.uid')->where('receiver_uid', $receiver_uid)->select();
        return $info;
    }

    //根据deal_status_id查找对应信息
    public function findInfoByDealStatusId($deal_status_id)
    {
        $info = db('dealStatus')->where('deal_status_id', $deal_status_id)->find();
        return $info;
    }

    //将已读消息标注为已读
    public function markReadDealInform($deal_status_id)
    {
        $info = db('dealStatus')->where('deal_status_id', $deal_status_id)->update(['is_read' => 1]);
        if ($info != 0) {
            $uid = $this->findInfoByDealStatusId($deal_status_id)['receiver_uid'];
            $userInfo = db('userlist')->where('uid', $uid)->find();
            $informNum = $userInfo['inform'];
            db('userlist')->where('uid', $uid)->update(['inform' => $informNum - 1]);
        }
        return $info;
    }
}