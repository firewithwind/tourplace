/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50717
Source Host           : localhost:3306
Source Database       : database

Target Server Type    : MYSQL
Target Server Version : 50717
File Encoding         : 65001

Date: 2017-05-24 21:28:36
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
  `City_Province` varchar(20) NOT NULL COMMENT '城市所属省份',
  PRIMARY KEY (`City_ID`),
  KEY `City_Name` (`City_Name`),
  KEY `City_Province` (`City_Province`),
  CONSTRAINT `City_Province` FOREIGN KEY (`City_Province`) REFERENCES `province` (`Province_Name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of city
-- ----------------------------

-- ----------------------------
-- Table structure for `order`
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `Order_ID` char(8) NOT NULL COMMENT '订单编号',
  `Order_Seller_ID` char(8) NOT NULL COMMENT '卖方用户ID',
  `Order_Buyer_ID` char(8) NOT NULL COMMENT '买方用户ID',
  `Order_Time` int(8) NOT NULL COMMENT '订单生成时间',
  `Order_Count` smallint(6) NOT NULL COMMENT '订单交易的门票数量',
  `Order_State` char(2) NOT NULL DEFAULT '1' COMMENT '订单状态（1未审核 2审核通过 3待收货 4已完成）',
  PRIMARY KEY (`Order_ID`),
  KEY `Order_Seller_ID` (`Order_Seller_ID`),
  KEY `Order_Buyer_ID` (`Order_Buyer_ID`),
  CONSTRAINT `Order_Buyer_ID` FOREIGN KEY (`Order_Buyer_ID`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Order_Seller_ID` FOREIGN KEY (`Order_Seller_ID`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE
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
  `Scenic_Province_Name` varchar(20) NOT NULL COMMENT '景点所属省份名称',
  `Scenic_City_Name` varchar(20) NOT NULL COMMENT '景点所属城市名称',
  `Scenic_Adress` varchar(200) NOT NULL COMMENT '景点地点',
  `Scenic_Phone` varchar(20) NOT NULL COMMENT '景点联系方式',
  `Scenic_Level` varchar(5) NOT NULL COMMENT '景点星级（A~AAAAA）',
  PRIMARY KEY (`Scenic_ID`),
  KEY `Scenic_Province_Name` (`Scenic_Province_Name`),
  KEY `Scenic_City_Name` (`Scenic_City_Name`),
  CONSTRAINT `Scenic_City_Name` FOREIGN KEY (`Scenic_City_Name`) REFERENCES `city` (`City_Name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Scenic_Province_Name` FOREIGN KEY (`Scenic_Province_Name`) REFERENCES `province` (`Province_Name`) ON DELETE CASCADE ON UPDATE CASCADE
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
  `Ticket_Scenic_ID` char(8) NOT NULL COMMENT '门票所属景点ID',
  `Ticket_Time` int(8) NOT NULL COMMENT '门票可用日期',
  PRIMARY KEY (`Ticket_ID`),
  KEY `Ticket_Scenic_ID` (`Ticket_Scenic_ID`),
  CONSTRAINT `Ticket_Scenic_ID` FOREIGN KEY (`Ticket_Scenic_ID`) REFERENCES `scenic` (`Scenic_ID`) ON DELETE CASCADE ON UPDATE CASCADE
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
  `User_Level` varchar(4) NOT NULL DEFAULT '普通' COMMENT '用户信用等级（优秀<-良好<-普通->次级->可疑//初始为普通）',
  `User_Type` varchar(4) NOT NULL COMMENT '用户类型（普通/官方）',
  PRIMARY KEY (`User_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------

-- ----------------------------
-- Table structure for `user-ticket`
-- ----------------------------
DROP TABLE IF EXISTS `user-ticket`;
CREATE TABLE `user-ticket` (
  `UserTicket_User_ID` char(8) NOT NULL COMMENT '持票用户ID',
  `UserTicket_Price` int(6) NOT NULL COMMENT '门票定价（普通用户定价不统一，由用户自己定价；官方用户定价必须固定）',
  `UserTicket_Count` smallint(6) NOT NULL COMMENT '门票数量',
  `UserTicket_Ticket_ID` char(8) NOT NULL COMMENT '门票ID',
  PRIMARY KEY (`UserTicket_User_ID`,`UserTicket_Ticket_ID`),
  KEY `UserTicket_Ticket_ID` (`UserTicket_Ticket_ID`),
  CONSTRAINT `UserTicket_Ticket_ID` FOREIGN KEY (`UserTicket_Ticket_ID`) REFERENCES `ticket` (`Ticket_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `UserTicket_User_ID` FOREIGN KEY (`UserTicket_User_ID`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user-ticket
-- ----------------------------
TE CASCADE,
  CONSTRAINT `UserTicket_User_ID` FOREIGN KEY (`UserTicket_User_ID`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user-ticket
-- ----------------------------
