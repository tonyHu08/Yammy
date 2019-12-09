<?php


namespace app\index\controller;

use think\Controller;

class Chat extends Controller
{
    //现实聊天信息界面（已弃用，该用js实现初始化）
    public function chat()
    {
        $shop_id = input('shop_id');
        $yd = model('YammyData');
        $shop_info = $yd->selectShopForId($shop_id);
        $opposite_uid = $shop_info['uid'];
        $this->assign("shop_id", $shop_id);
        $this->assign('opposite_uid', $opposite_uid);
        return $this->fetch();
    }

    //发送聊天消息
    public function sendMessage()
    {
        $msg = input('msg');
        $receiver = input('receiver');
        $sender = session('uid');
        $chat = model('Chat');
        //将发送消息插入数据库
        if ($chat->insertMessage($msg, $sender, $receiver)) {
            //更新userlist表中的未读数字
            $yd = model('YammyData');
            $yd->updateInformNum($receiver);
            return 1;
        }
    }

    //实时刷新最新未读消息
    public function receiveMessageActualTime()
    {
        $sender_uid = input("opposite_uid");
        $receiver_uid = session('uid');
        $chat = model('Chat');
        $chat_list = $chat->selectMessageUnreadWithSomeone($sender_uid, $receiver_uid);
        if (count($chat_list) != 0) {
            for ($i = 0; $i < count($chat_list); $i++) {
                $chat->markReadMessage($chat_list[$i]['chat_id']);
            }
        }
        return $chat_list;
    }

    //未读通知中获取未读的消息列表
    public function getUnreadItem()
    {
        $sender_uid = input("opposite_uid");
        $receiver_uid = session('uid');
        $chat = model('Chat');
        $msg_info = $chat->selectMessageUnreadWithSomeoneNew($sender_uid, $receiver_uid);
        $msg_info['newest_msg'] = $chat->selectMessageWithSomeoneNew($sender_uid, $receiver_uid);
        return $msg_info;
    }

    //打开聊天界面初始化消息（js）
    public function receiveMessageInitialize()
    {
        $opposite_uid = input("opposite_uid");
        $self_uid = session('uid');
        $chat = model('Chat');
        $chat_list = $chat->selectMessage($opposite_uid, $self_uid);
        if (count($chat_list) != 0) {
            for ($i = 0; $i < count($chat_list); $i++) {
                if ($chat_list[$i]['is_read'] == 0) {
                    $chat->markReadMessage($chat_list[$i]['chat_id']);
                }
            }
        }
        return $chat_list;
    }

    public function chatModal($shop_id)
    {
        $yd = model('YammyData');
        $shop_info = $yd->selectShopForId($shop_id);
        $opposite_uid = $shop_info['uid'];
        $this->assign("shop_id", $shop_id);
        $this->assign('opposite_uid', $opposite_uid);
        return $opposite_uid;
    }

    public function findOppositeInfo()
    {
        $opposite_uid = input('opposite_uid');
        $yd = model('YammyData');
        $opposite_info = $yd->findUserInfoByUid($opposite_uid);
        return $opposite_info;
    }

//    public function findGoodsInfo()
//    {
//        $goods_id = input('goods_id');
//        $yd = model('YammyData');
//        $goods_info = $yd->selectGoodsId($goods_id);
//        $shop_info = $yd->selectShopForId($goods_info['shopid']);
//        $opposite_info = [$shop_info['uid'], $shop_info['username']];
//        return $opposite_info;
//    }
}