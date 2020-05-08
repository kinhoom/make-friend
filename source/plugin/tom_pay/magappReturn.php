<?php
/* * 
 * 功能：马甲APP页面跳转同步通知页面
 */

define('IN_API', true);
define('CURSCRIPT', 'api');
define('DISABLEXSSCHECK', true); 
define('IN_TOM_PAY', true); 

require '../../../source/class/class_core.php';

$discuz = C::app();
$cachelist = array('plugin', 'diytemplatename');
$discuz->cachelist = $cachelist;
$discuz->init();

$_G['siteurl'] = substr($_G['siteurl'], 0, -22);
$_G['siteroot'] = substr( $_G['siteroot'], 0, - 22);

$payConfig = $_G['cache']['plugin']['tom_pay'];

$magapp_url        = trim($payConfig['magapp_url']);
$magapp_secret     = trim($payConfig['magapp_secret']);
$magapp_url        = rtrim($magapp_url,'/');

include DISCUZ_ROOT.'./source/plugin/tom_pay/class/log.class.php';
include DISCUZ_ROOT.'./source/plugin/tom_pay/class/function.core.php';

$logDir = DISCUZ_ROOT."./source/plugin/tom_pay/logs/";
if(!is_dir($logDir)){
    mkdir($logDir, 0777,true);
}else{
    chmod($logDir, 0777); 
}
$logHandler= new CLogFileHandler(DISCUZ_ROOT."./source/plugin/tom_pay/logs/[".date("Y-m-d")."]magapp.log");
$log = Log::Init($logHandler, 15);

$mag_order_id   = isset($_GET['mag_order_id'])? addslashes($_GET['mag_order_id']):'';

if(isset($_GET['order_no']) && !empty($_GET['order_no'])){
    
    echo 'SUCCESS';exit;
    
    $order_no       = isset($_GET['order_no'])? addslashes($_GET['order_no']):'';
    
    $orderInfo = C::t('#tom_pay#tom_pay_order')->fetch_by_order_no($order_no);
    if($orderInfo && !empty($orderInfo['mag_order_id'])){
        $mag_order_id = $orderInfo['mag_order_id'];
    }
}

$payOrderInfo = C::t('#tom_pay#tom_pay_order')->fetch_by_mag_order_id($mag_order_id);

Log::DEBUG("[return]start mag_order_id:" . json_encode(iconv_to_utf8($mag_order_id)));

$magapp_api_url = $magapp_url.'/core/pay/pay/orderStatusQuery?unionOrderNum='.$mag_order_id.'&secret='.$magapp_secret;
$mag_return     = getHtml($magapp_api_url);
if($mag_return){
    $mag_content = json_decode($mag_return,true);
    if (isset($mag_content['paycode']) && $mag_content['paycode'] == 1) {
        
        Log::DEBUG("[return] mag_content ok:" . json_encode(iconv_to_utf8($mag_content)));
        
        if($payOrderInfo){
            if($payOrderInfo['order_status'] == 1){
                $updateData = array();
                $updateData['order_status'] = 2;
                $updateData['pay_time'] = TIMESTAMP;
                C::t('#tom_pay#tom_pay_order')->update($payOrderInfo['id'],$updateData);

                Log::DEBUG("[return]update order flow:" . json_encode(iconv_to_utf8($payOrderInfo['order_no'])));
            }

            # plugin api start
            $order_no = $payOrderInfo['order_no'];
            if(checkDirNameChar($payOrderInfo['plugin_id'])){ // 正则验证文件名合法性  preg_match("#^[a-zA-Z0-9_]+$#", $str)
                $payNotufyFile = DISCUZ_ROOT.'./source/plugin/'.$payOrderInfo['plugin_id'].'/paynotify.php';
                if(file_exists($payNotufyFile)){
                    include $payNotufyFile;
                }else{
                    Log::DEBUG("[error]no find:".$payNotufyFile);
                }
            }else{
                Log::DEBUG("[error]checkDirNameChar:".$payOrderInfo['plugin_id']);
            }
            # plugin api end

            Log::DEBUG("[return]success mag_order_id:" . json_encode(iconv_to_utf8($mag_order_id)));
                
        }else{
            Log::DEBUG("[return]no find order flow mag_order_id:".$mag_order_id);
        }
        
    }else {
        Log::DEBUG("[return] mag_content paycode error:" . json_encode(iconv_to_utf8($mag_content['paycode'])));
    }
    
}else {
    Log::DEBUG("[return] mag_return error:" . json_encode(iconv_to_utf8($mag_return)));
}

if(isset($_GET['order_no']) && !empty($_GET['order_no'])){
    Log::DEBUG("[return]SUCCESS :".$_GET['order_no']);
    echo 'SUCCESS';exit;
}else{
    dheader('location:'.$_G['siteurl']."plugin.php?id=tom_pay&order_no=".$payOrderInfo['order_no'])."&pbrand=".rand(1, 1000);exit;  
}