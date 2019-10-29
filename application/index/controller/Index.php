<?php

namespace app\index\controller;

use think\Controller;

class Index extends Controller
{
    public function index()
    {
        return $this->redirect('index/indexShow');
    }

    public function sendMail()         //发送邮件
    {
        return $this->redirect('Mail/index', ['email' => input('email'), 'username' => session('username')]);
    }

    public function indexShow()         //显示主页
    {
        $gb = model('YammyData');
        $msginfo = $gb->msglist();
        $page = $msginfo->render();
        $allmsginfo = $gb->allMsgList();
        if(Seller::shopVali()) {
            $this->assign('shopvali', 1);
        } else {
            $this->assign('shopvali', 0);
        }
        $this->assign('allmessage', $allmsginfo);
        $this->assign('message', $msginfo);        //assign方法将参数赋值给模版
        $this->assign('page', $page);
        return $this->fetch('index');
    }


    public function emailVali()         //邮件中的激活链接
    {
        $username = input('username');
        $yd = model('YammyData');
        if($yd->updateActive($username)) {
            return "激活成功！";
        }
    }

}
