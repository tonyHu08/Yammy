<?php
/**
 * Created by PhpStorm.
 * User: junweihu
 * Date: 2018/6/5
 * Time: 上午11:13
 */

namespace app\index\controller;

use think\Controller;

class Seller extends Controller
{
    public function activeVali()       //验证账户是否激活
    {
        $yd = model('YammyData');
        return $yd->selectActive(session('username'));
    }

    public function sellerVali()        //验证卖家身份
    {
        $yd = model('YammyData');
        return $yd->selectSeller(session('username'));
    }

    static public function shopVali()          //验证是否有店铺
    {
        $yd = model('YammyData');
        return $yd->selectShop(session('username'));
    }

    static public function shopName()          //获取店铺名称
    {
        $yd = model('YammyData');
        return $yd->selectShopName(session('username'));
    }

    static public function shopId()          //获取店铺ID
    {
        $yd = model('YammyData');
        return $yd->selectShopId(session('username'));
    }

    public function shopAge()                   //获取店铺注册时间
    {
        $yd = model('YammyData');
        $age = $yd->selectShopAge(session('username'));
        $age = (time() - $age) / 86400;
        return $age;
    }

    public function shopClick()          //获取店铺点击量
    {
        $yd = model('YammyData');
        return $yd->selectShopClick(session('username'));
    }


    public function shopGoodsCount()          //获取店铺商品数量
    {
        $yd = model('YammyData');
        return $yd->selectShopGoodsCount(self::shopName());
    }

    public function shopAllGoods()            //获取当前店铺的全部商品
    {
        $yd = model('YammyData');
        return $yd->selectShopAllGoods(self::shopName());
    }

    public function shopGoodsId($goodsId)       //按商品id查找商品
    {
        $yd = model('YammyData');
        return $yd->selectGoodsId($goodsId);
    }

    public function shopInfo()          //获取店铺全部信息
    {
        $yd = model('YammyData');
        return $yd->selectShopInfo(session('username'));
    }

    public function selectGoodsClassify($goodsid)         //获取商品的分类信息
    {
        $goodsclassifyinfo = model('Yammydata');
        return $goodsclassifyinfo->selectGoodsClassify($goodsid);
    }

    public function sellerCenter()       //卖家中心验证身份
    {
        if(session('username') == null) {            //如果还未登录
            return $this->fetch('Login/login');
        }
        if(!$this->activeVali()) {                         //如果还没有激活账号
            return $this->fetch('index/activeWarning');
        }
        if(!$this->sellerVali()) {                        //如果还不是卖家
            return $this->fetch('index/sellerWarning');
        }
        if(self::shopVali()) {
            $this->assign('shop', 'index');        //如果有店铺
            $this->assign('shopname', self::shopName());
            $this->assign('shopage', (int)$this->shopAge());
            $this->assign('click', $this->shopClick());
            $this->assign('goodscount', $this->shopGoodsCount());
        } else {
            $this->assign('shop', 'setUpShop');         //如果没有店铺
        }
        if(input('func') == 'issue') {                          //如果点击了发布商品
            $this->assign('shop', 'issue');
        }
        if(input('func') == 'setShop') {                        //如果点击了设置店铺
            $shopInfo = $this->shopInfo();
            $this->assign('info', $shopInfo);
            $this->assign('shop', 'setShop');
        }
        if(input('func') == 'manage') {
            $allGoods = $this->shopAllGoods();
            $page = $allGoods->render();
            $this->assign('goods', $allGoods);
            $this->assign('page', $page);
            $this->assign('shop', 'manage');
        }
        if(input('func') == 'deal') {                           //如果点击了已卖出的商品
            $this->assign('shop', 'deal');
            $deal = model('deal');
            $dealInfo = $deal->selectSellerDealInfo(session('username'));
            $this->assign('deal', $dealInfo);
        }
        if(input('func') == 'deliver') {                           //如果点击了发货
            $this->assign('shop', 'deliver');
            $deal = model('deal');
            $dealInfo = $deal->selectSellerDeliver(session('username'));
            $this->assign('deal', $dealInfo);
        }
        if(input('func') == 'return') {                           //如果点击了退款管理
            $this->assign('shop', 'return');
            $deal = model('deal');
            $dealInfo = $deal->selectSellerReturn(session('username'));
            $this->assign('deal', $dealInfo);
        }
        if(input('goodsid') != null) {
            $goods = $this->shopGoodsId(input('goodsid'));
            $this->assign('goodsid', $goods);
            $goodsClassifyInfo = $this->selectGoodsClassify(input('goodsid'));
            if($goodsClassifyInfo) {
                $this->assign('count', (count($goodsClassifyInfo) + 1));
                $this->assign('goodsClassify', $goodsClassifyInfo);
            } else {
                $this->assign('goodsClassify', 0);
            }
            $this->assign('shop', 'mod');
        }
        $this->assign('tip', '发货成功！');
        return $this->fetch('');
    }

