/*
 Navicat Premium Data Transfer

 Source Server         : Yammy
 Source Server Type    : MySQL
 Source Server Version : 80011
 Source Host           : localhost:3306
 Source Schema         : Think_yammy

 Target Server Type    : MySQL
 Target Server Version : 80011
 File Encoding         : 65001

 Date: 16/06/2018 15:48:40
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for book
-- ----------------------------
DROP TABLE IF EXISTS `book`;
CREATE TABLE `book` (
  `username` varchar(255) DEFAULT NULL,
  `uid` int(10) DEFAULT NULL,
  `leaveword` varchar(255) DEFAULT NULL,
  `id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of book
-- ----------------------------
BEGIN;
INSERT INTO `book` VALUES ('tony', 2, '卖家服务态度很好！有问必答！以后买凶杀人就在你这了！', 0000000001, 1528171525);
INSERT INTO `book` VALUES ('tony', 2, '卖家服务不错，风扇质量也不错，nice', 0000000002, 1528171524);
INSERT INTO `book` VALUES ('tony', 2, '小龙虾个头都很大，可惜自己炒糊了', 0000000003, 1528171523);
COMMIT;

-- ----------------------------
-- Table structure for chart
-- ----------------------------
DROP TABLE IF EXISTS `chart`;
CREATE TABLE `chart` (
  `id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `username` varchar(20) DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  `msg` longtext,
  `headimg` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  CONSTRAINT `chart_ibfk_1` FOREIGN KEY (`username`) REFERENCES `userlist` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for deal
-- ----------------------------
DROP TABLE IF EXISTS `deal`;
CREATE TABLE `deal` (
  `goodsid` int(10) NOT NULL,
  `goodsname` varchar(255) NOT NULL,
  `shopname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `dealid` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `dealtime` int(10) NOT NULL,
  `message` varchar(255) DEFAULT NULL,
  `dealprice` double(10,0) NOT NULL,
  `sellername` varchar(255) NOT NULL,
  `shopid` int(10) NOT NULL,
  `count` int(10) NOT NULL,
  `goodsclassifyid` int(10) NOT NULL,
  `goodsimg` varchar(255) NOT NULL,
  `goodsclassify` varchar(255) NOT NULL,
  `dealstate` varchar(255) NOT NULL,
  PRIMARY KEY (`dealid`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of deal
-- ----------------------------
BEGIN;
INSERT INTO `deal` VALUES (51, '无骨鸭掌', '完美的雕', 'tony', 0000000007, 1528996199, NULL, 12, 'tony', 1, 1, 38, 'http://www.tonyyam.cn/static/goodimg/c3cab0af1c71ac3a7cae407fc0561509.png', '2只装', '已下单');
INSERT INTO `deal` VALUES (2, '完美小风扇', '完美的雕', 'tony', 0000000008, 1529074999, NULL, 42, 'tony', 1, 2, 31, 'http://www.tonyyam.cn/static/goodimg/2.png', '中号', '已下单');
COMMIT;

-- ----------------------------
-- Table structure for goods
-- ----------------------------
DROP TABLE IF EXISTS `goods`;
CREATE TABLE `goods` (
  `goodsid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goodsname` varchar(255) NOT NULL,
  `goodsimg` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `goodsintroduction` varchar(255) DEFAULT NULL,
  `classify` varchar(255) NOT NULL,
  `price` double(20,0) NOT NULL,
  `username` varchar(10) NOT NULL,
  `createtime` int(10) NOT NULL,
  `shop` varchar(255) NOT NULL,
  `freight` double(20,0) unsigned zerofill NOT NULL,
  `shopid` int(10) unsigned zerofill NOT NULL,
  PRIMARY KEY (`goodsid`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of goods
-- ----------------------------
BEGIN;
INSERT INTO `goods` VALUES (2, '完美小风扇', 'http://www.tonyyam.cn/static/goodimg/2.png', '完美小风扇', '家电', 15, 'tony', 1528171525, '完美的雕', 00000000000000000000, 0000000001);
INSERT INTO `goods` VALUES (3, '超静音风扇', 'http://www.tonyyam.cn/static/goodimg/1.png', '完全静音，品质之选', '家电', 699, 'tony', 1528299813, '完美的雕', 00000000000000000000, 0000000001);
INSERT INTO `goods` VALUES (4, '超厉害的每日坚果', 'http://www.tonyyam.cn/static/goodimg/3.png', '补充每日维生素所需，居家良品', '美食', 59, 'tony', 1528299847, '完美的雕', 00000000000000000000, 0000000001);
INSERT INTO `goods` VALUES (5, '超厉害的燕窝', 'http://www.tonyyam.cn/static/goodimg/4.png', '燕子的窝', '保健品', 399, 'tony', 1528299894, '完美的雕', 00000000000000000000, 0000000001);
INSERT INTO `goods` VALUES (7, '超厉害的牛奶君', 'http://www.tonyyam.cn/static/goodimg/6.png', '新西兰进口奶源', '美食', 59, 'tony', 1528299977, '完美的雕', 00000000000000000000, 0000000001);
INSERT INTO `goods` VALUES (8, '全自动超声波电动牙刷', 'http://www.tonyyam.cn/static/goodimg/7.png', '专利科技，完美去牙垢', '家电', 199, 'tony', 1528300010, '完美的雕', 00000000000000000000, 0000000001);
INSERT INTO `goods` VALUES (9, '静音除螨器', 'http://www.tonyyam.cn/static/goodimg/17.png', '给你清爽无虫的被窝', '家电', 599, 'tony', 1528350875, '完美的雕', 00000000000000000000, 0000000001);
INSERT INTO `goods` VALUES (10, '挂式熨斗', 'http://www.tonyyam.cn/static/goodimg/11.png', '给您平整的一身', '家电', 1299, 'tony', 1528350916, '完美的雕', 00000000000000000000, 0000000001);
INSERT INTO `goods` VALUES (11, '蓝牙HIFI入耳式耳机', 'http://www.tonyyam.cn/static/goodimg/12.png', 'HIFI音效，完美体验', '数码', 299, 'tony', 1528350964, '完美的雕', 00000000000000000000, 0000000001);
INSERT INTO `goods` VALUES (12, '端午大粽', 'http://www.tonyyam.cn/static/goodimg/14.png', '端午佳节，逢人送一个', '美食', 69, 'tony', 1528351025, '完美的雕', 00000000000000000000, 0000000001);
INSERT INTO `goods` VALUES (13, '人体工程学办公椅', 'http://www.tonyyam.cn/static/goodimg/15.png', '完美贴合你的背', '家具', 699, 'tony', 1528351064, '完美的雕', 00000000000000000000, 0000000001);
INSERT INTO `goods` VALUES (14, '柔软u型枕', 'http://www.tonyyam.cn/static/goodimg/16.png', '差旅必备', '配件', 39, 'tony', 1528351161, '完美的雕', 00000000000000000000, 0000000001);
INSERT INTO `goods` VALUES (15, '全铝行李箱', 'http://www.tonyyam.cn/static/goodimg/18.png', '7系铝材，超耐磨', '箱包', 299, 'tony', 1528351219, '完美的雕', 00000000000000000000, 0000000001);
INSERT INTO `goods` VALUES (16, '男士皮肤风衣', 'http://www.tonyyam.cn/static/goodimg/13.png', '男士必备，防风防雨', '男装', 399, 'tony', 1528351259, '完美的雕', 00000000000000000000, 0000000001);
INSERT INTO `goods` VALUES (17, '干衣干鞋器', 'http://www.tonyyam.cn/static/goodimg/19.png', '差旅必备，速干衣鞋', '家电', 199, 'tony', 1528351866, '完美的雕', 00000000000000000000, 0000000001);
INSERT INTO `goods` VALUES (18, '吸尘除螨器', 'http://www.tonyyam.cn/static/goodimg/20.png', '吸尘除螨，居家精选', '家电', 499, 'tony', 1528352038, '完美的雕', 00000000000000000000, 0000000001);
INSERT INTO `goods` VALUES (19, '智能柔光护眼台灯', 'http://www.tonyyam.cn/static/goodimg/21.png', '学习伴侣，柔光护眼', '家电', 199, 'tony', 1528352068, '完美的雕', 00000000000000000000, 0000000001);
INSERT INTO `goods` VALUES (20, '智能体重秤', 'http://www.tonyyam.cn/static/goodimg/22.png', '居家体重秤，帮助你认清自己', '家电', 59, 'tony', 1528352106, '完美的雕', 00000000000000000000, 0000000001);
INSERT INTO `goods` VALUES (21, '4USB智能插线板', 'http://www.tonyyam.cn/static/goodimg/23.png', '防雷防漏电，安全方便', '家电', 49, 'tony', 1528352149, '完美的雕', 00000000000000000000, 0000000001);
INSERT INTO `goods` VALUES (22, '复古面包机', 'http://www.tonyyam.cn/static/goodimg/24.png', '早餐在家就能做，不用排队买早餐', '家电', 299, 'tony', 1528352184, '完美的雕', 00000000000000000000, 0000000001);
INSERT INTO `goods` VALUES (23, '男士商务POLO衫', 'http://www.tonyyam.cn/static/goodimg/25.png', '澳洲羊毛，完美质地', '男装', 199, 'tony', 1528353101, '完美的雕', 00000000000000000000, 0000000001);
INSERT INTO `goods` VALUES (24, '复古咖啡机', 'http://www.tonyyam.cn/static/goodimg/30.png', '咖啡自制，早餐升级', '家电', 1299, 'tony', 1528356072, '完美的雕', 00000000000000000000, 0000000001);
INSERT INTO `goods` VALUES (25, '智能小夜灯', 'http://www.tonyyam.cn/static/goodimg/29.png', '有了小夜灯，起夜再不怕', '家电', 29, 'tony', 1528356121, '完美的雕', 00000000000000000000, 0000000001);
INSERT INTO `goods` VALUES (26, '智能碗具消毒柜', 'http://www.tonyyam.cn/static/goodimg/28.png', '品质生活，消毒开始', '家电', 1399, 'tony', 1528356164, '完美的雕', 00000000000000000000, 0000000001);
INSERT INTO `goods` VALUES (27, '智能复古烧水壶', 'http://www.tonyyam.cn/static/goodimg/27.png', '无菌烧水，复古情调', '家电', 299, 'tony', 1528356197, '完美的雕', 00000000000000000000, 0000000001);
INSERT INTO `goods` VALUES (28, '水质检测仪', 'http://www.tonyyam.cn/static/goodimg/26.png', '智能检水质，悦享品质生活', '数码', 59, 'tony', 1528356228, '完美的雕', 00000000000000000000, 0000000001);
INSERT INTO `goods` VALUES (29, '白色牛皮底运动鞋', 'http://www.tonyyam.cn/static/goodimg/4eebbee603feb36b2bc64c2284e288b4.png', '夏日必备，穿搭良品', '鞋', 299, 'tonyyam', 1528448355, '完美蜥蜴皮', 00000000000000000000, 0000000003);
INSERT INTO `goods` VALUES (30, '牛皮休闲鞋', 'http://www.tonyyam.cn/static/goodimg/22b6ede71c5d6e6ed3156faea30ffe49.png', '休闲午后，咖啡伴侣', '鞋', 399, 'tonyyam', 1528448400, '完美蜥蜴皮', 00000000000000000000, 0000000003);
INSERT INTO `goods` VALUES (31, '方扣中空平跟鞋', 'http://www.tonyyam.cn/static/goodimg/437a5c700b615acfd18a4f50cff34842.png', '时尚大方，舒适宜人', '鞋', 399, 'tonyyam', 1528448465, '完美蜥蜴皮', 00000000000000000000, 0000000003);
INSERT INTO `goods` VALUES (32, 'boost跑步鞋', 'http://www.tonyyam.cn/static/goodimg/968da959617bea9488be73baad7e12ba.png', '专利鞋底技术，为你每一脚都做好缓冲', '鞋', 399, 'tonyyam', 1528448511, '完美蜥蜴皮', 00000000000000000000, 0000000003);
INSERT INTO `goods` VALUES (33, '儿童牛仔夹克', 'http://www.tonyyam.cn/static/goodimg/708648b7cdbb0ca3dd41183493448814.png', '潮孩必备', '童装玩具', 299, 'tonyyam', 1528448616, '完美蜥蜴皮', 00000000000000000000, 0000000003);
INSERT INTO `goods` VALUES (34, '意大利手工小牛皮休闲鞋', 'http://www.tonyyam.cn/static/goodimg/8906826159b5111b9c265795a10e886b.png', '奢侈之选，土豪必备', '鞋', 8999, 'tonyyam', 1528448657, '完美蜥蜴皮', 00000000000000000000, 0000000003);
INSERT INTO `goods` VALUES (35, '方跟一字带凉鞋', 'http://www.tonyyam.cn/static/goodimg/be9899f83dac2880d52c5bb80a16d01d.png', '鞋日必备，清爽秀丽', '鞋', 399, 'tonyyam', 1528448735, '完美蜥蜴皮', 00000000000000000000, 0000000003);
INSERT INTO `goods` VALUES (36, '女士紧身连衣裙', 'http://www.tonyyam.cn/static/goodimg/eedcc3f81671d26494859002558b7afb.png', '夏日单品，出街良选', '女装', 399, 'tony', 1528512156, '完美的雕', 00000000000000000000, 0000000003);
INSERT INTO `goods` VALUES (37, '铝框行李箱', 'http://www.tonyyam.cn/static/goodimg/a082ed3156e3b778906385ba4d6c6f1a.png', '71升容量升级，灵活出行', '箱包', 399, 'tony', 1528512804, '完美的雕', 00000000000000000000, 0000000003);
INSERT INTO `goods` VALUES (38, '超级好吃的麻辣小龙虾', 'http://www.tonyyam.cn/static/goodimg/67ccf27ccd96fa4ce4f35082d722cd54.png', '完美小龙虾，帅气小龙虾', '美食', 128, 'tony', 1528555982, '完美的雕', 00000000000000000000, 0000000001);
INSERT INTO `goods` VALUES (48, '鸡 毛绒公仔 我的世界', 'http://www.tonyyam.cn/static/goodimg/ed6ebe03ce6cf1b892788788465da9bc.png', 'hhhh', '童装玩具', 2, 'tony', 1528773663, '完美的雕', 00000000000000000000, 0000000001);
INSERT INTO `goods` VALUES (51, '无骨鸭掌', 'http://www.tonyyam.cn/static/goodimg/c3cab0af1c71ac3a7cae407fc0561509.png', '完美鸭掌，极品鸭子', '美食', 6, 'tony', 1528777644, '完美的雕', 00000000000000000000, 0000000001);
INSERT INTO `goods` VALUES (52, '咸鸭蛋', 'http://www.tonyyam.cn/static/goodimg/421da267b732e56257c1d4e9b7e07b06.png', '极品咸鸭，用心下的蛋', '美食', 2, 'tony', 1528777787, '完美的雕', 00000000000000000000, 0000000001);
INSERT INTO `goods` VALUES (53, '美队3钥匙挂扣', 'http://www.tonyyam.cn/static/goodimg/7dd7ae50efe4959a3bdf04101e4c43dc.png', '美队3同款，不锈钢材质扎实手感', '配件', 70, 'tony', 1528949456, '完美的雕', 00000000000000000000, 0000000001);
INSERT INTO `goods` VALUES (54, '碳素羽毛球拍', 'http://www.tonyyam.cn/static/goodimg/830f01a489ea42571a45d372389bc70d.png', '专业碳纤维羽毛球拍，采用T1000碳纤维编织，减震，更硬！', '运动', 799, 'tony', 1528950429, '完美的雕', 00000000000000000000, 0000000001);
INSERT INTO `goods` VALUES (55, '健身瑜伽垫', 'http://www.tonyyam.cn/static/goodimg/f03b73d71a4a84c32db13eddece05cc3.png', '专业瑜伽垫，无异味，更安全', '运动', 79, 'tony', 1528950518, '完美的雕', 00000000000000000000, 0000000001);
COMMIT;

-- ----------------------------
-- Table structure for goodsclassify
-- ----------------------------
DROP TABLE IF EXISTS `goodsclassify`;
CREATE TABLE `goodsclassify` (
  `goodsid` int(10) NOT NULL,
  `goodsclassifyid` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `goodsclassify` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `goodsprice` int(10) NOT NULL,
  `goodsimg` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`goodsclassifyid`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of goodsclassify
-- ----------------------------
BEGIN;
INSERT INTO `goodsclassify` VALUES (47, 0000000001, 'red', 11, NULL);
INSERT INTO `goodsclassify` VALUES (47, 0000000002, 'blue', 12, NULL);
INSERT INTO `goodsclassify` VALUES (47, 0000000003, 'green', 13, NULL);
INSERT INTO `goodsclassify` VALUES (48, 0000000004, '火鸡', 2, NULL);
INSERT INTO `goodsclassify` VALUES (48, 0000000005, '公鸡', 100, NULL);
INSERT INTO `goodsclassify` VALUES (2, 0000000030, '小号', 15, NULL);
INSERT INTO `goodsclassify` VALUES (2, 0000000031, '中号', 21, NULL);
INSERT INTO `goodsclassify` VALUES (52, 0000000033, '1只装', 2, NULL);
INSERT INTO `goodsclassify` VALUES (52, 0000000034, '2只装', 4, NULL);
INSERT INTO `goodsclassify` VALUES (52, 0000000035, '3只装', 6, NULL);
INSERT INTO `goodsclassify` VALUES (52, 0000000036, '4只装', 7, NULL);
INSERT INTO `goodsclassify` VALUES (51, 0000000037, '1只装', 6, NULL);
INSERT INTO `goodsclassify` VALUES (51, 0000000038, '2只装', 12, NULL);
INSERT INTO `goodsclassify` VALUES (53, 0000000048, '钢铁侠', 70, NULL);
INSERT INTO `goodsclassify` VALUES (53, 0000000049, '战争机器', 70, NULL);
INSERT INTO `goodsclassify` VALUES (53, 0000000050, '黑豹', 70, NULL);
INSERT INTO `goodsclassify` VALUES (53, 0000000051, '三合一', 198, NULL);
INSERT INTO `goodsclassify` VALUES (54, 0000000052, '白色', 799, 'http://www.tonyyam.cn/static/goodimg/830f01a489ea42571a45d372389bc70d.png');
INSERT INTO `goodsclassify` VALUES (54, 0000000053, '黑色', 799, 'http://www.tonyyam.cn/static/goodimg/c1657eaa1a157f0f03d5fac0a9fc65f9.png');
INSERT INTO `goodsclassify` VALUES (55, 0000000054, '粉色', 79, NULL);
INSERT INTO `goodsclassify` VALUES (55, 0000000055, '黑色', 79, NULL);
INSERT INTO `goodsclassify` VALUES (55, 0000000056, '蓝色', 79, NULL);
INSERT INTO `goodsclassify` VALUES (55, 0000000057, '粉色加厚版', 109, NULL);
INSERT INTO `goodsclassify` VALUES (55, 0000000058, '蓝色加厚版', 109, NULL);
COMMIT;

-- ----------------------------
-- Table structure for shop
-- ----------------------------
DROP TABLE IF EXISTS `shop`;
CREATE TABLE `shop` (
  `shopid` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `shopname` varchar(255) NOT NULL,
  `shoptype` varchar(255) NOT NULL,
  `shopheadimg` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `click` int(10) DEFAULT NULL,
  `createtime` int(10) NOT NULL,
  PRIMARY KEY (`shopid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shop
-- ----------------------------
BEGIN;
INSERT INTO `shop` VALUES (0000000001, '完美的雕', '运动', 'http://www.tonyyam.cn/static/shopheadimg/IMG_4648.JPG', 'tony', 10, 1528085035);
INSERT INTO `shop` VALUES (0000000003, '完美蜥蜴皮', '服饰', 'http://www.tonyyam.cn/static/shopheadimg/IMG_0796.JPG', 'tonyyam', 10, 1528448274);
COMMIT;

-- ----------------------------
-- Table structure for shoppingcart
-- ----------------------------
DROP TABLE IF EXISTS `shoppingcart`;
CREATE TABLE `shoppingcart` (
  `shoppingcartid` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `goodsid` int(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `shopid` int(10) NOT NULL,
  `count` int(10) NOT NULL,
  `goodsclassifyid` int(10) DEFAULT NULL,
  `changetime` int(10) unsigned zerofill NOT NULL,
  PRIMARY KEY (`shoppingcartid`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shoppingcart
-- ----------------------------
BEGIN;
INSERT INTO `shoppingcart` VALUES (0000000001, 8, 'tony', 1, 1, 0, 1528085035);
INSERT INTO `shoppingcart` VALUES (0000000003, 3, 'tony', 1, 2, 0, 1528789767);
INSERT INTO `shoppingcart` VALUES (0000000004, 9, 'tony', 1, 1, 0, 1528085037);
INSERT INTO `shoppingcart` VALUES (0000000005, 15, 'tony', 1, 7, 0, 1528813194);
INSERT INTO `shoppingcart` VALUES (0000000006, 2, 'tony', 1, 1, 0, 1528085039);
INSERT INTO `shoppingcart` VALUES (0000000007, 38, 'tony', 1, 1, 0, 1528790905);
INSERT INTO `shoppingcart` VALUES (0000000008, 18, 'tony', 1, 2, 0, 1528789745);
INSERT INTO `shoppingcart` VALUES (0000000014, 36, 'tony', 3, 2, 0, 1528823657);
INSERT INTO `shoppingcart` VALUES (0000000015, 48, 'tony', 1, 1, 5, 1528883627);
INSERT INTO `shoppingcart` VALUES (0000000016, 51, 'tony', 1, 1, 37, 1528944319);
INSERT INTO `shoppingcart` VALUES (0000000018, 11, 'tony', 1, 2, 0, 1528989732);
INSERT INTO `shoppingcart` VALUES (0000000020, 53, 'tony', 1, 1, 48, 1528988515);
INSERT INTO `shoppingcart` VALUES (0000000021, 2, 'tony', 1, 1, 30, 1528989735);
COMMIT;

-- ----------------------------
-- Table structure for userlist
-- ----------------------------
DROP TABLE IF EXISTS `userlist`;
CREATE TABLE `userlist` (
  `uid` int(20) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `username` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` char(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nickname` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `active` tinyint(1) unsigned zerofill NOT NULL,
  `seller` tinyint(1) unsigned zerofill NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `phone` bigint(11) DEFAULT NULL,
  `regtime` int(11) DEFAULT NULL,
  `regip` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `loginip` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `headimg` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `logintime` int(11) unsigned zerofill DEFAULT NULL,
  `isadmin` tinyint(1) DEFAULT NULL,
  `lastlogintime` int(11) DEFAULT NULL,
  `showlast` int(11) DEFAULT NULL,
  `shopname` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`uid`,`username`) USING BTREE,
  KEY `username` (`username`),
  KEY `headimg` (`headimg`)
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of userlist
-- ----------------------------
BEGIN;
INSERT INTO `userlist` VALUES (00000000000000000081, 'ttony', 'gaga', 'thinktony', 1, 1, NULL, NULL, 1527093893, '::1', NULL, 'http://www.www.tonyyam.cn/static/headimg/mr.jpg', 01527341070, NULL, 1527233112, NULL, NULL);
INSERT INTO `userlist` VALUES (00000000000000000083, 'ttt', 'a', 'a', 1, 1, NULL, NULL, 1523158587, '::1', NULL, 'http://www.tonyyam.cn/static/headimg/hl.jpg', 01527393942, NULL, 1527232925, NULL, NULL);
INSERT INTO `userlist` VALUES (00000000000000000089, '1', '1', 'ha', 1, 1, NULL, NULL, 1527179666, '::1', NULL, 'http://www.tonyyam.cn/static/headimg/IMG_0796.JPG', 01527233115, NULL, 1527232996, NULL, NULL);
INSERT INTO `userlist` VALUES (00000000000000000090, 'tony', 'gaga', 'tony', 1, 1, NULL, NULL, 1527345090, '::1', NULL, 'http://www.tonyyam.cn/static/headimg/mr.jpg', 01527561187, NULL, 1527491000, NULL, NULL);
INSERT INTO `userlist` VALUES (00000000000000000091, 'bao', 'ha', 'ni', 0, 0, NULL, NULL, 1527349157, '::1', NULL, 'http://www.tonyyam.cn/static/headimg/IMG_0796.JPG', 01527478473, NULL, 1527387071, NULL, NULL);
INSERT INTO `userlist` VALUES (00000000000000000092, 'baoa', '1', 'a', 0, 0, NULL, NULL, 1527349384, '::1', NULL, 'http://www.tonyyam.cn/static/headimg/mr.jpg', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `userlist` VALUES (00000000000000000110, 'test', 'a', NULL, 0, 0, 'tony.hu08@icloud.com', 11111111111, 1527942242, NULL, NULL, 'http://www.tonyyam.cn/static/headimg/moren.png', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `userlist` VALUES (00000000000000000111, 'tonyyam', '1412000', NULL, 1, 1, 'guaidaojide1412000@163.com', 13208188252, 1528447123, NULL, NULL, 'http://www.tonyyam.cn/static/headimg/moren.png', NULL, NULL, NULL, NULL, NULL);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
