<?php

/*
   [Dashulai!] (C)2009-2019 WWW.DASHULAI.COM.
   技术支持/更新维护：官网 https://www.dashulai.com
   微信支付回调接口文件
*/

if(!defined('IN_DISCUZ') || !defined('IN_TOM_PAY')) {
	exit('Access Denied');
}

$jyConfig = $_G['cache']['plugin']['tom_love'];

include DISCUZ_ROOT.'./source/plugin/tom_love/class/phb.func.php';

$orderInfo = C::t('#tom_love#tom_love_order')->fetch_by_order_no($order_no);

if($orderInfo && $orderInfo['order_status'] == 1){
    
    $updateData = array();
    $updateData['order_status'] = 2;
    $updateData['pay_time'] = TIMESTAMP;
    C::t('#tom_love#tom_love_order')->update($orderInfo['id'],$updateData);

    Log::DEBUG("update order:" . json_encode(iconv_to_utf8($orderInfo['order_no'])));
    
    $userinfo = C::t('#tom_love#tom_love')->fetch_by_id($orderInfo['user_id']);

    if($orderInfo['order_type'] == 1){
        
        $updateData = array();
        $updateData['score'] = $userinfo['score'] + $orderInfo['score_value'];
        C::t('#tom_love#tom_love')->update($userinfo['id'],$updateData);

        $insertData = array();
        $insertData['user_id']      = $userinfo['id'];
        $insertData['score_value']  = $orderInfo['score_value'];
        $insertData['log_type']     = 2;
        $insertData['log_time']     = TIMESTAMP;
        C::t('#tom_love#tom_love_scorelog')->insert($insertData);
        
    }else if($orderInfo['order_type'] == 2){

        $vip_time = TIMESTAMP;
        if($userinfo['vip_time'] > TIMESTAMP){
            $vip_time = $userinfo['vip_time'] + $orderInfo['time_value']*30*86400;
        }else{
            $vip_time = TIMESTAMP + $orderInfo['time_value']*30*86400;
        }
        $updateData = array();
        $updateData['vip_id']   = 1;
        $updateData['vip_time'] = $vip_time;
        C::t('#tom_love#tom_love')->update($userinfo['id'],$updateData);
        
    }

    update_phb($orderInfo['user_id'], 'paymoney', $orderInfo['pay_price']);
 
}