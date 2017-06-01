/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50717
Source Host           : localhost:3306
Source Database       : database

Target Server Type    : MYSQL
Target Server Version : 50717
File Encoding         : 65001

Date: 2017-05-31 17:29:33
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
  `Province_ID` char(8) NOT NULL COMMENT '城市所属省份',
  PRIMARY KEY (`City_ID`),
  KEY `City_Name` (`City_Name`),
  KEY `Province_ID` (`Province_ID`) USING BTREE,
  CONSTRAINT `Province_ID` FOREIGN KEY (`Province_ID`) REFERENCES `province` (`Province_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of city
-- ----------------------------
INSERT INTO `city` VALUES ('00000000', '泰安市', '00000000');
INSERT INTO `city` VALUES ('00000001', '黄山市', '00000001');

-- ----------------------------
-- Table structure for `order`
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `Order_ID` char(8) NOT NULL COMMENT '订单编号',
  `Ticket_ID` char(8) NOT NULL,
  `User_ID1` char(8) NOT NULL COMMENT '卖方用户ID',
  `User_ID2` char(8) NOT NULL COMMENT '买方用户ID',
  `Order_Time` int(8) NOT NULL COMMENT '订单生成时间',
  `Order_Count` smallint(6) NOT NULL COMMENT '订单交易的门票数量',
  `Order_State` char(2) NOT NULL DEFAULT '1' COMMENT '订单状态（1未审核 2审核通过 3待收货 4已完成）',
  PRIMARY KEY (`Order_ID`),
  KEY `User_ID1` (`User_ID1`) USING BTREE,
  KEY `User_ID2` (`User_ID2`) USING BTREE,
  KEY `Ticket_ID1` (`Ticket_ID`),
  CONSTRAINT `Ticket_ID1` FOREIGN KEY (`Ticket_ID`) REFERENCES `ticket` (`Ticket_ID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `User_ID1` FOREIGN KEY (`User_ID1`) REFERENCES `user` (`User_ID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `User_ID2` FOREIGN KEY (`User_ID2`) REFERENCES `user` (`User_ID`) ON DELETE NO ACTION ON UPDATE CASCADE
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
INSERT INTO `province` VALUES ('00000001', '安徽省');
INSERT INTO `province` VALUES ('00000000', '山东省');

-- ----------------------------
-- Table structure for `scenic`
-- ----------------------------
DROP TABLE IF EXISTS `scenic`;
CREATE TABLE `scenic` (
  `Scenic_ID` char(8) NOT NULL COMMENT '景点ID',
  `Scenic_Picture` varchar(100) NOT NULL COMMENT '景点照片（存储路径）',
  `Scenic_Name` varchar(50) NOT NULL COMMENT '景点名称',
  `Scenic_Intro` varchar(2000) NOT NULL COMMENT '景点简介',
  `Province_ID1` varchar(20) NOT NULL COMMENT '景点所属省份名称',
  `City_ID` varchar(20) NOT NULL COMMENT '景点所属城市名称',
  `Scenic_Adress` varchar(200) NOT NULL COMMENT '景点地点',
  `Scenic_Phone` varchar(20) NOT NULL COMMENT '景点联系方式',
  `Scenic_Level` varchar(5) NOT NULL COMMENT '景点星级（A~AAAAA）',
  `Scenic_Vedio` varchar(100) NOT NULL COMMENT '景区宣传视屏链接',
  `Scenic_License` char(8) NOT NULL COMMENT '景区许可证（官方用户注册时填写）',
  PRIMARY KEY (`Scenic_ID`),
  KEY `City_ID` (`City_ID`) USING BTREE,
  KEY `Province_ID1` (`Province_ID1`) USING BTREE,
  CONSTRAINT `City_ID` FOREIGN KEY (`City_ID`) REFERENCES `city` (`City_ID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `Province_ID1` FOREIGN KEY (`Province_ID1`) REFERENCES `province` (`Province_ID`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of scenic
-- ----------------------------
INSERT INTO `scenic` VALUES ('00000000', 'tourplace/img/scenicindex/taishan.jpg', '泰山', '\r\n泰山风景名胜区（Mount tai scenic spot）：世界自然与文化遗产，世界地质公园，国家AAAAA级旅游景区，国家级风景名胜区，全国重点文物保护单位，中华国山，中国非物质文化遗产，全国文明风景旅游区，中国书法第一山。\r\n泰山又名岱山、岱宗、岱岳、东岳、泰岳，位于山东省中部，隶属于泰安市，绵亘于泰安、济南、淄博三市之间，总面积24200公顷。主峰玉皇顶海拔1545米，气势雄伟磅礴，有“五岳之首”、“五岳之长”、“天下第一山”之称。\r\n泰山被古人视为“直通帝座”的天堂，成为百姓崇拜，帝王告祭的神山，有“泰山安，四海皆安”的说法。自秦始皇开始到清代，先后有13代帝王引次亲登泰山封禅或祭祀，另外有24代帝王遣官祭祀72次。\r\n古代文人雅士更对泰山仰慕备至，纷纷前来游历，作诗记文。泰山宏大的山体上留下了20余处古建筑群，2200余处碑碣石刻。道教、佛教视泰山为“仙山佛国”，神化泰山，在泰山建造了大量宫观寺庙。经石峪的《金刚经》石刻，闻名中外。\r\n泰山风景以壮丽著称。重叠的山势，厚重的形体，苍松巨石的烘托，云烟的变化，使它在雄浑中兼有明丽，静穆中透着神奇。自然的泰山，彰显着自然的神奇；文化的泰山，印证着文化的神圣。\r\n泰山是中华民族的象征，是灿烂东方文化的缩影，是“天人合一”思想的寄托之地，是中华民族精神的家园。\r\n泰山风景名胜区（Mount tai scenic spot）：世界自然与文化遗产，世界地质公园，国家AAAAA级旅游景区，国家级风景名胜区，全国重点文物保护单位，中华国山，中国非物质文化遗产，全国文明风景旅游区，中国书法第一山。\r\n泰山又名岱山、岱宗、岱岳、东岳、泰岳，位于山东省中部，隶属于泰安市，绵亘于泰安、济南、淄博三市之间，总面积24200公顷。主峰玉皇顶海拔1545米，气势雄伟磅礴，有“五岳之首”、“五岳之长”、“天下第一山”之称。\r\n泰山被古人视为“直通帝座”的天堂，成为百姓崇拜，帝王告祭的神山，有“泰山安，四海皆安”的说法。自秦始皇开始到清代，先后有13代帝王引次亲登泰山封禅或祭祀，另外有24代帝王遣官祭祀72次。\r\n古代文人雅士更对泰山仰慕备至，纷纷前来游历，作诗记文。泰山宏大的山体上留下了20余处古建筑群，2200余处碑碣石刻。道教、佛教视泰山为“仙山佛国”，神化泰山，在泰山建造了大量宫观寺庙。经石峪的《金刚经》石刻，闻名中外。\r\n泰山风景以壮丽著称。重叠的山势，厚重的形体，苍松巨石的烘托，云烟的变化，使它在雄浑中兼有明丽，静穆中透着神奇。自然的泰山，彰显着自然的神奇；文化的泰山，印证着文化的神圣。\r\n泰山是中华民族的象征，是灿烂东方文化的缩影，是“天人合一”思想的寄托之地，是中华民族精神的家园。\r\n', '00000000', '00000000', '山东省泰安市泰山区红门路', '0538-8066666', 'AAAAA', 'http://www.iqiyi.com/w_19rr0voutd.html', '00000000');
INSERT INTO `scenic` VALUES ('00000001', 'tourplace/img/scenicindex/taishan.jpg', '黄山', '黄山：世界文化与自然双重遗产，世界地质公园，国家AAAAA级旅游景区，国家级风景名胜区，全国文明风景旅游区示范点，中华十大名山，天下第一奇山。\r\n黄山位于安徽省南部黄山市境内，有72峰，主峰莲花峰海拔1864米，与光明顶、天都峰并称三大黄山主峰，为36大峰之一。黄山是安徽旅游的标志，是中国十大风景名胜唯一的山岳风光。\r\n黄山原名“黟山”，因峰岩青黑，遥望苍黛而名。后因传说轩辕黄帝曾在此炼丹，故改名为“黄山”。黄山代表景观有“四绝三瀑”，四绝：奇松、怪石、云海、温泉；三瀑：人字瀑、百丈泉、九龙瀑。黄山迎客松是安徽人民热情友好的象征，承载着拥抱世界的东方礼仪文化。\r\n明朝旅行家徐霞客登临黄山时赞叹：“薄海内外之名山，无如徽之黄山。登黄山，天下无山，观止矣！”被后人引申为“五岳归来不看山，黄山归来不看岳”。', '00000001', '00000001', '安徽省黄山市黄山区', '0559-2580880', 'AAAAA', 'http://www.iqiyi.com/w_19rr9ynsmh.html', '00000001');

-- ----------------------------
-- Table structure for `ticket`
-- ----------------------------
DROP TABLE IF EXISTS `ticket`;
CREATE TABLE `ticket` (
  `Ticket_ID` char(8) NOT NULL COMMENT '门票ID',
  `Scenic_ID` char(8) NOT NULL COMMENT '门票所属景点ID',
  `Ticket_Picture` varchar(100) NOT NULL COMMENT '门票图片（存储路径）',
  `Ticket_Time` int(8) NOT NULL COMMENT '门票可用日期',
  PRIMARY KEY (`Ticket_ID`),
  KEY `Scenic_ID` (`Scenic_ID`) USING BTREE,
  CONSTRAINT `Scenic_ID` FOREIGN KEY (`Scenic_ID`) REFERENCES `scenic` (`Scenic_ID`) ON DELETE NO ACTION ON UPDATE CASCADE
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
  `User_Picture` varchar(100) NOT NULL COMMENT '用户头像图片',
  PRIMARY KEY (`User_ID`),
  KEY `Scenic_ID1` (`Scenic_ID1`) USING BTREE,
  CONSTRAINT `Scenic_ID1` FOREIGN KEY (`Scenic_ID1`) REFERENCES `scenic` (`Scenic_ID`) ON DELETE NO ACTION ON UPDATE CASCADE
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
  `UserTicket_Count` smallint(6) NOT NULL COMMENT '用户仓库门票数量（官方用户所有门票都要上架）',
  `Ticket_ID` char(8) NOT NULL COMMENT '门票ID',
  `UserTicket_Type` int(1) NOT NULL COMMENT '门票状态（0在仓库 1出售中 3已过期）',
  PRIMARY KEY (`User_ID`,`Ticket_ID`,`UserTicket_Type`),
  KEY `Ticket_ID` (`Ticket_ID`) USING BTREE,
  KEY `User_ID` (`User_ID`),
  CONSTRAINT `Ticket_ID` FOREIGN KEY (`Ticket_ID`) REFERENCES `ticket` (`Ticket_ID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `User_ID` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user-ticket
-- ----------------------------
