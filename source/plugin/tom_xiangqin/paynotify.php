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

$orderInfo = C::t('#tom_xiangqin#tom_xiangqin_order')->fetch_by_order_no($order_no);

if($orderInfo && $orderInfo['order_status'] == 1){
    $updateData = array();
    $updateData['order_status'] = 2;
    $updateData['pay_time'] = TIMESTAMP;
    C::t('#tom_xiangqin#tom_xiangqin_order')->update($orderInfo['id'],$updateData);

    Log::DEBUG("update order:" . json_encode(iconv_to_utf8($orderInfo['order_no'])));
    
    $xiangqinInfo = C::t('#tom_xiangqin#tom_xiangqin')->fetch_by_id($orderInfo['xiangqin_id']);

    if($orderInfo['order_type'] == 1){
        
        $top_time = TIMESTAMP;
        if($xiangqinInfo['top_time'] > TIMESTAMP){
            $top_time = $xiangqinInfo['top_time'] + $orderInfo['time_value']*86400;
        }else{
            $top_time = TIMESTAMP + $orderInfo['time_value']*86400;
        }
        
        $updateData = array();
        $updateData['top_time']     = $top_time;
        $updateData['top_do_time']  = TIMESTAMP;
        $updateData['top_status']   = 1;
        C::t('#tom_xiangqin#tom_xiangqin')->update($xiangqinInfo['id'],$updateData);
        
    }else if($orderInfo['order_type'] == 2){
        
        $vipInfo = C::t('#tom_xiangqin#tom_xiangqin_vip')->fetch_by_id($orderInfo['vip_id']);
        
        $vip_time = TIMESTAMP;
        if($xiangqinInfo['vip_time'] > TIMESTAMP){
            $vip_time = $xiangqinInfo['vip_time'] + $vipInfo['days']*86400;
        }else{
            $vip_time = TIMESTAMP + $vipInfo['days']*86400;
        }
        $updateData = array();
        $updateData['vip_id']   = $orderInfo['vip_id'];
        $updateData['vip_time'] = $vip_time;
        $updateData['qianxians'] = $xiangqinInfo['qianxians'] + $vipInfo['qianxian_times'];
        C::t('#tom_xiangqin#tom_xiangqin')->update($xiangqinInfo['id'],$updateData);
        
        if($vipInfo['qianxian_times'] > 0){
            $insertData = array();
            $insertData['xiangqin_id']      = $xiangqinInfo['id'];
            $insertData['change_num']       = $vipInfo['qianxian_times'];
            $insertData['old_num']          = $xiangqinInfo['qianxians'];
            $insertData['log_type']         = 4;
            $insertData['log_time']         = TIMESTAMP;
            C::t('#tom_xiangqin#tom_xiangqin_qianxians_log')->insert($insertData);
        }
        
    }else if($orderInfo['order_type'] == 3){
        
        $updateData = array();
        $updateData['qianxians'] = $xiangqinInfo['qianxians'] + $orderInfo['qianxian_value'];
        C::t('#tom_xiangqin#tom_xiangqin')->update($xiangqinInfo['id'],$updateData);
        
        $insertData = array();
        $insertData['xiangqin_id']      = $xiangqinInfo['id'];
        $insertData['change_num']       = $orderInfo['qianxian_value'];
        $insertData['old_num']          = $xiangqinInfo['qianxians'];
        $insertData['log_type']         = 5;
        $insertData['log_time']         = TIMESTAMP;
        C::t('#tom_xiangqin#tom_xiangqin_qianxians_log')->insert($insertData);
        
    }
}