<?php


namespace app\index\controller;

use think\Controller;

class Tool extends Controller
{
    public function loginStatusVerify()
    {
        if(session('username') == null) {            //如果还未登录
            return $this->fetch('Login/login');
        }
    }
}