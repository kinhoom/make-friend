<?php
/* * 
 * 功能：千帆APP异步执行脚本
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
$logHandler= new CLogFileHandler(DISCUZ_ROOT."./source/plugin/tom_pay/logs/[".date("Y-m-d")."]qianfan_cron.log");
$log = Log::Init($logHandler, 15);

Log::DEBUG("[corn] start");

$last_order_time = TIMESTAMP - 3500;
$orderList = C::t('#tom_pay#tom_pay_order')->fetch_all_list(" AND payment='qianfan_pay'  AND order_status=1 AND qf_order_id>0 AND order_time > {$last_order_time} ","ORDER BY id DESC",0,10);

Log::DEBUG("[corn] list :" . json_encode(iconv_to_utf8($orderList)));

if(is_array($orderList) && !empty($orderList)){
    foreach ($orderList as $key => $value){
        Log::DEBUG("[corn] list start :" . json_encode(iconv_to_utf8($value)));
        $corn_return = qf_curl($_G['siteurl'].'source/plugin/tom_pay/qianfanReturn.php?from=corn&qf_order_id='.$value['qf_order_id']);
        Log::DEBUG("[corn] list return :" . json_encode(iconv_to_utf8($corn_return)));
    }
}
Log::DEBUG("[corn] end");
echo 'corn ok';exit;