<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$sql = <<<EOF

DROP TABLE IF EXISTS `pre_tom_love`;
CREATE TABLE `pre_tom_love` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bbs_uid` int(11) NOT NULL DEFAULT '0',
  `bbs_username` varchar(255) DEFAULT NULL,
  `member_id` int(11) DEFAULT '0',
  `openid` varchar(255) NOT NULL,
  `unionid` varchar(255) DEFAULT NULL,
  `vip_id` int(11) DEFAULT '0',
  `vip_time` int(11) DEFAULT '0',
  `nickname` varchar(255) NOT NULL,
  `sex` tinyint(4) NOT NULL DEFAULT '1',
  `year` int(11) NOT NULL DEFAULT '0',
  `score` int(11) NOT NULL DEFAULT '0',
  `flowers` int(11) DEFAULT '0',
  `anlians` int(11) DEFAULT '0',
  `wx` varchar(255) DEFAULT NULL,
  `qq` varchar(255) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `phone_renzheng` tinyint(4) NOT NULL DEFAULT '0',
  `friend` tinyint(4) NOT NULL DEFAULT '0',
  `marriage` tinyint(4) DEFAULT '0',
  `work_id` int(11) NOT NULL DEFAULT '0',
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
  `height` varchar(255) DEFAULT NULL,
  `weight` varchar(255) DEFAULT NULL,
  `edu_id` int(11) DEFAULT '0',
  `pay_id` int(11) DEFAULT '0',
  `marital_id` int(11) DEFAULT '0',
  `describe` varchar(255) DEFAULT NULL,
  `mate_demands` varchar(255) DEFAULT NULL,
  `pic_num` int(11) NOT NULL DEFAULT '0',
  `avatar` varchar(255) DEFAULT NULL,
  `theme` varchar(255) DEFAULT NULL,
  `renzheng` tinyint(4) NOT NULL DEFAULT '0',
  `recommend` int(11) DEFAULT '0',
  `recommend_time` int(11) DEFAULT '0',
  `recommend_do_time` int(11) DEFAULT '0',
  `is_top` int(11) DEFAULT '0',
  `sign_time` int(11) DEFAULT '0',
  `add_time` int(11) DEFAULT '0',
  `last_time` int(11) DEFAULT '0',
  `smstp_open` int(11) DEFAULT '1',
  `last_smstp_time` int(11) DEFAULT '0',
  `closed` tinyint(4) NOT NULL DEFAULT '0',
  `is_majia` int(11) DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `shenhe_status` tinyint(4) NOT NULL DEFAULT '2',
  `clicks` int(11) DEFAULT '0',
  `subscribe` int(11) DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_tom_love_guanxi`;
CREATE TABLE `pre_tom_love_guanxi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0',
  `gx_user_id` int(11) NOT NULL DEFAULT '0',
  `type_id` tinyint(4) NOT NULL DEFAULT '0',
  `flowers` int(11) DEFAULT '0',
  `time_key` int(11) DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_tom_love_pic`;
CREATE TABLE `pre_tom_love_pic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `pic_url` varchar(255) DEFAULT NULL,
  `shenhe_status` tinyint(4) NOT NULL DEFAULT '1',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_tom_love_rec`;
CREATE TABLE `pre_tom_love_rec` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `rec_time` int(11) DEFAULT '0',
  `rec_status` int(11) DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_tom_love_renzheng`;
CREATE TABLE `pre_tom_love_renzheng` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `xm` varchar(100) DEFAULT NULL,
  `tel` varchar(100) DEFAULT NULL,
  `sfzh` varchar(100) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `pic_z` varchar(255) DEFAULT NULL,
  `pic_f` varchar(255) DEFAULT NULL,
  `pic_s` varchar(255) DEFAULT NULL,
  `renzheng_time` int(11) DEFAULT '0',
  `renzheng_status` int(11) DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_tom_love_scorelog`;
