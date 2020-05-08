<?php
/**
 * 
 * »µµ°ÍøÂçwww.huaidanwangluo.com
 * 
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

session_start();
loaducenter();
define('TPL_DEFAULT', true);
$jyConfig = $_G['cache']['plugin']['tom_love'];
$tomSysOffset = getglobal('setting/timeoffset');
$Lang = $scriptlang['tom_love'];
$nowYear = dgmdate($_G['timestamp'], 'Y',$tomSysOffset);
$nowTime = gmmktime(0,0,0,dgmdate($_G['timestamp'], 'n',$tomSysOffset),dgmdate($_G['timestamp'], 'j',$tomSysOffset),dgmdate($_G['timestamp'], 'Y',$tomSysOffset)) - $tomSysOffset*3600;
$formhash = FORMHASH;

include DISCUZ_ROOT.'./source/plugin/tom_love/class/love.func.php';

if (CHARSET == 'gbk') {
    include DISCUZ_ROOT.'./source/plugin/tom_love/config/works.gbk.php';
}else{
    include DISCUZ_ROOT.'./source/plugin/tom_love/config/works.utf.php';
}


if($_GET['mod'] == 'index'){
    include DISCUZ_ROOT.'./source/plugin/tom_love/pc/index.inc.php';
    
}else if($_GET['mod'] == 'weixin'){
    include DISCUZ_ROOT.'./source/plugin/tom_love/pc/weixin.inc.php';
    
}else{
    include DISCUZ_ROOT.'./source/plugin/tom_love/pc/index.inc.php';
}