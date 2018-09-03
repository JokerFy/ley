/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : lay_auth

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-09-03 17:03:47
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cms_admin
-- ----------------------------
DROP TABLE IF EXISTS `cms_admin`;
CREATE TABLE `cms_admin` (
  `id` mediumint(6) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `lastloginip` varchar(15) DEFAULT '0',
  `lastlogintime` int(10) unsigned DEFAULT '0',
  `email` varchar(40) DEFAULT '',
  `realname` varchar(50) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `create_time` int(10) NOT NULL DEFAULT '0',
  `update_time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_admin
-- ----------------------------
INSERT INTO `cms_admin` VALUES ('1', 'admin', 'cae584a4861a0a16eed0edcb9e34f15b', '0', '1528084583', '321@qq.com', 'singwa', '1', '0', '1529045788');
INSERT INTO `cms_admin` VALUES ('2', 'star2', 'cae584a4861a0a16eed0edcb9e34f15b', '0', '0', 'test@163.com', '', '1', '1528774065', '1535959659');
INSERT INTO `cms_admin` VALUES ('5', '123ff', 'cae584a4861a0a16eed0edcb9e34f15b', '0', '0', '321@qq.com', '', '1', '1528795849', '1529046358');
INSERT INTO `cms_admin` VALUES ('9', 'L\'test', 'cae584a4861a0a16eed0edcb9e34f15b', '0', '0', '123@qq.com', '', '1', '1528966728', '1528966728');
INSERT INTO `cms_admin` VALUES ('10', '12312321', '7c6069cd8e5025358922b6d9f65cb327', '0', '0', '123@121.com', '', '1', '1528962544', '1528962544');
INSERT INTO `cms_admin` VALUES ('16', 'xiaofang', 'cae584a4861a0a16eed0edcb9e34f15b', '0', '0', '494561@qq.com', '', '1', '1535959793', '1535959793');

-- ----------------------------
-- Table structure for cms_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `cms_auth_group`;
CREATE TABLE `cms_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `pid` smallint(8) NOT NULL DEFAULT '0',
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` varchar(1000) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_auth_group
-- ----------------------------
INSERT INTO `cms_auth_group` VALUES ('1', '0', '管理员', '1', '25,26,27,33,37,31,32,28,34,35,36,38,30,39,40,41,42');
INSERT INTO `cms_auth_group` VALUES ('4', '0', '游客a', '1', '25,26,27,31,32,28,34,44,45,46,47,55,56,57,58');
INSERT INTO `cms_auth_group` VALUES ('5', '0', '合作方', '1', '25,26,27,33,31,32,28,34,35,36,38');
INSERT INTO `cms_auth_group` VALUES ('9', '0', '这是测试组1', '1', '25,26,27,33,37,31,32,28,34,35,36,38,30,39,40,41');
INSERT INTO `cms_auth_group` VALUES ('10', '9', '我是测试组1的子组', '1', '25,26,27,33,37,31,32,28,34,35,36,38,30,39');
INSERT INTO `cms_auth_group` VALUES ('12', '0', 'tes', '1', '25,26,27,37,31,32,28,34,35,36,38');
INSERT INTO `cms_auth_group` VALUES ('14', '0', 'gagaga', '1', '25,67,26,27,37,31,32,28,34,35,36,38,30,39,40,41,42,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,65,62,63,64');
INSERT INTO `cms_auth_group` VALUES ('15', '4', '123', '1', '25,26,27,32,31,37');

-- ----------------------------
-- Table structure for cms_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `cms_auth_group_access`;
CREATE TABLE `cms_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`) USING BTREE,
  KEY `uid` (`uid`) USING BTREE,
  KEY `group_id` (`group_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_auth_group_access
-- ----------------------------
INSERT INTO `cms_auth_group_access` VALUES ('1', '1');
INSERT INTO `cms_auth_group_access` VALUES ('2', '4');
INSERT INTO `cms_auth_group_access` VALUES ('5', '1');
INSERT INTO `cms_auth_group_access` VALUES ('9', '9');
INSERT INTO `cms_auth_group_access` VALUES ('13', '1');
INSERT INTO `cms_auth_group_access` VALUES ('16', '15');

-- ----------------------------
-- Table structure for cms_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `cms_auth_rule`;
CREATE TABLE `cms_auth_rule` (
  `id` smallint(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` smallint(10) NOT NULL DEFAULT '0',
  `level` tinyint(1) NOT NULL DEFAULT '1',
  `name` char(80) NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '',
  `nav` varchar(10) NOT NULL DEFAULT '',
  `icon` varchar(30) NOT NULL DEFAULT '' COMMENT '图标',
  `listorder` smallint(10) unsigned NOT NULL DEFAULT '0',
  `create_time` int(10) NOT NULL DEFAULT '0',
  `update_time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=72 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_auth_rule
-- ----------------------------
INSERT INTO `cms_auth_rule` VALUES ('67', '25', '2', 'admin/Sys/index', '常规管理', '1', '1', '', '后台管理', 'layui-icon-util', '0', '0', '0');
INSERT INTO `cms_auth_rule` VALUES ('34', '28', '4', 'admin/auth.roles/add', '角色添加', '1', '1', '', '角色管理', '', '0', '1528796243', '1528796243');
INSERT INTO `cms_auth_rule` VALUES ('36', '28', '4', 'admin/auth.roles/edit', '角色编辑', '1', '1', '', '角色管理', '', '0', '1528796350', '1528796350');
INSERT INTO `cms_auth_rule` VALUES ('37', '27', '4', 'admin/auth.admin/delete', '管理员删除', '1', '1', '', '管理员列表', '', '0', '1528796445', '1528796445');
INSERT INTO `cms_auth_rule` VALUES ('25', '0', '1', 'admin/index/', '后台管理', '1', '1', '', '后台管理', 'layui-icon-home', '0', '1528633824', '1528633824');
INSERT INTO `cms_auth_rule` VALUES ('26', '25', '2', 'admin/index/index', '权限管理', '1', '1', '', '权限管理', 'layui-icon-group', '0', '1528635447', '1528635447');
INSERT INTO `cms_auth_rule` VALUES ('27', '26', '3', 'admin/auth.admin/index', '管理员列表', '1', '1', '', '权限管理', '', '0', '1528635483', '1528635483');
INSERT INTO `cms_auth_rule` VALUES ('28', '26', '3', 'admin/auth.roles/index', '角色管理', '1', '1', '', '权限管理', '', '0', '1528636197', '1528636197');
INSERT INTO `cms_auth_rule` VALUES ('30', '26', '3', 'admin/auth.rules/index', '规则管理', '1', '1', '', '权限管理', '', '0', '1528704159', '1528704159');
INSERT INTO `cms_auth_rule` VALUES ('31', '27', '4', 'admin/auth.admin/add', '管理员添加', '1', '1', '', '权限管理', '', '0', '1528793019', '1528793019');
INSERT INTO `cms_auth_rule` VALUES ('32', '27', '4', 'admin/auth.admin/edit', '管理员编辑', '1', '1', '', '权限管理', '', '0', '1528794102', '1528794102');
INSERT INTO `cms_auth_rule` VALUES ('38', '28', '4', 'admin/auth.roles/delete', '角色删除', '1', '1', '', '角色管理', '', '0', '1528796485', '1528796485');
INSERT INTO `cms_auth_rule` VALUES ('39', '30', '4', 'admin/auth.rules/add', '权限添加', '1', '1', '', '规则管理', '', '0', '1528796556', '1528796556');
INSERT INTO `cms_auth_rule` VALUES ('40', '30', '4', 'admin/auth.rules/edit', '权限编辑', '1', '1', '', '规则管理', '', '0', '1528796607', '1528796607');
INSERT INTO `cms_auth_rule` VALUES ('42', '30', '4', 'admin/auth.rules/delete', '权限删除', '1', '1', '', '规则管理', '', '0', '1528796757', '1528796757');
INSERT INTO `cms_auth_rule` VALUES ('44', '25', '2', 'admin/content/#', 'CMS管理', '1', '1', '', 'CMS管理', 'layui-icon-set-sm', '0', '1529043619', '1529043619');
INSERT INTO `cms_auth_rule` VALUES ('45', '44', '3', 'admin/cms.content/index', '文章管理', '1', '1', '', '文章管理', 'layui-icon-set-sm', '0', '1529043806', '1529043806');
INSERT INTO `cms_auth_rule` VALUES ('46', '45', '4', 'admin/cms.content/add', '添加文章', '1', '1', '', '文章管理', 'layui-icon-set-sm', '0', '1529046963', '1529046963');
INSERT INTO `cms_auth_rule` VALUES ('47', '45', '4', 'admin/cms.content/edit', '编辑文章', '1', '1', '', '文章管理', 'layui-icon-set-sm', '0', '1529047259', '1529047259');
INSERT INTO `cms_auth_rule` VALUES ('48', '45', '4', 'admin/cms.content/delete', '删除文章', '1', '1', '', '文章管理', 'layui-icon-set-sm', '0', '1529047307', '1529047307');
INSERT INTO `cms_auth_rule` VALUES ('55', '44', '3', 'admin/cms.position/index', '推荐位管理', '1', '1', '', 'CMS管理', 'layui-icon-set-sm', '0', '1529048542', '1529048542');
INSERT INTO `cms_auth_rule` VALUES ('56', '55', '4', 'admin/cms.position/add', '添加推荐位', '1', '1', '', '推荐位管理', 'layui-icon-set-sm', '0', '1529048701', '1529048701');
INSERT INTO `cms_auth_rule` VALUES ('57', '55', '4', 'admin/cms.position/edit', '编辑推荐位', '1', '1', '', '推荐位管理', 'layui-icon-set-sm', '0', '1529048737', '1529048737');
INSERT INTO `cms_auth_rule` VALUES ('58', '55', '4', 'admin/cms.position/delete', '删除推荐位', '1', '1', '', '推荐位管理', 'layui-icon-set-sm', '0', '1529048851', '1529048851');
INSERT INTO `cms_auth_rule` VALUES ('60', '44', '3', 'admin/cms.pcontent/index', '推荐位内容管理', '1', '1', '', 'CMS管理', 'layui-icon-set-sm', '0', '1529048959', '1529048959');
INSERT INTO `cms_auth_rule` VALUES ('61', '60', '4', 'admin/cms.pcontent/delete', '推荐位内容删除', '1', '1', '', '推荐位内容管理', 'layui-icon-set-sm', '0', '1529055445', '1529055445');
INSERT INTO `cms_auth_rule` VALUES ('62', '0', '1', 'admin/index/#', '博客系统', '1', '1', '', '', '', '0', '0', '0');
INSERT INTO `cms_auth_rule` VALUES ('63', '62', '2', 'admin/index/test', '我属于博客系统', '1', '1', '', '', '', '0', '0', '0');
INSERT INTO `cms_auth_rule` VALUES ('64', '62', '2', 'admin/index/hehe', '我也是博客系统', '1', '1', '', '', '', '0', '0', '0');
INSERT INTO `cms_auth_rule` VALUES ('65', '25', '2', 'admin/index/main', '后台首页', '1', '1', '', '后台管理', 'layui-icon-home', '9', '0', '0');

-- ----------------------------
-- Table structure for cms_menu
-- ----------------------------
DROP TABLE IF EXISTS `cms_menu`;
CREATE TABLE `cms_menu` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `parentid` smallint(6) NOT NULL DEFAULT '0',
  `m` varchar(20) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `c` varchar(20) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `f` varchar(20) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `data` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `listorder` smallint(6) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `listorder` (`listorder`) USING BTREE,
  KEY `parentid` (`parentid`) USING BTREE,
  KEY `module` (`m`,`c`,`f`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of cms_menu
-- ----------------------------
INSERT INTO `cms_menu` VALUES ('1', '前端导航', '0', 'admin', 'menu', 'index', '', '10', '1', '1', '0');
INSERT INTO `cms_menu` VALUES ('2', '后台菜单', '0', 'admin', 'content', 'index', '', '3', '1', '1', '0');
INSERT INTO `cms_menu` VALUES ('3', '用户管理', '2', 'admin', 'user', 'index', '', '0', '-1', '1', '1');
INSERT INTO `cms_menu` VALUES ('4', '推荐位管理', '2', 'admin', 'position', 'index', '', '4', '1', '1', '1');
INSERT INTO `cms_menu` VALUES ('5', '推荐位内容管理', '2', 'admin', 'position', 'positioncontent', '', '1', '1', '1', '1');
INSERT INTO `cms_menu` VALUES ('6', '基本管理', '2', 'admin', 'basic', 'index', '', '0', '-1', '1', '1');
INSERT INTO `cms_menu` VALUES ('7', '用户管理', '1', 'admin', 'admin', 'index', '', '0', '1', '1', '1');
INSERT INTO `cms_menu` VALUES ('8', '菜单管理', '2', 'admin', 'menu', 'index', '', '9', '1', '1', '1');
INSERT INTO `cms_menu` VALUES ('9', '内容管理', '2', 'admin', 'content', 'index', '', '5', '1', '1', '1');
INSERT INTO `cms_menu` VALUES ('10', '体育', '0', 'home', 'cat', 'index', '', '3', '1', '0', '0');
INSERT INTO `cms_menu` VALUES ('11', '科技', '0', 'home', 'cat ', 'index', '', '0', '-1', '0', '0');
INSERT INTO `cms_menu` VALUES ('12', '汽车', '0', 'home', 'cat', 'index', '', '0', '-1', '0', '0');
INSERT INTO `cms_menu` VALUES ('13', '科技', '0', 'home', 'cat', 'index', '', '0', '1', '0', '0');
INSERT INTO `cms_menu` VALUES ('14', '新闻', '0', 'home', 'cat', 'index', '', '0', '1', '0', '0');
INSERT INTO `cms_menu` VALUES ('15', '', '0', '', '', '', '', '0', '1', '0', '0');

-- ----------------------------
-- Table structure for cms_news
-- ----------------------------
DROP TABLE IF EXISTS `cms_news`;
CREATE TABLE `cms_news` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `title` varchar(80) NOT NULL DEFAULT '',
  `small_title` varchar(30) NOT NULL DEFAULT '',
  `title_font_color` varchar(250) NOT NULL DEFAULT '' COMMENT '标题颜色',
  `content` mediumtext NOT NULL,
  `thumb` varchar(100) NOT NULL DEFAULT '',
  `keywords` char(40) NOT NULL DEFAULT '',
  `description` varchar(250) NOT NULL COMMENT '文章描述',
  `posids` varchar(250) NOT NULL DEFAULT '',
  `listorder` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `copyfrom` varchar(250) DEFAULT NULL COMMENT '来源',
  `username` char(20) NOT NULL,
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `status` (`status`,`listorder`,`id`) USING BTREE,
  KEY `listorder` (`catid`,`status`,`listorder`,`id`) USING BTREE,
  KEY `catid` (`catid`,`status`,`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_news
-- ----------------------------
INSERT INTO `cms_news` VALUES ('21', '14', '习近平今日下午出席解放军代表团全体会议', '习近平出席解放军代表团全体会议', '', '', '/upload/2016/03/13/56e519a185c93.png', '中共中央总书记 国家主席 中央军委主席 习近平', '中共中央总书记', '', '5', '1', '1', 'admin', '1457854896', '0', '60');
INSERT INTO `cms_news` VALUES ('22', '12', '李克强让部长们当第一新闻发言人', '李克强让部长们当第一新闻发言人', '', '', '/upload/2016/03/13/56e51b6ac8ce2.jpg', '李克强  新闻发言人', '部长直接面对媒体回应关切，还能直接读到民情民生民意，而不是看别人的舆情汇报。', '', '6', '1', '0', 'admin', '1457855362', '0', '33');
INSERT INTO `cms_news` VALUES ('23', '1', '重庆美女球迷争芳斗艳1', '重庆美女球迷争芳斗艳', '', '1', '/upload/2016/03/13/56e51cbd34470.png', '重庆美女 球迷 争芳斗艳', '重庆美女球迷争芳斗艳', '', '9', '1', '0', 'admin', '1457855680', '0', '22');
INSERT INTO `cms_news` VALUES ('24', '12', '中超-汪嵩世界波制胜 富力客场1-0力擒泰达', '中超-汪嵩世界波制胜 富力客场1-0力擒泰达', '', '', '/upload/2016/03/13/56e51fc82b13a.png', '中超 汪嵩世界波  富力客场 1-0力擒泰达', '中超-汪嵩世界波制胜 富力客场1-0力擒泰达', '', '1', '1', '0', 'admin', '1457856460', '0', '25');
INSERT INTO `cms_news` VALUES ('26', '10', '一点浩然气，千里快哉风', '快哉快哉', '', '<p>\r\n	<span style=\"color:#333333;font-family:&quot;font-size:13.91px;background-color:#FFFFFF;\">落日绣帘卷，亭下水连空。知君为我，新作窗户湿青红。长记平山堂上，欹枕江南烟雨，渺渺没孤鸿。认得醉翁语，山色有无中。</span>\r\n</p>\r\n<p>\r\n	<span style=\"color:#333333;font-family:&quot;font-size:13.91px;background-color:#FFFFFF;\"><img src=\"/upload\\20180606\\7485cbd37120456d5b1731e9f061ee4e.jpg\" alt=\"\" /><br />\r\n</span>\r\n</p>', '/upload/20180606/978fc3c6e93d7af5a69929fede65d9e2.jpg', '侠客', '侠客', '', '4', '1', null, '', '0', '0', '0');
INSERT INTO `cms_news` VALUES ('29', '4', '1', '2', '', '                1            ', '/upload/20180606/1126b296194751d5ba5de07b7fe1bdb0.jpg', '2', '1', '', '2', '1', null, '', '0', '0', '0');
INSERT INTO `cms_news` VALUES ('32', '10', '2', '2', '', '2', '/upload\\20180606\\9f14489fb65a9cd6730ac3a1631b19ab.jpg', '2', '2', '', '3', '-1', null, '', '0', '0', '0');

-- ----------------------------
-- Table structure for cms_news_content
-- ----------------------------
DROP TABLE IF EXISTS `cms_news_content`;
CREATE TABLE `cms_news_content` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `news_id` mediumint(8) unsigned NOT NULL,
  `content` mediumtext NOT NULL,
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `news_id` (`news_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_news_content
-- ----------------------------
INSERT INTO `cms_news_content` VALUES ('7', '17', '&lt;p&gt;\r\n	gsdggsgsgsgsg\r\n&lt;/p&gt;\r\n&lt;p&gt;\r\n	sgsg\r\n&lt;/p&gt;\r\n&lt;p&gt;\r\n	gsdgsg \r\n&lt;/p&gt;\r\n&lt;p style=&quot;text-align:center;&quot;&gt;\r\n	       ggg\r\n&lt;/p&gt;', '1455756856', '0');
INSERT INTO `cms_news_content` VALUES ('8', '18', '&lt;p&gt;\r\n	你好\r\n&lt;/p&gt;\r\n&lt;p&gt;\r\n	我很好dsggfg\r\n&lt;/p&gt;\r\n&lt;p&gt;\r\n	&lt;br /&gt;\r\n&lt;/p&gt;\r\n&lt;p&gt;\r\n	gsgfgdfgd\r\n&lt;/p&gt;\r\n&lt;p&gt;\r\n	&lt;br /&gt;\r\n&lt;/p&gt;\r\n&lt;p&gt;\r\n	&lt;br /&gt;\r\n&lt;/p&gt;\r\n&lt;p&gt;\r\n	&lt;br /&gt;\r\n&lt;/p&gt;\r\n&lt;p&gt;\r\n	gggg\r\n&lt;/p&gt;', '1455756999', '0');
INSERT INTO `cms_news_content` VALUES ('9', '19', '111', '1456673467', '0');
INSERT INTO `cms_news_content` VALUES ('10', '20', '111', '1456674909', '0');
INSERT INTO `cms_news_content` VALUES ('11', '21', '&lt;p&gt;\r\n	&lt;span style=&quot;font-family:\'Microsoft YaHei\', u5FAEu8F6Fu96C5u9ED1, Arial, SimSun, u5B8Bu4F53;font-size:16px;line-height:32px;&quot;&gt;&amp;nbsp; &amp;nbsp; &amp;nbsp; 3月13日下午，中共中央总书记、国家主席、中央军委主席习近平出席十二届全国人大四次会议解放军代表团全体会议，并发表重要讲话。&lt;/span&gt;\r\n&lt;/p&gt;\r\n&lt;p&gt;\r\n	&lt;span style=&quot;font-family:\'Microsoft YaHei\', u5FAEu8F6Fu96C5u9ED1, Arial, SimSun, u5B8Bu4F53;font-size:16px;line-height:32px;&quot;&gt;&lt;img src=&quot;/upload/2016/03/13/56e519acb12ee.png&quot; alt=&quot;&quot; /&gt;&lt;br /&gt;\r\n&lt;/span&gt;\r\n&lt;/p&gt;', '1457854896', '0');
INSERT INTO `cms_news_content` VALUES ('12', '22', '&lt;p style=&quot;font-size:16px;font-family:\'Microsoft YaHei\', u5FAEu8F6Fu96C5u9ED1, Arial, SimSun, u5B8Bu4F53;&quot;&gt;\r\n	&amp;nbsp; &amp;nbsp; “部长通道”是今年两会一大亮点，成为两会开放透明和善待媒体的一个象征。在这个通道上，以往记者拉着喊着部长接受采访的场景不见了，变为部长主动站出来回应关切，甚至变成部长排队10多分钟等着接受采访。媒体报道称，两会前李克强总理接连两次“发话”，要求各部委主要负责人“要积极回应舆论关切”。部长主动放料，使这个通道上传出了很多新闻，如交通部长对拥堵费传闻的回应，人社部部长称网传延迟退休时间表属误读等。\r\n&lt;/p&gt;\r\n&lt;p style=&quot;font-size:16px;font-family:\'Microsoft YaHei\', u5FAEu8F6Fu96C5u9ED1, Arial, SimSun, u5B8Bu4F53;&quot;&gt;\r\n	&amp;nbsp; &amp;nbsp; &amp;nbsp;&amp;nbsp;&lt;img src=&quot;/upload/2016/03/13/56e51b7fcd445.jpg&quot; alt=&quot;&quot; /&gt;\r\n&lt;/p&gt;\r\n&lt;p style=&quot;font-size:16px;font-family:\'Microsoft YaHei\', u5FAEu8F6Fu96C5u9ED1, Arial, SimSun, u5B8Bu4F53;&quot;&gt;\r\n	&amp;nbsp; &amp;nbsp; &amp;nbsp; 记者之所以喜欢跑两会，原因之一是两会上高官云集，能“堵”到、“逮”到、“抢”到很多大新闻——现在不需要堵、逮和抢，部长们主动曝料，打通了各种阻隔，树立了开明开放的政府形象。期待“部长通道”不只在两会期间存在，最好能成为一种官媒交流、官民沟通的常态化新闻通道。\r\n&lt;/p&gt;\r\n&lt;p style=&quot;font-size:16px;font-family:\'Microsoft YaHei\', u5FAEu8F6Fu96C5u9ED1, Arial, SimSun, u5B8Bu4F53;&quot;&gt;\r\n	&lt;span style=&quot;font-family:\'Microsoft YaHei\', u5FAEu8F6Fu96C5u9ED1, Arial, SimSun, u5B8Bu4F53;font-size:16px;line-height:32px;&quot;&gt;部长们多面对媒体多发言，不仅能提高自身的媒介素养，也带动部门新闻发言人，更加重视与媒体沟通。部长直接面对媒体回应关切，还能直接读到民情民生民意，而不是看别人的舆情汇报。&lt;/span&gt;\r\n&lt;/p&gt;', '1457855362', '0');
INSERT INTO `cms_news_content` VALUES ('13', '23', '&lt;p&gt;\r\n	&lt;span style=&quot;color:#666666;font-family:\'Microsoft Yahei\', 微软雅黑, SimSun, 宋体, \'Arial Narrow\', serif;font-size:14px;line-height:28px;background-color:#FFFFFF;&quot;&gt;&amp;nbsp; &amp;nbsp; &amp;nbsp; 2016年3月13日，2016年中超联赛第2轮：重庆力帆vs河南建业，主场美女球迷争芳斗艳。&lt;/span&gt;\r\n&lt;/p&gt;\r\n&lt;p&gt;\r\n	&lt;span style=&quot;color:#666666;font-family:\'Microsoft Yahei\', 微软雅黑, SimSun, 宋体, \'Arial Narrow\', serif;font-size:14px;line-height:28px;background-color:#FFFFFF;&quot;&gt;&lt;img src=&quot;/upload/2016/03/13/56e51cb17542e.png&quot; alt=&quot;&quot; /&gt;&lt;img src=&quot;/upload/2016/03/13/56e51cb180f8a.png&quot; alt=&quot;&quot; /&gt;&lt;br /&gt;\r\n&lt;/span&gt;\r\n&lt;/p&gt;', '1457855680', '0');
INSERT INTO `cms_news_content` VALUES ('14', '24', '<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	新浪体育讯　　北京时间2016年3月12日晚7点35分，2016年中超联赛第2轮的一场比赛在天津水滴体育场进行。由天津泰达主场对阵广州富力。上半场双方机会都不多，<strong>下半场第57分钟，常飞亚左路护住皮球回做，汪嵩迎球直接远射世界波破门。随后天津泰达尽管全力进攻，但伊万诺维奇和迪亚涅都浪费了近在咫尺的机会</strong>，最终不得不0-1主场告负。\r\n</p>\r\n<p>\r\n	<img src=\"/upload/2016/03/13/56e51f63a5742.png\" alt=\"\" width=\"474\" height=\"301\" title=\"\" align=\"\" /> \r\n</p>\r\n<p>\r\n	由于首轮中超对阵北京国安的比赛延期举行，因此本场比赛实际上是天津泰达本赛季的首次亮相。新援蒙特罗领衔锋线，两名外援中后卫均首发出场。另一方面，在首轮主场不敌中超新贵河北华夏之后，本赛季球员流失较多的广州富力也许不得不早早开始他们的保级谋划。本场陈志钊红牌停赛，澳大利亚外援吉安努顶替了上轮首发的肖智。\r\n</p>\r\n<p>\r\n	广州富力显然更快地适应了比赛节奏。第3分钟，吉安努前插领球大步杀入禁区形成单刀，回防的赞纳迪内果断放铲化解险情。第8分钟，雷纳尔迪尼奥左路踩单车过人后低平球传中，约万诺维奇伸出大长腿将球挡出底线。第14分钟，富力队左路传中到远点，聂涛头球解围险些失误，送出本场比赛第一个角球。\r\n</p>\r\n<p>\r\n	天津队中场的配合逐渐找到一些感觉。第23分钟，天津队通过一连串小配合打到左路，周海滨下底传中被挡出底线。角球被富力队顶出后天津队二次将球传到禁区前沿，蒙特罗转身后射门但软弱无力被程月磊得到。第27分钟，约万诺维奇断球后直塞蒙特罗，蒙特罗转身晃开后卫在禁区外大力轰门打高。第29分钟，瓦格纳任意球吊入禁区，程月磊出击失误没有击到球，天津队后点将球再次传中，姜至鹏在对方夹击下奋力将球顶出底线。\r\n</p>\r\n<p>\r\n	双方都没有太好的打开僵局的办法，开始陷入苦战。第33分钟，常飞亚左路晃开空档突然起脚，皮球擦着近门柱稍稍偏出底线。第43分钟，白岳峰被雷纳尔迪尼奥断球得手，后者利用速度甩开约万诺维奇，低平球传中又躲过了赞纳迪内的滑铲，但吉安努门前近在咫尺的推射被杨启鹏神奇地单腿挡出！双方半场只得0-0互交白卷。\r\n</p>\r\n<p>\r\n	中场休息双方都没有换人。第47分钟，蒙特罗前场扣过多名对方队员后将球交给周海滨，但周海滨传中时禁区内的胡人天越位在先。第51分钟，王嘉楠右路晃开聂涛下底，但传中球又高又远。第54分钟，雷纳尔迪尼奥中场拿球挑过李本舰，后者无奈将其放倒吃到黄牌。第57分钟，常飞亚左路护住皮球回做，汪嵩迎球直接远射，杨启鹏鞭长莫及，皮球呼啸着直挂远角！世界波！富力队客场1-0取得领先。\r\n</p>\r\n<p>\r\n	第62分钟，瓦格纳任意球吊到禁区，程月磊再次拿球脱手，幸亏张耀坤将球踢出了边线。天津队率先做出调整，迪亚涅和周通两名前锋登场换下郭皓和瓦格纳。第64分钟，天津队右路传中，周通禁区内甩头攻门，程月磊侧扑将球得到。富力队并未保守。第66分钟，常飞亚左路连续盘带杀入禁区，小角度射门打偏。不过一分钟，雷纳尔迪尼奥禁区右角远射，皮球在门前反弹后稍稍偏出。\r\n</p>\r\n<p>\r\n	第71分钟，吉安努禁区角上回做，常飞亚跟进远射，杨启鹏单掌将球托出。天津队马上打出反击，蒙特罗禁区内转身将球分到右路，胡人天的传中找到后排插上的周海滨，但后者的大力头球顶得太正被程月磊侯个正着。富力队肖智换下卢琳。第74分钟，迪亚涅依靠强壮的身体杀入禁区直塞，蒙特罗停球后射门被密集防守的后卫挡出。\r\n</p>\r\n<p>\r\n	于洋换下雷纳尔迪尼奥，富力队加强防守。第81分钟，天津队角球开出，迪亚涅甩头攻门顶偏。天津队连续得到角球机会。第85分钟，天津队角球二次进攻，周通传中，蒙特罗后点头球回做，约万诺维奇离门不到两米处转身扫射竟然将球踢飞！\r\n</p>\r\n<div id=\"ad_33\" class=\"otherContent_01\" style=\"margin:10px 20px 10px 0px;padding:4px;\">\r\n	<iframe width=\"300px\" height=\"250px\" frameborder=\"0\" src=\"http://img.adbox.sina.com.cn/ad/28543.html\">\r\n	</iframe>\r\n</div>\r\n<p>\r\n	天津队范柏群换下李本舰。富力队用宁安换下常飞亚。第88分钟，胡人天战术犯规吃到黄牌。天津队久攻不下，第90分钟，赞纳迪内40米开外远射打偏。第93分钟，蒙特罗左路传中，迪亚涅头球争顶下来之后顺势扫射，皮球贴着横梁高出。广州富力最终将优势保持到了终场取得三分。\r\n</p>\r\n<p>\r\n	进球信息：\r\n</p>\r\n<p>\r\n	天津泰达：无。\r\n</p>\r\n<p>\r\n	广州富力：第58分钟，卢琳左路回做，汪嵩跟上远射破网。\r\n</p>\r\n<p>\r\n	黄牌信息：\r\n</p>\r\n<p>\r\n	天津泰达：第54分钟，李本舰。第88分钟，胡人天。\r\n</p>\r\n<p>\r\n	广州富力：无。\r\n</p>\r\n<p>\r\n	红牌信息：\r\n</p>\r\n<p>\r\n	无。\r\n</p>\r\n<p>\r\n	双方出场阵容：\r\n</p>\r\n<p>\r\n	天津泰达（4-5-1）：29-杨启鹏，23-聂涛、3-赞纳迪内、5-约万诺维奇、19-白岳峰，6-周海滨、7-李本舰（86分钟，28-范柏群）、8-胡人天、11-瓦格纳（63分钟，9-迪亚涅）、22-郭皓（63分钟，33-周通），10-蒙特罗；\r\n</p>\r\n<p>\r\n	广州富力（4-5-1）：1-程月磊，11-姜至鹏、5-张耀坤、22-张贤秀、28-王嘉楠，7-斯文森、21-常飞亚（88分钟，15-宁安）、23-卢琳（73分钟，29-肖智）、31-雷纳尔迪尼奥（77分钟，3-于洋）、33-汪嵩，9-吉安努。\r\n</p>\r\n<p>\r\n	（卢小挠）\r\n</p>\r\n<div>\r\n</div>\r\n<div style=\"font-size:0px;\">\r\n</div>\r\n<p>\r\n	<br />\r\n</p>', '1457856460', '0');

-- ----------------------------
-- Table structure for cms_position
-- ----------------------------
DROP TABLE IF EXISTS `cms_position`;
CREATE TABLE `cms_position` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(30) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `description` char(100) DEFAULT NULL,
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_position
-- ----------------------------
INSERT INTO `cms_position` VALUES ('1', '首页大图', '-1', '展示首页大图的推荐位1', '1455634352', '0');
INSERT INTO `cms_position` VALUES ('2', '首页大图', '1', '展示首页大图的', '1455634715', '0');
INSERT INTO `cms_position` VALUES ('3', '小图推荐', '1', '小图推荐位', '1456665873', '0');
INSERT INTO `cms_position` VALUES ('4', '首页后侧推荐位', '-1', '', '1457248469', '0');
INSERT INTO `cms_position` VALUES ('5', '右侧广告位', '0', '右侧广告位', '1457873143', '0');

-- ----------------------------
-- Table structure for cms_position_content
-- ----------------------------
DROP TABLE IF EXISTS `cms_position_content`;
CREATE TABLE `cms_position_content` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `position_id` int(5) unsigned NOT NULL,
  `title` varchar(30) NOT NULL DEFAULT '',
  `thumb` varchar(100) NOT NULL DEFAULT '',
  `url` varchar(100) DEFAULT NULL,
  `news_id` mediumint(8) unsigned NOT NULL,
  `listorder` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_position_content
-- ----------------------------
INSERT INTO `cms_position_content` VALUES ('28', '2', '习近平今日下午出席解放军代表团全体会议', '/upload/2016/03/13/56e519a185c93.png', null, '21', '0', '1', '1457854896', '0');
INSERT INTO `cms_position_content` VALUES ('29', '3', '李克强让部长们当第一新闻发言人', '/upload/2016/03/13/56e51b6ac8ce2.jpg', null, '22', '6', '1', '1457855362', '0');
INSERT INTO `cms_position_content` VALUES ('30', '3', '重庆美女球迷争芳斗艳', '/upload/2016/03/13/56e51cbd34470.png', null, '23', '0', '1', '1457855680', '0');
INSERT INTO `cms_position_content` VALUES ('31', '3', '中超-汪嵩世界波制胜 富力客场1-0力擒泰达', '/upload/2016/03/13/56e51fc82b13a.png', null, '24', '0', '1', '1457856460', '0');
INSERT INTO `cms_position_content` VALUES ('32', '5', '2015劳伦斯国际体坛精彩瞬间', '/upload/2016/03/13/56e5612d525c3.png', 'http://sports.sina.com.cn/laureus/moment2015/', '0', '0', '1', '1457873220', '0');
INSERT INTO `cms_position_content` VALUES ('33', '5', 'singwa老师教您如何学PHP', '/upload/2016/03/13/56e56211c68e7.jpg', 'http://t.imooc.com/space/teacher/id/255838', '0', '0', '1', '1457873435', '0');
INSERT INTO `cms_position_content` VALUES ('34', '2', '习近平今日下午出席解放军代表团全体会议', '/upload/2016/03/13/56e519a185c93.png', null, '21', '0', '1', '1457854896', '0');
INSERT INTO `cms_position_content` VALUES ('35', '2', '中超-汪嵩世界波制胜 富力客场1-0力擒泰达', '/upload/2016/03/13/56e51fc82b13a.png', null, '24', '0', '1', '1457856460', '0');
INSERT INTO `cms_position_content` VALUES ('38', '0', '11', '/upload\\20180830\\a774b5383fbc977cee7e2b6a570026c6.jpg', null, '0', '0', '1', '1535615893', '1535615893');
INSERT INTO `cms_position_content` VALUES ('39', '6', '习近平今日下午出席解放军代表团全体会议', '/upload/2016/03/13/56e519a185c93.png', null, '21', '3', '1', '1457854896', '1535705277');
INSERT INTO `cms_position_content` VALUES ('40', '6', '重庆美女球迷争芳斗艳', '/upload/2016/03/13/56e51cbd34470.png', null, '23', '10', '1', '1457855680', '1535705277');
INSERT INTO `cms_position_content` VALUES ('41', '7', '1', '/upload/20180606/1126b296194751d5ba5de07b7fe1bdb0.jpg', null, '29', '7', '1', '0', '1535705566');
INSERT INTO `cms_position_content` VALUES ('42', '7', '11', '/upload\\20180830\\969b0e1c3b5ec928030cd50923a2a42a.jpg', null, '33', '8', '1', '1535616474', '1535705566');