CREATE TABLE `pre_tom_love_scorelog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0',
  `score_value` int(11) DEFAULT '0',
  `log_type` tinyint(4) DEFAULT '0',
  `log_time` int(11) DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_tom_love_share`;
CREATE TABLE `pre_tom_love_share` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0',
  `share_time` int(11) DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_tom_love_shuoshuo`;
CREATE TABLE `pre_tom_love_shuoshuo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `reply_count` int(11) DEFAULT '0',
  `zan_count` int(11) DEFAULT '0',
  `ss_time` int(11) DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_tom_love_tz`;
CREATE TABLE `pre_tom_love_tz` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `tz_time` int(11) DEFAULT '0',
  `is_read` int(11) DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
        
DROP TABLE IF EXISTS `pre_tom_love_order`;
CREATE TABLE `pre_tom_love_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_no` varchar(255) DEFAULT NULL,
  `order_type` int(11) DEFAULT '1',
  `openid` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `score_value` int(11) DEFAULT '0',
  `time_value` int(11) DEFAULT '0',
  `pay_price` decimal(10,2) DEFAULT '0.00',
  `order_time` int(11) DEFAULT '0',
  `pay_time` int(11) DEFAULT '0',
  `order_status` int(11) DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;


DROP TABLE IF EXISTS `pre_tom_love_report`;
CREATE TABLE `pre_tom_love_report` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `report_user_id` int(11) DEFAULT '0',
  `report_content` varchar(255) DEFAULT NULL,
  `report_pic_1` varchar(255) DEFAULT NULL,
  `report_pic_2` varchar(255) DEFAULT NULL,
  `report_time` int(11) DEFAULT '0',
  `status` int(11) DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
        
DROP TABLE IF EXISTS `pre_tom_love_common`;
CREATE TABLE `pre_tom_love_common` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `clicks` int(11) DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
        
DROP TABLE IF EXISTS `pre_tom_love_shuoshuo_photo`;
CREATE TABLE `pre_tom_love_shuoshuo_photo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ss_id` int(11) DEFAULT '0',
  `picurl` varchar(255) DEFAULT NULL,
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
        
DROP TABLE IF EXISTS `pre_tom_love_shuoshuo_reply`;
CREATE TABLE `pre_tom_love_shuoshuo_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ss_id` int(11) DEFAULT '0',
  `reply_user_id` int(11) DEFAULT '0',
  `reply_user_nickname` varchar(255) DEFAULT NULL,
  `reply_user_avatar` varchar(255) DEFAULT NULL,
  `reply_user_sex` int(11) DEFAULT '0',
  `content` varchar(255) DEFAULT NULL,
  `reply_time` int(11) DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
        
DROP TABLE IF EXISTS `pre_tom_love_shuoshuo_zan`;
CREATE TABLE `pre_tom_love_shuoshuo_zan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ss_id` int(11) DEFAULT '0',
  `zan_user_id` int(11) DEFAULT '0',
  `zan_user_nickname` varchar(255) DEFAULT NULL,
  `zan_user_avatar` varchar(255) DEFAULT NULL,
  `zan_user_sex` int(11) DEFAULT '0',
  `zan_time` int(11) DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
        
DROP TABLE IF EXISTS `pre_tom_love_district`;
CREATE TABLE `pre_tom_love_district` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `level` tinyint(3) unsigned DEFAULT '0',
  `upid` mediumint(8) unsigned DEFAULT '0',
  `displayorder` int(11) DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
        
DROP TABLE IF EXISTS `pre_tom_love_sign`;
CREATE TABLE `pre_tom_love_sign` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0',
  `sign_txt` varchar(255) DEFAULT NULL,
  `time_key` int(11) DEFAULT '0',
  `sign_time` int(11) DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_tom_love_focuspic`;
