/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50717
Source Host           : localhost:3306
Source Database       : database

Target Server Type    : MYSQL
Target Server Version : 50717
File Encoding         : 65001

Date: 2017-05-26 20:23:12
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admin`
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `Admin_ID` char(8) NOT NULL COMMENT '管理员ID',
  `Admin_Name` varchar(20) NOT NULL COMMENT '管理员账户（只允许数字英文字母和下划线）',
  `Admin_Password` varchar(50) NOT NULL COMMENT '管理员密码（只允许数字英文字母和下划线）',
  PRIMARY KEY (`Admin_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin
-- ----------------------------

-- ----------------------------
-- Table structure for `city`
-- ----------------------------
DROP TABLE IF EXISTS `city`;
CREATE TABLE `city` (
  `City_ID` char(8) NOT NULL COMMENT '城市编号',
  `City_Name` varchar(20) NOT NULL COMMENT '城市名称',
  `Province_Name` varchar(20) NOT NULL COMMENT '城市所属省份',
  PRIMARY KEY (`City_ID`),
  KEY `City_Name` (`City_Name`),
  KEY `Province_Name` (`Province_Name`) USING BTREE,
  CONSTRAINT `Province_Name` FOREIGN KEY (`Province_Name`) REFERENCES `province` (`Province_Name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of city
-- ----------------------------

-- ----------------------------
-- Table structure for `oorder`
-- ----------------------------
DROP TABLE IF EXISTS `oorder`;
CREATE TABLE `oorder` (
  `Order_ID` char(8) NOT NULL COMMENT '订单编号',
  `User_ID1` char(8) NOT NULL COMMENT '卖方用户ID',
  `User_ID2` char(8) NOT NULL COMMENT '买方用户ID',
  `Order_Time` int(8) NOT NULL COMMENT '订单生成时间',
  `Order_Count` smallint(6) NOT NULL COMMENT '订单交易的门票数量',
  `Order_State` char(2) NOT NULL DEFAULT '1' COMMENT '订单状态（1未审核 2审核通过 3待收货 4已完成）',
  PRIMARY KEY (`Order_ID`),
  KEY `User_ID1` (`User_ID1`) USING BTREE,
  KEY `User_ID2` (`User_ID2`) USING BTREE,
  CONSTRAINT `oorder_ibfk_1` FOREIGN KEY (`User_ID1`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `oorder_ibfk_2` FOREIGN KEY (`User_ID2`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of oorder
-- ----------------------------

-- ----------------------------
-- Table structure for `order`
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `Order_ID` char(8) NOT NULL COMMENT '订单编号',
  `User_ID1` char(8) NOT NULL COMMENT '卖方用户ID',
  `User_ID2` char(8) NOT NULL COMMENT '买方用户ID',
  `Order_Time` int(8) NOT NULL COMMENT '订单生成时间',
  `Order_Count` smallint(6) NOT NULL COMMENT '订单交易的门票数量',
  `Order_State` char(2) NOT NULL DEFAULT '1' COMMENT '订单状态（1未审核 2审核通过 3待收货 4已完成）',
  PRIMARY KEY (`Order_ID`),
  KEY `User_ID1` (`User_ID1`) USING BTREE,
  KEY `User_ID2` (`User_ID2`) USING BTREE,
  CONSTRAINT `User_ID1` FOREIGN KEY (`User_ID1`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `User_ID2` FOREIGN KEY (`User_ID2`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order
-- ----------------------------

-- ----------------------------
-- Table structure for `province`
-- ----------------------------
DROP TABLE IF EXISTS `province`;
CREATE TABLE `province` (
  `Province_ID` char(8) NOT NULL COMMENT '省份ID',
  `Province_Name` varchar(20) NOT NULL COMMENT '省份名称',
  PRIMARY KEY (`Province_ID`),
  KEY `Province_Name` (`Province_Name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of province
-- ----------------------------

-- ----------------------------
-- Table structure for `scenic`
-- ----------------------------
DROP TABLE IF EXISTS `scenic`;
CREATE TABLE `scenic` (
  `Scenic_ID` char(8) NOT NULL COMMENT '景点ID',
  `Scenic_Picture` varchar(100) NOT NULL COMMENT '景点照片（存储路径）',
  `Scenic_Name` varchar(50) NOT NULL COMMENT '景点名称',
  `Scenic_Intro` varchar(2000) NOT NULL COMMENT '景点简介',
  `Province_Name1` varchar(20) NOT NULL COMMENT '景点所属省份名称',
  `City_Name` varchar(20) NOT NULL COMMENT '景点所属城市名称',
  `Scenic_Adress` varchar(200) NOT NULL COMMENT '景点地点',
  `Scenic_Phone` varchar(20) NOT NULL COMMENT '景点联系方式',
  `Scenic_Level` varchar(5) NOT NULL COMMENT '景点星级（A~AAAAA）',
  `Scenic_License` char(8) NOT NULL COMMENT '景区许可证（官方用户注册时填写）',
  PRIMARY KEY (`Scenic_ID`),
  KEY `City_Name` (`City_Name`) USING BTREE,
  KEY `Province_Name1` (`Province_Name1`) USING BTREE,
  CONSTRAINT `City_Name` FOREIGN KEY (`City_Name`) REFERENCES `city` (`City_Name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Province_Name1` FOREIGN KEY (`Province_Name1`) REFERENCES `province` (`Province_Name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of scenic
-- ----------------------------

-- ----------------------------
-- Table structure for `ticket`
-- ----------------------------
DROP TABLE IF EXISTS `ticket`;
CREATE TABLE `ticket` (
  `Ticket_ID` char(8) NOT NULL COMMENT '门票ID',
  `Scenic_ID` char(8) NOT NULL COMMENT '门票所属景点ID',
  `Tkcket_Picture` varchar(100) NOT NULL COMMENT '门票图片（存储路径）',
  `Ticket_Time` int(8) NOT NULL COMMENT '门票可用日期',
  PRIMARY KEY (`Ticket_ID`),
  KEY `Scenic_ID` (`Scenic_ID`) USING BTREE,
  CONSTRAINT `Scenic_ID` FOREIGN KEY (`Scenic_ID`) REFERENCES `scenic` (`Scenic_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ticket
-- ----------------------------

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `User_ID` char(8) NOT NULL COMMENT '用户ID',
  `User_Name` varchar(20) NOT NULL COMMENT '用户账号名（只允许数字英文字母和下划线）',
  `User_Password` varchar(20) NOT NULL COMMENT '用户密码（只允许数字英文字母和下划线）',
  `User_Truename` varchar(20) DEFAULT NULL COMMENT '用户姓名（普通用户填真实姓名，官方用户填单位名称）',
  `User_Intro` varchar(1000) DEFAULT NULL COMMENT '用户介绍',
  `User_Sex` char(2) DEFAULT NULL COMMENT '用户性别（普通用户填男/女 官方用户为空）',
  `User_Phone` varchar(20) DEFAULT NULL COMMENT '用户联系方式',
  `User_Birthday` int(8) DEFAULT NULL COMMENT '用户出生年月日（普通用户填写，官方用户为空）',
  `User_IDcard` char(18) DEFAULT NULL COMMENT '用户身份证号（普通用户填写，官方用户为空）',
  `User_Level` int(3) NOT NULL DEFAULT '50' COMMENT '用户信用等级(0~20可疑，20~40次级，40~60普通，60~80良好，80~100优秀)',
  `Scenic_ID1` char(8) DEFAULT NULL COMMENT '官方用户所管理景区ID（普通用户为空）',
  `User_Type` varchar(4) NOT NULL COMMENT '用户类型（普通/官方）',
  PRIMARY KEY (`User_ID`),
  KEY `Scenic_ID1` (`Scenic_ID1`) USING BTREE,
  CONSTRAINT `Scenic_ID1` FOREIGN KEY (`Scenic_ID1`) REFERENCES `scenic` (`Scenic_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------

-- ----------------------------
-- Table structure for `user-ticket`
-- ----------------------------
DROP TABLE IF EXISTS `user-ticket`;
CREATE TABLE `user-ticket` (
  `User_ID` char(8) NOT NULL COMMENT '持票用户ID',
  `UserTicket_Price` int(6) NOT NULL COMMENT '门票定价（普通用户定价不统一，由用户自己定价；官方用户定价必须固定）',
  `UserTicket_Count` smallint(6) NOT NULL COMMENT '门票数量',
  `Ticket_ID` char(8) NOT NULL COMMENT '门票ID',
  PRIMARY KEY (`User_ID`,`Ticket_ID`),
  KEY `Ticket_ID` (`Ticket_ID`) USING BTREE,
  KEY `User_ID` (`User_ID`),
  CONSTRAINT `Ticket_ID` FOREIGN KEY (`Ticket_ID`) REFERENCES `ticket` (`Ticket_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `User_ID` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user-ticket
-- ----------------------------
