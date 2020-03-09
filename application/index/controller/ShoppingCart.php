<?php


namespace app\index\controller;

use think\Controller;


class ShoppingCart extends Controller
{
    public function shoppingCart()              //显示购物车
    {
        if (!session('username')) {
            return $this->fetch('login/login');
        }
        $sc = model('ShoppingCart');
        $scgoods = $sc->shoppingCart(session('username'));          //获取当前用户的购物车信息
        $goodsinfo = [];
        for ($i = 0; $i < count($scgoods); $i++) {
            $goodsinfo[$i] = $sc->selectGoodsid(($scgoods[$i])['goodsid']);         //获取当前商品的详细信息
            if (($scgoods[$i])['goodsclassifyid'] == 0) {
                $goodsinfo[$i]['goodsclassify'] = '默认分类';
            } else {
                $goodsClassifyInfo = $sc->selectGoodsClassify(($scgoods[$i])['goodsclassifyid']);
                if ($goodsClassifyInfo) {
                    $goodsinfo[$i]['goodsclassify'] = $goodsClassifyInfo['goodsclassify'];
                    $goodsinfo[$i]['price'] = $goodsClassifyInfo['goodsprice'];
                } else {
                    $goodsinfo[$i]['goodsclassify'] = '已下架';
                    $goodsinfo[$i]['price'] = 0;
                }
            }
            $goodsinfo[$i]['count'] = ($scgoods[$i])['count'];
            $goodsinfo[$i]['shoppingcartid'] = ($scgoods[$i])['shoppingcartid'];
        }
        $this->assign('goods', $goodsinfo);
        return $this->fetch();
    }

    public function cartDeal()              //购物车下单商品
    {
        $shoppingcartid = input('id');
        $idarr = explode('|', $shoppingcartid);
        $sp = model('ShoppingCart');
        $ym = model('YammyData');
        $goodsInfo = [];
        for ($i = 0; $i < (count($idarr) - 1); $i++) {
            $goodsInfo[$i] = $sp->selectShoppingCartId($idarr[$i]);
            $goodsInfo[$i]['goodsname'] = $ym->selectGoodsId(($goodsInfo[$i])['goodsid'])['goodsname'];
            $goodsInfo[$i]['goodsimg'] = $ym->selectGoodsId(($goodsInfo[$i])['goodsid'])['goodsimg'];
            $goodsInfo[$i]['shoppingcartid'] = $idarr[$i];
            if (($goodsInfo[$i])['goodsclassifyid'] != 0) {
                $goodsInfo[$i]['price'] = $sp->selectGoodsClassify(($goodsInfo[$i])['goodsclassifyid'])['goodsprice'];
                $goodsInfo[$i]['goodsclassify'] = $sp->selectGoodsClassify(($goodsInfo[$i])['goodsclassifyid'])['goodsclassify'];
            } else {
                $goodsInfo[$i]['price'] = $ym->selectGoodsId(($goodsInfo[$i])['goodsid'])['price'];
                $goodsInfo[$i]['goodsclassify'] = '默认分类';
            }
        }
        $this->assign('sumprice', input('price'));
        $this->assign('goods', $goodsInfo);
        return $this->fetch('Deal/deal_confirm');
    }

    public function deleteShoppingCart()                //删除购物车商品
    {
        $sc = model('ShoppingCart');

        if ($sc->deleteShoppingCart(input('shoppingcartid'))) {
            $this->redirect('ShoppingCart/shoppingCart');
        } else {
            $this->error('删除失败');
        }
    }
}