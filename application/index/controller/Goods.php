<?php
/**
 * Created by PhpStorm.
 * User: junweihu
 * Date: 2018/6/7
 * Time: 上午12:04
 */

namespace app\index\controller;

use think\Controller;

class Goods extends Controller
{
    public function goodsSearch()       //关键字搜索商品
    {
        $yd = model('YammyData');
        $goods = $yd->searchGoods(input('word'));
        //如果搜索到商品
        if (isset($goods[0])) {
            $page = $goods->render();
            $this->assign('goods', $goods);
            $this->assign('searchword', input('word'));
            $this->assign('page', $page);
            $this->assign('classify', $goods[0]['classify']);
            $this->assign('title', '商品搜索-' . input('word'));
            $this->assign('come', '商品搜索');
            return $this->fetch('goods/goods_classify');
        } else {
            $this->assign('goods', 0);
            $this->assign('searchword', input('word'));
            $this->assign('page', 1);
            $this->assign('title', '商品搜索-' . input('word'));
            $this->assign('come', '商品搜索');
            return $this->fetch('goods/goods_classify');
        }
        return;
    }

    public function issueGoods()        //将商品信息插入数据库
    {
        $data = [
            'goodsName' => input('goodsName'),
            'type' => input('type'),
            'file' => request()->file('file'),
            'goodsClassify' => input('goodsClassify1'),
            'goodsPrice' => input('goodsClassifyPrice1'),
            'goodsIntroduction' => input('goodsIntroduction')
        ];
        $vali = validate('IssueGoods');
        if (!$vali->check($data)) {
            return $this->error($vali->getError());
        }
        $yd = model('YammyData');
        $goodscolor = [];

        $headimgPath = '';
        $info = $data['file']->validate(['size' => 3000000, 'ext' => 'jpg,png,gif'])->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'static/goodimg', '');
        if ($info) {
            $headimgPath = '/static/goodimg/' . $info->getFilename();
        } else {
            // 上传失败获取错误信息
            return $this->error($data['file']->getError());
        }

