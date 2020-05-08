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

$phone_from = isset($_GET['phone_from'])? daddslashes($_GET['phone_from']):'';
$phone_back = isset($_GET['phone_back'])? daddslashes($_GET['phone_back']):'';
$act        = isset($_GET['act'])? trim($_GET['act']):'';

if($act == 'save' && $_GET['formhash'] == FORMHASH){
    
    $outArr = array(
        'status'=> 200,
    );
    
    $tel = isset($_GET['tel'])? daddslashes($_GET['tel']):'';
    $tel_code = isset($_GET['tel_code'])? daddslashes($_GET['tel_code']):'';
    
    $get_tel_code = '';
    if(isset($_SESSION['tom_love_moblie_sms']) && !empty($_SESSION['tom_love_moblie_sms'])){
        $get_tel_code = $_SESSION['tom_love_moblie_sms'];
    }
    $get_tel = '';
    if(isset($_SESSION['tom_love_moblie_tel']) && !empty($_SESSION['tom_love_moblie_tel'])){
        $get_tel = $_SESSION['tom_love_moblie_tel'];
    }
    if($tel_code != $get_tel_code){
        $outArr['status'] = 201;
        echo json_encode($outArr); exit;
    }
    if($tel != $get_tel){
        $outArr['status'] = 202;
        echo json_encode($outArr); exit;
    }
    
    $userInfo = C::t('#tom_love#tom_love')->fetch_all_list("AND tel = '{$tel}' AND phone_renzheng = 1 AND id != {$__UserInfo['id']}", "ORDER BY id DESC", 0 ,1);
    if($userInfo){
        $outArr['status'] = 203;
        echo json_encode($outArr); exit;
    }
    
    $updateData = array();
    $updateData['tel'] = $tel;
    $updateData['phone_renzheng'] = 1;
    C::t('#tom_love#tom_love')->update($__UserInfo['id'], $updateData);
    
    if(file_exists(DISCUZ_ROOT.'./source/plugin/tom_xiangqin/tom_xiangqin.inc.php')){
        $__XiangqinTmp = C::t('#tom_xiangqin#tom_xiangqin')->fetch_by_user_id($__UserInfo['id']);
        if($__XiangqinTmp['id'] > 0){
            $updateData = array();
            $updateData['tel'] = $tel;
            C::t('#tom_xiangqin#tom_xiangqin')->update($__XiangqinTmp['id'], $updateData);
        }
    }
    
    echo json_encode($outArr); exit;
}else if($act == 'huoqu' && $_GET['formhash'] == FORMHASH){
    $outArr = array(
        'status'=> 200,
    );
    $tel = isset($_GET['tel'])? daddslashes($_GET['tel']):'';
    $userInfo = C::t('#tom_love#tom_love')->fetch_all_list("AND tel = '{$tel}' AND phone_renzheng = 1 AND id != {$__UserInfo['id']}", "ORDER BY id DESC", 0 ,1);
    if($userInfo){
        $outArr = array(
            'status'=> 201,
        );
        echo json_encode($outArr); exit;
    }
    if(!file_exists(DISCUZ_ROOT.'./source/plugin/tom_sms/sms.func.php')){
        $outArr = array(
            'status'=> 202,
        );
        echo json_encode($outArr); exit;
    }
    include DISCUZ_ROOT.'./source/plugin/tom_sms/sms.func.php';
    $code = substr(str_shuffle("012345678901234567890123456789"), 0, 6);
    plugin_send_sms('tom_love_01', $tel, array('number'=>$code));
    $_SESSION['tom_love_moblie_sms'] = $code;
    $_SESSION['tom_love_moblie_tel'] = $tel;
        
    echo json_encode($outArr); exit;
}else{

    $phoneUrl = "plugin.php?id=tom_love&mod=phone";
}

$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
include template("tom_love:phone");