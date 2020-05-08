<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：大叔来 www.dasuhlai.com
   微信支付回调接口文件
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

$wxpay_appid        = trim($payConfig['wxopen_appid']);
$wxpay_mchid        = trim($payConfig['wxopen_mchid']);
$wxpay_key          = trim($payConfig['wxopen_key']);
$wxpay_appsecret    = trim($payConfig['wxopen_appsecret']);

define("TOM_WXPAY_APPID", $wxpay_appid);
define("TOM_WXPAY_MCHID", $wxpay_mchid);
define("TOM_WXPAY_KEY", $wxpay_key);
define("TOM_WXPAY_APPSECRET", $wxpay_appsecret);

include DISCUZ_ROOT.'./source/plugin/tom_pay/class/wxpay/lib/WxPay.Api.php';
include DISCUZ_ROOT.'./source/plugin/tom_pay/class/wxpay/lib/WxPay.Notify.php';
include DISCUZ_ROOT.'./source/plugin/tom_pay/class/log.class.php';
include DISCUZ_ROOT.'./source/plugin/tom_pay/class/function.core.php';

$logDir = DISCUZ_ROOT."./source/plugin/tom_pay/logs/";
if(!is_dir($logDir)){
    mkdir($logDir, 0777,true);
}else{
    chmod($logDir, 0777); 
}
$logHandler= new CLogFileHandler(DISCUZ_ROOT."./source/plugin/tom_pay/logs/[".date("Y-m-d")."]wxpay.log");
$log = Log::Init($logHandler, 15);

class PayNotifyCallBack extends WxPayNotify{
    
	public function Queryorder($transaction_id){
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
        //Log::DEBUG("query:" . json_encode($result));
		if(array_key_exists("return_code", $result) && array_key_exists("result_code", $result) && $result["return_code"] == "SUCCESS" && $result["result_code"] == "SUCCESS"){
			return true;
		}
		return false;
	}
	
	public function NotifyProcess($data, &$msg){
        global $payConfig,$_G;
        
        //Log::DEBUG("call back:" . json_encode($data));
        Log::DEBUG("call back");
        
		$notfiyOutput = array();
		
		if(!array_key_exists("transaction_id", $data)){
            Log::DEBUG("error:can shu cuo wu");
            $msg = "can shu cuo wu";
			return false;
		}
		if(!$this->Queryorder($data["transaction_id"])){
            Log::DEBUG("error:ding dan cha xu shi bai");
            $msg = "ding dan cha xu shi bai";
			return false;
		}
        
        if(isset($data['result_code']) && $data['result_code']=='SUCCESS'){
        }else{
            Log::DEBUG("error:result_code error");
            $msg = "result_code error";
            return false;
        }
        
        if(isset($data['out_trade_no']) && !empty($data['out_trade_no'])){
        }else{
            Log::DEBUG("error:out_trade_no error");
            $msg = "out_trade_no error";
            return false;
        }
        
        $payOrderInfo = C::t('#tom_pay#tom_pay_order')->fetch_by_order_no($data['out_trade_no']);
        if($payOrderInfo && $payOrderInfo['order_status'] == 1){
            
            $updateData = array();
            $updateData['order_status'] = 2;
            $updateData['pay_time'] = TIMESTAMP;
            C::t('#tom_pay#tom_pay_order')->update($payOrderInfo['id'],$updateData);
            
            Log::DEBUG("update order flow:" . json_encode(iconv_to_utf8($payOrderInfo['order_no'])));
            
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
        
        Log::DEBUG("success");
		return true;
	}
    
}

Log::DEBUG("start");
$notify = new PayNotifyCallBack();
$notify->Handle(false);