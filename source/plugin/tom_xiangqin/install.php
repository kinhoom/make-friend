<?php

/*
   [Dashulai!] (C)2009-2019 WWW.DASHULAI.COM.
   技术支持/更新维护：官网 https://www.dashulai.com
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$sql = <<<EOF

DROP TABLE IF EXISTS `pre_tom_xiangqin`;
CREATE TABLE `pre_tom_xiangqin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0',
  `vip_id` int(11) DEFAULT '0',
  `vip_time` int(11) DEFAULT '0',
  `user_no` int(11) DEFAULT '0',
  `qianxians` int(11) DEFAULT '0',
  `xm` varchar(255) NOT NULL,
  `sex` tinyint(4) NOT NULL DEFAULT '1',
  `birth_year` int(11) NOT NULL DEFAULT '0',
  `birth_month` int(11) DEFAULT '0',
  `birth_day` int(11) DEFAULT '0',
  `height` varchar(255) DEFAULT NULL,
  `weight` varchar(255) DEFAULT NULL,
  `xingzuo_id` int(11) DEFAULT '0',
  `shuxiang_id` int(11) DEFAULT '0',
  `xuexing_id` int(11) DEFAULT '0',
  `minzu_id` int(11) DEFAULT '0',
  `job` varchar(255) DEFAULT NULL,
  `edu_id` int(11) DEFAULT '0',
  `wx` varchar(255) DEFAULT NULL,
  `qq` varchar(255) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `country_id` int(11) NOT NULL DEFAULT '0',
  `province_id` int(11) NOT NULL DEFAULT '0',
  `city_id` int(11) DEFAULT '0',
  `area_id` int(11) DEFAULT '0',
  `towns_id` int(11) DEFAULT '0',
  `area` varchar(255) DEFAULT NULL,
  `hjcountry_id` int(11) DEFAULT '0',
  `hjprovince_id` int(11) DEFAULT '0',
  `hjcity_id` int(11) DEFAULT '0',
  `hjarea_id` int(11) DEFAULT '0',
  `hjtowns_id` int(11) DEFAULT '0',
  `hjarea` varchar(255) DEFAULT NULL,
  `marital_id` int(11) DEFAULT '0',
  `child_id` int(11) DEFAULT '0',
  `shouru` int(11) DEFAULT '0',
  `house_id` int(11) DEFAULT '0',
  `che_id` int(11) DEFAULT '0',
  `zheou_min_age` int(11) DEFAULT '0',
  `zheou_max_age` int(11) DEFAULT '0',
  `zheou_province_id` int(11) DEFAULT '0',
  `zheou_city_id` int(11) DEFAULT '0',
  `zheou_marital_id` int(11) DEFAULT '0',
  `zheou_min_height` int(11) DEFAULT '0',
  `zheou_max_height` int(11) DEFAULT '0',
  `zheou_minzu_id` int(11) DEFAULT '0',
  `zheou_edu_id` int(11) DEFAULT '0',
  `zheou_desc` varchar(255) DEFAULT NULL,
  `describe` varchar(255) DEFAULT NULL,
  `closed` int(11) DEFAULT '0',
  `is_open` int(11) DEFAULT '1',
  `top_status` int(11) DEFAULT '0',
  `top_time` int(11) DEFAULT '0',
  `top_do_time` int(11) DEFAULT '0',
  `qianxian_status` int(11) DEFAULT '1',
  `add_time` int(11) DEFAULT '0',
  `is_ok` int(11) DEFAULT '0',
  `ok_time` int(11) DEFAULT '0',
  `agree_safe` int(11) DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `shenhe_status` tinyint(4) NOT NULL DEFAULT '1',
  `clicks` int(11) DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_sex` (`sex`),
  KEY `idx_user_no` (`user_no`),
  KEY `idx_marital_id` (`marital_id`),
  KEY `idx_birth_year` (`birth_year`),
  KEY `idx_height` (`height`),
  KEY `idx_shouru` (`shouru`),
  KEY `idx_edu_id` (`edu_id`),
  KEY `idx_is_ok` (`is_ok`),
  KEY `idx_shenhe_status` (`shenhe_status`),
  KEY `idx_status` (`status`),
  KEY `idx_is_open` (`is_open`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_tom_xiangqin_autoid`;
CREATE TABLE `pre_tom_xiangqin_autoid` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `add_time` int(11) DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_tom_xiangqin_collect`;
CREATE TABLE `pre_tom_xiangqin_collect` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `xiangqin_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_tom_xiangqin_common`;
CREATE TABLE `pre_tom_xiangqin_common` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xieyi_txt` text,
  `vip_txt` text,
  `top_txt` text,
  `qianxian_txt` text,
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_tom_xiangqin_hongniang`;
CREATE TABLE `pre_tom_xiangqin_hongniang` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `picurl` varchar(255) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `wx` varchar(255) DEFAULT NULL,
  `qrcode` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `paixu` int(11) DEFAULT '100',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_tom_xiangqin_order`;
CREATE TABLE `pre_tom_xiangqin_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_no` varchar(255) DEFAULT NULL,
  `order_type` int(11) DEFAULT '1',
  `openid` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `xiangqin_id` int(11) DEFAULT '0',
  `time_value` int(11) DEFAULT '0',
  `vip_id` int(11) DEFAULT '0',
  `qianxian_value` int(11) DEFAULT '0',
  `pay_price` decimal(10,2) DEFAULT '0.00',
  `order_time` int(11) DEFAULT '0',
  `pay_time` int(11) DEFAULT '0',
  `order_status` int(11) DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_order_no` (`order_no`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_tom_xiangqin_photo`;
CREATE TABLE `pre_tom_xiangqin_photo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `xiangqin_id` int(11) NOT NULL DEFAULT '0',
  `is_avatar` int(11) DEFAULT '0',
  `pic_url` varchar(255) DEFAULT NULL,
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_tom_xiangqin_success`;
CREATE TABLE `pre_tom_xiangqin_success` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `girl_no` varchar(255) DEFAULT NULL,
  `girl_xm` varchar(255) DEFAULT NULL,
  `boy_no` varchar(255) DEFAULT NULL,
  `boy_xm` varchar(255) DEFAULT NULL,
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_tom_xiangqin_vip`;
CREATE TABLE `pre_tom_xiangqin_vip` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT '0.00',
  `days` int(11) DEFAULT '0',
  `qianxian_times` int(11) DEFAULT '0',
  `chakan_times` int(11) DEFAULT '0',
  `vip_picurl` varchar(255) DEFAULT NULL,
  `vsort` int(11) DEFAULT '100',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_tom_xiangqin_chakan`;
CREATE TABLE `pre_tom_xiangqin_chakan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `xiangqin_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) DEFAULT '0',
  `time_key` int(11) DEFAULT '0',
  `add_time` int(11) DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_tom_xiangqin_qianxian`;
CREATE TABLE `pre_tom_xiangqin_qianxian` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `xiangqin_id` int(11) DEFAULT '0',
  `hongniang_id` int(11) DEFAULT '0',
  `qianxian_xiangqin_id` int(11) DEFAULT '0',
  `qianxian_beizu` text,
  `qianxian_time` int(11) DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_tom_xiangqin_qianxians_log`;
CREATE TABLE `pre_tom_xiangqin_qianxians_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `xiangqin_id` int(11) DEFAULT '0',
  `log_type` int(11) DEFAULT '0',
  `change_num` int(11) DEFAULT '0',
  `old_num` int(11) DEFAULT '0',
  `txt` text,
  `log_time` int(11) DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_tom_xiangqin_focuspic`;
CREATE TABLE `pre_tom_xiangqin_focuspic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `picurl` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `fsort` int(11) DEFAULT '10',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

EOF;

runquery($sql);
@unlink(DISCUZ_ROOT . './source/plugin/tom_xiangqin/discuz_plugin_tom_xiangqin.xml');
@unlink(DISCUZ_ROOT . './source/plugin/tom_xiangqin/discuz_plugin_tom_xiangqin_SC_GBK.xml');
@unlink(DISCUZ_ROOT . './source/plugin/tom_xiangqin/discuz_plugin_tom_xiangqin_SC_UTF8.xml');
@unlink(DISCUZ_ROOT . './source/plugin/tom_xiangqin/discuz_plugin_tom_xiangqin_TC_BIG5.xml');
@unlink(DISCUZ_ROOT . './source/plugin/tom_xiangqin/discuz_plugin_tom_xiangqin_TC_UTF8.xml');

$finish = TRUE;

@unlink(DISCUZ_ROOT . './source/plugin/tom_xiangqin/install.php');