CREATE TABLE `pre_tom_love_focuspic` (
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
    
DROP TABLE IF EXISTS `pre_tom_love_flowers_log`;
CREATE TABLE `pre_tom_love_flowers_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `toUser_id` int(11) DEFAULT 0,
  `gift_id` int(11) DEFAULT 0,
  `type_id` int(11) DEFAULT '0',
  `change_num` int(11) DEFAULT NULL,
  `old_num` int(11) DEFAULT NULL,
  `txt` text,
  `log_time` int(11) DEFAULT NULL,
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
    
DROP TABLE IF EXISTS `pre_tom_love_shop_goods`;
CREATE TABLE `pre_tom_love_shop_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_name` varchar(255) DEFAULT NULL,
  `goods_picurl` varchar(255) DEFAULT NULL,
  `goods_num` int(11) DEFAULT NULL,
  `market_price` decimal(10,2) DEFAULT NULL,
  `flowers_num` int(11) DEFAULT NULL,
  `content` text,
  `add_time` int(11) DEFAULT NULL,
  `is_show` int(11) DEFAULT NULL,
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
        
DROP TABLE IF EXISTS `pre_tom_love_shop_order`;
CREATE TABLE `pre_tom_love_shop_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `xm` varchar(255) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `order_status` int(11) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
   
DROP TABLE IF EXISTS `pre_tom_love_phb`;
CREATE TABLE `pre_tom_love_phb` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0',
  `phb_type` int(11) DEFAULT '1',
  `month_id` int(11) DEFAULT '0',
  `flowers` int(11) DEFAULT '0',
  `anlians` int(11) DEFAULT '0',
  `clicks` int(11) DEFAULT '0',
  `paymoney` decimal(10,2) DEFAULT '0.00',
  `signdays` int(11) DEFAULT '0',
  `shuoshuo` int(11) DEFAULT '0',
  `sharetime` int(11) DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
           
DROP TABLE IF EXISTS `pre_tom_love_gift`;
CREATE TABLE `pre_tom_love_gift` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gift_name` varchar(255) DEFAULT NULL,
  `gift_picurl` varchar(255) DEFAULT NULL,
  `score_num` int(11) DEFAULT '0',
  `flowers_num` int(11) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `is_show` int(11) DEFAULT NULL,
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
                   
DROP TABLE IF EXISTS `pre_tom_love_gift_count`;
CREATE TABLE `pre_tom_love_gift_count` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `gift_id` int(11) DEFAULT '0',
  `gift_name` varchar(255) DEFAULT NULL,
  `gift_picurl` varchar(255) DEFAULT NULL,
  `gift_num` int(11) DEFAULT NULL,
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_tom_love_pm`;
CREATE TABLE `pre_tom_love_pm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0',
  `pm_lists_id` int(11) DEFAULT '0',
  `new_num` int(11) DEFAULT '0',
  `last_time` int(11) DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_tom_love_pm_lists`;
CREATE TABLE `pre_tom_love_pm_lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0',
  `min_use_id` int(11) DEFAULT '0',
  `max_use_id` int(11) DEFAULT '0',
  `last_content` text,
  `last_time` int(11) DEFAULT '0',
  `add_time` int(11) DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_tom_love_pm_message`;
CREATE TABLE `pre_tom_love_pm_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pm_lists_id` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT '0',
  `content` text,
  `add_time` int(11) DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

EOF;

runquery($sql);
@unlink(DISCUZ_ROOT . './source/plugin/tom_love/discuz_plugin_tom_love.xml');
@unlink(DISCUZ_ROOT . './source/plugin/tom_love/discuz_plugin_tom_love_SC_GBK.xml');
@unlink(DISCUZ_ROOT . './source/plugin/tom_love/discuz_plugin_tom_love_SC_UTF8.xml');
@unlink(DISCUZ_ROOT . './source/plugin/tom_love/discuz_plugin_tom_love_TC_BIG5.xml');
@unlink(DISCUZ_ROOT . './source/plugin/tom_love/discuz_plugin_tom_love_TC_UTF8.xml');

$finish = TRUE;

@unlink(DISCUZ_ROOT . './source/plugin/tom_love/install.php');
