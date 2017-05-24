/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50717
Source Host           : localhost:3306
Source Database       : database

Target Server Type    : MYSQL
Target Server Version : 50717
File Encoding         : 65001

Date: 2017-05-24 12:03:35
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admin`
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `Admin_ID` char(8) NOT NULL,
  `Admin_Name` varchar(20) NOT NULL,
  `Admin_Password` varchar(50) NOT NULL,
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
  `City_ID` char(8) NOT NULL,
  `City_Name` varchar(20) NOT NULL,
  `City_Province` varchar(20) NOT NULL,
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
  `Order_ID` char(8) NOT NULL,
  `Order_Seller_ID` char(8) NOT NULL,
  `Order_Buyer_ID` char(8) NOT NULL,
  `Order_Time` int(8) NOT NULL,
  `Order_Count` smallint(6) NOT NULL,
  `Order_State` char(4) NOT NULL,
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
  `Province_ID` char(8) NOT NULL,
  `Province_Name` varchar(20) NOT NULL,
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
  `Scenic_ID` char(8) NOT NULL,
  `Scenic_Picture` varchar(100) NOT NULL,
  `Scenic_Name` varchar(50) NOT NULL,
  `Scenic_Intro` varchar(2000) NOT NULL,
  `Scenic_Province_Name` varchar(20) NOT NULL,
  `Scenic_City_Name` varchar(20) NOT NULL,
  `Scenic_Adress` varchar(200) NOT NULL,
  `Scenic_Phone` varchar(20) NOT NULL,
  `Scenic_Level` varchar(5) NOT NULL,
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
  `Ticket_ID` char(8) NOT NULL,
  `Ticket_Scenic_ID` char(8) NOT NULL,
  `Ticket_Time` int(8) NOT NULL,
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
  `User_ID` char(8) NOT NULL,
  `User_Name` varchar(20) NOT NULL,
  `User_Password` varchar(20) NOT NULL,
  `User_Truename` varchar(20) DEFAULT NULL,
  `User_Intro` varchar(1000) DEFAULT NULL,
  `User_Sex` char(2) DEFAULT NULL,
  `User_Phone` varchar(20) DEFAULT NULL,
  `User_Birthday` int(8) DEFAULT NULL,
  `User_IDcard` char(18) DEFAULT NULL,
  `User_Level` varchar(4) DEFAULT NULL,
  `User_Type` varchar(2) NOT NULL,
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
  `UserTicket_User_ID` char(8) NOT NULL,
  `UserTicket_Price` int(6) NOT NULL,
  `UserTicket_Count` smallint(6) NOT NULL,
  `UserTicket_Ticket_ID` char(8) NOT NULL,
  PRIMARY KEY (`UserTicket_User_ID`,`UserTicket_Ticket_ID`),
  KEY `UserTicket_Ticket_ID` (`UserTicket_Ticket_ID`),
  CONSTRAINT `UserTicket_Ticket_ID` FOREIGN KEY (`UserTicket_Ticket_ID`) REFERENCES `ticket` (`Ticket_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `UserTicket_User_ID` FOREIGN KEY (`UserTicket_User_ID`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user-ticket
-- ----------------------------
