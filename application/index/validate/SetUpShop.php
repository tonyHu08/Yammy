<?php
/**
 * Created by PhpStorm.
 * User: junweihu
 * Date: 2018/6/4
 * Time: 上午11:14
 */

namespace app\index\validate;

use think\Validate;
class SetUpShop extends Validate
{
    protected $rule = [
        'shopname' => 'require|max:25',
        'type' => 'require',
        'file' => 'require'
    ];

    protected $message = [
        'shopname.require' => '请输入店铺名',
        'type.require' => '店铺类型不能为空',
        'file.require' => '店铺头像不能为空'
    ];
}