<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：大叔来 www.dasuhlai.com
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$t_from = isset($_GET['t_from'])? daddslashes($_GET['t_from']):'';
$t_back = isset($_GET['t_back'])? daddslashes($_GET['t_back']):'';
$t_back_url = $t_back;
$t_back = urlencode($t_back);

$pwdUrl   = "plugin.php?id=tom_ucenter:ajax&act=getpwd&t_from={$t_from}&formhash=".FORMHASH;
$smsUrl     = "plugin.php?id=tom_ucenter:ajax&act=sms&t_from={$t_from}&formhash=".FORMHASH;

$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
include template("tom_ucenter:getpwd");

