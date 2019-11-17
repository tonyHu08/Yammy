<?php
/**
 * Created by PhpStorm.
 * User: junweihu
 * Date: 2018/5/30
 * Time: 上午1:27
 */

namespace app\index\model;

use think\Model;


class YammyData extends Model
{
    //插入注册信息
    public function reg($username, $password, $phonenum, $email, $headimg)
    {
        if(!$headimg) {
            $info = db('userlist')->insert(['username' => $username, 'password' => $password, 'phone' => $phonenum, 'email' => $email, 'regtime' => time(), 'active' => 0, 'seller' => 0, 'headimg' => "/static/headimg/moren.png"]);
            return $info;
        } else {
            $info = db('userlist')->insert(['username' => $username, 'password' => $password, 'phone' => $phonenum, 'email' => $email, 'regtime' => time(), 'active' => 0, 'seller' => 0, 'headimg' => $headimg]);
            return $info;
        }
    }

    //查找重复用户名
    public function findUserName($username)
    {
        $info = db('userlist')->where('username', $username)->find();
        return $info;
    }

    //查找重复邮箱
    public function findEmail($email)
    {
        $info = db('userlist')->where('email', $email)->find();
        return $info;
    }

    //查找重复手机号
    public function findPhone($phone)
    {
        $info = db('userlist')->where('phone', $phone)->find();
        return $info;
    }

    //查询登陆信息（账号密码是否正确）
    public function login($username, $password)
    {
        $info = db('userlist')->where('username', $username)->where('password', $password)->find();
        return $info;
    }


    //插入邮箱激活用户
    public function updateActive($username)
    {
        $info = db('userlist')->where('username', $username)->update(['active' => 1]);
        return $info;
    }

    //插入卖家用户
    public function applySeller($username)
    {
        $info = db('userlist')->where('username', $username)->update(['seller' => 1]);
        return $info;
    }

    //查看用户账户激活状态
    public function selectActive($username)
    {
        $active = db('userlist')->where('username', $username)->value('active');
        return $active;
    }

    //查看用户账户是否为卖家
    public function selectSeller($username)
    {
        $active = db('userlist')->where('username', $username)->value('seller');
        return $active;
    }

    //查看用户卖家是否有店铺
    public function selectShop($username)
    {
        $active = db('shop')->where('username', $username)->find();
        return $active;
    }

    //查看用户的店铺信息
    public function selectShopInfo($username)
    {
        $info = db('shop')->where('username', $username)->find();
        return $info;
    }


    //查找店铺信息
    public function selectShopForId($shopid)
    {
        $info = db('shop')->where('shopid', $shopid)->find();
        return $info;
    }


    //查看用户的店铺ID
    public function selectShopId($username)
    {
        $info = db('shop')->where('username', $username)->value('shopid');
        return $info;
    }

    //查看用户的店铺名称
    public function selectShopName($username)
    {
        $info = db('shop')->where('username', $username)->value('shopname');
        return $info;
    }

    //查看用户的店铺注册天数
    public function selectShopAge($username)
    {
        $info = db('shop')->where('username', $username)->value('createtime');
        return $info;
    }

    //查看用户的店铺点击数
    public function selectShopClick($username)
    {
        $info = db('shop')->where('username', $username)->value('click');
        return $info;
    }

    //查看用户的店铺商品总数
    public function selectShopGoodsCount($shop)
    {
        $info = db('goods')->where('shop', $shop)->count();
        return $info;
    }

    //查找一家店铺的全部商品
    public function selectShopAllGoods($shop)
    {
        $info = db('goods')->where('shop', $shop)->where('available', 1)->order('createtime desc')->paginate(10);
        return $info;
    }

    //查找此ID的商品信息
    public function selectGoodsId($goodsid)
    {
        $info = db('goods')->where('goodsid', $goodsid)->find();
        return $info;
    }

    //查找此ID的商品分类信息
    public function selectClassifyId($classifyid)
    {
        $info = db('goodsclassify')->where('goodsclassifyid', $classifyid)->find();
        return $info;
    }

    //获取留言列表
    public function msglist()
    {
        $info = db('userlist')->alias('u')->join('book b', 'b.username=u.username')->order('time desc')->paginate(10);
        return $info;
    }

    //获取完整的留言列表
    public function allMsgList()
    {
        $info = db('book')->order('time desc')->select();
        return $info;
    }

    //插入店铺信息
    public function shop($shopname, $type, $headimg)
    {
        $info = db('shop')->insert(['shopname' => $shopname, 'shoptype' => $type, 'createtime' => time(), 'shopheadimg' => $headimg, 'username' => session('username')]);
        return $info;
    }

