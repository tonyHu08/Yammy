<?php
/**
 * Created by PhpStorm.
 * User: junweihu
 * Date: 2018/6/5
 * Time: 上午11:08
 */

namespace app\index\controller;

use think\Controller;
class Captcha extends Controller
{
    public function captcha()               //验证码初始化
    {
        $captcha = new \think\captcha\Captcha();
        $captcha->imageW = 110;
        $captcha->imageH = 32;  //图片高
        $captcha->fontSize = 14;  //字体大小
        $captcha->length = 4;  //字符数
        $captcha->fontttf = '5.ttf';  //字体
        $captcha->expire = 30;  //有效期
        $captcha->useNoise = false;  //不添加杂点
        return $captcha->entry();
    }

    public function captchaState()          //验证验证码
    {
        $captcha = new \think\captcha\Captcha();
        $result = $captcha->check(input('captcha'));
        if(!$result) {
            return 0;
        } else {
            session('captcha', input('captcha'));
            return 1;
        }
    }
}