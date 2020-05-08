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

include DISCUZ_ROOT.'./source/plugin/tom_pay/class/wxpay/lib/WxPay.Api.php';

$outArr = array(
    'status'=> 1,
);

$goods_name = diconv($orderInfo['goods_name'],CHARSET,'utf-8');
$notifyUrl = $_G['siteurl']."source/plugin/tom_pay/wxpayNotify.php";
$pay_price = $orderInfo['pay_price']*100;

$code_url = '';

if(!empty($orderInfo['order_time']) && !empty($orderInfo['code_url']) && ($orderInfo['order_time']+5400) > TIMESTAMP){

    $code_url = $orderInfo['code_url'];

}else{

    $orderInput = new WxPayUnifiedOrder();
    $orderInput->SetBody($goods_name);		
    $orderInput->SetAttach("tom_pay");		
    $orderInput->SetOut_trade_no($order_no);	
    $orderInput->SetTotal_fee($pay_price);	
    $orderInput->SetGoods_tag("null");	
    $orderInput->SetNotify_url($notifyUrl);	
    $orderInput->SetTrade_type("NATIVE");
    $orderInput->SetProduct_id($orderInfo['goods_id']);
    $returnInfo = WxPayApi::unifiedOrder($orderInput,300);

    if(is_array($returnInfo) && $returnInfo['result_code']=='SUCCESS' && $returnInfo['return_code']=='SUCCESS'){

        $code_url = $returnInfo['code_url'];

        $updateData = array();
        $updateData['payment']          = 'wxpay_native';
        $updateData['code_url']         = $returnInfo['code_url'];
        $updateData['order_time']       = TIMESTAMP;
        C::t('#tom_pay#tom_pay_order')->update($orderInfo['id'],$updateData);

    }else{

        Log::DEBUG("[native]status(500):" . json_encode($returnInfo));

        $outArr = array(
            'status'=> 500,
        );
        echo json_encode($outArr); exit;
    }
}
    

if(!empty($code_url)){
    
    $qrcodeImg = $_G['siteurl']."plugin.php?id=tom_qrcode&data=".urlencode($code_url);

    $outArr = array(
        'status'=> 200,
        'src' => $qrcodeImg,
    );
    echo json_encode($outArr); exit;
}else{
    $outArr = array(
        'status'=> 301,
    );
    echo json_encode($outArr); exit;
}




