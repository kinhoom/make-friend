<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：大叔来 www.dasuhlai.com
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

session_start();
loaducenter();
define('TPL_DEFAULT', true);
$formhash = FORMHASH;
$ucenterConfig = $_G['cache']['plugin']['tom_ucenter'];
$tomSysOffset = getglobal('setting/timeoffset');
require_once libfile('function/discuzcode');
$appid = trim($ucenterConfig['wxpay_appid']);
$appsecret = trim($ucenterConfig['wxpay_appsecret']);
$prand = rand(1, 1000);
$cssJsVersion = "20171129";

include DISCUZ_ROOT.'./source/plugin/tom_ucenter/class/weixin.class.php';
$weixinClass = new weixinClass($appid,$appsecret);

include DISCUZ_ROOT.'./source/plugin/tom_ucenter/class/function.avatar.php';

$__IsWeixin = 0;
if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false){
    $__IsWeixin = 1;
}
$__IsQianfan = 0;
if(strpos($_SERVER['HTTP_USER_AGENT'], 'QianFan') !== false){
    $__IsQianfan = 1;
}
$__IsXiaoyun = 0;
if(strpos($_SERVER['HTTP_USER_AGENT'], 'Appbyme') !== false){
    $__IsXiaoyun = 1;
}
$__IsMagapp = 0;
if(strpos($_SERVER['HTTP_USER_AGENT'], 'MAGAPP') !== false){
    $__IsMagapp = 1;
}
$__IsMocuzapp = 0;
if(strpos($_SERVER['HTTP_USER_AGENT'], 'MocuzApp') !== false){
    $__IsMocuzapp = 1;
}

$__MemberInfo = array();
$loginStatus = false;
$cookieUid = getcookie('tom_ucenter_member_uid');
$cookieKey = getcookie('tom_ucenter_member_key');
if(!empty($cookieUid) && !empty($cookieKey)){
    $__MemberInfoTmp = C::t('#tom_ucenter#tom_ucenter_member')->fetch_by_uid($cookieUid);
    if($__MemberInfoTmp && !empty($__MemberInfoTmp['mykey'])){
        if(md5($__MemberInfoTmp['uid'].'|||'.$__MemberInfoTmp['mykey']) == $cookieKey){
            $__MemberInfo = $__MemberInfoTmp;
            $loginStatus = true;
        }
    }
}

if($_GET['mod'] == 'login'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_ucenter/module/login.php';
    
}else if($_GET['mod'] == 'reg'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_ucenter/module/reg.php';
    
}else if($_GET['mod'] == 'getpwd'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_ucenter/module/getpwd.php';
    
}else{
    
    include DISCUZ_ROOT.'./source/plugin/tom_ucenter/module/login.php';
    
}
