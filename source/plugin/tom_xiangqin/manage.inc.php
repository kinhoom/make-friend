<?php
/**
 * 
 * 大叔来出品 必属精品
 * 大叔来  全网首发 https://dwz.cn/bEeiwujz
 * 本资源来源于网络收集,仅供个人学习研究欣赏，请勿用于商业用途，并于下载24小时后删除!
 * 感谢支持！您的支持是我们最大的动力！为站长提供最适合的运营资源！
 * 欢迎大家来访获得最新更新的优秀资源！更多VIP特色资源不容错过！！
 * [大叔来]站长交流群: ①群 205670720
 * 永久域名：https://www.dashulai.com/ (请收藏备用!)
 * 
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

session_start();
loaducenter();
define('TPL_DEFAULT', true);
$jyConfig = $_G['cache']['plugin']['tom_love'];
$xiangqinConfig = $_G['cache']['plugin']['tom_xiangqin'];
$tomSysOffset = getglobal('setting/timeoffset');
$Lang = $scriptlang['tom_xiangqin'];
$nowYear = dgmdate($_G['timestamp'], 'Y',$tomSysOffset);
$formhash = FORMHASH;
$cssJsVersion = "20181222";

include DISCUZ_ROOT.'./source/plugin/tom_xiangqin/class/xiangqin.func.php';
include DISCUZ_ROOT.'./source/plugin/tom_love/class/love.func.php';
if (CHARSET == 'gbk') {
    include DISCUZ_ROOT.'./source/plugin/tom_xiangqin/config/works.gbk.php';
}else{
    include DISCUZ_ROOT.'./source/plugin/tom_xiangqin/config/works.utf.php';
}
if(isset($_G['uid']) && $_G['uid'] > 0 && $_G['groupid'] == 1){
    if($_GET['mod'] == 'add'){
        include DISCUZ_ROOT.'./source/plugin/tom_xiangqin/manage/add.php';
    }else if($_GET['mod'] == 'edit'){
        include DISCUZ_ROOT.'./source/plugin/tom_xiangqin/manage/edit.php';
    }else if($_GET['mod'] == 'usercard'){
        include DISCUZ_ROOT.'./source/plugin/tom_xiangqin/manage/usercard.php';
    }
}else if($_GET['mod'] == 'usercard'){
    include DISCUZ_ROOT.'./source/plugin/tom_xiangqin/manage/usercard.php';
}else{
    dheader('location:'.$_G['siteurl']);exit;
}