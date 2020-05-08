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
$tomSysOffset = getglobal('setting/timeoffset');
$Lang = $scriptlang['tom_love'];
$nowYear = dgmdate($_G['timestamp'], 'Y',$tomSysOffset);
$nowTime = gmmktime(0,0,0,dgmdate($_G['timestamp'], 'n',$tomSysOffset),dgmdate($_G['timestamp'], 'j',$tomSysOffset),dgmdate($_G['timestamp'], 'Y',$tomSysOffset)) - $tomSysOffset*3600;
$formhash = FORMHASH;

if(empty($_G['uid'])){
    dheader('location:'.$_G['siteurl']."plugin.php?id=tom_love:register");exit;
}

$user = uc_get_user($_G['uid'],1);
if($user['0'] > 0){

    $getUserInfoByBbsid = C::t('#tom_love#tom_love')->fetch_by_bbs_uid($user['0']);
    $getUserInfoByOpenid = C::t('#tom_love#tom_love')->fetch_by_openid($openid);
    if($getUserInfoByBbsid){
        $lifeTime = 86400*30;
        dsetcookie('tom_love_uid',$getUserInfoByBbsid['id'],$lifeTime);
        $_SESSION['tom_love_uid'] = $getUserInfoByBbsid['id'];

    }else if($openid && $getUserInfoByOpenid){
        $updateData = array();
        $updateData['bbs_uid'] = $user['0'];
        $updateData['bbs_username'] = $user['1'];
        C::t('#tom_love#tom_love')->update($getUserInfoByOpenid['id'],$updateData);
        $lifeTime = 86400*30;
        dsetcookie('tom_love_uid',$getUserInfoByOpenid['id'],$lifeTime);
        $_SESSION['tom_love_uid'] = $getUserInfoByOpenid['id'];
    }else{
        if($jyConfig['open_user_shenhe'] == 1){
            $shenhe_status = 1;
        }else{
            $shenhe_status = 2;
        }
        
        $insertData = array();
        $insertData['bbs_uid'] = $user['0'];
        $insertData['bbs_username'] = $user['1'];
        $insertData['nickname'] = $user['1'];
        $insertData['openid'] = $openid;
        $insertData['score'] = $jyConfig['score_num'];
        $insertData['avatar'] = "source/plugin/tom_love/images/avatar_default.jpg";
        $insertData['sex'] = 0;
        $insertData['shenhe_status'] = $shenhe_status;
        $insertData['add_time'] = TIMESTAMP;
        C::t('#tom_love#tom_love')->insert($insertData);

        $getUserInfoByBbsid = C::t('#tom_love#tom_love')->fetch_by_bbs_uid($user['0']);

        $lifeTime = 86400*30;
        dsetcookie('tom_love_uid',$getUserInfoByBbsid['id'],$lifeTime);
        $_SESSION['tom_love_uid'] = $getUserInfoByBbsid['id'];
    }

    dheader('location:'.$_G['siteurl']."plugin.php?id=tom_love");exit;

}

dheader('location:'.$_G['siteurl']."plugin.php?id=tom_love:register");exit;