        if ($goodsid = $yd->issueGoods($data['goodsName'], $data['type'], $headimgPath, $data['goodsPrice'], $data['goodsIntroduction'], Seller::shopName(), Seller::shopId())) {
            for ($i = 0, $j = 1; $i < 5; $i++, $j++) {
                if (input('goodsClassify' . $j) != null) {
                    $goodsClassifycount = $i;
                    $goodsClassify[$i] = input('goodsClassify' . $j);
                    $goodsClassifyprice[$i] = input('goodsClassifyprice' . $j);
                } else {
                    break;
                }
            }
            for ($i = 0; $i <= $goodsClassifycount; $i++) {
                $yd->issueGoodsClassify($goodsid, $goodsClassify[$i], $goodsClassifyprice[$i]);
            }
            return $this->success('发布成功！', 'Seller/seller_center');
        }
    }

    public function modGoods()        //将更新商品信息插入数据库
    {
        if (request()->file('file')) {
            $data = [
                'goodsName' => input('goodsName'),
                'type' => input('type'),
                'file' => request()->file('file'),
                'goodsClassify' => input('goodsClassify1'),
                'goodsPrice' => input('goodsClassifyprice1'),
                'goodsIntroduction' => input('goodsIntroduction')
            ];
            $vali = validate('IssueGoods');
            if (!$vali->check($data)) {
                return $this->error($vali->getError());
            }
            $headimgPath = '';
            $info = $data['file']->validate(['size' => 3000000, 'ext' => 'jpg,png,gif'])->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'static/goodimg', '');
            if ($info) {
                $headimgPath = '/static/goodimg/' . $info->getFilename();
            } else {
                // 上传失败获取错误信息
                return $this->error($data['file']->getError());
            }

            $yd = model('YammyData');
            if ($yd->updateGoods($data['goodsName'], $data['type'], $headimgPath, $data['goodsPrice'], $data['goodsIntroduction'], input('goodsId'))) {
                //插入商品类别信息
                for ($i = 0, $j = 1; $i < 5; $i++, $j++) {
                    if (input('goodsClassify' . $j) != null) {
                        $goodsClassifycount = $i;
                        $goodsClassify[$i] = input('goodsClassify' . $j);
                        $goodsClassifyprice[$i] = input('goodsClassifyprice' . $j);
                    } else {
                        break;
                    }
                }
                $goodsClassifyInfo = $yd->selectGoodsClassify(input('goodsId'));
                if ($goodsClassifyInfo) {
                    if (count($goodsClassifyInfo) <= ($goodsClassifycount + 1)) {
                        for ($i = 0; $i < count($goodsClassifyInfo); $i++) {
                            $yd->updateGoodsClassify(($goodsClassifyInfo[$i])['goodsclassifyid'], $goodsClassify[$i], $goodsClassifyprice[$i]);
                        }
                        for ($i; $i <= $goodsClassifycount; $i++) {
                            $yd->issueGoodsClassify(input('goodsId'), $goodsClassify[$i], $goodsClassifyprice[$i]);
                        }
                    } else {
                        for ($i = 0; $i <= $goodsClassifycount; $i++) {
                            $yd->updateGoodsClassify(($goodsClassifyInfo[$i])['goodsclassifyid'], $goodsClassify[$i], $goodsClassifyprice[$i]);
                        }
                        for ($i; $i < count($goodsClassifyInfo); $i++) {
                            $yd->deleteGoodsClassify(($goodsClassifyInfo[$i])['goodsclassifyid']);
                        }
                    }
                }
                return $this->success('设置成功！', 'Seller/sellerCenter?func=manage');
            }
        } else {
            $data = [
                'goodsName' => input('goodsName'),
                'type' => input('type'),
                'goodsClassify' => input('goodsClassify1'),
                'goodsPrice' => input('goodsClassifyprice1'),
                'file' => 'have',
                'goodsIntroduction' => input('goodsIntroduction')
            ];
            $vali = validate('IssueGoods');
            if (!$vali->check($data)) {
                return $this->error($vali->getError());
            }
            $yd = model('YammyData');
            $yd->updateGoodsNoImg($data['goodsName'], $data['type'], $data['goodsPrice'], $data['goodsIntroduction'], input('goodsId'));
            for ($i = 0, $j = 1; $i < 5; $i++, $j++) {
                if (input('goodsClassify' . $j) != null) {
                    $goodsClassifycount = $i;
                    $goodsClassify[$i] = input('goodsClassify' . $j);
                    $goodsClassifyprice[$i] = input('goodsClassifyprice' . $j);
                } else {
                    break;
                }
            }
            $goodsClassifyInfo = $yd->selectGoodsClassify(input('goodsId'));
            if ($goodsClassifyInfo) {
                if (count($goodsClassifyInfo) <= ($goodsClassifycount + 1)) {
                    for ($i = 0; $i < count($goodsClassifyInfo); $i++) {
                        $yd->updateGoodsClassify(($goodsClassifyInfo[$i])['goodsclassifyid'], $goodsClassify[$i], $goodsClassifyprice[$i]);
                    }
                    for ($i; $i <= $goodsClassifycount; $i++) {
                        $yd->issueGoodsClassify(input('goodsId'), $goodsClassify[$i], $goodsClassifyprice[$i]);
                    }
                } else {
                    for ($i = 0; $i <= $goodsClassifycount; $i++) {
                        $yd->updateGoodsClassify(($goodsClassifyInfo[$i])['goodsclassifyid'], $goodsClassify[$i], $goodsClassifyprice[$i]);
                    }
                    for ($i; $i < count($goodsClassifyInfo); $i++) {
                        $yd->deleteGoodsClassify(($goodsClassifyInfo[$i])['goodsclassifyid']);
                    }
                }
            }
            return $this->success('设置成功！', 'Seller/sellerCenter?func=manage');
        }
    }


    public function goodsClassify()             //显示分类页面
    {
        $classify = input('classify');
        $classifyinfo = model('YammyData');
        $goods = $classifyinfo->selectClassify($classify);
        if ($goods) {
            $page = $goods->render();
            $this->assign('goods', $goods);
            $this->assign('classify', $classify);
            $this->assign('page', $page);
            $this->assign('title', '商品分类-' . $classify);
            $this->assign('come', '商品分类');
            return $this->fetch();
        } else {
            $this->assign('goods', 0);
            $this->assign('classify', $classify);
            return $this->fetch();
        }
    }

    public function goodsSeller()             //显示店铺商品页面
    {
        $shop = input('shop');
        $shopinfo = model('YammyData');
        $goods = $shopinfo->selectSellerGoods($shop);
        if ($goods) {
            $page = $goods->render();
            $this->assign('goods', $goods);
            $this->assign('shopname', $shop);
            $this->assign('page', $page);
            $this->assign('come', '店铺商品');
            $this->assign('title', '店铺商品');
            return $this->fetch('goods/goods_classify');
        } else {
            $this->assign('goods', 0);
            $this->assign('shopname', $shop);
            $this->assign('come', '店铺商品');
            $this->assign('title', '店铺商品');
            return $this->fetch('goods/goods_classify');
        }
    }

    public function goods()                     //显示商品页
    {
        $yd = model('YammyData');
        $goodsinfo = $yd->selectGoodsId(input('goodsid'));
        $yd->updateClick(input('goodsid'));
        $goodsClassify = $yd->selectGoodsClassify(input('goodsid'));
        $evaluate = new Evaluate();
        $evaluation_list = $evaluate->showEvaluation(input('goodsid'));
        $this->assign('evaluation_list', $evaluation_list);
        $evaluation_count = count($evaluation_list);
        $this->assign('evaluation_count', $evaluation_count);
        if ($goodsClassify) {
            $goodsClassifyId = ($goodsClassify[0])['goodsclassifyid'];
        } else {
            $goodsClassifyId = 0;
        }
        if ($goodsinfo) {
            $this->assign('goodsinfo', $goodsinfo);
            $this->assign('goodsClassify', $goodsClassify);
            $this->assign('goodsClassifyId', $goodsClassifyId);
            $this->assign('tip', '加入购物车成功！');
            return $this->fetch();
        } else {
            return $this->error('商品信息错误');
        }
    }


    public function insertShoppingCart()              //添加购物车
    {
        $yd = model('YammyData');
        $sc = model('ShoppingCart');
        $goodsinfo = $yd->selectGoodsId(input('goodsid'));          //获取店铺id
        $shopid = $goodsinfo['shopid'];
        if (!$sc->sameGoods(session('username'), input('goodsid'), input('goodsclassifyid'))) {
            $sc->insertShoppingCart(session('username'), $shopid, input('goodsid'), input('count'), input('goodsclassifyid'));
            return 1;
        } else {
            $sc->updateCount(session('username'), input('goodsid'), input('count'), input('goodsclassifyid'));
            return 1;
        }
    }

    public function updateShoppingCartGoodsCount()          //更新商品数量
    {
        $sc = model('ShoppingCart');
        if ($sc->updateChangeCount(session('username'), input('shoppingcartid'), input('count'))) {
            return 0;
        }
    }
}