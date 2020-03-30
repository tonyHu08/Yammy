<?php
/**
 * Created by PhpStorm.
 * User: junweihu
 * Date: 2018/11/1
 * Time: 11:04 PM
 */

namespace app\index\validate;

use think\Validate;

class SingleChoice extends Validate
{
    protected $rule = [
        'topic' => 'require',
        'A' => 'require',
        'B' => 'require',
        'C' => 'require',
        'D' => 'require',
        'answer' => 'require'
    ];

    protected $message = [
        'topic.require' => '题目不能为空',
        'A.require' => '选项不能为空',
        'B.require' => '选项不能为空',
        'C.require' => '选项不能为空',
        'D.require' => '选项不能为空',
        'answer.require' => '答案不能为空'
    ];
}