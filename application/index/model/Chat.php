<?php


namespace app\index\model;

use think\model;

class Chat extends model
{
    //插入聊天消息
    public function insertMessage($msg, $sender_uid, $receiver_uid)
    {
        $info = db('chat')->insert(['sender_uid' => $sender_uid, 'receiver_uid' => $receiver_uid, 'chat_content' => $msg, 'time' => time(), 'is_read' => 0]);
        return $info;
    }

    //读取所有未读消息数量
    public function selectMessageUnreadNum($receiver_uid)
    {
        $info = db('chat')->where('receiver_uid', $receiver_uid)->where('is_read', 0)->count();
        return $info;
    }

    public function selectMessageUnreadByGroup($receiver_uid)
    {
        $info = db('chat')->where('receiver_uid', $receiver_uid)->where('is_read', 0)->field('sender_uid, count(chat_content)')->group('sender_uid')->select();
        return $info;
    }

    public function selectAllMessageByGroup($receiver_uid)
    {
        $info = db('chat')->where('receiver_uid', $receiver_uid)->field('sender_uid, count(chat_content), sum(is_read)')->group('sender_uid')->select();
        return $info;
    }

    //读取和某人未读聊天消息
    public function selectMessageUnreadWithSomeone($sender_uid, $receiver_uid)
    {
        $info = db('chat')->alias('c')->join('userlist u', 'c.sender_uid=u.uid')->where('receiver_uid', $receiver_uid)->where('sender_uid', $sender_uid)->where('is_read', 0)->select();
        return $info;
    }

    //读取和某人最新的未读聊天消息
    public function selectMessageUnreadWithSomeoneNew($sender_uid, $receiver_uid)
    {
        $info = db('chat')->alias('c')->join('userlist u', 'c.sender_uid=u.uid')->where('receiver_uid', $receiver_uid)->where('sender_uid', $sender_uid)->where('time', db('chat')->where('receiver_uid', $receiver_uid)->where('sender_uid', $sender_uid)->max('time'))->find();
        return $info;
    }

    //读取和某人最新的聊天消息
    public function selectMessageWithSomeoneNew($sender_uid, $receiver_uid)
    {
        $info = db('chat')->where('receiver_uid|sender_uid', $receiver_uid)->where('sender_uid|receiver_uid', $sender_uid)->where('time', db('chat')->where('receiver_uid|sender_uid', $receiver_uid)->where('sender_uid|receiver_uid', $sender_uid)->max('time'))->value('chat_content');
        return $info;
    }


    //读取全部聊天消息
    public function selectMessage($sender_uid, $receiver_uid)
    {
        $info = db('chat')->alias('c')->join('userlist u', 'c.sender_uid=u.uid')->where('receiver_uid|sender_uid', $receiver_uid)->where('sender_uid|receiver_uid', $sender_uid)->select();
        return $info;
    }

    //将已读消息标注为已读
    public function markReadMessage($chat_id)
    {
        $chat = db('chat')->where('chat_id', $chat_id)->find();
        //自己发的信息不做已读标记
        if ($chat['sender_uid'] != session('uid')) {
            $info = db('chat')->where('chat_id', $chat_id)->update(['is_read' => 1]);
        } else {
            $info = 0;
        }
        if ($info != 0) {
            $userInfo = db('userlist')->where('uid', $chat['receiver_uid'])->find();
            $informNum = $userInfo['inform'];
            db('userlist')->where('uid', $chat['receiver_uid'])->update(['inform' => $informNum - 1]);
        }
        return $info;
    }

}