<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：大叔来 www.dasuhlai.com
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

session_start();
define('TPL_DEFAULT', true);
$formhash = FORMHASH;
$payConfig = $_G['cache']['plugin']['tom_pay'];
$tomSysOffset = getglobal('setting/timeoffset');
$nowDayTime = gmmktime(0,0,0,dgmdate($_G['timestamp'], 'n',$tomSysOffset),dgmdate($_G['timestamp'], 'j',$tomSysOffset),dgmdate($_G['timestamp'], 'Y',$tomSysOffset)) - $tomSysOffset*3600;

$order_no  = isset($_GET['order_no'])? addslashes($_GET['order_no']):'';

$orderInfo = C::t('#tom_pay#tom_pay_order')->fetch_by_order_no($order_no);

if(!$orderInfo){
    $outArr = array(
        'status'=> 404,
    );
    echo json_encode($outArr); exit;
}

if($orderInfo['order_status'] == 2){
    $outArr = array(
        'status'=> 100,
    );
    echo json_encode($outArr); exit;
}

if($orderInfo['order_status'] != 1){
    $outArr = array(
        'status'=> 101,
    );
    echo json_encode($outArr); exit;
}

include DISCUZ_ROOT.'./source/plugin/tom_pay/class/function.core.php';
include DISCUZ_ROOT.'./source/plugin/tom_pay/class/log.class.php';

$logDir = DISCUZ_ROOT."./source/plugin/tom_pay/logs/";
if(!is_dir($logDir)){
    mkdir($logDir, 0777,true);
}else{
    chmod($logDir, 0777); 
}
$logHandler= new CLogFileHandler(DISCUZ_ROOT."./source/plugin/tom_pay/logs/[".date("Y-m-d")."]pay.log");
$log = Log::Init($logHandler, 15);

if($_GET['payment'] == 'wxpay_jsapi'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_pay/pay/wxpayJsapi.php';
    
}else if($_GET['payment'] == 'wxpay_native'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_pay/pay/wxpayNative.php';
    
}else if($_GET['payment'] == 'wxpay_h5'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_pay/pay/wxpayH5.php';
    
}else if($_GET['payment'] == 'wxpay_xiao'){
    
    $sid           = isset($_GET['sid'])? intval($_GET['sid']):0;
    $xiaoSitesInfo = C::t('#tom_xiaofenlei#tom_xiaofenlei_sites')->fetch_by_id($sid);
    if($sid > 1000 && $xiaoSitesInfo){
        include DISCUZ_ROOT.'./source/plugin/tom_pay/pay/wxpayXiaoSites.php';
    }else{
        include DISCUZ_ROOT.'./source/plugin/tom_pay/pay/wxpayXiao.php';
    }
    
}else if($_GET['payment'] == 'alipay_wap'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_pay/pay/alipayWap.php';
    
}else if($_GET['payment'] == 'qianfan_pay'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_pay/pay/qianfanPay.php';
    
}else if($_GET['payment'] == 'appbyme_pay'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_pay/pay/appbymePay.php';
    
}else if($_GET['payment'] == 'magapp_pay'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_pay/pay/magappPay.php';
    
}else{
    echo 'pay not act';exit;
}


