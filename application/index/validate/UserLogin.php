<?php
/**
 * Created by PhpStorm.
 * User: junweihu
 * Date: 2018/5/24
 * Time: 下午9:52
 */

namespace app\index\validate;

use think\Validate;

class UserLogin extends Validate
{
    protected $rule = [
        'username' => 'require|max:25',
        'password' => 'require',
    ];

    protected $message = [
        'username.require' => '请输入用户名',
        'password.require' => '请输入密码',
    ];
}