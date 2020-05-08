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

echo '<script src="source/plugin/tom_love/images/admin.js"></script>';

function get_love_config($pluginid){
    $pluginVarList = C::t('common_pluginvar')->fetch_all_by_pluginid($pluginid);
    $jyConfig = array();
    foreach ($pluginVarList as $vark => $varv){
        $jyConfig[$varv['variable']] = $varv['value'];
    }
    return $jyConfig;
}

function formatLang($Lang){
    $LangTmp  = array();
    if(is_array($Lang) && !empty($Lang)){
        foreach ($Lang as $key => $value){
            $LangTmp[$key] = htmlspecialchars_decode($value);
        }
    }
    return $LangTmp;
}

function tom_doing($do_msg,$dourl){
    cpmsg($do_msg, $dourl, 'loadingform');
}

function tomshowsubmit($var1,$var2){
    showsubmit($var1, $var2);
    return;
}

function tomloadcalendarjs(){
    echo '<script type="text/javascript" src="static/js/calendar.js"></script>';
    return;
}

function set_list_url($name = ""){
    $cookieValue = "";
    foreach ($_GET as $key => $value){
        $cookieValue.=$key."=".$value."&";
    }
    $cookieValue.="s=1";
    $lifeTime = 86400;
    dsetcookie($name,$cookieValue,$lifeTime);
    return false;
}

function get_list_url($name = ""){
    $cookieValue = getcookie($name);
    if($cookieValue && !empty($cookieValue)){
       return $cookieValue; 
    }
    return false;
}