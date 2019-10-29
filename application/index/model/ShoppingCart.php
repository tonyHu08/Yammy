<?php
/**
 * Created by PhpStorm.
 * User: junweihu
 * Date: 2018/6/9
 * Time: 下午2:40
 */

namespace app\index\model;

use think\Model;

class ShoppingCart extends Model


{
    //查找此商品在不在购物车中
    public function sameGoods($username, $goodsid, $goodsclassifyid)
    {
        $info = db('shoppingcart')->where('username', $username)->where('goodsid', $goodsid)->where('goodsclassifyid', $goodsclassifyid)->find();
        return $info;
    }

    //更新购物车商品数量（增加）
    public function updateCount($username, $goodsid, $count,$goodsclassifyid)
    {
        $oldcount = db('shoppingcart')->where('username', $username)->where('goodsid', $goodsid)->value('count');
        $info = db('shoppingcart')->where('username', $username)->where('goodsid', $goodsid)->where('goodsclassifyid', $goodsclassifyid)->update(['count' => $count + $oldcount,'changetime' => time()]);
        return $info;
    }

    //更新购物车商品数量（改变）
    public function updateChangeCount($username, $shoppingcartid, $count)
    {
        $info = db('shoppingcart')->where('username', $username)->where('shoppingcartid', $shoppingcartid)->update(['count' => $count,'changetime' => time()]);
        return $info;
    }

    //通过分类id查询分类信息
    public function selectGoodsClassify($goodsclassifyid)
    {
        $info = db('goodsclassify')->where('goodsclassifyid', $goodsclassifyid)->find();
        return $info;
    }

    //将商品存入购物车
    public function insertShoppingCart($username, $shopid, $goodsid, $count, $goodsClassifyId)
    {
        $info = db('shoppingcart')->insert(['username' => $username, 'shopid' => $shopid, 'goodsid' => $goodsid, 'count' => $count, 'goodsclassifyid' => $goodsClassifyId,'changetime' => time()]);
        return $info;
    }

    //查找购物车信息
    public function shoppingCart($username)
    {
        $info = db('shoppingcart')->where('username', $username)->order('changetime desc')->select();
        return $info;
    }

    //查找此ID的商品信息
    public function selectGoodsId($goodsid)
    {
        $info = db('goods')->where('goodsid', $goodsid)->find();
        return $info;
    }

    //删除购物车中的商品
    public function deleteShoppingCart($shoppingCartId)
    {
        $info = db('shoppingcart')->where('shoppingcartid', $shoppingCartId)->delete();
        return $info;
    }

    //通过购物车ID查找信息
    public function selectShoppingCartId($shoppingcartid)
    {
        $info = db('shoppingcart')->where('shoppingcartid', $shoppingcartid)->find();
        return $info;
    }

}