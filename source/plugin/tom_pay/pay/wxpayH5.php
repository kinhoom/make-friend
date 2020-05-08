<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：大叔来 www.dasuhlai.com
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$wxpay_appid        = trim($payConfig['wxpay_appid']);
$wxpay_mchid        = trim($payConfig['wxpay_mchid']);
$wxpay_key          = trim($payConfig['wxpay_key']);
$wxpay_appsecret    = trim($payConfig['wxpay_appsecret']);

define("TOM_WXPAY_APPID", $wxpay_appid);
define("TOM_WXPAY_MCHID", $wxpay_mchid);
define("TOM_WXPAY_KEY", $wxpay_key);
define("TOM_WXPAY_APPSECRET", $wxpay_appsecret);

$souhu_pv_ip  = isset($_GET['souhu_pv_ip'])? addslashes($_GET['souhu_pv_ip']):'';

$clientip = $_G['clientip'];
if(!empty($souhu_pv_ip) && $payConfig['open_js_getip'] == 1){
    $clientip = $souhu_pv_ip;
}

include DISCUZ_ROOT.'./source/plugin/tom_pay/class/wxpay/lib/WxPay.Api.php';

$outArr = array(
    'status'=> 1,
);

$orderInfo['goods_name'] = cutstr($orderInfo['goods_name'],10,"..");
$goods_name = diconv($orderInfo['goods_name'],CHARSET,'utf-8');
$notifyUrl = $_G['siteurl']."source/plugin/tom_pay/wxpayNotify.php";
if($payConfig['must_http'] == 1){
    $notifyUrl = str_replace("https:", "http:", $notifyUrl);
}
$pay_price = $orderInfo['pay_price']*100;
$scene_info = '{"h5_info": {"type":"Wap","wap_url": "'.$orderInfo['goods_url'].'","wap_name": "'.$goods_name.'"}}';

$mweb_url = '';

if(!empty($orderInfo['order_time']) && !empty($orderInfo['mweb_url']) && ($orderInfo['order_time']+0) > TIMESTAMP){
    
    $mweb_url = $orderInfo['mweb_url'];

}else{

    $orderInput = new WxPayUnifiedOrder();
    $orderInput->SetBody($goods_name);		
    $orderInput->SetAttach("tom_pay");		
    $orderInput->SetOut_trade_no($order_no);	
    $orderInput->SetTotal_fee($pay_price);
    $orderInput->SetSpbill_create_ip($clientip);
    $orderInput->SetNotify_url($notifyUrl);	
    $orderInput->SetTrade_type("MWEB");
    $orderInput->SetScene_info($scene_info);
    $returnInfo = WxPayApi::unifiedOrder($orderInput,300);
    
    if(is_array($returnInfo) && $returnInfo['result_code']=='SUCCESS' && $returnInfo['return_code']=='SUCCESS'){

        $mweb_url = $returnInfo['mweb_url'];

        $updateData = array();
        $updateData['payment']          = 'wxpay_h5';
        $updateData['mweb_url']         = $returnInfo['mweb_url'];
        $updateData['order_time']       = TIMESTAMP;
        C::t('#tom_pay#tom_pay_order')->update($orderInfo['id'],$updateData);

    }else{

        Log::DEBUG("[h5]status(500):" . json_encode($returnInfo));

        $outArr = array(
            'status'=> 500,
        );
        echo json_encode($outArr); exit;
    }
}
    

if(!empty($mweb_url)){

    $outArr = array(
        'status'=> 200,
        'mweburl' => $mweb_url,
    );
    echo json_encode($outArr); exit;
}else{
    $outArr = array(
        'status'=> 301,
    );
    echo json_encode($outArr); exit;
}




