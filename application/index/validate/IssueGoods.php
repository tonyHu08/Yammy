<?php
/**
 * Created by PhpStorm.
 * User: junweihu
 * Date: 2018/6/5
 * Time: 上午12:11
 */

namespace app\index\validate;

use think\Validate;
class issueGoods extends Validate
{
    protected $rule = [
        'goodsName' => 'require|max:25',
        'file' => 'require',
        'type' => 'require',
        'goodsPrice' => 'require',
        'goodsClassify' => 'require'
    ];

    protected $message = [
        'goodsName.require' => '请输入商品名',
        'file.require' => '商品头像不能为空',
        'type.require' => '商品类型不能为空',
        'goodsPrice.require' => '商品价格不能为空',
        'goodsClassify' => '商品分类不能为空'
    ];
}