    //更新店铺信息
    public function updateshop($shopname, $type, $headimg)
    {
        $info = db('shop')->where('username', session('username'))->update(['shopname' => $shopname, 'shoptype' => $type, 'shopheadimg' => $headimg]);
        return $info;
    }

    //更新商品信息（无图片）
    public function updateshopNoImg($shopname, $type)
    {
        $info = db('shop')->where('username', session('username'))->update(['shopname' => $shopname, 'shoptype' => $type]);
        return $info;
    }

    //插入商品信息
    public function issueGoods($goodsname, $type, $goodsimg, $price, $goodsintroduction, $shopname, $shopid)
    {
        $info = db('goods')->insert(['goodsname' => $goodsname, 'classify' => $type, 'createtime' => time(), 'goodsimg' => $goodsimg, 'username' => session('username'), 'price' => $price, 'goodsintroduction' => $goodsintroduction, 'shop' => $shopname, 'shopid' => $shopid, 'freight' => 0]);
        return $this->getLastInsID();
    }

    //插入商品类型信息
    public function issueGoodsClassify($goodsid, $goodsclassify, $goodsprice)
    {
        $info = db('goodsclassify')->insert(['goodsid' => $goodsid, 'goodsclassify' => $goodsclassify, 'goodsprice' => $goodsprice]);
        return $info;
    }

    //删除商品类型信息
    public function deleteGoodsClassify($goodsClassifyId)
    {
        $info = db('goodsclassify')->where('goodsclassifyid', $goodsClassifyId)->delete();
        return $info;
    }

    //更新商品类型信息
    public function updateGoodsClassify($goodsclassifyid, $goodsclassify, $goodsprice)
    {
        $info = db('goodsclassify')->where('goodsclassifyid', $goodsclassifyid)->update(['goodsclassify' => $goodsclassify, 'goodsprice' => $goodsprice]);
        return $info;
    }


    //查询商品类型信息
    public function selectGoodsClassify($goodsid)
    {
        $info = db('goodsclassify')->where('goodsid', $goodsid)->select();
        return $info;
    }

    //更新商品信息
    public function updateGoods($goodsname, $type, $goodsimg, $price, $goodsintroduction, $goodsid)
    {
        $info = db('goods')->where('goodsid', $goodsid)->update(['goodsname' => $goodsname, 'classify' => $type, 'goodsimg' => $goodsimg, 'price' => $price, 'goodsintroduction' => $goodsintroduction]);
        return $info;
    }

    //更新商品信息（不更新头像）
    public function updateGoodsNoImg($goodsname, $type, $price, $goodsintroduction, $goodsid)
    {
        $info = db('goods')->where('goodsid', $goodsid)->update(['goodsname' => $goodsname, 'classify' => $type, 'price' => $price, 'goodsintroduction' => $goodsintroduction]);
        return $info;
    }

    //更新店铺名称
    public function setShopName($shopname)
    {
        $info = db('shop')->where('username', session('username'))->update(['shopname' => $shopname]);
        return $info;
    }

    //更新店铺名称
    public function setShopType($shopType)
    {
        $info = db('shop')->where('username', session('username'))->update(['shoptype' => $shopType]);
        return $info;
    }

    //更新店铺名称
    public function setShopHeadImg($headImg)
    {
        $info = db('shop')->where('username', session('username'))->update(['shopheadimg' => $headImg]);
        return $info;
    }


    //查找一种类型的全部商品
    public function selectClassify($classify)
    {
        $info = db('goods')->where('classify', $classify)->paginate(15);
        return $info;
    }

    //查找一家店铺的全部商品
    public function selectSellerGoods($shop)
    {
        $info = db('goods')->where('shop', $shop)->order('createtime desc')->paginate(15);
        return $info;
    }

    //修改商品表中的商铺信息
    public function goodsShopName($username, $shopname)
    {
        $info = db('goods')->where('username', $username)->update(['shop' => $shopname]);
        return $info;
    }

    //搜索商品关键字
    public function searchGoods($word)
    {
        $info = db('goods')->where('goodsname', 'like', '%' . $word . '%')->paginate(15);
        return $info;
    }

    //更新店铺点击量
    public function updateClick($goodsid)
    {
        $goodsinfo = $this->selectGoodsId($goodsid);
        $info = db('shop')->where('shopid', $goodsinfo['shopid'])->update(['click' => $this->selectShopForId($goodsinfo['shopid'])['click'] + 1]);
        return $info;
    }


}