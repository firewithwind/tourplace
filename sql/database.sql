/*
Navicat MySQL Data Transfer

Source Server         : 123
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : tourplace

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2017-06-02 23:18:31
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
INSERT INTO `city` VALUES ('00000002', '威海市', '00000000');
INSERT INTO `city` VALUES ('00000003', '上海市', '00000002');
INSERT INTO `city` VALUES ('00000004', '北京市', '00000003');
INSERT INTO `city` VALUES ('00000005', '伊犁哈萨克自治州', '00000004');
INSERT INTO `city` VALUES ('00000006', '临汾市', '00000005');
INSERT INTO `city` VALUES ('00000007', '西双版纳傣族自治州', '00000006');
INSERT INTO `city` VALUES ('00000008', '阿坝藏族羌族自治州', '00000007');
INSERT INTO `city` VALUES ('00000009', '三亚市', '00000008');
INSERT INTO `city` VALUES ('00000010', '桂林市', '00000009');
INSERT INTO `city` VALUES ('00000011', '厦门市', '00000010');
INSERT INTO `city` VALUES ('00000012', '承德市', '00000011');
INSERT INTO `city` VALUES ('00000013', '韶关市', '00000012');
INSERT INTO `city` VALUES ('99999999', '海外', '99999999');

-- ----------------------------
-- Table structure for `order`
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `Order_ID` char(8) NOT NULL COMMENT '订单编号',
  `Ticket_ID` char(8) NOT NULL,
  `User_ID1` char(8) NOT NULL COMMENT '买方用户ID',
  `User_ID2` char(8) NOT NULL COMMENT '卖方用户ID',
  `Order_Time` char(10) NOT NULL COMMENT '订单生成时间',
  `Order_Count` smallint(6) NOT NULL COMMENT '订单交易的门票数量',
  `Order_State` char(2) NOT NULL DEFAULT '1' COMMENT '订单状态（1待付款 2已完成）',
  `Order_Price` int(10) NOT NULL,
  PRIMARY KEY (`Order_ID`),
  KEY `User_ID1` (`User_ID1`) USING BTREE,
  KEY `Ticket_ID1` (`Ticket_ID`),
  CONSTRAINT `Ticket_ID1` FOREIGN KEY (`Ticket_ID`) REFERENCES `ticket` (`Ticket_ID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `User_ID1` FOREIGN KEY (`User_ID1`) REFERENCES `user` (`User_ID`) ON DELETE NO ACTION ON UPDATE CASCADE
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
INSERT INTO `province` VALUES ('00000002', '上海市');
INSERT INTO `province` VALUES ('00000006', '云南省');
INSERT INTO `province` VALUES ('00000003', '北京市');
INSERT INTO `province` VALUES ('00000007', '四川省');
INSERT INTO `province` VALUES ('00000001', '安徽省');
INSERT INTO `province` VALUES ('00000000', '山东省');
INSERT INTO `province` VALUES ('00000005', '山西省');
INSERT INTO `province` VALUES ('00000012', '广东省');
INSERT INTO `province` VALUES ('00000009', '广西壮族自治区');
INSERT INTO `province` VALUES ('00000004', '新疆维吾尔族自治区');
INSERT INTO `province` VALUES ('00000011', '河北省');
INSERT INTO `province` VALUES ('00000008', '海南省');
INSERT INTO `province` VALUES ('99999999', '海外');
INSERT INTO `province` VALUES ('00000010', '福建省');

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
  `Scenic_Level` varchar(4) NOT NULL COMMENT '景点星级（其他 2A 3A 4A 5A）',
  `Scenic_Type` int(1) NOT NULL COMMENT '景区类型（0登山 1观海 2游乐园 3名胜古迹 4秀丽风景 5异族风情 6其他）',
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
INSERT INTO `scenic` VALUES ('00000000', '/tourplace/img/scenicindex/taishan.jpg', '泰山', '泰山风景名胜区（Mount tai scenic spot）：世界自然与文化遗产，世界地质公园，国家AAAAA级旅游景区，国家级风景名胜区，全国重点文物保护单位，中华国山，中国非物质文化遗产，全国文明风景旅游区，中国书法第一山。\r\n泰山又名岱山、岱宗、岱岳、东岳、泰岳，位于山东省中部，隶属于泰安市，绵亘于泰安、济南、淄博三市之间，总面积24200公顷。主峰玉皇顶海拔1545米，气势雄伟磅礴，有“五岳之首”、“五岳之长”、“天下第一山”之称。\r\n泰山被古人视为“直通帝座”的天堂，成为百姓崇拜，帝王告祭的神山，有“泰山安，四海皆安”的说法。自秦始皇开始到清代，先后有13代帝王引次亲登泰山封禅或祭祀，另外有24代帝王遣官祭祀72次。\r\n古代文人雅士更对泰山仰慕备至，纷纷前来游历，作诗记文。泰山宏大的山体上留下了20余处古建筑群，2200余处碑碣石刻。道教、佛教视泰山为“仙山佛国”，神化泰山，在泰山建造了大量宫观寺庙。经石峪的《金刚经》石刻，闻名中外。\r\n泰山风景以壮丽著称。重叠的山势，厚重的形体，苍松巨石的烘托，云烟的变化，使它在雄浑中兼有明丽，静穆中透着神奇。自然的泰山，彰显着自然的神奇；文化的泰山，印证着文化的神圣。\r\n泰山是中华民族的象征，是灿烂东方文化的缩影，是“天人合一”思想的寄托之地，是中华民族精神的家园。\r\n泰山风景名胜区（Mount tai scenic spot）：世界自然与文化遗产，世界地质公园，国家AAAAA级旅游景区，国家级风景名胜区，全国重点文物保护单位，中华国山，中国非物质文化遗产，全国文明风景旅游区，中国书法第一山。\r\n泰山又名岱山、岱宗、岱岳、东岳、泰岳，位于山东省中部，隶属于泰安市，绵亘于泰安、济南、淄博三市之间，总面积24200公顷。主峰玉皇顶海拔1545米，气势雄伟磅礴，有“五岳之首”、“五岳之长”、“天下第一山”之称。\r\n泰山被古人视为“直通帝座”的天堂，成为百姓崇拜，帝王告祭的神山，有“泰山安，四海皆安”的说法。自秦始皇开始到清代，先后有13代帝王引次亲登泰山封禅或祭祀，另外有24代帝王遣官祭祀72次。\r\n古代文人雅士更对泰山仰慕备至，纷纷前来游历，作诗记文。泰山宏大的山体上留下了20余处古建筑群，2200余处碑碣石刻。道教、佛教视泰山为“仙山佛国”，神化泰山，在泰山建造了大量宫观寺庙。经石峪的《金刚经》石刻，闻名中外。\r\n泰山风景以壮丽著称。重叠的山势，厚重的形体，苍松巨石的烘托，云烟的变化，使它在雄浑中兼有明丽，静穆中透着神奇。自然的泰山，彰显着自然的神奇；文化的泰山，印证着文化的神圣。\r\n泰山是中华民族的象征，是灿烂东方文化的缩影，是“天人合一”思想的寄托之地，是中华民族精神的家园。', '00000000', '00000000', '山东省泰安市泰山区红门路', '0538-8066666', '5A', '1', 'http://www.iqiyi.com/w_19rr0voutd.html', '00000000');
INSERT INTO `scenic` VALUES ('00000001', '/tourplace/img/scenicindex/huangshan.jpg', '黄山', '黄山：世界文化与自然双重遗产，世界地质公园，国家AAAAA级旅游景区，国家级风景名胜区，全国文明风景旅游区示范点，中华十大名山，天下第一奇山。\r\n黄山位于安徽省南部黄山市境内，有72峰，主峰莲花峰海拔1864米，与光明顶、天都峰并称三大黄山主峰，为36大峰之一。黄山是安徽旅游的标志，是中国十大风景名胜唯一的山岳风光。\r\n黄山原名“黟山”，因峰岩青黑，遥望苍黛而名。后因传说轩辕黄帝曾在此炼丹，故改名为“黄山”。黄山代表景观有“四绝三瀑”，四绝：奇松、怪石、云海、温泉；三瀑：人字瀑、百丈泉、九龙瀑。黄山迎客松是安徽人民热情友好的象征，承载着拥抱世界的东方礼仪文化。\r\n明朝旅行家徐霞客登临黄山时赞叹：“薄海内外之名山，无如徽之黄山。登黄山，天下无山，观止矣！”被后人引申为“五岳归来不看山，黄山归来不看岳”。', '00000001', '00000001', '安徽省黄山市黄山区', '0559-2580880', '5A', '1', 'http://www.iqiyi.com/w_19rr9ynsmh.html', '00000001');
INSERT INTO `scenic` VALUES ('00000002', '/tourplace/img/scenicindex/liugongdao.jpg', '刘公岛', '刘公岛位于山东半岛最东端的威海湾内，人文景观丰富独特，既有上溯千年的战国遗址、汉代刘公刘母的美丽传说，又有清朝北洋海军提督署、水师学堂、古炮台等甲午战争遗址，还有众多英租时期遗留下来的欧式建筑，素有“东隅屏藩”和“不沉的战舰”之称。其北部海蚀崖直立陡峭，南部平缓绵延，森林覆盖率达87%，有“海上仙山”和“世外桃源”的美誉。\r\n刘公岛自1985年由封闭的军事禁区对外开放以来，景区风景名胜资源保护利用取得丰硕成果。1985年被命名为国家森林公园。1999年刘公岛被建设部命名为”国家文明风景区”。2011年晋升为国家AAAAA级旅游景区。[1] \r\n主要景点有中国甲午战争博物馆、中国甲午战争博物馆刘公岛国家森林公园、刘公岛博览园、刘公岛鲸馆、旗顶山炮台、东泓炮台、铁码头等景点', '00000000', '00000002', '山东省威海市区东2.1海里的威海湾', '0631-5287807', '5A', '2', 'http://www.iqiyi.com/w_19rrz5qrlx.html', '00000002');
INSERT INTO `scenic` VALUES ('00000003', '/tourplace/img/scenicindex/huanlegu.jpg', '欢乐谷', '上海欢乐谷——中国首个连锁主题公园品牌、国家4A级旅游景区，地处上海松江佘山国家旅游度假区，是华侨城集团投资40亿元打造的精品力作。全园占地面积65万平方米，拥有100多项老少皆宜、丰富多彩的体验项目，是国内占地面积最大、科技含量最高、游乐设施最先进、文化活动最丰富的主题公园之一。\r\n上海欢乐谷全园共有七大主题区：阳光港、欢乐时光、上海滩、香格里拉、欢乐海洋、金矿镇和飓风湾。这里有众多从美国、德国、荷兰、瑞士等国家引进的世界顶尖科技娱乐项目，如：全球至尊无底跌落式过山车“绝顶雄风”、国内首台木质过山车“谷木游龙”、世界最高落差“激流勇进”、全球最受欢迎亲子悬挂过山车“大洋历险”、国际经典旋转类亲子游乐项目“小飞鱼”、亚洲惊险之塔“天地双雄”、国际领先级4K高清“飞行影院”、最新4D过山车模拟体验馆“海洋之星”……荟萃大型多媒体歌舞秀《欢乐之旅》、原创魔术剧《奇幻之门》、影视特技实景剧《上海滩》、气势恢宏的大型马战实景表演《满江红》，零距离海狮互动等精彩演艺。\r\n2013年7月1日，位于上海欢乐谷西南部、占地面积约12.8万平方米、包含近40个体验项目的上海玛雅海滩水公园开门迎客。3万平米的二期项目“魔力水城”将于2016年暑假全新推出。', '00000002', '00000003', '上海市松江区林湖路888号', '021-33552222', '4A', '3', 'http://v.youku.com/v_show/id_XMzMwNTc0NzY4.html', '00000003');
INSERT INTO `scenic` VALUES ('00000004', '/tourplace/img/scenicindex/gugong.jpg', '故宫', '北京故宫是中国明清两代的皇家宫殿，旧称为紫禁城，位于北京中轴线的中心，是中国古代宫廷建筑之精华。北京故宫以三大殿为中心，占地面积72万平方米，建筑面积约15万平方米，有大小宫殿七十多座，房屋九千余间。是世界上现存规模最大、保存最为完整的木质结构古建筑之一。\r\n北京故宫于明成祖永乐四年（1406年）开始建设，以南京故宫为蓝本营建，到永乐十八年（1420年）建成。它是一座长方形城池，南北长961米，东西宽753米，四面围有高10米的城墙，城外有宽52米的护城河。紫禁城内的建筑分为外朝和内廷两部分。外朝的中心为太和殿、中和殿、保和殿，统称三大殿，是国家举行大典礼的地方。内廷的中心是乾清宫、交泰殿、坤宁宫，统称后三宫，是皇帝和皇后居住的正宫。 \r\n北京故宫被誉为世界五大宫之首（北京故宫、法国凡尔赛宫、英国白金汉宫、美国白宫、俄罗斯克里姆林宫），是国家AAAAA级旅游景区，  1961年被列为第一批全国重点文物保护单位，  1987年被列为世界文化遗产', '00000003', '00000004', '北京市东城区景山前街4号', '010-85007421', '5A', '4', 'http://www.iqiyi.com/life/20130721/2db6482c418d5801.html', '00000004');
INSERT INTO `scenic` VALUES ('00000005', '/tourplace/img/scenicindex/xibominsufengqingyuan.jpg', '锡伯民俗风情园', '锡伯民俗风情园位于新疆维吾尔自治区伊犁哈萨克自治州察布查尔锡伯自治县，是一\r\n个汇聚和展示锡伯族历史文化和民俗风情的民俗风情园。锡伯族人特别注重本民族的文化和民俗。\r\n锡伯族民俗风情园位于伊犁河谷中部的察布查尔县是全国唯一的锡伯族自治县，锡伯族悠久的历史文化和民俗风情在这里形成了独具风格的旅游特色。\r\n在这里，你还可以见到锡伯族人民所崇敬的两位英雄——图伯特、喀尔莽阿的雕塑，雕塑的造型或射、或骑，其台基上刻有英雄的生平事迹与成就。', '00000004', '00000005', '新疆维吾尔自治区伊犁哈萨克自治州察布查尔锡伯自治县', '0999-3948889', '3A', '6', 'http://baidu.ku6.com/watch/8834599462996233356.html?page=videoMultiNeed', '00000005');
INSERT INTO `scenic` VALUES ('00000006', '/tourplace/img/scenicindex/hongdongsusanjianyu.jpg', '洪洞苏三监狱', ' 山西省临汾市洪洞苏三监狱，在城内旧县衙(今县政府)西南隅，有一座古老的监狱，据《洪洞县志》记载，这座监狱始建于明洪武二年(公元一三六九年)，距今已六百多年了，是我国仅存的一座完整的明代监狱，一九五九年被列为山西省文物保护单位。 明代监狱，俗称“苏三监狱”，那脍炙人口， 妇孺皆知的《苏三起解》就发生在这儿，明正德年间(公元一五○六－－一五二一年)北京名妓苏三在洪洞蒙冤落难囚于此监，后人遂称之为“苏三监狱”。\r\n      苏三出身寒门，本姓周，系良家女，因家境生变，求亲不遇，被骗京城，附入烟花，排行三姐，号玉堂春，守法不逾，邂逅金陵王景隆，彼此相爱，矢志不渝，时洪洞县富商沈洪(字延龄)，管贾京城，慕玉堂春之名，以重金赎回洪洞作妾，其妻皮氏妒之，置毒饭中，沈误食而亡，皮氏诬告苏三，知县受贿，屈打成招，遂称狱冤，后景隆中举得官巡按山西玉堂春逢夫得救，二人终成亲眷。这一动人的历史故事被编成小说、戏剧等广为传颂，经久不衰，苏三监狱也随之闻名中外，成为人们参观游览和考察历史的名胜古迹。', '00000005', '00000006', '山西省临汾市洪洞', '0531-58912340', '2A', '7', 'http://v.ku6.com/show/V0A2aT3E7hEBrUot_USfKw...html', '00000006');
INSERT INTO `scenic` VALUES ('00000007', '/tourplace/img/scenicindex/jingzhenbajiaoting.jpg', '景真八角亭', '    景真八角亭，是西双版纳的重要文物之一。位于勐海县景真地方，距县城14公里。因这座亭子在景真地方，人们通常称它为景真八角亭。 八角亭是一座佛教建筑物，是景真地区中心佛寺“瓦拉扎滩”的一个组成部分。相传，这座八角亭是佛教徙们为纪念佛祖释迦牟尼，而仿照他戴的金丝台帽“卡钟罕”建筑的。在古代，它是个议事亭，在傣历每月15和30两日，景真地区的佛爷集中亭内，听高僧授经和商定宗教重大活动，也是处理日常重大事务的场所，同时也是和尚晋升为佛爷的场所。 在八角亭北边大约两里路的山顶，高耸着一座佛塔，与八角亭遥遥相对。 八角亭以它婀娜的姿态，屹立于流沙河畔。在景真佛寺与八角亭之间，有棵巨大古老的菩提树，挺拔的树干几个人才能合抱过来，蓊郁葳蕤，点缀了八角亭的绮丽风光。', '00000006', '00000007', '云南省西双版纳勐海县景真地方', '0691-2129850', '1A', '6', 'http://www.56.com/u86/v_NTcxODE4NTk.html', '00000007');
INSERT INTO `scenic` VALUES ('00000008', '/tourplace/img/scenicindex/jiuzhaigou.jpg', '九寨沟', '九寨沟：世界自然遗产、国家重点风景名胜区、国家AAAAA级旅游景区、国家级自然保护区、国家地质公园、世界生物圈保护区网络，是中国第一个以保护自然风景为主要目的的自然保护区。\r\n九寨沟位于四川省阿坝藏族羌族自治州九寨沟县境内，地处青藏高原向四川盆地过渡地带，距离成都市400多千米，是一条纵深50余千米的山沟谷地，总面积64297公顷，森林覆盖率超过80%。因沟内有树正寨、荷叶寨、则查洼寨等九个藏族村寨坐落在这片高山湖泊群中而得名。\r\n九寨沟国家级自然保护区主要保护对象是以大熊猫、金丝猴等珍稀动物及其自然生态环境。有74种国家保护珍稀植物，有18种国家保护动物，还有丰富的古生物化石、古冰川地貌。\r\n“九寨归来不看水”，是对九寨沟景色真实的诠释。泉、瀑、河、滩108个海子，构成一个个五彩斑斓的瑶池玉盆。长海、剑岩、诺日朗、树正、扎如、黑海六大景观，呈“Y”字形分布。翠海、叠瀑、彩林、雪峰、藏情、蓝冰，被称为“六绝”。神奇的九寨，被世人誉为“童话世界”，号称“水景之王”。', '00000007', '00000008', '四川省阿坝藏族羌族自治州九寨沟县', '400-088-6969', '5A', '5', 'http://www.iqiyi.com/w_19rrd88cc5.html', '00000008');
INSERT INTO `scenic` VALUES ('00000009', '/tourplace/img/scenicindex/tianyahaijiao.jpg', '天涯海角', '天涯海角游览区，位于三亚市天涯区，距主城区西南约23公里处，背对马岭山，面向茫茫大海，是海南建省20年第一旅游名胜，新中国成立60周年海南第一旅游品牌，国家AAAA级旅游景区。景区海湾沙滩上大小百块石耸立，“天涯石”、“海角石”、“日月石”和“南天一柱”突兀其间。', '00000008', '00000009', '海南省三亚市西郊23公里处', '0898-38869267', '4A', '2', 'http://www.iqiyi.com/w_19rr86i7a5.html', '00000009');
INSERT INTO `scenic` VALUES ('00000010', '/tourplace/img/scenicindex/lijiang.jpg', '漓江', '世界上规模最大、风景最美的岩溶山水游览区之一 位于华南广西壮族自治区东部，属珠江水系,从桂林到阳朔约83公里的水程，称漓江。 漓江自桂林至阳朔83公里水程，她酷似一条青罗带，蜿蜒于万点奇峰之间，沿江风光旖旎，碧水萦回，奇峰倒影、深潭、喷泉、飞瀑参差，构成一幅绚丽多彩的画卷，人称“百里漓江、百里画廊”是广西东北部喀斯特地形发育最典型的地段。这百里漓江，依据景色的不同，大致可分为三个景区：第一景区：桂林市区至黄牛峡；第二景区：黄牛峡至水落村；第三景区：水落村至阳朔； 漓江风景区游览胜地繁多，在短期内只能择其主要景点进行游览，其中一江（漓江）、两洞（芦笛岩、七星岩）、三山（独秀峰、伏波山、叠彩山）具有代表性，它们基本上是桂林山水的精华所在。 漓江属珠江水系，发源于兴安县猫儿山，从桂林到阳朔共83公里水程，像蜿蜒的玉带，缠绕在苍翠的奇峰中。乘舟泛游漓江，可观奇峰倒影、碧水青山、牧童悠歌、渔翁闲吊、古朴的田园人家、清新的呼吸，一切都那么诗情画意。', '00000009', '00000010', '广西壮族自治区桂林市东北兴安县猫儿山', '0773-2827643', '5A', '5', 'http://www.iqiyi.com/w_19rti68hs5.html', '00000010');
INSERT INTO `scenic` VALUES ('00000011', '/tourplace/img/scenicindex/gulangyu.jpg', '鼓浪屿', '鼓浪屿（英文：Kulangsu）原名“圆沙洲”，别名“圆洲仔”，南宋时期命“五龙屿”，明朝改称“鼓浪屿”。因岛西南方海滩上有一块两米多高、中有洞穴的礁石，每当涨潮水涌，浪击礁石，声似擂鼓，人们称“鼓浪石”，鼓浪屿因此而逐渐又名。因涨潮水涌，浪击礁石，声似擂鼓而得名。鼓浪屿街道短小，纵横交错，是厦门最大的一个卫星岛之一。\r\n鼓浪屿全岛的绿地覆盖率超过40%，植物种群丰富，各种乔木、灌木、藤木、地被植物共90余科，1000余种。代表景点有：日光岩、菽庄花园、皓月园、毓园、鼓浪石、鼓浪屿钢琴博物馆、郑成功纪念馆、海底世界、天然海滨浴场、海天堂构等。\r\n鼓浪屿风景名胜区获得国家5A级旅游景区、全国重点文物保护单位、中国最美五大城区等荣誉。', '00000010', '00000011', '福建省厦门市思明区', '0592-2060777', '5A', '2', 'http://www.iqiyi.com/w_19rruvyyj9.html', '00000011');
INSERT INTO `scenic` VALUES ('00000012', '/tourplace/img/scenicindex/bishushanzhuang.jpg', '避暑山庄', '承德避暑山庄：世界文化遗产，国家AAAAA级旅游景区，全国重点文物保护单位，中国四大名园之一。\r\n承德避暑山庄又名“承德离宫”或“热河行宫”，位于河北省承德市中心北部，武烈河西岸一带狭长的谷地上，是清代皇帝夏天避暑和处理政务的场所。\r\n避暑山庄始建于1703年，历经清康熙、雍正、乾隆三朝，耗时89年建成。避暑山庄以朴素淡雅的山村野趣为格调，取自然山水之本色，吸收江南塞北之风光，成为中国现存占地最大的古代帝王宫苑。\r\n避暑山庄分宫殿区、湖泊区、平原区、山峦区四大部分，整个山庄东南多水，西北多山，是中国自然地貌的缩影，是中国园林史上一个辉煌的里程碑，是中国古典园林艺术的杰作，是中国古典园林之最高范例。\r\n1961年3月4日，避暑山庄被公布为第一批全国重点文物保护单位，与同时公布的颐和园、拙政园、留园并称为中国四大名园，1994年12月被列入《世界遗产名录》。', '00000011', '00000012', '河北省承德市丽正门路20号', '0314-2161132', '5A', '4', 'http://www.iqiyi.com/w_19rtj6go6p.html', '00000012');
INSERT INTO `scenic` VALUES ('00000013', '/tourplace/img/scenicindex/badalingchangcheng.jpg', '八达岭长城', '八达岭长城，位于北京市延庆区军都山关沟古道北口。是中国古代伟大的防御工程万里长城的重要组成部分，是明长城的一个隘口。八达岭长城为居庸关的重要前哨，古称“居庸之险不在关而在八达岭”。\r\n明长城的八达岭段被称作“玉关天堑”，为明代居庸关八景之一。八达岭长城是明长城向游人开放最早的地段，八达岭景区以八达岭长城为主，兴建了八达岭饭店和由江泽民主席亲笔题名的中国长城博物馆等功能齐全的现代化旅游服务设施。\r\n八达岭景区是全国文明风景旅游区示范点，以其宏伟的景观、完善的设施和深厚的文化历史内涵而著称于世，是举世闻名的旅游胜地。\r\n2016年7月29日开始，八达岭长城向现役军人、残疾军人免收门票', '00000003', '00000004', '北京市延庆区军都山关沟古道北口', '010-69121423', '5A', '4', 'http://www.iqiyi.com/w_19rr9m6frt.html', '00000013');
INSERT INTO `scenic` VALUES ('00000014', '/tourplace/img/scenicindex/nanhuasi.jpg', '南华寺', '南华寺坐落于广东省韶关市曲江区马坝镇东南7公里的曹溪之畔，距离韶关市区南约24公里。 南华寺是中国佛教名寺之一，是禅宗六祖惠能宏扬“南宗禅法”的发源地。[1] \r\n南华寺始建于南北朝梁武帝天监元年（公元502年）。天监三年，寺庙建成，梁武帝赐“宝林寺”名。后又先后更名为“中兴寺”、“法泉寺”、至宋开宝元年（公元968年），宋太宗敕赐“南华禅寺”，寺名乃沿袭至今。因禅宗六祖在此弘法，也称六祖道场。 南华寺建筑面积一万二千多平方米，由曹溪门、放生池、宝林门、天王殿、大雄宝殿、藏经阁、灵照塔、六祖殿等建筑群组成。建筑除灵照塔、六祖殿外，都是1934年后虚云和尚募化重修的。[2] \r\n1983年，南华寺最早一批被国务院定为汉族地区佛教全国重点寺院。2001年06月25日，南华寺作为明、清时期古建筑，被国务院批准列入第五批全国重点文物保护单位名单。', '00000012', '00000013', '广东省韶关市南二十公里庾岭分脉的山麓', '0751-6501223', '4A', '4', 'http://www.iqiyi.com/w_19rubqkrnd.html', '00000014');
INSERT INTO `scenic` VALUES ('00000015', '/tourplace/img/scenicindex/tiantan.jpg', '天坛', '天坛，世界文化遗产，全国重点文物保护单位，国家AAAAA级旅游景区，全国文明风景旅游区示范点。\r\n天坛，在北京市南部，东城区永定门内大街东侧。占地约273万平方米。天坛始建于明永乐十八年（1420年），清乾隆、光绪时曾重修改建。为明、清两代帝王祭祀皇天、祈五谷丰登之场所。天坛是圜丘、祈谷两坛的总称，有坛墙两重，形成内外坛，坛墙南方北圆，象征天圆地方。主要建筑在内坛，圜丘坛在南、祈谷坛在北，二坛同在一条南北轴线上，中间有墙相隔。圜丘坛内主要建筑有圜丘坛、皇穹宇等等，祈谷坛内主要建筑有祈年殿、皇乾殿、祈年门等。', '00000003', '00000004', '北京市东城区天坛东路甲1号天坛公园内', '010-67013036', '5A', '4', 'http://v.youku.com/v_show/id_XNTYwMTQwMjky.html', '00000015');
INSERT INTO `scenic` VALUES ('00000016', '/tourplace/img/scenicindex/dongfangmingzhu', '东方明珠', '东方明珠广播电视塔（The Oriental Pearl Radio & TV Tower）是上海的标志性文化景观之一，位于浦东新区陆家嘴，塔高约468米。该建筑于1991年7月兴建，1995年5月投入使用，承担上海6套无线电视发射业务，地区覆盖半径80公里。[1-3] \r\n东方明珠广播电视塔是国家首批AAAAA级旅游景区。塔内有太空舱、旋转餐厅、上海城市历史发展陈列馆等景观和设施，1995年被列入上海十大新景观之一。', '00000002', '00000003', '上海黄浦江畔（陆家嘴金融贸易区）', '021-58797138', '5A', '7', 'http://v.youku.com/v_show/id_XNjgwOTc3MDYw.html', '00000016');
INSERT INTO `scenic` VALUES ('99999987', '/tourplace/img/scenicindex/hufujinzita.jpg', '胡夫金字塔', ' ', '99999999', '99999999', ' ', ' ', ' ', '8', ' ', '');
INSERT INTO `scenic` VALUES ('99999988', '/tourplace/img/scenicindex/ziyounvshenxiang.jpg', '自由女神像', ' ', '99999999', '99999999', '  ', ' ', ' ', '8', ' ', '');
INSERT INTO `scenic` VALUES ('99999989', '/tourplace/img/scenicindex/baijinhangong.jpg', '白金汉宫', '白金汉宫（Buckingham Palace）是英国君主位于伦敦的主要寝宫及办公处。宫殿坐落在威斯敏斯特，是国家庆典和王室欢迎礼举行场地之一，也是一处重要的旅游景点。在英国历史上的欢庆或危机时刻，白金汉宫也是一处重要的集会场所。\r\n1703年至1705年，白金汉和诺曼比公爵约翰·谢菲尔德在此兴建了一处大型镇厅建筑“白金汉宫”，构成了今天的主体建筑，1761年，乔治三世获得该府邸，并作为一处私人寝宫。此后宫殿的扩建工程持续超过了75年，主要由建筑师约翰·纳西和爱德华·布罗尔主持，为中央庭院构筑了三侧建筑。1837年，维多利亚女王登基后，白金汉宫成为英王正式宫寝。19世纪末20世纪初，宫殿公共立面修建，形成延续至今天白金汉宫形象。二战期间，宫殿礼拜堂遭一枚德国炸弹袭击而毁；在其址上建立的女王画廊于1962年向公众开放，展示皇家收藏品。现在的白金汉宫对外开放参观，每天清晨都会进行著名的禁卫军交接典礼，成为英国王室文化的一大景观。', '99999999', '99999999', '', '', ' ', '8', ' ', '');
INSERT INTO `scenic` VALUES ('99999990', ' ', '悉尼歌剧院', ' ', '99999999', '99999999', ' ', ' ', ' ', '8', ' ', '');
INSERT INTO `scenic` VALUES ('99999991', ' ', '威斯敏特教堂', ' ', '99999999', '99999999', ' ', ' ', ' ', '8', ' ', '');
INSERT INTO `scenic` VALUES ('99999992', ' ', '富士山', ' ', '99999999', '99999999', ' ', ' ', ' ', '8', ' ', '');
INSERT INTO `scenic` VALUES ('99999993', ' ', '普罗旺斯', ' ', '99999999', '99999999', ' ', ' ', ' ', '8', ' ', '');
INSERT INTO `scenic` VALUES ('99999994', ' ', '普吉岛', ' ', '99999999', '99999999', ' ', ' ', ' ', '8', ' ', '');
INSERT INTO `scenic` VALUES ('99999995', ' ', '塞班岛', ' ', '99999999', '99999999', ' ', ' ', ' ', '8', ' ', '');
INSERT INTO `scenic` VALUES ('99999996', ' ', '埃菲尔铁塔', ' ', '99999999', '99999999', ' ', ' ', ' ', '8', ' ', '');

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
INSERT INTO `ticket` VALUES ('00000001', '00000001', '/tourplace/img/user/11.png', '20170401');

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
  `User_Birthday` char(10) DEFAULT NULL COMMENT '用户出生年月日（普通用户填写，官方用户为空）',
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
INSERT INTO `user` VALUES ('00000009', 'qqq', 'qqq', 'ddd', 'qqq', '0', '111123123123', '1231231', '123123123123123123', '50', null, '0', '/tourplace/src/img/user/00000009.jpg');
INSERT INTO `user` VALUES ('00000010', '小洋葱头', '010203', null, '无', null, null, null, null, '50', null, '0', '/tourplace/img/user/00.jpg');
INSERT INTO `user` VALUES ('00000015', '程序猿001', 'asdf', null, '', null, null, null, null, '50', null, '0', '/tourplace/img/user/00.jpg');
INSERT INTO `user` VALUES ('10000002', '黄山', '010203', null, '无', null, null, null, null, '50', '00000001', '1', '/tourplace/img/user/00.jpg');
INSERT INTO `user` VALUES ('10000003', '刘公岛', '123', null, '无', null, null, null, null, '50', '00000002', '1', '/tourplace/img/user/00.jpg');

-- ----------------------------
-- Table structure for `user-ticket`
-- ----------------------------
DROP TABLE IF EXISTS `user-ticket`;
CREATE TABLE `user-ticket` (
  `User_ID` char(8) NOT NULL COMMENT '持票用户ID',
  `UserTicket_Price` int(6) NOT NULL COMMENT '门票定价（普通用户定价不统一，由用户自己定价；官方用户定价必须固定）',
  `UserTicket_Count` smallint(6) NOT NULL COMMENT '用户仓库门票数量（官方用户所有门票都要上架）',
  `Ticket_ID` char(8) NOT NULL COMMENT '门票ID',
  `UserTicket_Type` int(1) NOT NULL COMMENT '门票状态（0在仓库 1出售中 2已过期）',
  PRIMARY KEY (`User_ID`,`Ticket_ID`,`UserTicket_Type`),
  KEY `Ticket_ID` (`Ticket_ID`) USING BTREE,
  KEY `User_ID` (`User_ID`),
  CONSTRAINT `Ticket_ID` FOREIGN KEY (`Ticket_ID`) REFERENCES `ticket` (`Ticket_ID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `User_ID` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user-ticket
-- ----------------------------

-- ----------------------------
-- Table structure for `user2`
-- ----------------------------
DROP TABLE IF EXISTS `user2`;
CREATE TABLE `user2` (
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
  PRIMARY KEY (`User_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user2
-- ----------------------------
INSERT INTO `user2` VALUES ('00000009', 'qqq', 'qqq', 'ddd', 'qqq', '0', '111123123123', '1231231', '123123123123123123', '50', null, '0', '/tourplace/src/img/user/00000009.jpg');
INSERT INTO `user2` VALUES ('00000010', '小洋葱头', '010203', null, '无', null, null, null, null, '50', null, '0', '/tourplace/img/user/00.jpg');
INSERT INTO `user2` VALUES ('10000002', '黄山', '010203', null, '无', null, null, null, null, '50', '00000001', '1', '/tourplace/img/user/00.jpg');
INSERT INTO `user2` VALUES ('00000015', '程序猿001', 'asdf', null, '', null, null, null, null, '50', null, '0', '/tourplace/img/user/00.jpg');
INSERT INTO `user2` VALUES ('10000003', '刘公岛', '123', null, '无', null, null, null, null, '50', '00000002', '1', '/tourplace/img/user/00.jpg');
