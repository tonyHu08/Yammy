<?php
/**
 * Created by PhpStorm.
 * User: junweihu
 * Date: 2018/5/24
 * Time: 下午9:52
 */

namespace app\index\validate;

use think\Validate;

class UserList extends Validate
{
    protected $rule = [
        'username' => 'require|max:25',
        'password' => 'require',
        'repassword' => 'require',
        'captcha' => 'require',
        'email' => 'require',
        'phonenum' => 'require',
    ];

    protected $message = [
        'username.require' => '请输入用户名',
        'password.require' => '请输入的密码',
        'repassword.require' => '输入确认密码',
        'captcha.require' => '请输入验证码',
        'email.require' => '邮箱地址不能为空',
        'phone.require' => '手机号码不能为空'
    ];
}