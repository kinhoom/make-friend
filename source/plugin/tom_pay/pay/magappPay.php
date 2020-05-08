<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：大叔来 www.dasuhlai.com
*/

if(!defined('IN_DISCUZ')){
	exit('Access Denied');
}

$magapp_url        = trim($payConfig['magapp_url']);    // 马甲客户端网址
$magapp_secret     = trim($payConfig['magapp_secret']); // 马甲密钥  马甲后台，新增应用-生成Secret
$magapp_url        = rtrim($magapp_url,'/');

$outArr = array(
    'status'=> 1,
);

$orderInfo['goods_name']    = cutstr($orderInfo['goods_name'],10,"..");
$goods_name                 = diconv($orderInfo['goods_name'],CHARSET,'utf-8');
$callbackUrl                = $_G['siteurl']."source/plugin/tom_pay/magappReturn.php?order_no=".$orderInfo['order_no'];

$mag_order_id = '';

if(!empty($orderInfo['order_time']) && !empty($orderInfo['mag_order_id']) && ($orderInfo['order_time']+5400) > TIMESTAMP ){

    $mag_order_id = $orderInfo['mag_order_id'];

}else{
    
    $paramArr = array(
        'trade_no'      => $orderInfo['order_no'],
        'callback'      => $callbackUrl,
        'amount'        => $orderInfo['pay_price'],
        'title'         => $goods_name,
        'user_id'       => $_G['uid'],
        'to_user_id'    => 0,
        'des'           => $goods_name,
        'remark'        => $goods_name,
        'secret'        => $magapp_secret
    );
	$magapp_api_url = $magapp_url.'/core/pay/pay/unifiedOrder?'.http_build_query($paramArr);
    
    $return = getHtml($magapp_api_url);
    if(!empty($return)){
        $content = json_decode($return,true);
        if(is_array($content) && !empty($content['data']) && !empty($content['data']['unionOrderNum'])){
            
            $mag_order_id = $content['data']['unionOrderNum'];
            
            $updateData = array();
            $updateData['payment']          = 'magapp_pay';
            $updateData['mag_order_id']     = $mag_order_id;
            $updateData['order_time']       = TIMESTAMP;
            C::t('#tom_pay#tom_pay_order')->update($orderInfo['id'],$updateData);
            
        }else{
            Log::DEBUG("[magapp]status(500):" . json_encode($content));

            $outArr = array(
                'status'=> 500,
            );
            echo json_encode($outArr); exit;
        }
    }else{
        Log::DEBUG("[magapp]status(501):" . json_encode($return));

        $outArr = array(
            'status'=> 500,
        );
        echo json_encode($outArr); exit;
    }

}
    

if(!empty($mag_order_id)){

    $outArr = array(
        'status'=> 200,
        'mag_order_id' => $mag_order_id,
    );
    echo json_encode($outArr); exit;
}else{
    $outArr = array(
        'status'=> 301,
    );
    echo json_encode($outArr); exit;
}