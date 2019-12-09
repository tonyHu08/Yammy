<?php


namespace app\index\model;

use think\Model;

class Inform extends Model
{
    public function suntractUnreadNum($uid)
    {
        $userInfo = db('userlist')->where('uid', $uid)->find();
        $informNum = $userInfo['inform'];
        db('userlist')->where('uid', $uid)->update(['inform' => $informNum - 1]);
    }

    public function sumUnreadNum()
    {
        $chat_unread_sum = db('chat')->where('is_read', 0)->where('receiver_uid', session('uid'))->count();
        $evaluation_unread_sum = db('evaluation')->where('is_read', 0)->where('seller_uid', session('uid'))->count();
        $deal_info_unread_sum = db('dealStatus')->where('is_read', 0)->where('receiver_uid', session('uid'))->count();
        $sum_unread_num = $chat_unread_sum + $evaluation_unread_sum +$deal_info_unread_sum;
        db('userlist')->where('uid', session('uid'))->update(['inform' => $sum_unread_num]);
        return $sum_unread_num;
    }
}