<?php
/**
 * Created by PhpStorm.
 * User: junweihu
 * Date: 2018-11-29
 * Time: 10:48
 */

namespace app\index\validate;

use think\Validate;
class ShortAnswer extends Validate
{
    protected $rule = [
        'topic' => 'require',
        'difficulty' => 'require'
    ];

    protected $message = [
        'topic.require' => '题目不能为空',
        'difficulty' => '难度不能为空'
    ];
}