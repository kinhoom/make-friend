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
$tomSysOffset = getglobal('setting/timeoffset');
$Lang = $scriptlang['tom_love'];
$nowYear = dgmdate($_G['timestamp'], 'Y',$tomSysOffset);
$nowTime = gmmktime(0,0,0,dgmdate($_G['timestamp'], 'n',$tomSysOffset),dgmdate($_G['timestamp'], 'j',$tomSysOffset),dgmdate($_G['timestamp'], 'Y',$tomSysOffset)) - $tomSysOffset*3600;
$formhash = FORMHASH;
$cssJsVersion = "201601012";

include DISCUZ_ROOT.'./source/plugin/tom_love/class/love.func.php';

if(isset($_G['uid']) && $_G['uid'] > 0 && $_G['groupid'] == 1){
    if (CHARSET == 'gbk') {
        include DISCUZ_ROOT.'./source/plugin/tom_love/config/works.gbk.php';
    }else{
        include DISCUZ_ROOT.'./source/plugin/tom_love/config/works.utf.php';
    }

    if($_GET['mod'] == 'add'){
        
        include DISCUZ_ROOT.'./source/plugin/tom_love/manage/add.php';
    }else if($_GET['mod'] == 'add2'){
        
        include DISCUZ_ROOT.'./source/plugin/tom_love/manage/add2.php';
    }else if($_GET['mod'] == 'edit'){
        
        include DISCUZ_ROOT.'./source/plugin/tom_love/manage/edit.php';
    }else{
        
        include DISCUZ_ROOT.'./source/plugin/tom_love/manage/add.php';
    }
}else{
    dheader('location:'.$_G['siteurl']);exit;
}
