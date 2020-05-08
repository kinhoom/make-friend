<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$LangTmp = $scriptlang['tom_link'];
$adminBaseUrl = ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=tom_link&pmod=admin'; 
$adminListUrl = 'action=plugins&operation=config&do='.$pluginid.'&identifier=tom_link&pmod=admin';
$adminFromUrl = 'plugins&operation=config&do=' . $pluginid . '&identifier=tom_link&pmod=admin';
$tomSysOffset = getglobal('setting/timeoffset');


$pluginVarList = C::t('common_pluginvar')->fetch_all_by_pluginid($pluginid);
$linkConfig = array();
foreach ($pluginVarList as $vark => $varv){
    $linkConfig[$varv['variable']] = $varv['value'];
}

$Lang  = array();
if(is_array($LangTmp) && !empty($LangTmp)){
    foreach ($LangTmp as $key => $value){
        $Lang[$key] = htmlspecialchars_decode($value);
    }
}

if (CHARSET == 'gbk') {
    include DISCUZ_ROOT.'./source/plugin/tom_link/config/config.gbk.php';
}else{
    include DISCUZ_ROOT.'./source/plugin/tom_link/config/config.utf8.php';
}

include DISCUZ_ROOT.'./source/plugin/tom_link/tom.func.php';
if($_GET['tmod'] == 'index'){
    include DISCUZ_ROOT.'./source/plugin/tom_link/admin/index.php';
}else if($_GET['tmod'] == 'addon'){
    include DISCUZ_ROOT.'./source/plugin/tom_link/admin/addon.php';
}else{
    include DISCUZ_ROOT.'./source/plugin/tom_link/admin/index.php';
}


