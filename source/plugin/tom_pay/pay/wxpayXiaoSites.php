<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：大叔来 www.dasuhlai.com
*/

if(!defined('IN_DISCUZ')){
	exit('Access Denied');
}

$xiaofenleiConfig = $_G['cache']['plugin']['tom_xiaofenlei'];

$wxpay_appid        = trim($xiaoSitesInfo['wxpay_appid']);
$wxpay_mchid        = trim($xiaoSitesInfo['wxpay_mchid']);
$wxpay_key          = trim($xiaoSitesInfo['wxpay_key']);
$wxpay_appsecret    = trim($xiaoSitesInfo['wxpay_appsecret']);

define("TOM_WXPAY_APPID", $wxpay_appid);
define("TOM_WXPAY_MCHID", $wxpay_mchid);
define("TOM_WXPAY_KEY", $wxpay_key);
define("TOM_WXPAY_APPSECRET", $wxpay_appsecret);

$code  = !empty($_GET['code'])? addslashes($_GET['code']):'';

$openid = '';
$getOpenidUrl = "https://api.weixin.qq.com/sns/jscode2session?appid={$wxpay_appid}&secret={$wxpay_appsecret}&js_code={$code}&grant_type=authorization_code";
$return = getHtml($getOpenidUrl);
if(!empty($return)){
    $content = json_decode($return,true);
    if(is_array($content) && !empty($content) && isset($content['openid']) && !empty($content['openid'])){
        $openid = $content['openid'];
    }
}

if(empty($openid)){
    $outArr = array(
        'status'=> 601,
    );
    echo json_encode($outArr); exit;
}

include DISCUZ_ROOT.'./source/plugin/tom_pay/class/wxpay/lib/WxPay.Api.php';

$outArr = array(
    'status'=> 1,
);

$orderInfo['goods_name'] = cutstr($orderInfo['goods_name'],10,"..");
$goods_name = diconv($orderInfo['goods_name'],CHARSET,'utf-8');
$notifyUrl = $_G['siteurl']."source/plugin/tom_pay/xiaoSitesNotify.php";
if($payConfig['must_http'] == 1){
    $notifyUrl = str_replace("https:", "http:", $notifyUrl);
}
$pay_price = $orderInfo['pay_price']*100;

$prepay_id = '';

if(!empty($orderInfo['order_time']) && !empty($orderInfo['prepay_id']) && ($orderInfo['order_time']+5400) > TIMESTAMP ){

    $prepay_id = $orderInfo['prepay_id'];

}else{

    $orderInput = new WxPayUnifiedOrder();
    $orderInput->SetBody($goods_name);		
    $orderInput->SetAttach("sid_".$sid);
    $orderInput->SetOut_trade_no($order_no);
    $orderInput->SetTotal_fee($pay_price);	
    $orderInput->SetGoods_tag("null");	
    $orderInput->SetNotify_url($notifyUrl);	
    $orderInput->SetTrade_type("JSAPI");
    $orderInput->SetOpenid($openid);
    $returnInfo = WxPayApi::unifiedOrder($orderInput,300);

    if(is_array($returnInfo) && $returnInfo['result_code']=='SUCCESS' && $returnInfo['return_code']=='SUCCESS'){

        $prepay_id = $returnInfo['prepay_id'];

        $updateData = array();
        $updateData['payment']          = 'wxpay_xiao';
        $updateData['prepay_id']        = $returnInfo['prepay_id'];
        $updateData['order_time']       = TIMESTAMP;
        C::t('#tom_pay#tom_pay_order')->update($orderInfo['id'],$updateData);

    }else{

        Log::DEBUG("[xiaoSites]status(500):" . json_encode($returnInfo));

        $outArr = array(
            'status'=> 500,
        );
        echo json_encode($outArr); exit;
    }
}
    

if(!empty($prepay_id)){
    $jsapi = new WxPayJsApiPay();
    $jsapi->SetAppid($wxpay_appid);
    $timeStamp = time();
    $timeStamp = "$timeStamp";
    $jsapi->SetTimeStamp($timeStamp);
    $jsapi->SetNonceStr(WxPayApi::getNonceStr());
    $jsapi->SetPackage("prepay_id=" . $prepay_id);
    $jsapi->SetSignType("MD5");
    $jsapi->SetPaySign($jsapi->MakeSign());
    $parameters = $jsapi->GetValues();

    $outArr = array(
        'status'=> 200,
        'parameters' => $parameters,
    );
    echo json_encode($outArr); exit;
}else{
    $outArr = array(
        'status'=> 301,
    );
    echo json_encode($outArr); exit;
}




