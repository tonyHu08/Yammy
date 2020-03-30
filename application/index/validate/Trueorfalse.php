<?php
/**
 * Created by PhpStorm.
 * User: junweihu
 * Date: 2018/11/2
 * Time: 11:16 AM
 */

namespace app\index\validate;

use think\Validate;

class Trueorfalse extends Validate
{
    protected $rule = [
        'topic' => 'require',
        'answer' => 'require'
    ];

    protected $message = [
        'topic.require' => '题目不能为空',
        'answer.require' => '答案不能为空'
    ];
}