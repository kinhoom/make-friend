<?php
/*
 * CopyRight  : [Dashulai!] (C)2009-2019
 * Document   : 大叔来：www.dashulai.com
 * Created on : 2019-01-02,10:23:46
 * Author     : 大叔来(旺旺：https://dwz.cn/bEeiwujz) www.dashulai.com $
 * Description: [Dashulai!] (C)2009-2019 WWW.DASHULAI.COM..
 *              本资源来源于网络收集,仅供个人学习研究欣赏，请勿用于商业用途，并于下载24小时后删除!
 *              大叔来社区 全网首发 https://www.dashulai.com；
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$sql = '';

$tom_love_field = C::t('#tom_love#tom_love')->fetch_all_field();
if (!isset($tom_love_field['anlians'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_love')." ADD `anlians` int(11) DEFAULT '0';\n";
}
if (!isset($tom_love_field['vip_id'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_love')." ADD `vip_id` int(11) DEFAULT '0';\n";
}
if (!isset($tom_love_field['vip_time'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_love')." ADD `vip_time` int(11) DEFAULT '0';\n";
}
if (!isset($tom_love_field['recommend_time'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_love')." ADD `recommend_time` int(11) DEFAULT '0';\n";
}
if (!isset($tom_love_field['recommend_do_time'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_love')." ADD `recommend_do_time` int(11) DEFAULT '0';\n";
}
if (!isset($tom_love_field['mate_demands'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_love')." ADD `mate_demands` varchar(255) DEFAULT NULL;\n";
}
if (!isset($tom_love_field['last_smstp_time'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_love')." ADD `last_smstp_time` int(11) DEFAULT '0';\n";
}
if (!isset($tom_love_field['hjcountry_id'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_love')." ADD `hjcountry_id` int(11) DEFAULT '0';\n";
}
if (!isset($tom_love_field['hjprovince_id'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_love')." ADD `hjprovince_id` int(11) DEFAULT '0';\n";
}
if (!isset($tom_love_field['hjcity_id'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_love')." ADD `hjcity_id` int(11) DEFAULT '0';\n";
}
if (!isset($tom_love_field['hjarea_id'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_love')." ADD `hjarea_id` int(11) DEFAULT '0';\n";
}
if (!isset($tom_love_field['hjarea'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_love')." ADD `hjarea` varchar(255) DEFAULT NULL;\n";
}
if (!isset($tom_love_field['sign_time'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_love')." ADD `sign_time` int(11) DEFAULT '0';\n";
}
if (!isset($tom_love_field['clicks'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_love')." ADD `clicks` int(11) DEFAULT '0';\n";
}
if (!isset($tom_love_field['subscribe'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_love')." ADD `subscribe` int(11) DEFAULT '0';\n";
}
if (!isset($tom_love_field['towns_id'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_love')." ADD `towns_id` int(11) DEFAULT '0';\n";
}
if (!isset($tom_love_field['hjtowns_id'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_love')." ADD `hjtowns_id` int(11) DEFAULT '0';\n";
}
if (!isset($tom_love_field['phone_renzheng'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_love')." ADD `phone_renzheng` tinyint(4) NOT NULL DEFAULT '0';\n";
}
if (!isset($tom_love_field['shenhe_status'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_love')." ADD `shenhe_status` tinyint(4) NOT NULL DEFAULT '2';\n";
}
if (!isset($tom_love_field['member_id'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_love')." ADD `member_id` int(11) DEFAULT '0';\n";
}
if (!isset($tom_love_field['unionid'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_love')." ADD `unionid` varchar(255) DEFAULT NULL;\n";
}
if (!isset($tom_love_field['is_majia'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_love')." ADD `is_majia` int(11) DEFAULT '0';\n";
}
if (!isset($tom_love_field['smstp_open'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_love')." ADD `smstp_open` int(11) DEFAULT '1';\n";
}

$tom_love_shuoshuo_field = C::t('#tom_love#tom_love_shuoshuo')->fetch_all_field();
if (!isset($tom_love_shuoshuo_field['reply_count'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_love_shuoshuo')." ADD `reply_count` int(11) DEFAULT '0';\n";
}
if (!isset($tom_love_shuoshuo_field['zan_count'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_love_shuoshuo')." ADD `zan_count` int(11) DEFAULT '0';\n";
}

$tom_love_guanxi_field = C::t('#tom_love#tom_love_guanxi')->fetch_all_field();
if (!isset($tom_love_guanxi_field['time_key'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_love_guanxi')." ADD `time_key` int(11) DEFAULT '0';\n";
}

$tom_love_renzheng_field = C::t('#tom_love#tom_love_renzheng')->fetch_all_field();
if (!isset($tom_love_renzheng_field['pic_s'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_love_renzheng')." ADD `pic_s` varchar(255) DEFAULT NULL;\n";
}

if (!empty($sql)) {
	runquery($sql);
}

$sql = <<<EOF

CREATE TABLE IF NOT EXISTS `pre_tom_love_order` (
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
        

CREATE TABLE IF NOT EXISTS `pre_tom_love_report` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `report_user_id` int(11) DEFAULT '0',
  `report_content` varchar(255) DEFAULT NULL,
  `report_time` int(11) DEFAULT '0',
  `status` int(11) DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
        
CREATE TABLE IF NOT EXISTS `pre_tom_love_common` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `clicks` int(11) DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
        
CREATE TABLE IF NOT EXISTS `pre_tom_love_shuoshuo_photo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ss_id` int(11) DEFAULT '0',
  `picurl` varchar(255) DEFAULT NULL,
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
        
CREATE TABLE IF NOT EXISTS `pre_tom_love_shuoshuo_reply` (
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
        
CREATE TABLE IF NOT EXISTS `pre_tom_love_shuoshuo_zan` (
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
        
CREATE TABLE IF NOT EXISTS `pre_tom_love_district`(
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
        
CREATE TABLE IF NOT EXISTS `pre_tom_love_sign`(
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
     
CREATE TABLE IF NOT EXISTS `pre_tom_love_focuspic` (
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

CREATE TABLE IF NOT EXISTS `pre_tom_love_flowers_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `toUser_id` int(11) DEFAULT '0',
  `gift_id` int(11) DEFAULT '0',
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

CREATE TABLE IF NOT EXISTS `pre_tom_love_shop_goods` (
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

CREATE TABLE IF NOT EXISTS `pre_tom_love_shop_order` (
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

CREATE TABLE IF NOT EXISTS `pre_tom_love_phb` (
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
   
CREATE TABLE IF NOT EXISTS `pre_tom_love_gift` (
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
     
CREATE TABLE IF NOT EXISTS `pre_tom_love_gift_count` (
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

CREATE TABLE IF NOT EXISTS `pre_tom_love_pm` (
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

CREATE TABLE IF NOT EXISTS `pre_tom_love_pm_lists` (
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

CREATE TABLE IF NOT EXISTS `pre_tom_love_pm_message` (
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

$sql = '';

$tom_love_order_field = C::t('#tom_love#tom_love_order')->fetch_all_field();
if (!isset($tom_love_order_field['order_type'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_love_order')." ADD `order_type` int(11) DEFAULT '1';\n";
}
if (!isset($tom_love_order_field['time_value'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_love_order')." ADD `time_value` int(11) DEFAULT '0';\n";
}

$tom_love_flowers_log_field = C::t('#tom_love#tom_love_flowers_log')->fetch_all_field();
if (!isset($tom_love_flowers_log_field['gift_id'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_love_flowers_log')." ADD `gift_id` int(11) DEFAULT '0';\n";
}
if (!isset($tom_love_flowers_log_field['toUser_id'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_love_flowers_log')." ADD `toUser_id` int(11) DEFAULT '0';\n";
}

$tom_love_phb_field = C::t('#tom_love#tom_love_phb')->fetch_all_field();
if (!isset($tom_love_phb_field['phb_type'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_love_phb')." ADD `phb_type` int(11) DEFAULT '1';\n";
}

$tom_love_report_field = C::t('#tom_love#tom_love_report')->fetch_all_field();
if (!isset($tom_love_report_field['status'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_love_report')." ADD `status` int(11) DEFAULT '0';\n";
}
if (!isset($tom_love_report_field['report_pic_1'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_love_report')." ADD `report_pic_1` varchar(255) DEFAULT NULL;\n";
}
if (!isset($tom_love_report_field['report_pic_2'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_love_report')." ADD `report_pic_2` varchar(255) DEFAULT NULL;\n";
}

$tom_love_pic_field = C::t('#tom_love#tom_love_pic')->fetch_all_field();
if (!isset($tom_love_pic_field['shenhe_status'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_love_pic')." ADD `shenhe_status` tinyint(4) NOT NULL DEFAULT '1';\n";
}

if (!empty($sql)) {
	runquery($sql);
}

$finish = TRUE;
