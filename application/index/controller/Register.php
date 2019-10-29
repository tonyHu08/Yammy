<?php


namespace app\index\controller;

use think\Controller;

class Register extends Controller
{
    public function register()           //显示注册页面
    {
        return $this->fetch();
    }

    public function registerVerify()         //注册验证
    {
        $ul = validate('UserList');         //实例化UserList对象
        $data = [
            'username' => input('username'),
            'phonenum' => input('phonenum'),
            'email' => input('email'),
            'password' => input('password'),
            'repassword' => input('repassword'),
            'captcha' => input('captcha')
        ];
        $password = input('password');
        $repassword = input('repassword');
        if (!$ul->check($data)) {
            $this->error($ul->getError());
        }
        if (!session('captcha')) {
            $captcha = new \think\captcha\Captcha();
            $result = $captcha->check($data['captcha']);
            if (!$result) {
                $this->error('验证码错误');
            }
        } else {
            if (session('captcha') != $data['captcha']) {
                session('captcha', null);
                $this->error('验证码错误');
            }
        }
        $userlist = model('YammyData');          //创建Yammydata对象userlist
        if ($userlist->findUsername($data['username'])) {
            $this->error('用户名已被注册，请重新输入用户名');
        }
        if ($userlist->findemail($data['email'])) {
            $this->error('邮箱已被注册，请重新输入邮箱地址');
        }
        if ($userlist->findUsername($data['username'])) {
            $this->error('手机号码已被注册，请重新输入手机号码');
        }
        $headimg = request()->file('file');
        $headimgPath = '';
        if ($headimg) {
            $info = $headimg->validate(['size' => 3000000, 'ext' => 'jpg,png,gif'])->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'static/headimg', '');
            if ($info) {
                $headimgPath = '/static/headimg/' . $info->getFilename();
                //裁剪头像
                $image = \think\Image::open('./static/headimg/' . $info->getSaveName());
                $image->thumb(150, 150, \think\Image::THUMB_CENTER)->save('./static/headimg/' . $info->getSaveName());
            } else {
                // 上传失败获取错误信息
                return $this->error($headimg->getError());
            }
        }
        if ($password != $repassword) {
            $this->error('两次密码不一致，请重新输入');
        }
        $info = $userlist->reg($data['username'], $data['password'], $data['phonenum'], $data['email'], $headimgPath);    //用userlist中reg方法将数据插入数据库
        if ($info) {
            session('username', null);        //在Mall中再存username，以此判断注册操作还是二次发送操作
            session('headimg', $headimgPath);        //将登陆的用户名及头像信息存入session
            $this->redirect('Mail/index', ['email' => $data['email'], 'username' => $data['username']]);
        } else {
            $this->error('注册失败');
        }
    }

    public function regNameVerify()       //页面动态验证注册用户名是否可用
    {
        $username = input('name');
        $userlist = model('YammyData');
        if($userlist->findUsername($username)) {
            return 0;
        } else {
            return 1;
        }
    }
}