<?php

/*
   [Dashulai!] (C)2009-2019 WWW.DASHULAI.COM.
   技术支持/更新维护：官网 https://www.dashulai.com
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$sql = <<<EOF

DROP TABLE IF EXISTS pre_tom_xiangqin;
DROP TABLE IF EXISTS pre_tom_xiangqin_autoid;
DROP TABLE IF EXISTS pre_tom_xiangqin_collect;
DROP TABLE IF EXISTS pre_tom_xiangqin_common;
DROP TABLE IF EXISTS pre_tom_xiangqin_hongniang;
DROP TABLE IF EXISTS pre_tom_xiangqin_order;
DROP TABLE IF EXISTS pre_tom_xiangqin_photo;
DROP TABLE IF EXISTS pre_tom_xiangqin_success;
DROP TABLE IF EXISTS pre_tom_xiangqin_vip;
DROP TABLE IF EXISTS pre_tom_xiangqin_chakan;
DROP TABLE IF EXISTS pre_tom_xiangqin_qianxian;
DROP TABLE IF EXISTS pre_tom_xiangqin_qianxians_log;
DROP TABLE IF EXISTS pre_tom_xiangqin_focuspic;

EOF;

runquery($sql);

$finish = TRUE;