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

$sql = <<<EOF

DROP TABLE IF EXISTS pre_tom_love;
DROP TABLE IF EXISTS pre_tom_love_guanxi;
DROP TABLE IF EXISTS pre_tom_love_pic;
DROP TABLE IF EXISTS pre_tom_love_rec;
DROP TABLE IF EXISTS pre_tom_love_renzheng;
DROP TABLE IF EXISTS pre_tom_love_scorelog;
DROP TABLE IF EXISTS pre_tom_love_share;
DROP TABLE IF EXISTS pre_tom_love_shuoshuo;
DROP TABLE IF EXISTS pre_tom_love_tz;
DROP TABLE IF EXISTS pre_tom_love_order;
DROP TABLE IF EXISTS pre_tom_love_report;
DROP TABLE IF EXISTS pre_tom_love_common;
DROP TABLE IF EXISTS pre_tom_love_shuoshuo_photo;
DROP TABLE IF EXISTS pre_tom_love_shuoshuo_reply;
DROP TABLE IF EXISTS pre_tom_love_shuoshuo_zan;
DROP TABLE IF EXISTS pre_tom_love_district;
DROP TABLE IF EXISTS pre_tom_love_sign;
DROP TABLE IF EXISTS pre_tom_love_focuspic;
DROP TABLE IF EXISTS pre_tom_love_shop_order;
DROP TABLE IF EXISTS pre_tom_love_shop_goods;
DROP TABLE IF EXISTS pre_tom_love_flowers_log;
DROP TABLE IF EXISTS pre_tom_love_phb;
DROP TABLE IF EXISTS pre_tom_love_gift;
DROP TABLE IF EXISTS pre_tom_love_gift_count;
DROP TABLE IF EXISTS pre_tom_love_pm;
DROP TABLE IF EXISTS pre_tom_love_pm_lists;
DROP TABLE IF EXISTS pre_tom_love_pm_message;
EOF;

runquery($sql);

$finish = TRUE;