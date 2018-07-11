-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2018-06-14 14:59:08
-- 服务器版本: 5.5.56-log
-- PHP 版本: 5.4.45

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `glagbn`
--

-- --------------------------------------------------------

--
-- 表的结构 `action`
--

CREATE TABLE IF NOT EXISTS `action` (
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `act_name` char(20) NOT NULL DEFAULT '' COMMENT '活动名称',
  `act_type` int(10) NOT NULL DEFAULT '0' COMMENT '活动类型，0抽奖，1公众号吸粉',
  `act_status` int(2) NOT NULL COMMENT '活动状态，0结束，1开始',
  `home_page_path` varchar(50) DEFAULT NULL COMMENT '活动url',
  `start_time` int(11) DEFAULT '0' COMMENT '活动开始时间',
  `end_time` int(11) DEFAULT '0' COMMENT '活动结束时间',
  `create_time` int(11) NOT NULL COMMENT '录入时间',
  `create_by` int(10) DEFAULT NULL COMMENT '发布者',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='抽奖活动表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `lottery_condition`
--

CREATE TABLE IF NOT EXISTS `lottery_condition` (
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `num` char(255) NOT NULL COMMENT '量',
  `type` int(10) NOT NULL COMMENT '0人数，1概率',
  `operator` varchar(10) NOT NULL DEFAULT '=' COMMENT '运算符，默认=',
  `label` varchar(50) DEFAULT NULL COMMENT '标签',
  `act_id` int(10) NOT NULL COMMENT '活动id',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='奖品条件表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `lottery_prize`
--

CREATE TABLE IF NOT EXISTS `lottery_prize` (
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT COMMENT '奖品id',
  `name` char(20) NOT NULL DEFAULT '' COMMENT '奖品名称',
  `img_url` char(255) DEFAULT NULL COMMENT '奖品图片URL',
  `des` varchar(255) NOT NULL COMMENT '奖品详情说明',
  `act_id` int(2) NOT NULL COMMENT '活动id',
  `weight` int(10) NOT NULL DEFAULT '0' COMMENT '权重值',
  `condition_where` varchar(255) DEFAULT NULL COMMENT '获奖条件（报名人数）',
  `amount` int(10) NOT NULL DEFAULT '0' COMMENT '奖品总量，-1不限量',
  `balance` int(10) NOT NULL DEFAULT '0' COMMENT '奖品余量，-1不限量',
  `last_update_time` int(11) NOT NULL COMMENT '上次更新时间',
  `create_time` int(11) NOT NULL COMMENT '录入时间',
  `create_by` int(11) DEFAULT NULL COMMENT '创建人',
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='奖品表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `lottery_record`
--

CREATE TABLE IF NOT EXISTS `lottery_record` (
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `user_id` int(16) NOT NULL COMMENT '会员id',
  `open_id` char(255) NOT NULL COMMENT '会员openid',
  `custname` varchar(10) DEFAULT NULL COMMENT '姓名',
  `mobile` char(11) DEFAULT NULL COMMENT '手机号码',
  `act_id` int(10) NOT NULL COMMENT '活动id',
  `prize_id` int(16) unsigned DEFAULT NULL COMMENT '奖品id',
  `status` int(2) NOT NULL DEFAULT '0' COMMENT '领取状态，0未报名（默认）1已报名，2已抽奖，3已领',
  `sign_time` int(11) DEFAULT NULL COMMENT '报名时间',
  `draw_time` int(11) DEFAULT NULL COMMENT '抽奖时间',
  `get_time` int(11) DEFAULT NULL COMMENT '领取时间',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除日期',
  PRIMARY KEY (`id`),
  KEY `prize_id` (`prize_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='活动中奖记录表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `syslog`
--

CREATE TABLE IF NOT EXISTS `syslog` (
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT COMMENT '日志id',
  `operator_name` char(20) NOT NULL COMMENT '操作者',
  `operator_mobile` char(11) DEFAULT '' COMMENT '操作人手机号',
  `operator_openid` char(20) NOT NULL COMMENT '操作者id',
  `operation_url` char(255) NOT NULL COMMENT '操作记录',
  `operation_sql` char(255) NOT NULL COMMENT '操作语句',
  `operation_ip` char(32) NOT NULL COMMENT 'IP地址',
  `operation_actid` int(10) NOT NULL COMMENT '活动id',
  `operation_actname` char(20) NOT NULL COMMENT '活动名',
  `operation_type` int(10) NOT NULL DEFAULT '0' COMMENT '操作类型 0日常（默认）、1报名(入库)、2领取',
  `operation_time` int(50) DEFAULT '1' COMMENT '操作日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='操作日志表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `openid` char(255) DEFAULT NULL COMMENT '用户微信open_id，可为空，标识未绑定微信',
  `nickname` char(20) NOT NULL COMMENT '昵称',
  `custname` char(20) DEFAULT NULL COMMENT '姓名',
  `mobile` char(11) DEFAULT '' COMMENT '用户手机号',
  `user_group` int(2) NOT NULL DEFAULT '0' COMMENT '用户权限，0一般、1管理员',
  `status` int(2) NOT NULL DEFAULT '1' COMMENT '用户状态，1正常，0注销',
  `source_actid` int(10) NOT NULL COMMENT '用户入库来源活动id',
  `last_update_time` int(11) NOT NULL COMMENT '上次更新时间',
  `create_time` int(11) NOT NULL COMMENT '注册时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='会员信息表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `wx_user`
--

CREATE TABLE IF NOT EXISTS `wx_user` (
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `openid` char(255) NOT NULL COMMENT '用户微信open_id，可为空，标识未绑定微信',
  `nickname` char(20) NOT NULL COMMENT '微信名',
  `wx_info` varchar(2048) NOT NULL COMMENT '微信用户信息',
  `last_update_time` int(11) NOT NULL DEFAULT '0' COMMENT '上次更新时间',
  `create_time` int(11) NOT NULL COMMENT '注册时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='微信用户信息' AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- 表的结构 `fans_record`
--

CREATE TABLE IF NOT EXISTS `fans_record` (
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `user_id` int(16) NOT NULL COMMENT '会员id',
  `open_id` char(255) NOT NULL COMMENT '会员openid',
  `custname` varchar(10) DEFAULT NULL COMMENT '姓名',
  `mobile` char(11) DEFAULT NULL COMMENT '手机号码',
  `act_id` int(10) NOT NULL COMMENT '活动id',
  `parent_id` int(16) NOT NULL DEFAULT 0 COMMENT '推荐人id，官方默认0',
  `status` int(2) NOT NULL DEFAULT '0' COMMENT '粉丝状态，0取消关注，1关注，2已完成，3已领取',
  `poster_id` int(16) NOT NULL DEFAULT NULL COMMENT '推广海报id',
  `last_follow_unfollow_time` int(11) DEFAULT NULL COMMENT '最近的一次关注取消时间',
  `complete_time` int(11) DEFAULT NULL COMMENT '完成时间',
  `get_time` int(11) DEFAULT NULL COMMENT '领取时间',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='吸粉活动记录表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `action_images`
--

CREATE TABLE IF NOT EXISTS `action_images` (
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `act_id` int(10) NOT NULL COMMENT '活动id',
  `name` varchar(50) DEFAULT NULL COMMENT '图片名称',
  `images_url` varchar(255) DEFAULT NULL COMMENT '图片地址',
  `url_type` tinyint(1) DEFAULT '1' COMMENT '图片地址类型，1服务器地址，2外链地址',
  `media_id` varchar(255) DEFAULT NULL COMMENT '图片媒体id',
  `media_expire_time` int(11) DEFAULT NULL COMMENT '媒体资源有效期',
  `last_time` int(11) DEFAULT NULL COMMENT '最近一次更新时间',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除日期',
  `create_by` int(11) DEFAULT NULL COMMENT '创建操作人id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='活动图片资源表' AUTO_INCREMENT=1 ;
-- --------------------------------------------------------

--
-- 表的结构 `wechat`
--
CREATE TABLE IF NOT EXISTS `wechat` (
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(50) NOT NULL COMMENT '公众号名称',
  `app_id` varchar(255) NOT NULL COMMENT '开发者ID',
  `app_secret` varchar(255) NOT NULL COMMENT '开发者密码',
  `token` varchar(255) NULL COMMENT '服务器配置令牌',
  `encodingaeskey` varchar(255) NULL COMMENT '消息加解密密钥',
  `server_http_url` varchar(255) NULL COMMENT '请求服务器地址(URL)',
  `last_time` int(11) DEFAULT NULL COMMENT '最近一次更新时间',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除日期',
  `create_by` int(11) DEFAULT NULL COMMENT '创建操作人id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='微信公众号信息表' AUTO_INCREMENT=1;
--
-- --------------------------------------------------------

-- 表的结构 `wechat_menu`
--
CREATE TABLE IF NOT EXISTS `wechat_menu` (
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `wechat_id` int(10) NOT NULL COMMENT '公众号id',
  `name` varchar(50) NOT NULL COMMENT '菜单名称',
  `parent_id` int(10) NOT NULL DEFAULT 0 COMMENT '父级菜单id，默认0（首级）',
  `sort` int(10) NOT NULL COMMENT '菜单顺序',
  `is_active` tinyint(1) DEFAULT '1' COMMENT '是否显示菜单，1显示，0隐藏',
  `responsetype` int(2) NOT NULL COMMENT '1链接类型view/2事件类型click',
  `jsonstr` varchar(1024) NOT NULL COMMENT 'JSON字符串配置',
  `link_url` varchar(255) DEFAULT NULL COMMENT 'view类型的url',
  `last_time` int(11) DEFAULT NULL COMMENT '最近一次更新时间',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除日期',
  `create_by` int(11) DEFAULT NULL COMMENT '创建操作人id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='微信公众号自定义菜单' AUTO_INCREMENT=1;
--
--
-- 限制表 `lottery_record`
--
ALTER TABLE `lottery_record`
  ADD CONSTRAINT `FK_record_prize` FOREIGN KEY (`prize_id`) REFERENCES `lottery_prize` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
