<?php
/* * 
 * 功能：千帆APP页面跳转同步通知页面
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

$qf_secret    = trim($payConfig['qf_secret']);
$qf_hostname   = trim($payConfig['qf_hostname']);

include DISCUZ_ROOT.'./source/plugin/tom_pay/class/log.class.php';
include DISCUZ_ROOT.'./source/plugin/tom_pay/class/function.core.php';
include DISCUZ_ROOT.'./source/plugin/tom_pay/class/qianfan.core.php';

$logDir = DISCUZ_ROOT."./source/plugin/tom_pay/logs/";
if(!is_dir($logDir)){
    mkdir($logDir, 0777,true);
}else{
    chmod($logDir, 0777); 
}
$logHandler= new CLogFileHandler(DISCUZ_ROOT."./source/plugin/tom_pay/logs/[".date("Y-m-d")."]qianfan.log");
$log = Log::Init($logHandler, 15);

$qf_order_id  = isset($_GET['qf_order_id'])? addslashes($_GET['qf_order_id']):'';

$payOrderInfo = C::t('#tom_pay#tom_pay_order')->fetch_by_qf_order_id($qf_order_id);

Log::DEBUG("[return]start qf_order_id:" . json_encode(iconv_to_utf8($_GET['qf_order_id'])));

$qf_nonce          = qf_nonce();
$qf_data           = array('order_id'=>$qf_order_id,'nonce'=>$qf_nonce);
$qf_data['sign']   = qf_sign($qf_data,$qf_secret);
$qf_url            = 'http://'.$qf_hostname.'.qianfanapi.com/api1_2/orders/query?'.http_build_query($qf_data);
$qf_return         = qf_curl($qf_url);
$qf_content        = json_decode($qf_return,true);
if($qf_content){
    if ($qf_content['data'][$qf_order_id]['result']==1 || $qf_content['data'][$qf_order_id]['result']==2) {
        
        Log::DEBUG("[return] qf_content ok:" . json_encode(iconv_to_utf8($qf_content)));
        
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

            Log::DEBUG("[return]success qf_order_id:" . json_encode(iconv_to_utf8($qf_order_id)));
                
        }else{
            Log::DEBUG("[return]no find order flow qf_order_id:".$qf_order_id);
        }
        
    }else {
        Log::DEBUG("[return] qf_content data error:" . json_encode(iconv_to_utf8($qf_content['data'])));
    }
    
}else {
    Log::DEBUG("[return] qf_content error:" . json_encode(iconv_to_utf8($qf_content)));
}

if($_GET['from'] == 'corn'){
    echo 'corn success';exit;
}else{
    dheader('location:'.$_G['siteurl']."plugin.php?id=tom_pay&order_no=".$payOrderInfo['order_no'])."&pbrand=".rand(1, 1000);exit;  
}