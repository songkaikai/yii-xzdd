/*
Navicat MySQL Data Transfer

Source Server         : wamp
Source Server Version : 50711
Source Host           : localhost:3306
Source Database       : ceshi

Target Server Type    : MYSQL
Target Server Version : 50711
File Encoding         : 65001

Date: 2017-08-26 14:37:36
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for xz_account_log
-- ----------------------------
DROP TABLE IF EXISTS `xz_account_log`;
CREATE TABLE `xz_account_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `type` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '日志类型 1 推荐奖 2 公排一见点 3 中奖 4 静态分红 5分销收益 6 轰炸奖 7 领导奖 8 公排2见点',
  `in` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '入账',
  `out` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '出账',
  `balance` decimal(20,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '累计结余',
  `desc` varchar(100) DEFAULT NULL COMMENT '说明',
  `order_no` char(30) DEFAULT NULL COMMENT '订单号',
  `add_date` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`),
  KEY `type` (`type`)
) ENGINE=MyISAM AUTO_INCREMENT=246 DEFAULT CHARSET=utf8 COMMENT='账户日志';

-- ----------------------------
-- Records of xz_account_log
-- ----------------------------
INSERT INTO `xz_account_log` VALUES ('1', '1', '3', '320.00', '0.00', '11914.70', '201706230003中奖', '', '1498200647');
INSERT INTO `xz_account_log` VALUES ('2', '1', '3', '150.00', '0.00', '12032.70', '201706230003中奖', '', '1498200647');
INSERT INTO `xz_account_log` VALUES ('3', '1', '3', '150.00', '0.00', '12167.70', '201706230003中奖', '', '1498200647');
INSERT INTO `xz_account_log` VALUES ('4', '1', '3', '70.00', '0.00', '12222.70', '201706230003中奖', '', '1498200647');
INSERT INTO `xz_account_log` VALUES ('5', '20', '3', '70.00', '0.00', '8681.00', '201706230003中奖', '', '1498200647');
INSERT INTO `xz_account_log` VALUES ('6', '20', '3', '70.00', '0.00', '8744.00', '201706230003中奖', '', '1498200647');
INSERT INTO `xz_account_log` VALUES ('7', '20', '3', '70.00', '0.00', '8807.00', '201706230003中奖', '', '1498200647');
INSERT INTO `xz_account_log` VALUES ('8', '20', '3', '30.00', '0.00', '8830.00', '201706230003中奖', '', '1498200647');
INSERT INTO `xz_account_log` VALUES ('9', '20', '3', '30.00', '0.00', '8857.00', '201706230003中奖', '', '1498200647');
INSERT INTO `xz_account_log` VALUES ('10', '20', '3', '30.00', '0.00', '8884.00', '201706230003中奖', '', '1498200647');
INSERT INTO `xz_account_log` VALUES ('11', '20', '3', '30.00', '0.00', '8911.00', '201706230003中奖', '', '1498200647');
INSERT INTO `xz_account_log` VALUES ('12', '20', '3', '30.00', '0.00', '8938.00', '201706230003中奖', '', '1498200647');
INSERT INTO `xz_account_log` VALUES ('13', '20', '3', '30.00', '0.00', '8965.00', '201706230003中奖', '', '1498200647');
INSERT INTO `xz_account_log` VALUES ('14', '20', '3', '30.00', '0.00', '8992.00', '201706230003中奖', '', '1498200647');
INSERT INTO `xz_account_log` VALUES ('15', '20', '3', '30.00', '0.00', '9019.00', '201706230003中奖', '', '1498200647');
INSERT INTO `xz_account_log` VALUES ('16', '20', '3', '10.00', '0.00', '9026.00', '201706230003中奖', '', '1498200647');
INSERT INTO `xz_account_log` VALUES ('17', '20', '3', '10.00', '0.00', '9035.00', '201706230003中奖', '', '1498200647');
INSERT INTO `xz_account_log` VALUES ('18', '20', '3', '10.00', '0.00', '9044.00', '201706230003中奖', '', '1498200648');
INSERT INTO `xz_account_log` VALUES ('19', '20', '3', '10.00', '0.00', '9053.00', '201706230003中奖', '', '1498200648');
INSERT INTO `xz_account_log` VALUES ('20', '20', '3', '10.00', '0.00', '9062.00', '201706230003中奖', '', '1498200648');
INSERT INTO `xz_account_log` VALUES ('21', '20', '3', '10.00', '0.00', '9071.00', '201706230003中奖', '', '1498200648');
INSERT INTO `xz_account_log` VALUES ('22', '20', '3', '10.00', '0.00', '9080.00', '201706230003中奖', '', '1498200648');
INSERT INTO `xz_account_log` VALUES ('23', '20', '3', '10.00', '0.00', '9089.00', '201706230003中奖', '', '1498200648');
INSERT INTO `xz_account_log` VALUES ('24', '20', '3', '10.00', '0.00', '9098.00', '201706230003中奖', '', '1498200648');
INSERT INTO `xz_account_log` VALUES ('25', '20', '3', '10.00', '0.00', '9107.00', '201706230003中奖', '', '1498200648');
INSERT INTO `xz_account_log` VALUES ('26', '21', '3', '10.00', '0.00', '7271.00', '201706230003中奖', '', '1498200648');
INSERT INTO `xz_account_log` VALUES ('27', '22', '6', '1.00', '0.00', '8050.40', '轰炸奖', '', '1498200648');
INSERT INTO `xz_account_log` VALUES ('28', '21', '3', '10.00', '0.00', '7280.00', '201706230003中奖', '', '1498200648');
INSERT INTO `xz_account_log` VALUES ('29', '22', '6', '1.00', '0.00', '8051.30', '轰炸奖', '', '1498200648');
INSERT INTO `xz_account_log` VALUES ('30', '21', '3', '10.00', '0.00', '7289.00', '201706230003中奖', '', '1498200648');
INSERT INTO `xz_account_log` VALUES ('31', '22', '6', '1.00', '0.00', '8052.20', '轰炸奖', '', '1498200648');
INSERT INTO `xz_account_log` VALUES ('32', '21', '3', '10.00', '0.00', '7298.00', '201706230003中奖', '', '1498200648');
INSERT INTO `xz_account_log` VALUES ('33', '22', '6', '1.00', '0.00', '8053.10', '轰炸奖', '', '1498200648');
INSERT INTO `xz_account_log` VALUES ('34', '21', '3', '10.00', '0.00', '7307.00', '201706230003中奖', '', '1498200648');
INSERT INTO `xz_account_log` VALUES ('35', '22', '6', '1.00', '0.00', '8054.00', '轰炸奖', '', '1498200648');
INSERT INTO `xz_account_log` VALUES ('36', '21', '3', '10.00', '0.00', '7316.00', '201706230003中奖', '', '1498200648');
INSERT INTO `xz_account_log` VALUES ('37', '22', '6', '1.00', '0.00', '8054.90', '轰炸奖', '', '1498200648');
INSERT INTO `xz_account_log` VALUES ('38', '19', '3', '320.00', '0.00', '1302.80', '201706230004中奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('39', '22', '3', '150.00', '0.00', '8204.80', '201706230004中奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('40', '22', '3', '150.00', '0.00', '8339.80', '201706230004中奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('41', '22', '3', '70.00', '0.00', '8394.80', '201706230004中奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('42', '22', '3', '70.00', '0.00', '8457.80', '201706230004中奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('43', '22', '3', '70.00', '0.00', '8520.80', '201706230004中奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('44', '22', '3', '70.00', '0.00', '8583.80', '201706230004中奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('45', '22', '3', '30.00', '0.00', '8606.80', '201706230004中奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('46', '22', '3', '30.00', '0.00', '8633.80', '201706230004中奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('47', '22', '3', '30.00', '0.00', '8660.80', '201706230004中奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('48', '22', '3', '30.00', '0.00', '8687.80', '201706230004中奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('49', '22', '3', '30.00', '0.00', '8714.80', '201706230004中奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('50', '22', '3', '30.00', '0.00', '8741.80', '201706230004中奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('51', '22', '3', '30.00', '0.00', '8768.80', '201706230004中奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('52', '22', '3', '30.00', '0.00', '8795.80', '201706230004中奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('53', '22', '3', '10.00', '0.00', '8802.80', '201706230004中奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('54', '21', '3', '10.00', '0.00', '7325.00', '201706230004中奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('55', '22', '6', '1.00', '0.00', '8802.80', '轰炸奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('56', '21', '3', '10.00', '0.00', '7334.00', '201706230004中奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('57', '22', '6', '1.00', '0.00', '8803.70', '轰炸奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('58', '21', '3', '10.00', '0.00', '7343.00', '201706230004中奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('59', '22', '6', '1.00', '0.00', '8804.60', '轰炸奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('60', '21', '3', '10.00', '0.00', '7352.00', '201706230004中奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('61', '22', '6', '1.00', '0.00', '8805.50', '轰炸奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('62', '21', '3', '10.00', '0.00', '7361.00', '201706230004中奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('63', '22', '6', '1.00', '0.00', '8806.40', '轰炸奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('64', '21', '3', '10.00', '0.00', '7370.00', '201706230004中奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('65', '22', '6', '1.00', '0.00', '8807.30', '轰炸奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('66', '21', '3', '10.00', '0.00', '7379.00', '201706230004中奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('67', '22', '6', '1.00', '0.00', '8808.20', '轰炸奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('68', '20', '3', '10.00', '0.00', '9116.00', '201706230004中奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('69', '20', '3', '10.00', '0.00', '9125.00', '201706230004中奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('70', '20', '3', '10.00', '0.00', '9134.00', '201706230004中奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('71', '20', '3', '10.00', '0.00', '9143.00', '201706230004中奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('72', '20', '3', '10.00', '0.00', '9152.00', '201706230004中奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('73', '20', '3', '10.00', '0.00', '9161.00', '201706230004中奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('74', '20', '3', '10.00', '0.00', '9170.00', '201706230004中奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('75', '20', '3', '10.00', '0.00', '9179.00', '201706230004中奖', '', '1498200688');
INSERT INTO `xz_account_log` VALUES ('76', '1', '4', '7.50', '0.00', '12223.20', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('77', '20', '4', '7.50', '0.00', '9185.50', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('78', '20', '4', '7.50', '0.00', '9192.25', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('79', '20', '4', '7.50', '0.00', '9199.00', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('80', '20', '4', '7.50', '0.00', '9205.75', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('81', '20', '4', '7.50', '0.00', '9212.50', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('82', '20', '4', '7.50', '0.00', '9219.25', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('83', '20', '4', '7.50', '0.00', '9226.00', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('84', '20', '4', '7.50', '0.00', '9232.75', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('85', '20', '4', '7.50', '0.00', '9239.50', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('86', '20', '4', '7.50', '0.00', '9246.25', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('87', '20', '4', '7.50', '0.00', '9253.00', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('88', '20', '4', '7.50', '0.00', '9259.75', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('89', '20', '4', '7.50', '0.00', '9266.50', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('90', '20', '4', '7.50', '0.00', '9273.25', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('91', '20', '4', '7.50', '0.00', '9280.00', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('92', '20', '4', '7.50', '0.00', '9286.75', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('93', '20', '4', '7.50', '0.00', '9293.50', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('94', '20', '4', '7.50', '0.00', '9300.25', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('95', '20', '4', '7.50', '0.00', '9307.00', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('96', '20', '4', '7.50', '0.00', '9313.75', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('97', '20', '4', '7.50', '0.00', '9320.50', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('98', '21', '4', '7.50', '0.00', '7385.50', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('99', '21', '4', '7.50', '0.00', '7392.25', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('100', '21', '4', '7.50', '0.00', '7399.00', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('101', '21', '4', '7.50', '0.00', '7405.75', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('102', '21', '4', '7.50', '0.00', '7412.50', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('103', '21', '4', '7.50', '0.00', '7419.25', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('104', '21', '4', '7.50', '0.00', '7426.00', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('105', '21', '4', '7.50', '0.00', '7432.75', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('106', '21', '4', '7.50', '0.00', '7439.50', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('107', '21', '4', '7.50', '0.00', '7446.25', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('108', '21', '4', '7.50', '0.00', '7453.00', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('109', '21', '4', '7.50', '0.00', '7459.75', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('110', '21', '4', '7.50', '0.00', '7466.50', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('111', '21', '4', '7.50', '0.00', '7473.25', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('112', '21', '4', '7.50', '0.00', '7480.00', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('113', '21', '4', '7.50', '0.00', '7486.75', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('114', '21', '4', '7.50', '0.00', '7493.50', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('115', '21', '4', '7.50', '0.00', '7500.25', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('116', '21', '4', '7.50', '0.00', '7507.00', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('117', '21', '4', '7.50', '0.00', '7513.75', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('118', '21', '4', '7.50', '0.00', '7520.50', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('119', '21', '4', '7.50', '0.00', '7527.25', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('120', '19', '4', '7.50', '0.00', '1278.30', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('121', '22', '4', '7.50', '0.00', '8815.60', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('122', '22', '4', '7.50', '0.00', '8822.35', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('123', '22', '4', '7.50', '0.00', '8829.10', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('124', '22', '4', '7.50', '0.00', '8835.85', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('125', '22', '4', '7.50', '0.00', '8842.60', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('126', '22', '4', '7.50', '0.00', '8849.35', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('127', '22', '4', '7.50', '0.00', '8856.10', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('128', '22', '4', '7.50', '0.00', '8862.85', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('129', '22', '4', '7.50', '0.00', '8869.60', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('130', '22', '4', '7.50', '0.00', '8876.35', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('131', '22', '4', '7.50', '0.00', '8883.10', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('132', '22', '4', '7.50', '0.00', '8889.85', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('133', '22', '4', '7.50', '0.00', '8896.60', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('134', '22', '4', '7.50', '0.00', '8903.35', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('135', '22', '4', '7.50', '0.00', '8910.10', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('136', '22', '4', '7.50', '0.00', '8916.85', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('137', '22', '4', '7.50', '0.00', '8923.60', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('138', '22', '4', '7.50', '0.00', '8930.35', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('139', '22', '4', '7.50', '0.00', '8937.10', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('140', '22', '4', '7.50', '0.00', '8943.85', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('141', '22', '4', '7.50', '0.00', '8950.60', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('142', '22', '4', '7.50', '0.00', '8957.35', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('143', '22', '4', '7.50', '0.00', '8964.10', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('144', '22', '4', '7.50', '0.00', '8970.85', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('145', '22', '4', '7.50', '0.00', '8977.60', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('146', '22', '4', '7.50', '0.00', '8984.35', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('147', '22', '4', '7.50', '0.00', '8991.10', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('148', '22', '4', '7.50', '0.00', '8997.85', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('149', '21', '4', '7.50', '0.00', '7534.00', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('150', '21', '4', '7.50', '0.00', '7540.75', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('151', '21', '4', '7.50', '0.00', '7547.50', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('152', '21', '4', '7.50', '0.00', '7554.25', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('153', '21', '4', '7.50', '0.00', '7561.00', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('154', '21', '4', '7.50', '0.00', '7567.75', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('155', '21', '4', '7.50', '0.00', '7574.50', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('156', '20', '4', '7.50', '0.00', '9327.25', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('157', '20', '4', '7.50', '0.00', '9334.00', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('158', '20', '4', '7.50', '0.00', '9340.75', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('159', '20', '4', '7.50', '0.00', '9347.50', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('160', '20', '4', '7.50', '0.00', '9354.25', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('161', '20', '4', '7.50', '0.00', '9361.00', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('162', '20', '4', '7.50', '0.00', '9367.75', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('163', '20', '4', '7.50', '0.00', '9374.50', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('164', '20', '4', '7.50', '0.00', '9381.25', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('165', '16', '4', '7.50', '0.00', '26.50', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('166', '16', '4', '7.50', '0.00', '33.25', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('167', '16', '4', '7.50', '0.00', '40.00', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('168', '16', '4', '7.50', '0.00', '46.75', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('169', '16', '4', '7.50', '0.00', '53.50', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('170', '16', '4', '7.50', '0.00', '60.25', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('171', '16', '4', '7.50', '0.00', '67.00', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('172', '16', '4', '7.50', '0.00', '73.75', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('173', '16', '4', '7.50', '0.00', '80.50', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('174', '16', '4', '7.50', '0.00', '87.25', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('175', '17', '4', '7.50', '0.00', '7.50', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('176', '17', '4', '7.50', '0.00', '14.25', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('177', '17', '4', '7.50', '0.00', '21.00', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('178', '17', '4', '7.50', '0.00', '27.75', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('179', '17', '4', '7.50', '0.00', '34.50', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('180', '17', '4', '7.50', '0.00', '41.25', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('181', '17', '4', '7.50', '0.00', '48.00', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('182', '17', '4', '7.50', '0.00', '54.75', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('183', '17', '4', '7.50', '0.00', '61.50', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('184', '17', '4', '7.50', '0.00', '68.25', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('185', '17', '4', '7.50', '0.00', '75.00', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('186', '17', '4', '7.50', '0.00', '81.75', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('187', '17', '4', '7.50', '0.00', '88.50', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('188', '17', '4', '7.50', '0.00', '95.25', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('189', '17', '4', '7.50', '0.00', '102.00', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('190', '17', '4', '7.50', '0.00', '108.75', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('191', '17', '4', '7.50', '0.00', '115.50', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('192', '17', '4', '7.50', '0.00', '122.25', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('193', '17', '4', '7.50', '0.00', '129.00', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('194', '17', '4', '7.50', '0.00', '135.75', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('195', '17', '4', '7.50', '0.00', '142.50', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('196', '17', '4', '7.50', '0.00', '149.25', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('197', '17', '4', '7.50', '0.00', '156.00', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('198', '17', '4', '7.50', '0.00', '162.75', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('199', '17', '4', '7.50', '0.00', '169.50', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('200', '17', '4', '7.50', '0.00', '176.25', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('201', '17', '4', '7.50', '0.00', '183.00', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('202', '17', '4', '7.50', '0.00', '189.75', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('203', '17', '4', '7.50', '0.00', '196.50', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('204', '17', '4', '7.50', '0.00', '203.25', '订单收益', '', '1498201540');
INSERT INTO `xz_account_log` VALUES ('205', '1', '7', '4.00', '0.00', '12226.45', '2017-06-22领导奖', '', '1498201714');
INSERT INTO `xz_account_log` VALUES ('206', '1', '8', '5.00', '0.00', '12231.05', 'B网1层见点奖', '', '1498202079');
INSERT INTO `xz_account_log` VALUES ('207', '1', '8', '5.00', '0.00', '12235.55', 'B网1层见点奖', '', '1498202079');
INSERT INTO `xz_account_log` VALUES ('208', '23', '11', '58.00', '0.00', '58.00', '开户充值', null, '1498202716');
INSERT INTO `xz_account_log` VALUES ('209', '23', '0', '0.00', '58.00', '0.00', '会员开通购买', null, '1498202716');
INSERT INTO `xz_account_log` VALUES ('210', '16', '1', '3.00', '0.00', '89.50', '2层推荐奖', '', '1498202716');
INSERT INTO `xz_account_log` VALUES ('211', '1', '1', '2.00', '0.00', '12237.05', '3层推荐奖', '', '1498202716');
INSERT INTO `xz_account_log` VALUES ('212', '19', '2', '2.00', '0.00', '1279.55', '1层见点奖', '', '1498202716');
INSERT INTO `xz_account_log` VALUES ('213', '16', '2', '2.00', '0.00', '91.20', '2层见点奖', '', '1498202716');
INSERT INTO `xz_account_log` VALUES ('214', '16', '12', '100.00', '0.00', '191.00', '系统充值', null, '1498210352');
INSERT INTO `xz_account_log` VALUES ('215', '24', '11', '58.00', '0.00', '58.00', '开户充值', null, '1498290495');
INSERT INTO `xz_account_log` VALUES ('216', '24', '0', '0.00', '58.00', '0.00', '会员开通购买', null, '1498290495');
INSERT INTO `xz_account_log` VALUES ('217', '1', '1', '3.00', '0.00', '12239.85', '2层推荐奖', '', '1498290495');
INSERT INTO `xz_account_log` VALUES ('218', '20', '2', '2.00', '0.00', '9382.50', '1层见点奖', '', '1498290495');
INSERT INTO `xz_account_log` VALUES ('219', '18', '2', '2.00', '0.00', '5.60', '2层见点奖', '', '1498290495');
INSERT INTO `xz_account_log` VALUES ('220', '16', '2', '2.00', '0.00', '193.00', '3层见点奖', '', '1498290495');
INSERT INTO `xz_account_log` VALUES ('221', '25', '11', '58.00', '0.00', '58.00', '开户充值', null, '1498290512');
INSERT INTO `xz_account_log` VALUES ('222', '25', '0', '0.00', '58.00', '0.00', '会员开通购买', null, '1498290512');
INSERT INTO `xz_account_log` VALUES ('223', '1', '1', '3.00', '0.00', '12242.55', '2层推荐奖', '', '1498290512');
INSERT INTO `xz_account_log` VALUES ('224', '20', '2', '2.00', '0.00', '9384.30', '1层见点奖', '', '1498290512');
INSERT INTO `xz_account_log` VALUES ('225', '18', '2', '2.00', '0.00', '7.40', '2层见点奖', '', '1498290512');
INSERT INTO `xz_account_log` VALUES ('226', '16', '2', '2.00', '0.00', '194.80', '3层见点奖', '', '1498290512');
INSERT INTO `xz_account_log` VALUES ('227', '26', '11', '58.00', '0.00', '58.00', '开户充值', null, '1498290526');
INSERT INTO `xz_account_log` VALUES ('228', '26', '0', '0.00', '58.00', '0.00', '会员开通购买', null, '1498290526');
INSERT INTO `xz_account_log` VALUES ('229', '1', '1', '3.00', '0.00', '12245.25', '2层推荐奖', '', '1498290526');
INSERT INTO `xz_account_log` VALUES ('230', '20', '8', '5.00', '0.00', '9389.10', 'B网1层见点奖', '', '1498290526');
INSERT INTO `xz_account_log` VALUES ('231', '1', '8', '5.00', '0.00', '12249.95', 'B网2层见点奖', '', '1498290526');
INSERT INTO `xz_account_log` VALUES ('232', '21', '2', '2.00', '0.00', '7575.75', '1层见点奖', '', '1498290526');
INSERT INTO `xz_account_log` VALUES ('233', '18', '2', '2.00', '0.00', '9.20', '2层见点奖', '', '1498290526');
INSERT INTO `xz_account_log` VALUES ('234', '16', '2', '2.00', '0.00', '196.60', '3层见点奖', '', '1498290526');
INSERT INTO `xz_account_log` VALUES ('235', '27', '12', '1000.00', '0.00', '1000.00', '系统充值', null, '1498469507');
INSERT INTO `xz_account_log` VALUES ('236', '27', '0', '0.00', '58.00', '942.00', '会员开通购买', null, '1498470199');
INSERT INTO `xz_account_log` VALUES ('237', '1', '1', '3.00', '0.00', '12252.45', '2层推荐奖', '', '1498470199');
INSERT INTO `xz_account_log` VALUES ('238', '21', '2', '2.00', '0.00', '7577.55', '1层见点奖', '', '1498470199');
INSERT INTO `xz_account_log` VALUES ('239', '18', '2', '2.00', '0.00', '11.00', '2层见点奖', '', '1498470199');
INSERT INTO `xz_account_log` VALUES ('240', '16', '2', '2.00', '0.00', '198.40', '3层见点奖', '', '1498470199');
INSERT INTO `xz_account_log` VALUES ('241', '27', '0', '0.00', '58.00', '884.00', '会员开通购买', null, '1498470273');
INSERT INTO `xz_account_log` VALUES ('242', '1', '1', '3.00', '0.00', '12255.15', '2层推荐奖', '', '1498470273');
INSERT INTO `xz_account_log` VALUES ('243', '22', '2', '2.00', '0.00', '8999.10', '1层见点奖', '', '1498470273');
INSERT INTO `xz_account_log` VALUES ('244', '19', '2', '2.00', '0.00', '1281.35', '2层见点奖', '', '1498470273');
INSERT INTO `xz_account_log` VALUES ('245', '16', '2', '2.00', '0.00', '200.20', '3层见点奖', '', '1498470273');

-- ----------------------------
-- Table structure for xz_ad
-- ----------------------------
DROP TABLE IF EXISTS `xz_ad`;
CREATE TABLE `xz_ad` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL DEFAULT '',
  `type` tinyint(4) DEFAULT '101' COMMENT '101 轮播图 102 友情链接',
  `category_id` int(11) DEFAULT '0',
  `image` varchar(255) NOT NULL DEFAULT '',
  `link` varchar(255) NOT NULL DEFAULT '',
  `created_at` int(11) NOT NULL DEFAULT '0',
  `updated_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `i-type-category` (`type`,`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xz_ad
-- ----------------------------
INSERT INTO `xz_ad` VALUES ('6', '广告图一', '101', '0', '/uploads/ad-img/img_5933aafecb204.png', '#', '1496558334', '1496558334');
INSERT INTO `xz_ad` VALUES ('4', '活动一', '103', '0', '/uploads/ad-img/img_587c83cc17dff.jpg', '#', '1484555212', '1484555212');
INSERT INTO `xz_ad` VALUES ('5', '活动二', '103', '0', '/uploads/ad-img/img_587c83d8b8b23.jpg', '#', '1484555224', '1484555224');

-- ----------------------------
-- Table structure for xz_address
-- ----------------------------
DROP TABLE IF EXISTS `xz_address`;
CREATE TABLE `xz_address` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `consignee` varchar(50) DEFAULT NULL COMMENT '收货人姓名',
  `address` varchar(100) DEFAULT NULL COMMENT '收货地址',
  `mobile` char(11) DEFAULT NULL COMMENT '手机号',
  `area` varchar(50) DEFAULT NULL COMMENT '所在地区',
  `is_default` tinyint(1) unsigned DEFAULT '0' COMMENT '是否默认',
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='收货地址';

-- ----------------------------
-- Records of xz_address
-- ----------------------------
INSERT INTO `xz_address` VALUES ('1', '236', '一切都是', '你们也', '13867937473', '辽宁-抚顺市-市辖区', '1');
INSERT INTO `xz_address` VALUES ('2', '237', '是因为太', '一个人资料性别', '15067985777', '辽宁-抚顺市-市辖区', '1');
INSERT INTO `xz_address` VALUES ('3', '1', '公关部', '大家聚聚', '13881896085', '辽宁-抚顺市-市辖区', '0');
INSERT INTO `xz_address` VALUES ('4', '238', '头发', '在线', '13586525325', '辽宁-抚顺市-市辖区', '1');
INSERT INTO `xz_address` VALUES ('5', '239', '嘎嘣', '带回家', '13654698545', '辽宁-抚顺市-市辖区', '1');
INSERT INTO `xz_address` VALUES ('6', '241', 'xiao黑', '是你', '13819445301', '上海-县-崇明县', '1');
INSERT INTO `xz_address` VALUES ('7', '240', '邱石', '好还是好', '15316935610', '辽宁-抚顺市-市辖区', '0');
INSERT INTO `xz_address` VALUES ('10', '243', '文郎', '特么累咯', '15315273885', '辽宁-抚顺市', '1');
INSERT INTO `xz_address` VALUES ('8', '242', '这么着', '一个人资料', '15067985777', '辽宁-抚顺市-市辖区', '1');
INSERT INTO `xz_address` VALUES ('9', '240', '邱剑', '我的人都有一', '15306706913', '辽宁-抚顺市-市辖区', '1');
INSERT INTO `xz_address` VALUES ('11', '244', 'ggh', 'fff', '17096540319', '辽宁-抚顺市-市辖区', '1');
INSERT INTO `xz_address` VALUES ('12', '1', '王中', '要在地', '13526262562', '辽宁-抚顺市-市辖区', '1');
INSERT INTO `xz_address` VALUES ('13', '16', '王中22', '要在地', '13526262562', '辽宁-抚顺市-市辖区', '1');

-- ----------------------------
-- Table structure for xz_admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `xz_admin_menu`;
CREATE TABLE `xz_admin_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  `route` varchar(256) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `data` blob,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`),
  CONSTRAINT `xz_admin_menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `xz_admin_menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xz_admin_menu
-- ----------------------------
INSERT INTO `xz_admin_menu` VALUES ('1', '产品管理', null, '/backend/products/index', '0', 0x7B2269636F6E22203A2266612066612D7468227D);
INSERT INTO `xz_admin_menu` VALUES ('2', '产品分类', '1', '/backend/category/index?type=2', '1', null);
INSERT INTO `xz_admin_menu` VALUES ('3', '产品列表', '1', '/backend/products/index', '0', null);
INSERT INTO `xz_admin_menu` VALUES ('13', '提现日志', null, '/backend/withdraw/index', '5', 0x7B2269636F6E223A2266612066612D636F6D6D656E74696E67227D);
INSERT INTO `xz_admin_menu` VALUES ('14', '网站配置', null, '/backend/config/index', '6', 0x7B2269636F6E223A2266612066612D636F67227D);
INSERT INTO `xz_admin_menu` VALUES ('15', '基础配置', '14', '/backend/config/base-config', '1', null);
INSERT INTO `xz_admin_menu` VALUES ('16', '其他配置', '14', '/backend/config/index', '2', null);
INSERT INTO `xz_admin_menu` VALUES ('17', '轮播图片', '14', '/backend/ad/index', '3', null);
INSERT INTO `xz_admin_menu` VALUES ('18', '后台配置', null, '/backend/rbac/route/index', '7', 0x7B2269636F6E223A2266612066612D62617273227D);
INSERT INTO `xz_admin_menu` VALUES ('19', '管理员列表', '18', '/backend/admin-user/index', '1', null);
INSERT INTO `xz_admin_menu` VALUES ('20', '权限配置', '18', '/backend/rbac/assignment/index', '2', null);
INSERT INTO `xz_admin_menu` VALUES ('21', '角色列表', '18', '/backend/rbac/role/index', '3', null);
INSERT INTO `xz_admin_menu` VALUES ('22', '权限列表', '18', '/backend/rbac/permission/index', '4', null);
INSERT INTO `xz_admin_menu` VALUES ('23', '规则列表', '18', '/backend/rbac/rule/index', '5', null);
INSERT INTO `xz_admin_menu` VALUES ('24', '路由列表', '18', '/backend/rbac/route/index', '5', null);
INSERT INTO `xz_admin_menu` VALUES ('25', '后台菜单', '18', '/backend/rbac/menu/index', '7', null);
INSERT INTO `xz_admin_menu` VALUES ('26', '开发工具', null, '/gii/default/index', '8', 0x7B2269636F6E223A2266612066612D7368617265227D);
INSERT INTO `xz_admin_menu` VALUES ('27', 'gii', '26', '/gii/default/index', '2', null);
INSERT INTO `xz_admin_menu` VALUES ('28', 'debug', '26', '/debug/default/index', '1', null);
INSERT INTO `xz_admin_menu` VALUES ('30', '页面管理', '14', '/backend/page/index', '7', null);
INSERT INTO `xz_admin_menu` VALUES ('31', '活动图片', '14', '/backend/active/index', '5', null);
INSERT INTO `xz_admin_menu` VALUES ('32', '会员管理', null, null, '1', 0x7B2269636F6E22203A2266612066612D7468227D);
INSERT INTO `xz_admin_menu` VALUES ('33', '会员列表', '32', '/backend/member/index', '1', null);
INSERT INTO `xz_admin_menu` VALUES ('34', '订单管理', null, null, '3', 0x7B2269636F6E22203A2266612066612D7468227D);
INSERT INTO `xz_admin_menu` VALUES ('35', '订单列表', '34', '/backend/orders/index', '1', null);
INSERT INTO `xz_admin_menu` VALUES ('36', '公排池', null, null, '5', 0x7B2269636F6E22203A2266612066612D7468227D);
INSERT INTO `xz_admin_menu` VALUES ('37', '公排队列', '36', '/backend/public-row/a', '1', null);
INSERT INTO `xz_admin_menu` VALUES ('38', '导出待发货订单', '34', '/backend/orders/export', '2', null);
INSERT INTO `xz_admin_menu` VALUES ('39', '批量发货', '34', '/backend/orders/import', '3', null);

-- ----------------------------
-- Table structure for xz_admin_user
-- ----------------------------
DROP TABLE IF EXISTS `xz_admin_user`;
CREATE TABLE `xz_admin_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `access_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `u-username` (`username`),
  UNIQUE KEY `u-email` (`email`),
  UNIQUE KEY `u-password-reset-token` (`password_reset_token`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of xz_admin_user
-- ----------------------------
INSERT INTO `xz_admin_user` VALUES ('1', 'admin', '', '21232f297a57a5a743894a0e4a801fc3', null, '739800600@qq.com', '10', '', '0', '1484660891');
INSERT INTO `xz_admin_user` VALUES ('4', 'demo', '', 'fe01ce2a7fbac8fafaed7c982a04e229', null, 'demo@demo.com', '10', '', '1481431804', '1481431804');

-- ----------------------------
-- Table structure for xz_auth_assignment
-- ----------------------------
DROP TABLE IF EXISTS `xz_auth_assignment`;
CREATE TABLE `xz_auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `xz_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `xz_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of xz_auth_assignment
-- ----------------------------
INSERT INTO `xz_auth_assignment` VALUES ('Administrator', '1', '1482897657');
INSERT INTO `xz_auth_assignment` VALUES ('AdministratorAccess', '1', '1482897661');
INSERT INTO `xz_auth_assignment` VALUES ('VisitorAccess', '4', '1482897661');

-- ----------------------------
-- Table structure for xz_auth_item
-- ----------------------------
DROP TABLE IF EXISTS `xz_auth_item`;
CREATE TABLE `xz_auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `xz_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `xz_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of xz_auth_item
-- ----------------------------
INSERT INTO `xz_auth_item` VALUES ('/backend/*', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/active/create', '2', null, null, null, '1484554951', '1484554951');
INSERT INTO `xz_auth_item` VALUES ('/backend/active/delete', '2', null, null, null, '1484554952', '1484554952');
INSERT INTO `xz_auth_item` VALUES ('/backend/active/index', '2', null, null, null, '1484554951', '1484554951');
INSERT INTO `xz_auth_item` VALUES ('/backend/active/update', '2', null, null, null, '1484554952', '1484554952');
INSERT INTO `xz_auth_item` VALUES ('/backend/active/upload', '2', null, null, null, '1484554951', '1484554951');
INSERT INTO `xz_auth_item` VALUES ('/backend/active/view', '2', null, null, null, '1484554951', '1484554951');
INSERT INTO `xz_auth_item` VALUES ('/backend/ad/*', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/ad/create', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/ad/delete', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/ad/index', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/ad/update', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/ad/upload', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/ad/view', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/admin-user/*', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/admin-user/create', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/admin-user/delete', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/admin-user/index', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/admin-user/update', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/admin-user/upload', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/admin-user/view', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/category/*', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/category/create', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/category/delete', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/category/index', '2', null, null, null, '1482977677', '1482977677');
INSERT INTO `xz_auth_item` VALUES ('/backend/category/index?type=1', '2', null, null, null, '1482977712', '1482977712');
INSERT INTO `xz_auth_item` VALUES ('/backend/category/index?type=2', '2', null, null, null, '1482977717', '1482977717');
INSERT INTO `xz_auth_item` VALUES ('/backend/category/index?type=3', '2', null, null, null, '1482977721', '1482977721');
INSERT INTO `xz_auth_item` VALUES ('/backend/category/index?type=4', '2', null, null, null, '1482977728', '1482977728');
INSERT INTO `xz_auth_item` VALUES ('/backend/category/update', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/category/upload', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/category/view', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/config/*', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/config/base-config', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/config/create', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/config/delete', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/config/index', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/config/update', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/config/upload', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/config/view', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/config/view-config', '2', null, null, null, '1483066838', '1483066838');
INSERT INTO `xz_auth_item` VALUES ('/backend/default/*', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/default/edit-password', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/default/error', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/default/index', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/default/login', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/default/logout', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/downloads/*', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/downloads/create', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/downloads/delete', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/downloads/index', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/downloads/update', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/downloads/upload', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/downloads/view', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/feedback/*', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/feedback/delete', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/feedback/index', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/feedback/upload', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/feedback/view', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/member/index', '2', null, null, null, '1484661305', '1484661305');
INSERT INTO `xz_auth_item` VALUES ('/backend/member/lock', '2', null, null, null, '1484661305', '1484661305');
INSERT INTO `xz_auth_item` VALUES ('/backend/member/unlock', '2', null, null, null, '1484661305', '1484661305');
INSERT INTO `xz_auth_item` VALUES ('/backend/member/upload', '2', null, null, null, '1484661311', '1484661311');
INSERT INTO `xz_auth_item` VALUES ('/backend/news/*', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/news/create', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/news/delete', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/news/index', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/news/update', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/news/upload', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/news/view', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/orders/delete', '2', null, null, null, '1484664112', '1484664112');
INSERT INTO `xz_auth_item` VALUES ('/backend/orders/export', '2', null, null, null, '1484664112', '1484664112');
INSERT INTO `xz_auth_item` VALUES ('/backend/orders/import', '2', null, null, null, '1484664112', '1484664112');
INSERT INTO `xz_auth_item` VALUES ('/backend/orders/index', '2', null, null, null, '1484664112', '1484664112');
INSERT INTO `xz_auth_item` VALUES ('/backend/orders/shipments', '2', null, null, null, '1484664112', '1484664112');
INSERT INTO `xz_auth_item` VALUES ('/backend/orders/shipments-confirm', '2', null, null, null, '1484664112', '1484664112');
INSERT INTO `xz_auth_item` VALUES ('/backend/orders/upload', '2', null, null, null, '1484664112', '1484664112');
INSERT INTO `xz_auth_item` VALUES ('/backend/orders/view', '2', null, null, null, '1484664112', '1484664112');
INSERT INTO `xz_auth_item` VALUES ('/backend/page/*', '2', null, null, null, '1483164471', '1483164471');
INSERT INTO `xz_auth_item` VALUES ('/backend/page/create', '2', null, null, null, '1483164471', '1483164471');
INSERT INTO `xz_auth_item` VALUES ('/backend/page/delete', '2', null, null, null, '1483164471', '1483164471');
INSERT INTO `xz_auth_item` VALUES ('/backend/page/index', '2', null, null, null, '1483164471', '1483164471');
INSERT INTO `xz_auth_item` VALUES ('/backend/page/update', '2', null, null, null, '1483164471', '1483164471');
INSERT INTO `xz_auth_item` VALUES ('/backend/page/upload', '2', null, null, null, '1483164471', '1483164471');
INSERT INTO `xz_auth_item` VALUES ('/backend/page/view', '2', null, null, null, '1483164471', '1483164471');
INSERT INTO `xz_auth_item` VALUES ('/backend/photos/*', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/photos/create', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/photos/delete', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/photos/edit-detail', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/photos/index', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/photos/update', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/photos/upload', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/photos/upload-photo', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/photos/view', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/products/*', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/products/create', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/products/delete', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/products/index', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/products/update', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/products/upload', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/products/view', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/public-row/a', '2', null, null, null, '1485331816', '1485331816');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/*', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/assignment/*', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/assignment/assign', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/assignment/index', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/assignment/revoke', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/assignment/view', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/default/*', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/default/index', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/menu/*', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/menu/create', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/menu/delete', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/menu/index', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/menu/update', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/menu/view', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/permission/*', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/permission/assign', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/permission/create', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/permission/delete', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/permission/index', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/permission/remove', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/permission/update', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/permission/view', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/role/*', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/role/assign', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/role/create', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/role/delete', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/role/index', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/role/remove', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/role/update', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/role/view', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/route/*', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/route/assign', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/route/create', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/route/index', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/route/refresh', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/route/remove', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/rule/*', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/rule/create', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/rule/delete', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/rule/index', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/rule/update', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/rule/view', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/user/*', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/user/activate', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/user/change-password', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/user/delete', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/user/index', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/user/login', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/user/logout', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/user/request-password-reset', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/user/reset-password', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/user/signup', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/rbac/user/view', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/backend/withdraw/chuli', '2', null, null, null, '1485332669', '1485332669');
INSERT INTO `xz_auth_item` VALUES ('/backend/withdraw/confirm', '2', null, null, null, '1485332669', '1485332669');
INSERT INTO `xz_auth_item` VALUES ('/backend/withdraw/index', '2', null, null, null, '1485332669', '1485332669');
INSERT INTO `xz_auth_item` VALUES ('/debug/*', '2', null, null, null, '1482977163', '1482977163');
INSERT INTO `xz_auth_item` VALUES ('/debug/default/*', '2', null, null, null, '1482977163', '1482977163');
INSERT INTO `xz_auth_item` VALUES ('/debug/default/db-explain', '2', null, null, null, '1482977163', '1482977163');
INSERT INTO `xz_auth_item` VALUES ('/debug/default/download-mail', '2', null, null, null, '1482977163', '1482977163');
INSERT INTO `xz_auth_item` VALUES ('/debug/default/index', '2', null, null, null, '1482977163', '1482977163');
INSERT INTO `xz_auth_item` VALUES ('/debug/default/toolbar', '2', null, null, null, '1482977163', '1482977163');
INSERT INTO `xz_auth_item` VALUES ('/debug/default/view', '2', null, null, null, '1482977163', '1482977163');
INSERT INTO `xz_auth_item` VALUES ('/gii/*', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/gii/default/*', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/gii/default/action', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/gii/default/diff', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/gii/default/index', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/gii/default/preview', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('/gii/default/view', '2', null, null, null, '1482896720', '1482896720');
INSERT INTO `xz_auth_item` VALUES ('Administrator', '1', '超级管理员', null, null, '1482896582', '1482898405');
INSERT INTO `xz_auth_item` VALUES ('AdministratorAccess', '2', '超级管理员权限', null, null, '1482897169', '1482898428');
INSERT INTO `xz_auth_item` VALUES ('VisitorAccess', '2', '浏览者权限，只读权限', 'VisitorRule', null, '1482897866', '1482898974');

-- ----------------------------
-- Table structure for xz_auth_item_child
-- ----------------------------
DROP TABLE IF EXISTS `xz_auth_item_child`;
CREATE TABLE `xz_auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `xz_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `xz_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `xz_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `xz_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of xz_auth_item_child
-- ----------------------------
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/*');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/*');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/active/create');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/active/delete');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/active/index');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/active/update');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/active/upload');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/active/view');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/ad/*');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/ad/*');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/ad/create');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/ad/create');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/ad/delete');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/ad/delete');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/ad/index');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/ad/index');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/ad/update');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/ad/update');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/ad/upload');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/ad/upload');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/ad/view');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/ad/view');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/admin-user/*');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/admin-user/*');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/admin-user/create');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/admin-user/create');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/admin-user/delete');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/admin-user/delete');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/admin-user/index');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/admin-user/index');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/admin-user/update');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/admin-user/update');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/admin-user/upload');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/admin-user/upload');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/admin-user/view');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/admin-user/view');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/category/*');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/category/*');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/category/create');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/category/create');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/category/delete');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/category/delete');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/category/update');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/category/update');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/category/upload');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/category/upload');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/category/view');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/category/view');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/config/*');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/config/*');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/config/base-config');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/config/base-config');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/config/create');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/config/create');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/config/delete');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/config/delete');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/config/index');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/config/index');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/config/update');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/config/update');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/config/upload');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/config/upload');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/config/view');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/config/view');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/config/view-config');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/default/*');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/default/*');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/default/edit-password');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/default/edit-password');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/default/error');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/default/error');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/default/index');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/default/index');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/default/login');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/default/login');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/default/logout');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/default/logout');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/downloads/*');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/downloads/*');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/downloads/create');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/downloads/create');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/downloads/delete');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/downloads/delete');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/downloads/index');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/downloads/index');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/downloads/update');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/downloads/update');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/downloads/upload');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/downloads/upload');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/downloads/view');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/downloads/view');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/feedback/*');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/feedback/*');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/feedback/delete');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/feedback/delete');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/feedback/index');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/feedback/index');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/feedback/upload');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/feedback/upload');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/feedback/view');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/feedback/view');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/member/index');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/member/lock');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/member/unlock');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/member/upload');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/news/*');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/news/*');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/news/create');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/news/create');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/news/delete');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/news/delete');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/news/index');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/news/index');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/news/update');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/news/update');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/news/upload');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/news/upload');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/news/view');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/news/view');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/orders/delete');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/orders/export');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/orders/import');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/orders/index');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/orders/shipments');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/orders/shipments-confirm');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/orders/upload');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/orders/view');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/photos/*');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/photos/*');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/photos/create');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/photos/create');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/photos/delete');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/photos/delete');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/photos/edit-detail');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/photos/edit-detail');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/photos/index');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/photos/index');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/photos/update');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/photos/update');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/photos/upload');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/photos/upload');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/photos/upload-photo');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/photos/upload-photo');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/photos/view');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/photos/view');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/products/*');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/products/*');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/products/create');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/products/create');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/products/delete');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/products/delete');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/products/index');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/products/index');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/products/update');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/products/update');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/products/upload');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/products/upload');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/products/view');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/products/view');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/public-row/a');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/*');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/*');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/assignment/*');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/assignment/*');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/assignment/assign');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/assignment/assign');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/assignment/index');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/assignment/index');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/assignment/revoke');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/assignment/revoke');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/assignment/view');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/assignment/view');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/default/*');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/default/*');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/default/index');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/default/index');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/menu/*');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/menu/*');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/menu/create');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/menu/create');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/menu/delete');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/menu/delete');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/menu/index');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/menu/index');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/menu/update');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/menu/update');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/menu/view');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/menu/view');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/permission/*');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/permission/*');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/permission/assign');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/permission/assign');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/permission/create');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/permission/create');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/permission/delete');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/permission/delete');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/permission/index');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/permission/index');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/permission/remove');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/permission/remove');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/permission/update');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/permission/update');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/permission/view');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/permission/view');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/role/*');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/role/*');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/role/assign');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/role/assign');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/role/create');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/role/create');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/role/delete');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/role/delete');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/role/index');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/role/index');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/role/remove');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/role/remove');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/role/update');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/role/update');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/role/view');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/role/view');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/route/*');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/route/*');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/route/assign');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/route/assign');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/route/create');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/route/create');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/route/index');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/route/index');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/route/refresh');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/route/refresh');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/route/remove');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/route/remove');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/rule/*');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/rule/*');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/rule/create');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/rule/create');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/rule/delete');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/rule/delete');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/rule/index');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/rule/index');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/rule/update');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/rule/update');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/rule/view');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/rule/view');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/user/*');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/user/*');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/user/activate');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/user/activate');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/user/change-password');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/user/change-password');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/user/delete');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/user/delete');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/user/index');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/user/index');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/user/login');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/user/login');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/user/logout');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/user/logout');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/user/request-password-reset');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/user/request-password-reset');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/user/reset-password');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/user/reset-password');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/user/signup');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/user/signup');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/user/view');
INSERT INTO `xz_auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/user/view');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/withdraw/chuli');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/withdraw/confirm');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/backend/withdraw/index');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/debug/*');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/debug/default/*');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/debug/default/db-explain');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/debug/default/download-mail');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/debug/default/index');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/debug/default/toolbar');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/debug/default/view');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/gii/*');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/gii/default/*');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/gii/default/action');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/gii/default/diff');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/gii/default/index');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/gii/default/preview');
INSERT INTO `xz_auth_item_child` VALUES ('AdministratorAccess', '/gii/default/view');

-- ----------------------------
-- Table structure for xz_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `xz_auth_rule`;
CREATE TABLE `xz_auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of xz_auth_rule
-- ----------------------------
INSERT INTO `xz_auth_rule` VALUES ('VisitorRule', 'O:36:\"app\\modules\\backend\\rbac\\VisitorRule\":3:{s:4:\"name\";s:11:\"VisitorRule\";s:9:\"createdAt\";i:1482898941;s:9:\"updatedAt\";i:1482898941;}', '1482898941', '1482898941');

-- ----------------------------
-- Table structure for xz_cart
-- ----------------------------
DROP TABLE IF EXISTS `xz_cart`;
CREATE TABLE `xz_cart` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `goods_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '产品ID',
  `goods_name` varchar(100) NOT NULL COMMENT '产品名称',
  `buy_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '购买数量',
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='购物车';

-- ----------------------------
-- Records of xz_cart
-- ----------------------------

-- ----------------------------
-- Table structure for xz_category
-- ----------------------------
DROP TABLE IF EXISTS `xz_category`;
CREATE TABLE `xz_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '分类名',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父id',
  `type` tinyint(4) NOT NULL COMMENT '1.news 2 products 3 photo',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `i-type-pid` (`type`,`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xz_category
-- ----------------------------
INSERT INTO `xz_category` VALUES ('1', '报单产品', '0', '2', '1497585348', '1497585348');
INSERT INTO `xz_category` VALUES ('2', '血战产品', '0', '2', '1497585369', '1497585369');
INSERT INTO `xz_category` VALUES ('3', '兑换产品', '0', '2', '1497585376', '1497585376');

-- ----------------------------
-- Table structure for xz_config
-- ----------------------------
DROP TABLE IF EXISTS `xz_config`;
CREATE TABLE `xz_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '字段名英文',
  `label` varchar(50) DEFAULT NULL COMMENT '字段标注',
  `value` varchar(255) NOT NULL DEFAULT '' COMMENT '字段值',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `iu-name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xz_config
-- ----------------------------
INSERT INTO `xz_config` VALUES ('1', 'qq', 'QQ', '123456', '1484473174', '1484473174');
INSERT INTO `xz_config` VALUES ('2', 'tel', '400电话', '0558-88888888', '1484566932', '1484566932');

-- ----------------------------
-- Table structure for xz_content
-- ----------------------------
DROP TABLE IF EXISTS `xz_content`;
CREATE TABLE `xz_content` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '类型1news,2product3photo',
  `category_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
  `market_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `member_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '会员价',
  `description` varchar(255) NOT NULL DEFAULT '',
  `keywords` varchar(255) NOT NULL DEFAULT '',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0不显示1显示',
  `admin_user_id` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL DEFAULT '0',
  `updated_at` int(11) NOT NULL DEFAULT '0',
  `is_member` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否报单产品',
  `is_recommend` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否推荐产品',
  `max_point` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '最多抵扣积分',
  `stock` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '库存',
  `day_max_sell` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '每日最多销售',
  `day_sell` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '当日已销售',
  PRIMARY KEY (`id`),
  KEY `i-type-status-title` (`type`,`status`,`title`),
  KEY `i-update` (`updated_at`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xz_content
-- ----------------------------
INSERT INTO `xz_content` VALUES ('1', '会员报单产品', '2', '1', '/uploads/products-img/img_5943591f91c17.png', '100.00', '58.00', '', '', '1', '1', '1497585951', '1497585951', '1', '0', '0', '500', '0', '0');

-- ----------------------------
-- Table structure for xz_content_detail
-- ----------------------------
DROP TABLE IF EXISTS `xz_content_detail`;
CREATE TABLE `xz_content_detail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `content_id` int(11) NOT NULL,
  `detail` text NOT NULL,
  `params` varchar(1000) NOT NULL DEFAULT '',
  `file_url` varchar(255) NOT NULL DEFAULT '',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `i-content` (`content_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xz_content_detail
-- ----------------------------
INSERT INTO `xz_content_detail` VALUES ('1', '1', '<p>报单产品</p>', '<p>报单产品</p>', '', '1497585951', '1497585951');

-- ----------------------------
-- Table structure for xz_feedback
-- ----------------------------
DROP TABLE IF EXISTS `xz_feedback`;
CREATE TABLE `xz_feedback` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `subject` varchar(125) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT '',
  `phone` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `body` varchar(255) NOT NULL DEFAULT '',
  `created_at` int(11) NOT NULL DEFAULT '0',
  `updated_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xz_feedback
-- ----------------------------

-- ----------------------------
-- Table structure for xz_lottery
-- ----------------------------
DROP TABLE IF EXISTS `xz_lottery`;
CREATE TABLE `xz_lottery` (
  `period` char(30) NOT NULL COMMENT '开奖期数',
  `add_date` int(10) unsigned NOT NULL COMMENT '开奖时间',
  `first_member_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '头奖会员',
  PRIMARY KEY (`period`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='奖池';

-- ----------------------------
-- Records of xz_lottery
-- ----------------------------
INSERT INTO `xz_lottery` VALUES ('201706230001', '1498189915', '1');
INSERT INTO `xz_lottery` VALUES ('201706230002', '1498189951', '64');
INSERT INTO `xz_lottery` VALUES ('201706230003', '1498200647', '1');
INSERT INTO `xz_lottery` VALUES ('201706230004', '1498200688', '81');

-- ----------------------------
-- Table structure for xz_member
-- ----------------------------
DROP TABLE IF EXISTS `xz_member`;
CREATE TABLE `xz_member` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uno` char(20) DEFAULT NULL COMMENT '会员编号',
  `uname` char(20) DEFAULT NULL COMMENT '用户名',
  `nick_name` varchar(50) DEFAULT NULL COMMENT '昵称',
  `password_hash` char(100) DEFAULT NULL COMMENT '密码',
  `auth_key` char(100) DEFAULT NULL,
  `true_name` varchar(30) DEFAULT NULL COMMENT '真实姓名',
  `reg_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '会员状态',
  `recommender` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '推荐人',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '会员等级',
  `route` varchar(2000) DEFAULT NULL COMMENT '路由',
  `commissions` decimal(20,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '累计获得佣金',
  `balance` decimal(20,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '账户余额',
  `integral_balance` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '公排积分',
  `vouchers` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '代金券金额',
  `password_reset_token` char(100) DEFAULT NULL COMMENT '重置密码TOKEN',
  `avatar` varchar(150) DEFAULT NULL COMMENT '头像',
  `sex` varchar(20) DEFAULT NULL COMMENT '性别',
  `recomm_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '推荐人数',
  `depth` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '深度',
  `team` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '团队业绩',
  `split_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后一次结算时间',
  `day_fenghong` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '今日分红',
  `report_center` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否可以跨级报单',
  `api_token` char(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uno` (`uno`),
  UNIQUE KEY `uname` (`uname`),
  KEY `route` (`route`(333)),
  KEY `recommender` (`recommender`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COMMENT='会员表';

-- ----------------------------
-- Records of xz_member
-- ----------------------------
INSERT INTO `xz_member` VALUES ('1', '888000011E', '13588888888', '天一要', '$2y$13$cvX.7.UO9ZHItDBvYBYfK.o3pVcHZmca/gbrBPe9GhHfZeVMAsNrC', 'IlT9_X2Lo71hywVjCuEAJQ5NR3CVpekH', '小军', '1496828890', '1', '0', '1', ',1,', '13236.50', '12254.85', '1.35', '0.00', null, '', '1', '5', '0', '0.00', '1498060800', '8', '0', 'g53Gu5UP7sts-zJD0XVPBiFLJzWM1XlU_1498383838');
INSERT INTO `xz_member` VALUES ('16', '8880000G46', '15233333333', '张五', '$2y$13$1MPwQK..nTRNd4G0UZ8TPudDWZfCX2mDnP5Rjw3u5wAGZnnUNLCRG', '9IefUyb27ass6FiZd02za4Eopt_UUepB', null, '1497939565', '1', '1', '1', ',1,16,', '268.00', '200.00', '9.00', '0.00', null, null, null, '1', '1', '0.00', '0', '80', '0', 'Ld-eFdW0vz0eDjOx0nO1GqZ3frNzrKWi_1497939596');
INSERT INTO `xz_member` VALUES ('17', '8880000H4A', '15852525252', '张四', '$2y$13$7ZP6IbAOzL0n7AmzI0INqOnYJL7bbG478qgo4LCkvtMyGF/NlgSj6', 'ogVkLk039wdOrc5-H5z9NtZHO5tlx1TT', null, '1498187221', '1', '0', '1', ',17,', '225.00', '202.50', '22.50', '0.00', null, null, null, '0', '0', '0.00', '0', '240', '0', null);
INSERT INTO `xz_member` VALUES ('18', '8880000I86', '15852525253', '张四', '$2y$13$CKjbZa6YLPykZKiNqZ3GDuxoqz9lntlTtt7yQc53xnH8.OpLxhKvu', 'NqsIiR13-8uDby9wd004pmi2cfu4KgTu', null, '1498187255', '1', '0', '1', ',18,', '70.00', '10.80', '0.80', '0.00', null, null, null, '0', '0', '0.00', '0', '0', '0', null);
INSERT INTO `xz_member` VALUES ('19', '8880000JA4', '15236425262', '张四', '$2y$13$AjVTP6.Brlokpnlt8qtrwuts6ghbuk0cy4u5PwkwE56PqS6oP0lWO', 'Q8_HBh2k_eDcTW_5htKX6f2RopaZypZK', null, '1498187419', '1', '0', '1', ',19,', '481.50', '1281.15', '33.15', '0.00', null, null, null, '1', '0', '0.00', '0', '8', '0', null);
INSERT INTO `xz_member` VALUES ('20', '8880000K89', '15211111111', '56', '$2y$13$Ou1dLPxoVs79TWLxBVyZ5uCFSwrTCR5OwUsy.foJc.se8mkRtF6ge', 'pCaNIsw-MEkN9V7WpABBYyeM-Dz35DXt', null, '1498187445', '1', '19', '1', ',19,20,', '2712.00', '9388.60', '26.40', '0.00', null, null, null, '1', '1', '0.00', '0', '240', '0', null);
INSERT INTO `xz_member` VALUES ('21', '8880000LC9', '15222222222', '53', '$2y$13$9G7A/W5VWqUVzNSXWSddPutzmUrJ63NEbten7rTk9J6VEu3sXD4Ye', 'LuwY9smPhWCYzQdUdJChiTrLCwpiUtTA', null, '1498187574', '1', '20', '1', ',19,20,21,', '699.50', '7577.35', '35.15', '0.00', null, null, null, '1', '2', '0.00', '0', '232', '0', null);
INSERT INTO `xz_member` VALUES ('22', '8880000M04', '15233333334', '56', '$2y$13$xCNoR.R1fCl8kTM5lJYGj.8C4chbYteQe/zcXJZCMXNL9J4lnUopW', 'gksLMjLGe4SHjSUJEP8ucjKpx_tA7wxH', null, '1498187740', '1', '21', '1', ',19,20,21,22,', '2279.00', '8998.90', '45.50', '0.00', null, null, null, '0', '3', '0.00', '0', '224', '0', null);
INSERT INTO `xz_member` VALUES ('23', '8880000N10', '18955555555', '59', '$2y$13$mjiN2p74fbahvDZtgsu1CuVXQAbi4DaWIkCM5iNe7qQMlugMFwXK2', '34Gb6h_ODVddkovtPDexWKfqVOLzCYgP', null, '1498202716', '1', '16', '1', ',1,16,23,', '58.00', '0.00', '0.00', '0.00', null, null, null, '0', '2', '0.00', '0', '0', '0', null);
INSERT INTO `xz_member` VALUES ('24', '8880000OAD', '15263636363', '张三', '$2y$13$EcmhS6AIaA0ad7vn0zrTm.KgtoePTwl/cIYCW.FbDYNkTxdVZwera', '3n4sW1jJFjNqo0WikfDXgsbPUItfMpjp', null, '1498290495', '1', '1', '1', ',1,24,', '58.00', '0.00', '0.00', '0.00', null, null, null, '0', '1', '0.00', '0', '0', '0', null);
INSERT INTO `xz_member` VALUES ('25', '8880000PCA', '15856565656', '地三', '$2y$13$K8tJxbq6RdZJcEbmmDnVL.L0kO.WuqN/Hz8qGiibwE1eQvXVl6PHy', 'QynhsBxTkMSptB8rxY0_GH6fF81xllEv', null, '1498290512', '1', '1', '1', ',1,25,', '58.00', '0.00', '0.00', '0.00', null, null, null, '0', '1', '0.00', '0', '0', '0', null);
INSERT INTO `xz_member` VALUES ('26', '8880000Q25', '15425262523', '在地', '$2y$13$WYwMu4.XXVYROroj77gcc.CAPTuO4InHvVahbcC.5TIUUAB.UKj8i', '06G6RYGi59GjJe1teqGmcU1VQNQRFWn_', null, '1498290526', '1', '1', '1', ',1,26,', '58.00', '0.00', '0.00', '0.00', null, null, null, '0', '1', '0.00', '0', '0', '0', null);
INSERT INTO `xz_member` VALUES ('27', '8880000RB7', '15211111112', '张四', '$2y$13$NU4jTLnAGwQdfCexJ49R1ezwfe8d8BaqL0uluUUmAo/W8EE2QeVd.', 'zPznClZ2mtSGk92ys0yG4DrSOamnzZr9', null, '1498468117', '1', '1', '1', ',1,27,', '1000.00', '884.00', '0.00', '0.00', null, null, null, '0', '1', '0.00', '0', '0', '0', 'UsMhyAES9jO1CFlRBIv38r2vSgRL8DnE_1498470126');

-- ----------------------------
-- Table structure for xz_migration
-- ----------------------------
DROP TABLE IF EXISTS `xz_migration`;
CREATE TABLE `xz_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xz_migration
-- ----------------------------

-- ----------------------------
-- Table structure for xz_orders
-- ----------------------------
DROP TABLE IF EXISTS `xz_orders`;
CREATE TABLE `xz_orders` (
  `order_no` char(30) NOT NULL COMMENT '订单编号',
  `member_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `order_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '订单类型 1 报单订单 2 血战单 3 兑换单',
  `goods_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '产品ID',
  `goods_name` varchar(100) DEFAULT NULL COMMENT '产品名称',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '单价',
  `buy_count` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '购买数量',
  `point_amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '积分抵扣金额',
  `total` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '实际支付金额',
  `order_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '订单金额',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `pay_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '支付时间',
  `consignee` varchar(30) DEFAULT NULL COMMENT '收货人',
  `area` varchar(50) DEFAULT NULL COMMENT '地区',
  `address` varchar(100) DEFAULT NULL COMMENT '收货地址',
  `mobile` char(11) DEFAULT NULL COMMENT '收货人手机',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '订单状态',
  `over_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '完成时间',
  `express` char(20) DEFAULT NULL COMMENT '快递公司',
  `express_no` char(30) DEFAULT NULL COMMENT '快递单号',
  `fh_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发货时间',
  `fenghong` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '订单分红',
  `split_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分红时间',
  PRIMARY KEY (`order_no`),
  KEY `member_id` (`member_id`),
  KEY `order_type` (`order_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='会员资格购买单';

-- ----------------------------
-- Records of xz_orders
-- ----------------------------
INSERT INTO `xz_orders` VALUES ('1000161706201419253916', '1', '1', '1', '报单产品', '58.00', '1', '0.00', '58.00', '58.00', '1497939565', '1497939565', '王中', '辽宁-抚顺市-市辖区', '要在地', '13526262562', '1', '0', null, null, '0', '0.00', '0');
INSERT INTO `xz_orders` VALUES ('1000181706231107359790', '18', '1', '1', '报单产品', '58.00', '1', '0.00', '58.00', '58.00', '1498187255', '1498187255', null, null, null, null, '1', '0', null, null, '0', '0.00', '0');
INSERT INTO `xz_orders` VALUES ('1000191706231110199138', '19', '1', '1', '报单产品', '58.00', '1', '0.00', '58.00', '58.00', '1498187419', '1498187419', null, null, null, null, '1', '0', null, null, '0', '0.00', '0');
INSERT INTO `xz_orders` VALUES ('1000201706231110457394', '20', '1', '1', '报单产品', '58.00', '1', '0.00', '58.00', '58.00', '1498187445', '1498187445', null, null, null, null, '1', '0', null, null, '0', '0.00', '0');
INSERT INTO `xz_orders` VALUES ('1000211706231112549205', '21', '1', '1', '报单产品', '58.00', '1', '0.00', '58.00', '58.00', '1498187574', '1498187574', null, null, null, null, '1', '0', null, null, '0', '0.00', '0');
INSERT INTO `xz_orders` VALUES ('1000221706231115404818', '22', '1', '1', '报单产品', '58.00', '1', '0.00', '58.00', '58.00', '1498187740', '1498187740', null, null, null, null, '1', '0', null, null, '0', '0.00', '0');
INSERT INTO `xz_orders` VALUES ('1000231706231525168455', '23', '1', '1', '报单产品', '58.00', '1', '0.00', '58.00', '58.00', '1498202716', '1498202716', null, null, null, null, '1', '0', null, null, '0', '0.00', '0');
INSERT INTO `xz_orders` VALUES ('1000241706241548158792', '24', '1', '1', '报单产品', '58.00', '1', '0.00', '58.00', '58.00', '1498290495', '1498290495', null, null, null, null, '1', '0', null, null, '0', '0.00', '0');
INSERT INTO `xz_orders` VALUES ('1000251706241548327386', '25', '1', '1', '报单产品', '58.00', '1', '0.00', '58.00', '58.00', '1498290512', '1498290512', null, null, null, null, '1', '0', null, null, '0', '0.00', '0');
INSERT INTO `xz_orders` VALUES ('1000261706241548464814', '26', '1', '1', '报单产品', '58.00', '1', '0.00', '58.00', '58.00', '1498290526', '1498290526', null, null, null, null, '1', '0', null, null, '0', '0.00', '0');
INSERT INTO `xz_orders` VALUES ('1000271706261743196439', '27', '1', '1', '报单产品', '58.00', '1', '0.00', '58.00', '58.00', '1498470199', '1498470199', 'tte', '浙江浇灌', '中兴路一号', '13562626262', '1', '0', null, null, '0', '0.00', '0');
INSERT INTO `xz_orders` VALUES ('1000271706261744333840', '27', '1', '1', '报单产品', '58.00', '1', '0.00', '58.00', '58.00', '1498470273', '1498470273', 'tte', '浙江浇灌', '中兴路一号', '13562626262', '1', '0', null, null, '0', '0.00', '0');

-- ----------------------------
-- Table structure for xz_orders_detail
-- ----------------------------
DROP TABLE IF EXISTS `xz_orders_detail`;
CREATE TABLE `xz_orders_detail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_no` char(32) NOT NULL COMMENT '订单编号',
  `goods_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '产品ID',
  `goods_name` varchar(100) DEFAULT NULL COMMENT '产品名称',
  `price` decimal(10,2) unsigned DEFAULT '0.00' COMMENT '单价',
  `buy_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '购买数量',
  `total` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '小计',
  PRIMARY KEY (`id`),
  KEY `order_no` (`order_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='订单详情表';

-- ----------------------------
-- Records of xz_orders_detail
-- ----------------------------

-- ----------------------------
-- Table structure for xz_orders_fenghong
-- ----------------------------
DROP TABLE IF EXISTS `xz_orders_fenghong`;
CREATE TABLE `xz_orders_fenghong` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `order_no` char(30) NOT NULL COMMENT '订单编号',
  `order_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '订单金额',
  `member_paihao` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '会员订单排号',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `millisecond` smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT '毫秒',
  `lottery_number` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '开奖号',
  `lottery_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '开奖时间',
  `period` char(30) DEFAULT NULL COMMENT '开奖期数',
  `fh_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '分红金额',
  `day_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '当天分红金额',
  `split_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后一次分账时间',
  `chuju` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否出局',
  `chuju_date` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '出局时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `frequency` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '出局次数',
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_no` (`order_no`),
  KEY `member_id` (`member_id`)
) ENGINE=MyISAM AUTO_INCREMENT=136 DEFAULT CHARSET=utf8 COMMENT='血战订单';

-- ----------------------------
-- Records of xz_orders_fenghong
-- ----------------------------
INSERT INTO `xz_orders_fenghong` VALUES ('1', '1', '23043198796', '100.00', '1', '1498068000', '578', '1', '1498200647', '201706230003', '320.00', '0.00', '0', '1', '1498201140', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('2', '1', '25461916620', '100.00', '2', '1498068000', '28', '2', '1498200647', '201706230003', '150.00', '0.00', '0', '1', '1498201140', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('3', '1', '22787372601', '100.00', '3', '1498068000', '596', '3', '1498200647', '201706230003', '150.00', '0.00', '0', '1', '1498201140', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('4', '1', '22536246805', '100.00', '4', '1498068000', '415', '4', '1498200647', '201706230003', '85.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('5', '20', '23024843640', '100.00', '1', '1498068000', '196', '5', '1498200647', '201706230003', '85.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('6', '20', '23733105332', '100.00', '2', '1498068000', '321', '6', '1498200647', '201706230003', '85.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('7', '20', '23325413043', '100.00', '3', '1498068000', '946', '7', '1498200647', '201706230003', '85.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('8', '20', '22569879799', '100.00', '4', '1498068000', '559', '8', '1498200647', '201706230003', '45.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('9', '20', '21814696685', '100.00', '5', '1498068000', '609', '9', '1498200647', '201706230003', '45.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('10', '20', '22370969205', '100.00', '6', '1498068000', '64', '10', '1498200647', '201706230003', '45.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('11', '20', '22184161793', '100.00', '7', '1498068000', '639', '11', '1498200647', '201706230003', '45.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('12', '20', '27591176900', '100.00', '8', '1498068000', '15', '12', '1498200647', '201706230003', '45.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('13', '20', '24173963620', '100.00', '9', '1498068000', '387', '13', '1498200647', '201706230003', '45.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('14', '20', '22032031497', '100.00', '10', '1498068000', '124', '14', '1498200647', '201706230003', '45.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('15', '20', '21213997780', '100.00', '11', '1498068000', '784', '15', '1498200647', '201706230003', '45.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('16', '20', '22009823782', '100.00', '12', '1498068000', '473', '16', '1498200647', '201706230003', '25.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('17', '20', '23774265166', '100.00', '13', '1498068000', '989', '17', '1498200647', '201706230003', '25.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('18', '20', '23252161944', '100.00', '14', '1498068000', '234', '18', '1498200647', '201706230003', '25.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('19', '20', '25958881400', '100.00', '15', '1498068000', '481', '19', '1498200647', '201706230003', '25.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('20', '20', '23641825344', '100.00', '16', '1498068000', '984', '20', '1498200647', '201706230003', '25.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('21', '20', '22833203305', '100.00', '17', '1498068000', '215', '22', '1498200647', '201706230003', '25.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('22', '20', '22462564780', '100.00', '18', '1498068000', '53', '21', '1498200647', '201706230003', '25.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('23', '20', '22252203308', '100.00', '19', '1498068000', '559', '23', '1498200647', '201706230003', '25.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('24', '20', '23712077356', '100.00', '20', '1498068000', '876', '24', '1498200647', '201706230003', '25.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('25', '20', '22178123240', '100.00', '21', '1498068000', '882', '25', '1498200647', '201706230003', '25.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('26', '21', '23412457979', '100.00', '1', '1498068000', '66', '26', '1498200647', '201706230003', '25.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('27', '21', '21442387216', '100.00', '2', '1498068000', '661', '27', '1498200647', '201706230003', '25.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('28', '21', '22793464762', '100.00', '3', '1498068000', '235', '28', '1498200647', '201706230003', '25.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('29', '21', '21419893642', '100.00', '4', '1498068000', '505', '29', '1498200647', '201706230003', '25.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('30', '21', '23428936170', '100.00', '5', '1498068000', '564', '30', '1498200647', '201706230003', '25.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('31', '21', '27855651680', '100.00', '6', '1498068000', '824', '31', '1498200647', '201706230003', '25.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('32', '21', '23449824637', '100.00', '7', '1498068000', '876', '32', '1498200647', '201706230003', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('33', '21', '22394017532', '100.00', '8', '1498068000', '133', '33', '1498200647', '201706230003', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('34', '21', '21112027783', '100.00', '9', '1498068000', '342', '34', '1498200647', '201706230003', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('35', '21', '22444342957', '100.00', '10', '1498068000', '481', '35', '1498200647', '201706230003', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('36', '21', '26975430600', '100.00', '11', '1498068000', '747', '36', '1498200647', '201706230003', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('37', '21', '26211320000', '100.00', '12', '1498068000', '946', '37', '1498200647', '201706230003', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('38', '21', '23893269944', '100.00', '13', '1498068000', '68', '39', '1498200647', '201706230003', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('39', '21', '24173646924', '100.00', '14', '1498068000', '265', '40', '1498200647', '201706230003', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('40', '21', '21195739524', '100.00', '15', '1498068000', '465', '41', '1498200647', '201706230003', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('41', '21', '24025316202', '100.00', '16', '1498068000', '62', '38', '1498200647', '201706230003', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('42', '21', '23938508032', '100.00', '17', '1498068000', '862', '42', '1498200647', '201706230003', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('43', '21', '22750675650', '100.00', '18', '1498068000', '121', '44', '1498200647', '201706230003', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('44', '21', '21597819616', '100.00', '19', '1498068000', '376', '45', '1498200647', '201706230003', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('45', '21', '21330358108', '100.00', '20', '1498068000', '494', '46', '1498200647', '201706230003', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('46', '21', '24454681190', '100.00', '21', '1498068000', '63', '43', '1498200647', '201706230003', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('47', '21', '24199542543', '100.00', '22', '1498068000', '897', '47', '1498200647', '201706230003', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('48', '19', '22543357915', '100.00', '1', '1498068000', '606', '48', '1498200647', '201706230003', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('49', '22', '21542673781', '100.00', '1', '1498068000', '919', '49', '1498200647', '201706230003', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('50', '22', '24099417413', '100.00', '2', '1498068000', '203', '50', '1498200647', '201706230003', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('51', '22', '25669429600', '100.00', '3', '1498068000', '258', '51', '1498200647', '201706230003', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('52', '22', '24138247555', '100.00', '4', '1498068000', '521', '52', '1498200647', '201706230003', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('53', '22', '24094233428', '100.00', '5', '1498068000', '587', '53', '1498200647', '201706230003', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('54', '22', '23041789484', '100.00', '6', '1498068000', '867', '54', '1498200647', '201706230003', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('55', '22', '23692954269', '100.00', '7', '1498068000', '148', '55', '1498200647', '201706230003', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('56', '22', '23244948380', '100.00', '8', '1498068000', '784', '56', '1498200647', '201706230003', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('57', '22', '23931568431', '100.00', '9', '1498068000', '67', '58', '1498200647', '201706230003', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('58', '22', '22944209222', '100.00', '10', '1498068000', '29', '57', '1498200647', '201706230003', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('59', '22', '22106621460', '100.00', '11', '1498068000', '339', '59', '1498200647', '201706230003', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('60', '22', '23492043037', '100.00', '12', '1498068000', '595', '60', '1498200647', '201706230003', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('61', '22', '23143101806', '100.00', '13', '1498068000', '813', '61', '1498200647', '201706230003', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('62', '22', '25860371300', '100.00', '14', '1498068000', '893', '62', '1498200647', '201706230003', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('63', '22', '21112618252', '100.00', '15', '1498068000', '165', '63', '1498200647', '201706230003', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('64', '22', '24270811360', '100.00', '16', '1498068000', '431', '2', '1498200688', '201706230004', '150.00', '0.00', '0', '1', '1498201140', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('65', '22', '23060579420', '100.00', '17', '1498068000', '649', '3', '1498200688', '201706230004', '150.00', '0.00', '0', '1', '1498201140', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('66', '22', '25797667700', '100.00', '18', '1498068000', '721', '4', '1498200688', '201706230004', '85.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('67', '22', '24269538869', '100.00', '19', '1498068000', '973', '5', '1498200688', '201706230004', '85.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('68', '22', '29489318130', '100.00', '20', '1498068000', '187', '6', '1498200688', '201706230004', '85.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('69', '22', '21865840555', '100.00', '21', '1498068000', '272', '7', '1498200688', '201706230004', '85.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('70', '22', '22051336690', '100.00', '22', '1498068000', '491', '8', '1498200688', '201706230004', '45.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('71', '22', '21364063780', '100.00', '23', '1498068000', '754', '9', '1498200688', '201706230004', '45.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('72', '22', '24249340468', '100.00', '24', '1498068000', '991', '10', '1498200688', '201706230004', '45.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('73', '22', '24190119013', '100.00', '25', '1498068000', '25', '11', '1498200688', '201706230004', '45.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('74', '22', '22004467313', '100.00', '26', '1498068000', '254', '12', '1498200688', '201706230004', '45.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('75', '22', '24235241327', '100.00', '27', '1498068000', '923', '13', '1498200688', '201706230004', '45.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('76', '22', '21761918098', '100.00', '28', '1498068000', '138', '14', '1498200688', '201706230004', '45.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('77', '22', '23261301676', '100.00', '29', '1498068000', '565', '15', '1498200688', '201706230004', '45.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('78', '22', '23258557805', '100.00', '30', '1498068000', '837', '16', '1498200688', '201706230004', '25.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('79', '21', '21848193847', '100.00', '23', '1498068000', '146', '17', '1498200688', '201706230004', '25.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('80', '21', '23727490737', '100.00', '24', '1498068000', '671', '18', '1498200688', '201706230004', '25.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('81', '19', '28990057510', '100.00', '25', '1498068000', '167', '1', '1498200688', '201706230004', '320.00', '0.00', '0', '1', '1498201140', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('82', '21', '21502053651', '100.00', '26', '1498068000', '313', '20', '1498200688', '201706230004', '25.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('83', '21', '22244354831', '100.00', '27', '1498068000', '58', '19', '1498200688', '201706230004', '25.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('84', '21', '22703053774', '100.00', '28', '1498068000', '819', '21', '1498200688', '201706230004', '25.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('85', '21', '24050764383', '100.00', '29', '1498068000', '58', '22', '1498200688', '201706230004', '25.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('86', '21', '23819828231', '100.00', '30', '1498068000', '117', '23', '1498200688', '201706230004', '25.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('87', '20', '25411782650', '100.00', '22', '1498068000', '36', '24', '1498200688', '201706230004', '25.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('88', '20', '22939595013', '100.00', '23', '1498068000', '661', '25', '1498200688', '201706230004', '25.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('89', '20', '26030627900', '100.00', '24', '1498068000', '68', '26', '1498200688', '201706230004', '25.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('90', '20', '21234451706', '100.00', '25', '1498068000', '339', '27', '1498200688', '201706230004', '25.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('91', '20', '27921078990', '100.00', '26', '1498068000', '606', '28', '1498200688', '201706230004', '25.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('92', '20', '21818056070', '100.00', '27', '1498068000', '916', '29', '1498200688', '201706230004', '25.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('93', '20', '28598801450', '100.00', '28', '1498068000', '181', '30', '1498200688', '201706230004', '25.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('94', '20', '24298580200', '100.00', '29', '1498068000', '451', '31', '1498200688', '201706230004', '25.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('95', '20', '22483245300', '100.00', '30', '1498068000', '709', '32', '1498200688', '201706230004', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('96', '16', '28647731580', '100.00', '1', '1498068000', '152', '33', '1498200688', '201706230004', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('97', '16', '22000679195', '100.00', '2', '1498068000', '688', '34', '1498200688', '201706230004', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('98', '16', '21430475716', '100.00', '3', '1498068000', '33', '35', '1498200688', '201706230004', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('99', '16', '24159876420', '100.00', '4', '1498068000', '299', '37', '1498200688', '201706230004', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('100', '16', '21137856736', '100.00', '5', '1498068000', '565', '38', '1498200688', '201706230004', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('101', '16', '22308379224', '100.00', '6', '1498068000', '61', '36', '1498200688', '201706230004', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('102', '16', '29479883380', '100.00', '7', '1498068000', '874', '39', '1498200688', '201706230004', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('103', '16', '22501291268', '100.00', '8', '1498068000', '145', '40', '1498200688', '201706230004', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('104', '16', '24003929547', '100.00', '9', '1498068000', '418', '41', '1498200688', '201706230004', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('105', '16', '22147117203', '100.00', '10', '1498068000', '471', '42', '1498200688', '201706230004', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('106', '17', '24370994030', '100.00', '1', '1498068000', '203', '44', '1498200688', '201706230004', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('107', '17', '21104937822', '100.00', '2', '1498068000', '75', '43', '1498200688', '201706230004', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('108', '17', '22637140761', '100.00', '3', '1498068000', '31', '46', '1498200688', '201706230004', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('109', '17', '23124592762', '100.00', '4', '1498068000', '44', '47', '1498200688', '201706230004', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('110', '17', '21864145815', '100.00', '5', '1498068000', '29', '45', '1498200688', '201706230004', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('111', '17', '23624197065', '100.00', '6', '1498068000', '564', '48', '1498200688', '201706230004', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('112', '17', '22470688969', '100.00', '7', '1498068000', '621', '49', '1498200688', '201706230004', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('113', '17', '28579331600', '100.00', '8', '1498068000', '887', '50', '1498200688', '201706230004', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('114', '17', '23915326561', '100.00', '9', '1498068000', '97', '51', '1498200688', '201706230004', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('115', '17', '23078158653', '100.00', '10', '1498068000', '231', '52', '1498200688', '201706230004', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('116', '17', '23542892090', '100.00', '11', '1498068000', '954', '53', '1498200688', '201706230004', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('117', '17', '22341015010', '100.00', '12', '1498068000', '537', '55', '1498200688', '201706230004', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('118', '17', '24058426722', '100.00', '13', '1498068000', '92', '54', '1498200688', '201706230004', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('119', '17', '21519839133', '100.00', '14', '1498068000', '179', '56', '1498200688', '201706230004', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('120', '17', '22305785176', '100.00', '15', '1498068000', '449', '57', '1498200688', '201706230004', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('121', '17', '26797472590', '100.00', '16', '1498068000', '663', '58', '1498200688', '201706230004', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('122', '17', '21954429380', '100.00', '17', '1498068000', '742', '59', '1498200688', '201706230004', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('123', '17', '23823440416', '100.00', '18', '1498068000', '996', '60', '1498200688', '201706230004', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('124', '17', '24894128900', '100.00', '19', '1498068000', '254', '61', '1498200688', '201706230004', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('125', '17', '23001805536', '100.00', '20', '1498068000', '302', '62', '1498200688', '201706230004', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('126', '17', '23494772260', '100.00', '21', '1498068000', '564', '63', '1498200688', '201706230004', '15.00', '7.50', '1498060800', '0', '0', '1', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('127', '17', '22162733409', '100.00', '22', '1498068000', '786', '0', '0', '', '15.00', '7.50', '1498060800', '0', '0', '0', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('128', '17', '27620387340', '100.00', '23', '1498068000', '42', '0', '0', '', '15.00', '7.50', '1498060800', '0', '0', '0', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('129', '17', '27454921450', '100.00', '24', '1498068000', '262', '0', '0', '', '15.00', '7.50', '1498060800', '0', '0', '0', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('130', '17', '21141918770', '100.00', '25', '1498068000', '317', '0', '0', '', '15.00', '7.50', '1498060800', '0', '0', '0', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('131', '17', '24016544213', '100.00', '26', '1498068000', '576', '0', '0', '', '15.00', '7.50', '1498060800', '0', '0', '0', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('132', '17', '28226437920', '100.00', '27', '1498068000', '828', '0', '0', '', '15.00', '7.50', '1498060800', '0', '0', '0', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('133', '17', '21164240886', '100.00', '28', '1498068000', '53', '0', '0', '', '15.00', '7.50', '1498060800', '0', '0', '0', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('134', '17', '21917375782', '100.00', '29', '1498068000', '257', '0', '0', '', '15.00', '7.50', '1498060800', '0', '0', '0', '0');
INSERT INTO `xz_orders_fenghong` VALUES ('135', '17', '28710082220', '100.00', '30', '1498068000', '366', '0', '0', '', '15.00', '7.50', '1498060800', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for xz_page
-- ----------------------------
DROP TABLE IF EXISTS `xz_page`;
CREATE TABLE `xz_page` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `keyword` varchar(100) NOT NULL DEFAULT '',
  `template` varchar(100) NOT NULL DEFAULT '' COMMENT '模板路径',
  `content` text NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xz_page
-- ----------------------------

-- ----------------------------
-- Table structure for xz_public_row
-- ----------------------------
DROP TABLE IF EXISTS `xz_public_row`;
CREATE TABLE `xz_public_row` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '公排号',
  `order_id` char(32) NOT NULL COMMENT '订单编号',
  `member_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `send_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '发放金额',
  `layer` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '层数',
  `parent_node` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上一级点',
  `parent_route` varchar(1000) DEFAULT NULL COMMENT '上一级路由',
  `column` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '第几列',
  `is_chu` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否出局',
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='公排池';

-- ----------------------------
-- Records of xz_public_row
-- ----------------------------
INSERT INTO `xz_public_row` VALUES ('1', '1000161706201419253916', '16', '22.00', '1', '0', ',1,', '1', '0');
INSERT INTO `xz_public_row` VALUES ('2', '1000181706231107359790', '18', '12.00', '2', '1', ',1,2,', '1', '0');
INSERT INTO `xz_public_row` VALUES ('3', '1000191706231110199138', '19', '6.00', '2', '1', ',1,3,', '2', '0');
INSERT INTO `xz_public_row` VALUES ('4', '1000201706231110457394', '20', '4.00', '3', '2', ',1,2,4,', '1', '0');
INSERT INTO `xz_public_row` VALUES ('5', '1000211706231112549205', '21', '4.00', '3', '2', ',1,2,5,', '2', '0');
INSERT INTO `xz_public_row` VALUES ('6', '1000221706231115404818', '22', '2.00', '3', '3', ',1,3,6,', '3', '0');
INSERT INTO `xz_public_row` VALUES ('7', '1000231706231525168455', '23', '0.00', '3', '3', ',1,3,7,', '4', '0');
INSERT INTO `xz_public_row` VALUES ('8', '1000241706241548158792', '24', '0.00', '4', '4', ',1,2,4,8,', '1', '0');
INSERT INTO `xz_public_row` VALUES ('9', '1000251706241548327386', '25', '0.00', '4', '4', ',1,2,4,9,', '2', '0');
INSERT INTO `xz_public_row` VALUES ('10', '1000261706241548464814', '26', '0.00', '4', '5', ',1,2,5,10,', '3', '0');
INSERT INTO `xz_public_row` VALUES ('11', '1000271706261743196439', '27', '0.00', '4', '5', ',1,2,5,11,', '4', '0');
INSERT INTO `xz_public_row` VALUES ('12', '1000271706261743196439', '27', '0.00', '4', '6', ',1,3,6,12,', '5', '0');

-- ----------------------------
-- Table structure for xz_public_row_b
-- ----------------------------
DROP TABLE IF EXISTS `xz_public_row_b`;
CREATE TABLE `xz_public_row_b` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '公排号',
  `member_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `send_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '发放金额',
  `layer` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '层数',
  `parent_node` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上一级点',
  `parent_route` varchar(1000) DEFAULT NULL COMMENT '上一级路由',
  `column` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '第几列',
  `is_chu` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否出局',
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='B网公排池';

-- ----------------------------
-- Records of xz_public_row_b
-- ----------------------------
INSERT INTO `xz_public_row_b` VALUES ('1', '1', '15.00', '1', '0', ',1,', '1', '0');
INSERT INTO `xz_public_row_b` VALUES ('2', '20', '5.00', '2', '1', ',1,2,', '1', '0');
INSERT INTO `xz_public_row_b` VALUES ('3', '22', '0.00', '2', '1', ',1,3,', '2', '0');
INSERT INTO `xz_public_row_b` VALUES ('4', '1', '0.00', '3', '2', ',1,2,4,', '1', '0');

-- ----------------------------
-- Table structure for xz_recharge
-- ----------------------------
DROP TABLE IF EXISTS `xz_recharge`;
CREATE TABLE `xz_recharge` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_no` char(20) NOT NULL COMMENT '订单编号',
  `member_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `recharge_money` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '充值金额',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `pay_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '支付时间',
  `pay_type` char(20) DEFAULT NULL COMMENT '支付方式',
  `pay_no` char(50) DEFAULT NULL COMMENT '支付单号',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_no` (`order_no`),
  KEY `member_id` (`member_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='充值表';

-- ----------------------------
-- Records of xz_recharge
-- ----------------------------
INSERT INTO `xz_recharge` VALUES ('1', '62337638243', '1', '100', '1498121711', '1498124532', 'alipay', '432222', '1');
INSERT INTO `xz_recharge` VALUES ('2', '61749340683', '1', '100', '1498121729', '0', null, null, '0');
INSERT INTO `xz_recharge` VALUES ('3', '63499726674', '1', '100', '1498121974', '0', null, null, '0');
INSERT INTO `xz_recharge` VALUES ('4', '62829239910', '1', '100', '1498121986', '0', null, null, '0');
INSERT INTO `xz_recharge` VALUES ('5', '63418803279', '1', '100', '1498122042', '0', null, null, '0');
INSERT INTO `xz_recharge` VALUES ('6', '61066581105', '1', '100', '1498122103', '0', null, null, '0');
INSERT INTO `xz_recharge` VALUES ('7', '63610136759', '1', '100', '1498122166', '0', null, null, '0');

-- ----------------------------
-- Table structure for xz_session
-- ----------------------------
DROP TABLE IF EXISTS `xz_session`;
CREATE TABLE `xz_session` (
  `id` char(40) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` longblob,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xz_session
-- ----------------------------
INSERT INTO `xz_session` VALUES ('ne7c6q1qj6idknt83v67brvji2', '1498470949', 0x5F5F666C6173687C613A303A7B7D5F5F72657475726E55726C7C733A32313A222F6261636B656E642F6D656D6265722F696E646578223B5F5F69647C693A313B);
INSERT INTO `xz_session` VALUES ('6jmosekemu9bc7hjqe4os8hkd4', '1497856115', 0x5F5F666C6173687C613A303A7B7D5F5F72657475726E55726C7C733A32323A222F6261636B656E642F64656661756C742F6C6F67696E223B);
INSERT INTO `xz_session` VALUES ('dntu8ugkboadsvkbohkkvu76d6', '1497864285', 0x5F5F666C6173687C613A303A7B7D5F5F69647C733A313A2231223B);
INSERT INTO `xz_session` VALUES ('7kj8gi213f6b51fqq6bh9not77', '1497952568', 0x5F5F666C6173687C613A303A7B7D5F5F69647C733A313A2231223B);
INSERT INTO `xz_session` VALUES ('lfsa39o13b18j54k6hfflvud63', '1497931386', 0x5F5F666C6173687C613A303A7B7D5F5F72657475726E55726C7C733A32323A222F6261636B656E642F64656661756C742F6C6F67696E223B);
INSERT INTO `xz_session` VALUES ('9931q7qvcvi5scoaoi3mfnv612', '1498028529', 0x5F5F666C6173687C613A303A7B7D5F5F69647C733A313A2231223B);
INSERT INTO `xz_session` VALUES ('9ivvvkem0icimavrrp9mcmd186', '1498471713', 0x5F5F666C6173687C613A303A7B7D5F5F69647C733A323A223237223B);

-- ----------------------------
-- Table structure for xz_withdraw
-- ----------------------------
DROP TABLE IF EXISTS `xz_withdraw`;
CREATE TABLE `xz_withdraw` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `draw_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '提现金额',
  `pay_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '实付金额',
  `add_time` int(10) unsigned DEFAULT '0' COMMENT '添加时间',
  `cash_time` int(10) unsigned DEFAULT '0' COMMENT '提现时间',
  `status` tinyint(1) unsigned DEFAULT '0' COMMENT '状态',
  `pay_no` char(32) DEFAULT NULL COMMENT '支付单号',
  `withdraw_type` char(20) NOT NULL DEFAULT '0' COMMENT '提现类型',
  `bank_name` varchar(50) DEFAULT NULL COMMENT '银行名称',
  `card_no` char(20) DEFAULT NULL COMMENT '银行卡号',
  `true_name` char(32) DEFAULT NULL COMMENT '真实姓名',
  `alipay_no` varchar(50) DEFAULT NULL COMMENT '支付宝号',
  `friend_no` varchar(50) DEFAULT NULL COMMENT '朋友号',
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='提现表';

-- ----------------------------
-- Records of xz_withdraw
-- ----------------------------
INSERT INTO `xz_withdraw` VALUES ('1', '1', '100.00', '90.00', '1497949306', '0', '0', null, 'alipay', null, null, '真实姓名', 'test@df.com', null);
