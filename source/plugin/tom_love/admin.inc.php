<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$Lang = $scriptlang['tom_love'];
$tomSysOffset = getglobal('setting/timeoffset');
$nowYear = dgmdate($_G['timestamp'], 'Y',$tomSysOffset);

$adminBaseUrl = ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=tom_love&pmod=admin'; 
$adminListUrl = 'action=plugins&operation=config&do='.$pluginid.'&identifier=tom_love&pmod=admin';
$adminFromUrl = 'plugins&operation=config&do=' . $pluginid . '&identifier=tom_love&pmod=admin';
$manageUrl = $_G['siteurl'].'plugin.php?id=tom_love:manage';

include DISCUZ_ROOT.'source/plugin/tom_love/class/function.admin.php';
$jyConfig = get_love_config($pluginid);
$Lang = formatLang($Lang);

if (CHARSET == 'gbk') {
    include DISCUZ_ROOT.'./source/plugin/tom_love/config/works.gbk.php';
}else{
    include DISCUZ_ROOT.'./source/plugin/tom_love/config/works.utf.php';
}

include DISCUZ_ROOT.'./source/plugin/tom_love/class/tom.func.php';
if($_GET['tmod'] == 'user'){
    include DISCUZ_ROOT.'./source/plugin/tom_love/admin/user.php';
    
}else if($_GET['tmod'] == 'rz'){
    include DISCUZ_ROOT.'./source/plugin/tom_love/admin/rz.php';
    
}else if($_GET['tmod'] == 'ss'){
    include DISCUZ_ROOT.'./source/plugin/tom_love/admin/ss.php';
    
}else if($_GET['tmod'] == 'order'){
    include DISCUZ_ROOT.'./source/plugin/tom_love/admin/order.php';
    
}else if($_GET['tmod'] == 'report'){
    include DISCUZ_ROOT.'./source/plugin/tom_love/admin/report.php';

}else if($_GET['tmod'] == 'shop'){
    include DISCUZ_ROOT.'./source/plugin/tom_love/admin/shop.php';
    
}else if($_GET['tmod'] == 'district'){
    include DISCUZ_ROOT.'./source/plugin/tom_love/admin/district.php';

}else if($_GET['tmod'] == 'focuspic'){ 
    include DISCUZ_ROOT.'./source/plugin/tom_love/admin/focuspic.php';

}else if($_GET['tmod'] == 'gift'){ 
    include DISCUZ_ROOT.'./source/plugin/tom_love/admin/gift.php';

}else if($_GET['tmod'] == 'usershenhe'){ 
    include DISCUZ_ROOT.'./source/plugin/tom_love/admin/usershenhe.php';

}else if($_GET['tmod'] == 'picshenhe'){ 
    include DISCUZ_ROOT.'./source/plugin/tom_love/admin/picshenhe.php';

}else if($_GET['tmod'] == 'addon'){
    include DISCUZ_ROOT.'./source/plugin/tom_love/admin/addon.php';
    
}else if($_GET['tmod'] == 'doDao'){
    include DISCUZ_ROOT.'./source/plugin/tom_love/admin/doDao.php';
    
}else if($_GET['tmod'] == 'pmMessage'){
    include DISCUZ_ROOT.'./source/plugin/tom_love/admin/pmMessage.php';
    
}else{
    include DISCUZ_ROOT.'./source/plugin/tom_love/admin/user.php';
}
