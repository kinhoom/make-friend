<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：大叔来 www.dasuhlai.com
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$sql = <<<EOF

DROP TABLE IF EXISTS `pre_tom_ucenter_address`;
CREATE TABLE `pre_tom_ucenter_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT '0',
  `default_id` int(11) DEFAULT '0',
  `xm` varchar(255) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `province_id` int(11) DEFAULT '0',
  `city_id` int(11) DEFAULT '0',
  `area_id` int(11) DEFAULT '0',
  `area_str` varchar(255) DEFAULT NULL,
  `info` varchar(255) DEFAULT NULL,
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;


DROP TABLE IF EXISTS `pre_tom_ucenter_district`;
CREATE TABLE `pre_tom_ucenter_district` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `level` tinyint(3) unsigned DEFAULT '0',
  `upid` mediumint(8) unsigned DEFAULT '0',
  `displayorder` int(11) DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_upid` (`upid`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_tom_ucenter_member`;
CREATE TABLE `pre_tom_ucenter_member` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) DEFAULT NULL,
  `unionid` varchar(255) DEFAULT NULL,
  `bbs_uid` int(11) DEFAULT '0',
  `nickname` varchar(255) DEFAULT NULL,
  `picurl` varchar(255) DEFAULT NULL,
  `mykey` varchar(255) DEFAULT NULL,
  `xm` varchar(255) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `pwd` varchar(255) DEFAULT NULL,
  `score` int(11) DEFAULT '0',
  `last_login_type` varchar(255) DEFAULT NULL,
  `last_login_time` int(11) DEFAULT '0',
  `add_time` int(11) DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`uid`),
  KEY `idx_openid` (`openid`),
  KEY `idx_bbsid` (`bbs_uid`),
  KEY `idx_tel` (`tel`)
) ENGINE=MyISAM;
        
DROP TABLE IF EXISTS `pre_tom_ucenter_scorelog`;
CREATE TABLE `pre_tom_ucenter_scorelog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT '0',
  `add_score` int(11) DEFAULT '0',
  `reduce_score` int(11) DEFAULT '0',
  `old_score` int(11) DEFAULT NULL,
  `message` text,
  `log_time` int(11) DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

   
EOF;

runquery($sql);

$sql='INSERT INTO '.DB::table('tom_ucenter_district').'(id,name,level,upid,displayorder) SELECT id,name,level,upid,displayorder FROM '.DB::table('common_district');
DB::query($sql);

@unlink(DISCUZ_ROOT . './source/plugin/tom_ucenter/discuz_plugin_tom_ucenter.xml');
@unlink(DISCUZ_ROOT . './source/plugin/tom_ucenter/discuz_plugin_tom_ucenter_SC_GBK.xml');
@unlink(DISCUZ_ROOT . './source/plugin/tom_ucenter/discuz_plugin_tom_ucenter_SC_UTF8.xml');
@unlink(DISCUZ_ROOT . './source/plugin/tom_ucenter/discuz_plugin_tom_ucenter_TC_BIG5.xml');
@unlink(DISCUZ_ROOT . './source/plugin/tom_ucenter/discuz_plugin_tom_ucenter_TC_UTF8.xml');

$finish = TRUE;

@unlink(DISCUZ_ROOT . './source/plugin/tom_ucenter/install.php');
