<?php
/*
 * 源码出处：大-叔-来
 * 官方网址: www.dashulai.com
 * 备用网址: https://dwz.cn/q4scNR7Q(请收藏备用!)
 * 本资源来源于网络收集,仅供个人学习研究欣赏，请勿用于商业用途，并于下载24小时后删除!
 * 技术支持/更新维护：官网 https://www.dashulai.com
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

$openid = isset($_GET['openid'])? addslashes($_GET['openid']):"";

$pageType = 'login';
if($_GET['act'] == 'doLogin' && $_GET['formhash'] == FORMHASH){
    $outArr = array(
        'status'=> 0,
    );
    $username = isset($_GET['username'])? daddslashes(diconv(urldecode($_GET['username']),'utf-8')):'';
    $password = isset($_GET['password'])? daddslashes($_GET['password']):'';
    $user = uc_user_login($username,$password,0);
    if($user['0'] > 0){
        $outArr['status'] = 200;
        
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
            $insertData = array();
            $insertData['bbs_uid'] = $user['0'];
            $insertData['bbs_username'] = $user['1'];
            $insertData['nickname'] = $user['1'];
            $insertData['openid'] = $openid;
            $insertData['score'] = $jyConfig['score_num'];
            $insertData['avatar'] = "source/plugin/tom_love/images/avatar_default.jpg";
            $insertData['sex'] = 0;
            $insertData['add_time'] = TIMESTAMP;
            C::t('#tom_love#tom_love')->insert($insertData);

            $getUserInfoByBbsid = C::t('#tom_love#tom_love')->fetch_by_bbs_uid($user['0']);

            $lifeTime = 86400*30;
            dsetcookie('tom_love_uid',$getUserInfoByBbsid['id'],$lifeTime);
            $_SESSION['tom_love_uid'] = $getUserInfoByBbsid['id'];
        }
    }else{
       $outArr['status'] = 100;
    }
    echo json_encode($outArr); exit;
}else if($_GET['act'] == 'doRegister' && $_GET['formhash'] == FORMHASH){
    $outArr = array(
        'status'=> 0,
    );
    $username = isset($_GET['username'])? daddslashes(diconv(urldecode($_GET['username']),'utf-8')):'';
    $password = isset($_GET['password'])? daddslashes($_GET['password']):'';
    $email = isset($_GET['email'])? daddslashes($_GET['email']):'';
    
    $usernamelen = dstrlen($username);
    if($usernamelen < 3) {
        $outArr['status'] = 201;
        echo json_encode($outArr); exit;
    }
    if($usernamelen > 15) {
        $outArr['status'] = 202;
        echo json_encode($outArr); exit;
    }
    $censorexp = '/^('.str_replace(array('\\*', "\r\n", ' '), array('.*', '|', ''), preg_quote(($_G['setting']['censoruser'] = trim($_G['setting']['censoruser'])), '/')).')$/i';
    if($_G['setting']['censoruser'] && @preg_match($censorexp, $username)) {
        $outArr['status'] = 203;
        echo json_encode($outArr); exit;
    }
    
    $uid = uc_user_register($username, $password, $email, '', '', $_G['clientip']);
    if($uid <= 0) {
        if($uid == -1) {
            $outArr['status'] = 301;
            echo json_encode($outArr); exit;
        } elseif($uid == -2) {
            $outArr['status'] = 302;
            echo json_encode($outArr); exit;
        } elseif($uid == -3) {
            $outArr['status'] = 303;
            echo json_encode($outArr); exit;
        } elseif($uid == -4) {
            $outArr['status'] = 304;
            echo json_encode($outArr); exit;
        } elseif($uid == -5) {
            $outArr['status'] = 305;
            echo json_encode($outArr); exit;
        } elseif($uid == -6) {
            $outArr['status'] = 306;
            echo json_encode($outArr); exit;
        } else {
            $outArr['status'] = 307;
            echo json_encode($outArr); exit;
        }
    }
    $init_arr = array('credits' => explode(',', $_G['setting']['initcredits']));
	C::t('common_member')->insert($uid, $username, $password, $email, $_G['clientip'], $_G['setting']['newusergroupid'], $init_arr);
    
    if($_G['setting']['regctrl'] || $_G['setting']['regfloodctrl']) {
        C::t('common_regip')->delete_by_dateline($_G['timestamp']-($_G['setting']['regctrl'] > 72 ? $_G['setting']['regctrl'] : 72)*3600);
        if($_G['setting']['regctrl']) {
            C::t('common_regip')->insert(array('ip' => $_G['clientip'], 'count' => -1, 'dateline' => $_G['timestamp']));
        }
    }

    if($_G['setting']['regverify'] == 2) {
        C::t('common_member_validate')->insert(array(
            'uid' => $uid,
            'submitdate' => $_G['timestamp'],
            'moddate' => 0,
            'admin' => '',
            'submittimes' => 1,
            'status' => 0,
            'message' => '',
            'remark' => '',
        ), false, true);
        manage_addnotify('verifyuser');
    }
    
    include_once libfile('function/stat');
    updatestat('register');
    
    $getUserInfoByOpenid = C::t('#tom_love#tom_love')->fetch_by_openid($openid);
    if($openid && $getUserInfoByOpenid){
        $updateData = array();
        $updateData['bbs_uid'] = $uid;
        $updateData['bbs_username'] = $username;
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
        $insertData['bbs_uid'] = $uid;
        $insertData['bbs_username'] = $username;
        $insertData['nickname'] = $username;
        $insertData['openid'] = $openid;
        $insertData['score'] = $jyConfig['score_num'];
        $insertData['avatar'] = "source/plugin/tom_love/images/avatar_default.jpg";
        $insertData['sex'] = 0;
        $insertData['shenhe_status'] = $shenhe_status;
        $insertData['add_time'] = TIMESTAMP;
        C::t('#tom_love#tom_love')->insert($insertData);
        
        $getUserInfoByBbsid = C::t('#tom_love#tom_love')->fetch_by_bbs_uid($uid);
        
        $lifeTime = 86400*30;
        dsetcookie('tom_love_uid',$getUserInfoByBbsid['id'],$lifeTime);
        $_SESSION['tom_love_uid'] = $getUserInfoByBbsid['id'];
    }
    
    $outArr['status'] = 200;
    echo json_encode($outArr); exit;
    
}else if($_GET['act'] == 'loginOut'){
    $lifeTime = 86400*30;
    dsetcookie('tom_love_uid',0,$lifeTime);
    $_SESSION['tom_love_uid'] = 0;
    dheader('location:'.$_G['siteurl']."plugin.php?id=tom_love");
    exit;
}else if($_GET['act'] == 'register'){
    $pageType = 'register';
}else{
    $pageType = 'login';
}

$__IsWeixin = 0;
if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false){ $__IsWeixin = 1;}

$loginUrl = "plugin.php?id=tom_love:register";
$regUrl = "plugin.php?id=tom_love:register";

$indexUrl = "plugin.php?id=tom_love";

$refererUrl = "plugin.php?id=tom_love:qqlogin";
$qqLoginUrl = $_G['siteurl']."connect.php?mod=login&op=init&referer=".urlencode($refererUrl)."&statfrom=login_simple";
$wxLoginUrl = "plugin.php?id=tom_love:wxlogin";

$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
include template("tom_love:register");

