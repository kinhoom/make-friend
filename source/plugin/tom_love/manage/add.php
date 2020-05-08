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

if($_GET['act'] == 'add' && $_GET['formhash'] == FORMHASH){
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
        $insertData = array();
        $insertData['bbs_uid'] = $uid;
        $insertData['bbs_username'] = $username;
        $insertData['nickname'] = $username;
        $insertData['openid'] = $openid;
        $insertData['score'] = $jyConfig['score_num'];
        $insertData['avatar'] = "source/plugin/tom_love/images/avatar_default.jpg";
        $insertData['sex'] = 0;
        $insertData['is_majia'] = 1;
        $insertData['add_time'] = TIMESTAMP;
        C::t('#tom_love#tom_love')->insert($insertData);
        
        $getUserInfoByBbsid = C::t('#tom_love#tom_love')->fetch_by_bbs_uid($uid);
        
        $lifeTime = 86400*30;
        dsetcookie('tom_love_uid',$getUserInfoByBbsid['id'],$lifeTime);
        $_SESSION['tom_love_uid'] = $getUserInfoByBbsid['id'];
    }
    
    $outArr = array(
        'status'=> 200,
        'id' => $getUserInfoByBbsid['id'],
    );
    echo json_encode($outArr); exit;
}

$manageUrl = "plugin.php?id=tom_love:manage&mod=add";
$editUrl = "plugin.php?id=tom_love:manage&mod=edit&act=add&user_id=";

$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
include template("tom_love:admin/adduser");