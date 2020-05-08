<?php

/*
   [Dashulai!] (C)2009-2019 WWW.DASHULAI.COM.
   技术支持/更新维护：官网 https://www.dashulai.com
*/

/**
   1 待支付 2 已支付
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$jyConfig = $_G['cache']['plugin']['tom_love'];

$act = isset($_GET['act'])? addslashes($_GET['act']):"score";

if($act == "score" && $_GET['formhash'] == FORMHASH){
    
    $outArr = array(
        'status'=> 1,
    );

    $user_id    = isset($_GET['user_id'])? intval($_GET['user_id']):0;
    $pay_price  = intval($_GET['pay_price'])>0? intval($_GET['pay_price']):1;
    
    $userinfo = C::t('#tom_love#tom_love')->fetch_by_id($user_id);
    if(!$userinfo){
        $outArr = array(
            'status'=> 301,
        );
        echo json_encode($outArr); exit;
    }
    
    $yuan_score_listStr = str_replace("\r\n","{n}",$jyConfig['yuan_score_list']); 
    $yuan_score_listStr = str_replace("\n","{n}",$yuan_score_listStr);
    $yuan_score_listTmpArr = explode("{n}", $yuan_score_listStr);

    $yuan_scoreArr = array();
    if(is_array($yuan_score_listTmpArr) && !empty($yuan_score_listTmpArr)){
        foreach ($yuan_score_listTmpArr as $key => $value){
            if(!empty($value)){
                list($yuan, $score) = explode("|", $value);
                $yuan = intval($yuan);
                $score = intval($score);
                if(!empty($yuan) && !empty($score)){
                    $yuan_scoreArr[$yuan] = $score;
                }
            }
        }
    }
    
    if(!isset($yuan_scoreArr[$pay_price]) || $pay_price <= 0){
        $outArr = array(
            'status'=> 302,
        );
        echo json_encode($outArr); exit;
    }

    $order_no = "JY".date("YmdHis")."-".mt_rand(111111, 666666);
    
    if(!file_exists(DISCUZ_ROOT.'./source/plugin/tom_pay/tom_pay.inc.php')){
        $outArr = array(
            'status'=> 303,
        );
        echo json_encode($outArr); exit;
    }
    
    $insertData = array();
    $insertData['order_no']         = $order_no;
    $insertData['user_id']          = $user_id;
    $insertData['score_value']      = $yuan_scoreArr[$pay_price];
    $insertData['pay_price']        = $pay_price;
    $insertData['order_status']     = 1;
    $insertData['order_time']       = TIMESTAMP;
    if(C::t('#tom_love#tom_love_order')->insert($insertData)){
        
        $insertData = array();
        $insertData['plugin_id']       = 'tom_love';      
        $insertData['order_no']        = $order_no;            
        $insertData['goods_id']        = $user_id;           
        $insertData['goods_name']      = lang('plugin/tom_love','wxpay_score_order');
        $insertData['goods_beizu']     = lang('plugin/tom_love','wxpay_score_order');
        $insertData['goods_url']       = "plugin.php?id=tom_love&mod=scorepay";
        $insertData['succ_back_url']   = "plugin.php?id=tom_love&mod=scorepay";
        $insertData['fail_back_url']   = "plugin.php?id=tom_love&mod=scorepay";
        $insertData['allow_alipay']    = 1;         
        $insertData['pay_price']       = $pay_price;    
        $insertData['order_status']    = 1;             
        $insertData['add_time']        = TIMESTAMP;     
        if(C::t('#tom_pay#tom_pay_order')->insert($insertData)){
            $outArr = array(
                'pay_status' => 1,
                'status'    => 200,
                'payurl' => "plugin.php?id=tom_pay&order_no=".$order_no,
            );
            echo json_encode($outArr); exit;

        }else{
            $outArr = array(
                'status'=> 304,
            );
            echo json_encode($outArr); exit;
        }
    }else{
        $outArr = array(
            'status'=> 304,
        );
        echo json_encode($outArr); exit;
    }
    
}else if($act == "vip" && $_GET['formhash'] == FORMHASH){
    
    $outArr = array(
        'status'=> 1,
    );

    $user_id    = isset($_GET['user_id'])? intval($_GET['user_id']):0;
    $month_id   = intval($_GET['month_id'])>0? intval($_GET['month_id']):1;
    $vip_id     = intval($_GET['vip_id'])>0? intval($_GET['vip_id']):1;
    
    $userinfo = C::t('#tom_love#tom_love')->fetch_by_id($user_id);
    if(!$userinfo){
        $outArr = array(
            'status'=> 301,
        );
        echo json_encode($outArr); exit;
    }
    
    $yuan_vip1_listStr = str_replace("\r\n","{n}",$jyConfig['yuan_vip1_list']); 
    $yuan_vip1_listStr = str_replace("\n","{n}",$yuan_vip1_listStr);
    $yuan_vip1_listTmpArr = explode("{n}", $yuan_vip1_listStr);
    
    $yuan_vip1Arr = array();
    if(is_array($yuan_vip1_listTmpArr) && !empty($yuan_vip1_listTmpArr)){
        foreach ($yuan_vip1_listTmpArr as $key => $value){
            if(!empty($value)){
                list($month, $price) = explode("|", $value);
                $month = intval($month);
                $price = intval($price);
                if(!empty($month) && !empty($price)){
                    $yuan_vip1Arr[$month] = $price;
                }
            }
        }
    }

    if(!isset($yuan_vip1Arr[$month_id])){
        $outArr = array(
            'status'=> 302,
        );
        echo json_encode($outArr); exit;
    }
    
    $order_no   = "JY".date("YmdHis")."-".mt_rand(111111, 666666);
    $pay_price  = $yuan_vip1Arr[$month_id];
    
    if(!file_exists(DISCUZ_ROOT.'./source/plugin/tom_pay/tom_pay.inc.php')){
        $outArr = array(
            'status'=> 303,
        );
        echo json_encode($outArr); exit;
    }

    $insertData = array();
    $insertData['order_no']         = $order_no;
    $insertData['order_type']       = 2;
    $insertData['user_id']          = $user_id;
    $insertData['score_value']      = 0;
    $insertData['time_value']       = $month_id;
    $insertData['pay_price']        = $pay_price;
    $insertData['order_status']     = 1;
    $insertData['order_time']       = TIMESTAMP;
    if(C::t('#tom_love#tom_love_order')->insert($insertData)){
        $order_id = C::t('#tom_love#tom_love_order')->insert_id();
        
        $insertData = array();
        $insertData['plugin_id']       = 'tom_love';      
        $insertData['order_no']        = $order_no;            
        $insertData['goods_id']        = $user_id;           
        $insertData['goods_name']      = lang('plugin/tom_love','wxpay_vip_order');
        $insertData['goods_beizu']     = lang('plugin/tom_love','wxpay_vip_order');
        $insertData['goods_url']       = "plugin.php?id=tom_love&mod=vippay";
        $insertData['succ_back_url']   = "plugin.php?id=tom_love&mod=vippay";
        $insertData['fail_back_url']   = "plugin.php?id=tom_love&mod=vippay";
        $insertData['allow_alipay']    = 1;         
        $insertData['pay_price']       = $pay_price;    
        $insertData['order_status']    = 1;             
        $insertData['add_time']        = TIMESTAMP;     
        if(C::t('#tom_pay#tom_pay_order')->insert($insertData)){
            $outArr = array(
                'pay_status' => 1,
                'status'    => 200,
                'payurl' => "plugin.php?id=tom_pay&order_no=".$order_no,
            );
            echo json_encode($outArr); exit;

        }else{
            $outArr = array(
                'status'=> 304,
            );
            echo json_encode($outArr); exit;
        }
    }else{
        $outArr = array(
            'status'=> 304,
        );
        echo json_encode($outArr); exit;
    }
    
}else{
    $outArr = array(
        'status'=> 111111,
    );
    echo json_encode($outArr); exit;
}