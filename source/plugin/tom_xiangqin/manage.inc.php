<?php
/**
 * 
 * ��������Ʒ ������Ʒ
 * ������  ȫ���׷� https://dwz.cn/bEeiwujz
 * ����Դ��Դ�������ռ�,��������ѧϰ�о����ͣ�����������ҵ��;����������24Сʱ��ɾ��!
 * ��л֧�֣�����֧�����������Ķ�����Ϊվ���ṩ���ʺϵ���Ӫ��Դ��
 * ��ӭ������û�����¸��µ�������Դ������VIP��ɫ��Դ���ݴ������
 * [������]վ������Ⱥ: ��Ⱥ 205670720
 * ����������https://www.dashulai.com/ (���ղر���!)
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