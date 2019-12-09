<?php


namespace app\index\controller;

use think\Controller;

class Inform extends Controller
{
    //通过userlist表中的inform字段确定未读信息数量
    public function checkInformNum()
    {
        $yd = model('YammyData');
        $informNum = $yd->findUserInfoByUid(session('uid'))['inform'];
        return $informNum;
    }


    //确认未读消息数
    public function refreshInformNum()
    {
        $inform = model('Inform');
        $unreadNum = $inform->sumUnreadNum();
        return $unreadNum;
    }

    //查找全部通知内容
    public function checkAllInform()
    {
        $data[0] = $this->checkUnreadChatInformNum();
        $data[1] = $this->checkEvaluateInformNum();
        $data[2] = $this->checkDealInformNum();
        return $data;
    }

    //查找聊天未读通知数量
    public function checkUnreadChatInformNum()
    {
        $chat = model('Chat');
        $unreadChatNum = $chat->selectMessageUnreadNum(session('uid'));
        if ($unreadChatNum) {
            return $unreadChatNum;
        } else {
            return 0;
        }
    }

    public function checkUnreadChatInformByGroup()
    {
        $chat = model('Chat');
        $unreadChat = $chat->selectMessageUnreadByGroup(session('uid'));
        return $unreadChat;
    }

    public function checkAllChatInformByGroup()
    {
        $chat = model('Chat');
        $unreadChat = $chat->selectAllMessageByGroup(session('uid'));
        return $unreadChat;
    }

    //查找评论未读通知数量
    public function checkEvaluateInformNum()
    {
        $evaluate = model('Evaluate');
        $unreadEvaluation = $evaluate->selectEvaluationUnreadNum(session('uid'));
        if ($unreadEvaluation) {
            return $unreadEvaluation;
        } else {
            return 0;
        }
    }

    //查找交易信息通知数量
    public function checkDealInformNum()
    {
        $deal_m = model('Deal');
        $unreadDealInfoNum = $deal_m->selectDealUnreadNum();
        if ($unreadDealInfoNum) {
            return $unreadDealInfoNum;
        } else {
            return 0;
        }
    }

    //查找所有交易通知
    public function checkAllDealInfrom()
    {
        $deal_m = model('Deal');
        $deal_inform = $deal_m->selectDealInfo(session('uid'));
        if (count($deal_inform) != 0) {
            for ($i = 0; $i < count($deal_inform); $i++) {
                if ($deal_inform[$i]['is_read'] == 0) {
                    $deal_m->markReadDealInform($deal_inform[$i]['deal_status_id']);
                }
            }
        }
        return $deal_inform;
    }

}