    public function applySeller()        //点击申请卖家按钮后
    {
        $yd = model('YammyData');
        if($yd->applySeller(session('username'))) {
            return $this->success('成功申请成为卖家！', 'Seller/sellerCenter');
        }
    }

    public function reSetShop()         //更新店铺信息
    {
        if(request()->file('file')) {
            $data = [
                'shopname' => input('shopname'),
                'type' => input('type'),
                'file' => request()->file('file')
            ];
            $vali = validate('SetUpShop');

            if(!$vali->check($data)) {
                return $this->error($vali->getError());
            }
            $headimgPath = '';
            $info = $data['file']->validate(['size' => 3000000, 'ext' => 'jpg,png,gif'])->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'static/shopheadimg', '');
            if($info) {
                $headimgPath = '/static/shopheadimg/' . $info->getFilename();
                //裁剪头像
                $image = \think\Image::open('./static/shopheadimg/' . $info->getSaveName());
                $image->thumb(150, 150, \think\Image::THUMB_CENTER)->save('./static/shopheadimg/' . $info->getSaveName());
            } else {
                // 上传失败获取错误信息
                return $this->error($data['file']->getError());
            }
            $yd = model('YammyData');
            if($yd->updateshop($data['shopname'], $data['type'], $headimgPath)) {
                if($yd->goodsShopName(session('username'), $data['shopname'])) {
                    return $this->success('修改店铺信息成功！', 'Seller/sellerCenter');
                }
            }
        } else {
            $data = [
                'shopname' => input('shopname'),
                'type' => input('type'),
                'file' => 'have'
            ];
            $vali = validate('SetUpShop');
            if(!$vali->check($data)) {
                return $this->error($vali->getError());
            }
            $yd = model('YammyData');
            if($yd->updateshopNoImg($data['shopname'], $data['type'])) {
                if($yd->goodsShopName(session('username'), $data['shopname'])) {
                    return $this->success('修改店铺信息成功！', 'Seller/sellerCenter');
                }
            }
        }
    }

    public function setUpShop()          //将店铺信息插入数据库
    {
        $data = [
            'shopname' => input('shopname'),
            'type' => input('type'),
            'file' => request()->file('file')
        ];
        $vali = validate('SetUpShop');

        if(!$vali->check($data)) {
            return $this->error($vali->getError());
        }
        $headimgPath = '';
        $info = $data['file']->validate(['size' => 3000000, 'ext' => 'jpg,png,gif'])->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'static/shopheadimg', '');
        if($info) {
            $headimgPath = '/static/shopheadimg/' . $info->getFilename();
            //裁剪头像
            $image = \think\Image::open('./static/shopheadimg/' . $info->getSaveName());
            $image->thumb(150, 150, \think\Image::THUMB_CENTER)->save('./static/shopheadimg/' . $info->getSaveName());
        } else {
            // 上传失败获取错误信息
            return $this->error($data['file']->getError());
        }
        $yd = model('YammyData');
        if($yd->shop($data['shopname'], $data['type'], $headimgPath)) {
            return $this->success('开店成功！', 'Seller/sellerCenter');
        }
    }

    public function deliverGoods()            //发货
    {
        $deal = model('deal');
        if($deal->deliverGoods(input('dealid'))) {
            return 1;
        }
    }

    public function cancelGoods()            //取消订单
    {
        $deal = model('deal');
        if($deal->cancelGoods(input('dealid'))) {
            return 1;
        }
    }

    public function goodsReturn()            //取消订单
    {
        $deal = model('deal');
        if($deal->goodsReturnDispose(input('dealid'))) {
            return 1;
        }
    }

}