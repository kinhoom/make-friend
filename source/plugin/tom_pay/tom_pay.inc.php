<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：大叔来 www.dasuhlai.com
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

session_start();
define('TPL_DEFAULT', true);
$formhash = FORMHASH;
$payConfig = $_G['cache']['plugin']['tom_pay'];
$tomSysOffset = getglobal('setting/timeoffset');
$nowDayTime = gmmktime(0,0,0,dgmdate($_G['timestamp'], 'n',$tomSysOffset),dgmdate($_G['timestamp'], 'j',$tomSysOffset),dgmdate($_G['timestamp'], 'Y',$tomSysOffset)) - $tomSysOffset*3600;
require_once libfile('function/discuzcode');
$appid = trim($payConfig['wxpay_appid']);  
$appsecret = trim($payConfig['wxpay_appsecret']);
$cssJsVersion = "20180528";

include DISCUZ_ROOT.'./source/plugin/tom_pay/class/weixin.class.php';
$weixinClass = new weixinClass($appid,$appsecret);

$_isWeiXin = $__IsQianfan = $__IsXiaoyun = $__IsMagapp = $__IsMocuzapp = $__IsMiniprogram = 0;
if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false){ $_isWeiXin = 1;}
if(strpos($_SERVER['HTTP_USER_AGENT'], 'QianFan') !== false){ $__IsQianfan = 1;}
if(strpos($_SERVER['HTTP_USER_AGENT'], 'Appbyme') !== false){ $__IsXiaoyun = 1;}
if(strpos($_SERVER['HTTP_USER_AGENT'], 'MAGAPP') !== false){ $__IsMagapp = 1;}
if(strpos($_SERVER['HTTP_USER_AGENT'], 'MocuzApp') !== false){ $__IsMocuzapp = 1;}
$cookie_tom_miniprogram = getcookie('tom_miniprogram');
if($cookie_tom_miniprogram == 1 || $_GET['f'] == 'miniprogram'){ $__IsMiniprogram = 1;}

if($_isWeiXin == 1){
    include DISCUZ_ROOT.'./source/plugin/tom_pay/oauth2.php';
}

if($_GET['mod'] == 'wap'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_pay/module/wap.php';
    
}else{
    
    include DISCUZ_ROOT.'./source/plugin/tom_pay/module/wap.php';
}


