<?php
/**
 * Created by PhpStorm.
 * User: junweihu
 * Date: 2018/7/11
 * Time: 上午12:20
 */

namespace app\index\controller;


use think\Controller;

class Deal extends Controller
{
    public function successDeal()
    {
        return $this->success('下单成功！', 'deal');
    }

    public function deal()            //显示我的订单
    {
        if (session('username') == null) {            //如果还未登录
            return $this->fetch('Login/login');
        }
        $deal = model('deal');
        $dealInfo = $deal->selectDealInfoByUsername(session('username'));
        $page = $dealInfo->render();
        $this->assign('page', $page);
        $this->assign('deal', $dealInfo);
        $this->assign('tip', '已提醒卖家发货');
        $operation = input('operation');
        if (input('operation') != "") {
            $this->assign('operation', $operation);
        } else {
            $this->assign('operation', 'null');
        }

        return $this->fetch();
    }

    public function deleteDeal()        //买家删除订单
    {
        $deal = model('deal');
        if ($deal->deleteDeal(input('dealid'))) {
            return $this->redirect('Deal/deal', ['operation' => 'delete']);
        }
    }

    public function goodsReturn()       //买家申请退货
    {
        $deal = model('deal');
        if ($deal->goodsReturn(input('dealid'), input('reason'))) {
            return $this->redirect('Deal/deal', ['operation' => 'return']);
        }
    }

    public function goodsTakeOver()       //买家确认收货
    {
        $deal = model('deal');
        if ($deal->goodsTakeOver(input('dealid'))) {
            return $this->redirect('Deal/deal', ['operation' => 'takeOver']);
        }
    }

    public function dealConfirm()                 //显示购买商品
    {
        $yd = model('YammyData');
        $goodsInfo = $yd->selectGoodsId(input('goodsid'));
        if(input('classifyid') != 0) {
            $classify = $yd->selectClassifyId(input('classifyid'));
            $goodsInfo['goodsclassify'] = $classify['goodsclassify'];
            $goodsInfo['price'] = $classify['goodsprice'];
            $goodsInfo['goodsclassifyid'] = input('classifyid');
        } else {
            $goodsInfo['goodsclassify'] = '默认分类';
            $goodsInfo['goodsclassifyid'] = 0;
        }
        $goodsInfo['shoppingcartid'] = 0;
        $goodsInfo['count'] = input('goodscount');
        $goods[0] = $goodsInfo;
        $this->assign('sumprice', $goodsInfo['price'] * input('goodscount'));
        $this->assign('goods', $goods);
        return $this->fetch();
    }


    public function insertDeal()           //将订单插入数据库
    {
        $yd = model('YammyData');
        $deal = model('deal');
        $goodsInfo = $yd->selectGoodsId(input('goodsid'));
        if ($deal->insertGoodsDeal(input('goodsid'), $goodsInfo['goodsname'], $goodsInfo['shop'], $goodsInfo['shopid'], $goodsInfo['username'], session('username'), input('classifyid'), input('price'), input('count'), $goodsInfo['goodsimg'], input('classify'))) {
            //如果插入成功，删除购物车里的已购买商品
            $this->deleteShoppingCart(input('shoppingcartid'));
        } else {
            return 0;
        }
    }
}