<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$Lang = $scriptlang['tom_xiangqin'];
$tomSysOffset = getglobal('setting/timeoffset');
$nowYear = dgmdate($_G['timestamp'], 'Y',$tomSysOffset);

$adminBaseUrl = ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=tom_xiangqin&pmod=admin'; 
$adminListUrl = 'action=plugins&operation=config&do='.$pluginid.'&identifier=tom_xiangqin&pmod=admin';
$adminFromUrl = 'plugins&operation=config&do=' . $pluginid . '&identifier=tom_xiangqin&pmod=admin';
$manageUrl = $_G['siteurl'].'plugin.php?id=tom_xiangqin:manage';

include DISCUZ_ROOT.'./source/plugin/tom_xiangqin/class/function.admin.php';
include DISCUZ_ROOT.'./source/plugin/tom_xiangqin/class/xiangqin.core.php';
$jyConfig = get_xiangqin_config($pluginid);
$Lang = formatLang($Lang);

if (CHARSET == 'gbk') {
    include DISCUZ_ROOT.'./source/plugin/tom_xiangqin/config/works.gbk.php';
}else{
    include DISCUZ_ROOT.'./source/plugin/tom_xiangqin/config/works.utf.php';
}

include DISCUZ_ROOT.'./source/plugin/tom_love/class/tom.func.php';

if($_GET['tmod'] == 'user'){
    include DISCUZ_ROOT.'./source/plugin/tom_xiangqin/admin/user.php';
    
}else if($_GET['tmod'] == 'viptype'){
    include DISCUZ_ROOT.'./source/plugin/tom_xiangqin/admin/viptype.php';

}else if($_GET['tmod'] == 'hongniang'){
    include DISCUZ_ROOT.'./source/plugin/tom_xiangqin/admin/hongniang.php';

}else if($_GET['tmod'] == 'success'){
    include DISCUZ_ROOT.'./source/plugin/tom_xiangqin/admin/success.php';

}else if($_GET['tmod'] == 'order'){
    include DISCUZ_ROOT.'./source/plugin/tom_xiangqin/admin/order.php';

}else if($_GET['tmod'] == 'doDao'){
    include DISCUZ_ROOT.'./source/plugin/tom_xiangqin/admin/doDao.php';
    
}else if($_GET['tmod'] == 'common'){
    include DISCUZ_ROOT.'./source/plugin/tom_xiangqin/admin/common.php';
    
}else if($_GET['tmod'] == 'addon'){
    include DISCUZ_ROOT.'./source/plugin/tom_xiangqin/admin/addon.php';
    
}else if($_GET['tmod'] == 'qianxian'){
    include DISCUZ_ROOT.'./source/plugin/tom_xiangqin/admin/qianxian.php';
    
}else if($_GET['tmod'] == 'allqianxian'){
    include DISCUZ_ROOT.'./source/plugin/tom_xiangqin/admin/allqianxian.php';
    
}else if($_GET['tmod'] == 'qianxiansLog'){
    include DISCUZ_ROOT.'./source/plugin/tom_xiangqin/admin/qianxiansLog.php';
    
}else if($_GET['tmod'] == 'focuspic'){
    include DISCUZ_ROOT.'./source/plugin/tom_xiangqin/admin/focuspic.php';
    
}else{
    include DISCUZ_ROOT.'./source/plugin/tom_xiangqin/admin/user.php';
}