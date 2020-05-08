<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$LangTmp = $scriptlang['tom_pay'];
$adminBaseUrl = ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=tom_pay&pmod=admin'; 
$adminListUrl = 'action=plugins&operation=config&do='.$pluginid.'&identifier=tom_pay&pmod=admin';
$adminFromUrl = 'plugins&operation=config&do=' . $pluginid . '&identifier=tom_pay&pmod=admin';
$tomSysOffset = getglobal('setting/timeoffset');

$nowDayTime = gmmktime(0,0,0,dgmdate($_G['timestamp'], 'n',$tomSysOffset),dgmdate($_G['timestamp'], 'j',$tomSysOffset),dgmdate($_G['timestamp'], 'Y',$tomSysOffset)) - $tomSysOffset*3600;
$nowMonthTime = gmmktime(0,0,0,dgmdate($_G['timestamp'], 'n',$tomSysOffset),1,dgmdate($_G['timestamp'], 'Y',$tomSysOffset)) - $tomSysOffset*3600;

$pluginVarList = C::t('common_pluginvar')->fetch_all_by_pluginid($pluginid);
$payConfig = array();
foreach ($pluginVarList as $vark => $varv){
    $payConfig[$varv['variable']] = $varv['value'];
}

$Lang  = array();
if(is_array($LangTmp) && !empty($LangTmp)){
    foreach ($LangTmp as $key => $value){
        $Lang[$key] = htmlspecialchars_decode($value);
    }
}

if($_GET['tmod'] == 'order'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_pay/admin/order.php';
    
}else if($_GET['tmod'] == 'addon'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_pay/admin/addon.php';
    
}else{
    
    include DISCUZ_ROOT.'./source/plugin/tom_pay/admin/order.php';
    
}