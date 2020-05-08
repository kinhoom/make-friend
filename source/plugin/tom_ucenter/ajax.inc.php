<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

session_start();
loaducenter();
$formhash       = FORMHASH;
$ucenterConfig  = $_G['cache']['plugin']['tom_ucenter'];
$tomSysOffset   = getglobal('setting/timeoffset');
$appid          = trim($ucenterConfig['wxpay_appid']);
$appsecret      = trim($ucenterConfig['wxpay_appsecret']);

$t_from = isset($_GET['t_from'])? daddslashes($_GET['t_from']):'';

$__MemberInfo = array();
$loginStatus = false;
$cookieUid = getcookie('tom_ucenter_member_uid');
$cookieKey = getcookie('tom_ucenter_member_key');
if(!empty($cookieUid) && !empty($cookieKey)){
    $__MemberInfoTmp = C::t('#tom_ucenter#tom_ucenter_member')->fetch_by_uid($cookieUid);
    if($__MemberInfoTmp && !empty($__MemberInfoTmp['mykey'])){
        if(md5($__MemberInfoTmp['uid'].'|||'.$__MemberInfoTmp['mykey']) == $cookieKey){
            $__MemberInfo = $__MemberInfoTmp;
            $loginStatus = true;
        }
    }
}


if($_GET['act'] == 'login' && $_GET['formhash'] == FORMHASH){
    
    $outArr = array(
        'status'=> 1,
    );
    
    $tel = isset($_GET['tel'])? daddslashes(diconv(urldecode($_GET['tel']),'utf-8')):'';
    $pwd = isset($_GET['pwd'])? daddslashes(diconv(urldecode($_GET['pwd']),'utf-8')):'';
    
    if(empty($tel) || empty($pwd)){
        $outArr['status'] = 500;
        echo json_encode($outArr); exit;
    }
    
    $memberInfo = C::t('#tom_ucenter#tom_ucenter_member')->fetch_by_tel($tel);
    if(!$memberInfo){
        $outArr['status'] = 301;
        echo json_encode($outArr); exit;
    }
    
    if(md5($pwd.'|||'.$memberInfo['mykey']) == $memberInfo['pwd']){
        
        $updateData = array();
        $updateData['last_login_type']     = 'tel';
        $updateData['last_login_time']     = TIMESTAMP;
        C::t('#tom_ucenter#tom_ucenter_member')->update($memberInfo['uid'],$updateData);
        
        $lifeTime = 86400;
        dsetcookie('tom_ucenter_member_uid',$memberInfo['uid'],$lifeTime);
        dsetcookie('tom_ucenter_member_key',md5($memberInfo['uid'].'|||'.$memberInfo['mykey']),$lifeTime);
        
        $outArr['status'] = 200;
        echo json_encode($outArr); exit;
    }else{
        $outArr['status'] = 302;
        echo json_encode($outArr); exit;
    }

}else if($_GET['act'] == 'loginout' && $_GET['formhash'] == FORMHASH){
    
    $lifeTime = 86400;
    dsetcookie('tom_ucenter_member_uid','',$lifeTime);
    dsetcookie('tom_ucenter_member_key','',$lifeTime);

    echo 200;exit;
    
}else if($_GET['act'] == 'reg' && $_GET['formhash'] == FORMHASH){
    
    $outArr = array(
        'status'=> 1,
    );
    
    $nickname   = isset($_GET['nickname'])? daddslashes(diconv(urldecode($_GET['nickname']),'utf-8')):'';
    $pwd        = isset($_GET['pwd'])? daddslashes(diconv(urldecode($_GET['pwd']),'utf-8')):'';
    $tel        = isset($_GET['tel'])? daddslashes($_GET['tel']):'';
    $tel_code   = isset($_GET['tel_code'])? daddslashes($_GET['tel_code']):'';
    
    $get_tel_code = '';
    if(isset($_SESSION['tom_ucenter_moblie_sms']) && !empty($_SESSION['tom_ucenter_moblie_sms'])){
        $get_tel_code = $_SESSION['tom_ucenter_moblie_sms'];
    }
    $get_tel = '';
    if(isset($_SESSION['tom_ucenter_moblie_tel']) && !empty($_SESSION['tom_ucenter_moblie_tel'])){
        $get_tel = $_SESSION['tom_ucenter_moblie_tel'];
    }
    
    if($tel_code != $get_tel_code){
        $outArr['status'] = 301;
        echo json_encode($outArr); exit;
    }
    if($tel != $get_tel){
        $outArr['status'] = 302;
        echo json_encode($outArr); exit;
    }
    
    $memberInfo = C::t('#tom_ucenter#tom_ucenter_member')->fetch_by_tel($tel);
    if($memberInfo){
        $outArr['status'] = 303;
        echo json_encode($outArr); exit;
    }
    
    if(empty($pwd)){
        $outArr['status'] = 304;
        echo json_encode($outArr); exit;
    }
    
    $mykey = substr(str_shuffle("012345678901234567890123456789"), 0, 6);
    
    $insertData = array();
    $insertData['nickname']     = $nickname;
    $insertData['mykey']        = $mykey;
    $insertData['tel']          = $tel;
    $insertData['pwd']          = md5($pwd.'|||'.$mykey);
    $insertData['add_time']     = TIMESTAMP;
    if(C::t('#tom_ucenter#tom_ucenter_member')->insert($insertData)){
        $outArr['status'] = 200;
        echo json_encode($outArr); exit;
    }
    
    $outArr['status'] = 1;
    echo json_encode($outArr); exit;
    
}else if($_GET['act'] == 'getpwd' && $_GET['formhash'] == FORMHASH){
    
    $outArr = array(
        'status'=> 1,
    );
    
    $pwd        = isset($_GET['pwd'])? daddslashes(diconv(urldecode($_GET['pwd']),'utf-8')):'';
    $tel        = isset($_GET['tel'])? daddslashes($_GET['tel']):'';
    $tel_code   = isset($_GET['tel_code'])? daddslashes($_GET['tel_code']):'';
    
    $get_tel_code = '';
    if(isset($_SESSION['tom_ucenter_moblie_sms']) && !empty($_SESSION['tom_ucenter_moblie_sms'])){
        $get_tel_code = $_SESSION['tom_ucenter_moblie_sms'];
    }
    $get_tel = '';
    if(isset($_SESSION['tom_ucenter_moblie_tel']) && !empty($_SESSION['tom_ucenter_moblie_tel'])){
        $get_tel = $_SESSION['tom_ucenter_moblie_tel'];
    }
    
    if($tel_code != $get_tel_code){
        $outArr['status'] = 301;
        echo json_encode($outArr); exit;
    }
    if($tel != $get_tel){
        $outArr['status'] = 302;
        echo json_encode($outArr); exit;
    }
    
    $memberInfo = C::t('#tom_ucenter#tom_ucenter_member')->fetch_by_tel($tel);
    if(!$memberInfo){
        $outArr['status'] = 303;
        echo json_encode($outArr); exit;
    }
    
    $mykey = substr(str_shuffle("012345678901234567890123456789"), 0, 6);
    
    $updateData = array();
    $updateData['mykey']        = $mykey;
    $updateData['pwd']          = md5($pwd.'|||'.$mykey);
    if(C::t('#tom_ucenter#tom_ucenter_member')->update($memberInfo['uid'],$updateData)){
        $outArr['status'] = 200;
        echo json_encode($outArr); exit;
    }
    
    $outArr['status'] = 1;
    echo json_encode($outArr); exit;
    
}else if($_GET['act'] == 'sms' && $_GET['formhash'] == FORMHASH){
    
    $outArr = array(
        'status'=> 1,
    );
    
    $tel = isset($_GET['tel'])? daddslashes($_GET['tel']):'';
    
    if(!file_exists(DISCUZ_ROOT.'./source/plugin/tom_sms/sms.func.php')){
        $outArr = array(
            'status'=> 301,
        );
        echo json_encode($outArr); exit;
    }
    
    include DISCUZ_ROOT.'./source/plugin/tom_sms/sms.func.php';
    
    $code = substr(str_shuffle("012345678901234567890123456789"), 0, 6);
    
    $r = plugin_send_sms('tom_tongcheng_01', $tel, array('number'=>$code));
    
    $_SESSION['tom_ucenter_moblie_sms'] = $code;
    $_SESSION['tom_ucenter_moblie_tel'] = $tel;
    
    if($r['status'] == 'success'){
        $outArr = array(
            'status'=> 200,
        );
        echo json_encode($outArr); exit;
    }else{
        $outArr = array(
            'status'=> 404,
        );
        echo json_encode($outArr); exit;
    }
        
    echo json_encode($outArr); exit;
}else{
    echo 'error';exit;
}

