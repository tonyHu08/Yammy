<?php


namespace app\index\controller;

use think\Controller;


class Login extends Controller
{
        public function login()         //显示登陆页面
    {
        return $this->fetch();
    }

    public function loginVerify()        //登陆验证
    {
        $data = [
            'username' => input('username'),
            'password' => input('password')
        ];
        $ul = validate('UserLogin');
        if (!$ul->check($data)) {
            return $this->error($ul->getError());
        }
        $userlist = model('YammyData');
        $info = $userlist->login($data['username'], $data['password']);
        if ($info) {
            session('username', $info['username']);
            session('uid', $info['uid']);
            session('headimg', $info['headimg']);        //将登陆的用户名及头像信息存入session
            session('identity', $info['identity']);
            session('num', $info['num']);
            return $this->redirect($_SERVER['HTTP_REFERER']);
        } else {
            return $this->error('帐号或密码错误，请重新输入！');
        }
    }


    public function exitLogin()         //退出登录
    {
        session('username', null);
        session('uid', null);
        session('headimg', null);
        return $this->redirect('Index/index');
    }
}