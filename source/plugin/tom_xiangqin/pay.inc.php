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

$jyConfig		= $_G['cache']['plugin']['tom_love'];
$xiangqinConfig = $_G['cache']['plugin']['tom_xiangqin'];

$act = isset($_GET['act'])? addslashes($_GET['act']):"vip";

if($act == "top" && $_GET['formhash'] == FORMHASH){
    
    $outArr = array(
        'status'=> 1,
    );

    $xiangqin_id    = isset($_GET['xiangqin_id'])? intval($_GET['xiangqin_id']):0;
    $days           = intval($_GET['days'])>0? intval($_GET['days']):0;
    
    $xiangqinInfo       = C::t('#tom_xiangqin#tom_xiangqin')->fetch_by_id($xiangqin_id);
    $userinfo           = C::t('#tom_love#tom_love')->fetch_by_id($xiangqinInfo['user_id']);
    
    if(!$xiangqinInfo || !$userinfo){
        $outArr = array(
            'status'=> 301,
        );
        echo json_encode($outArr); exit;
    }
    
    $top_money_listStr = str_replace("\r\n","{n}",$xiangqinConfig['top_money_list']); 
    $top_money_listStr = str_replace("\n","{n}",$top_money_listStr);
    $top_money_listTmpArr = explode("{n}", $top_money_listStr);
    
    $top_moneyArr = array();
    if(is_array($top_money_listTmpArr) && !empty($top_money_listTmpArr)){
        foreach ($top_money_listTmpArr as $key => $value){
            if(!empty($value)){
                list($day, $price) = explode("|", $value);
                $day = intval($day);
               // $price = intval($price);
                if(!empty($day) && !empty($price)){
                    $top_moneyArr[$day] = $price;
                }
            }
        }
    }

    if(!isset($top_moneyArr[$days])){
        $outArr = array(
            'status'=> 302,
        );
        echo json_encode($outArr); exit;
    }
    
    $order_no   = "JY".date("YmdHis")."-".mt_rand(111111, 666666);
    $pay_price  = $top_moneyArr[$days];
    
    if(!file_exists(DISCUZ_ROOT.'./source/plugin/tom_pay/tom_pay.inc.php')){
        $outArr = array(
            'status'=> 303,
        );
        echo json_encode($outArr); exit;
    }

    $insertData = array();
    $insertData['order_no']         = $order_no;
    $insertData['order_type']       = 1;
    $insertData['user_id']          = $userinfo['id'];
    $insertData['xiangqin_id']      = $xiangqinInfo['id'];
    $insertData['time_value']       = $days;
    $insertData['pay_price']        = $pay_price;
    $insertData['order_status']     = 1;
    $insertData['order_time']       = TIMESTAMP;
    if(C::t('#tom_xiangqin#tom_xiangqin_order')->insert($insertData)){
        $order_id = C::t('#tom_xiangqin#tom_xiangqin_order')->insert_id();
        
        $insertData = array();
        $insertData['plugin_id']       = 'tom_xiangqin';      
        $insertData['order_no']        = $order_no;            
        $insertData['goods_id']        = $xiangqin_id;
        $insertData['goods_name']      = lang('plugin/tom_xiangqin','wxpay_top_order');
        $insertData['goods_beizu']     = lang('plugin/tom_xiangqin','wxpay_top_order');
        $insertData['goods_url']       = "plugin.php?id=tom_xiangqin&mod=top";
        $insertData['succ_back_url']   = "plugin.php?id=tom_xiangqin&mod=top";
        $insertData['fail_back_url']   = "plugin.php?id=tom_xiangqin&mod=top";
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
    
    $vip_id             = isset($_GET['vip_id'])? intval($_GET['vip_id']):0;
    $xiangqin_id        = isset($_GET['xiangqin_id'])? intval($_GET['xiangqin_id']):0;
    
    $xiangqinInfo       = C::t('#tom_xiangqin#tom_xiangqin')->fetch_by_id($xiangqin_id);
    $userinfo           = C::t('#tom_love#tom_love')->fetch_by_id($xiangqinInfo['user_id']);
    $vipinfo            = C::t('#tom_xiangqin#tom_xiangqin_vip')->fetch_by_id($vip_id);
    
    if(!$xiangqinInfo || !$userinfo){
        $outArr = array(
            'status'=> 301,
        );
        echo json_encode($outArr); exit;
    }
    
    if($vipinfo){
        $pay_price  = $vipinfo['price'];
        $days       = $vipinfo['days'];
    }else{
        $outArr = array(
            'status'=> 302,
        );
        echo json_encode($outArr); exit;
    }
    
    if(!file_exists(DISCUZ_ROOT.'./source/plugin/tom_pay/tom_pay.inc.php')){
        $outArr = array(
            'status'=> 303,
        );
        echo json_encode($outArr); exit;
    }
    $order_no   = "JY".date("YmdHis")."-".mt_rand(111111, 666666);
    
    $insertData = array();
    $insertData['order_no']         = $order_no;
    $insertData['order_type']       = 2;
    $insertData['user_id']          = $userinfo['id'];
    $insertData['xiangqin_id']      = $xiangqinInfo['id'];
    $insertData['vip_id']           = $vip_id;
    $insertData['pay_price']        = $pay_price;
    $insertData['order_status']     = 1;
    $insertData['order_time']       = TIMESTAMP;
    if(C::t('#tom_xiangqin#tom_xiangqin_order')->insert($insertData)){
        
        $insertData = array();
        $insertData['plugin_id']       = 'tom_xiangqin';      
        $insertData['order_no']        = $order_no;            
        $insertData['goods_id']        = $xiangqin_id;           
        $insertData['goods_name']      = lang('plugin/tom_xiangqin','wxpay_vip_order');
        $insertData['goods_beizu']     = lang('plugin/tom_xiangqin','wxpay_vip_order');
        $insertData['goods_url']       = "plugin.php?id=tom_xiangqin&mod=vip";
        $insertData['succ_back_url']   = "plugin.php?id=tom_xiangqin&mod=vip";
        $insertData['fail_back_url']   = "plugin.php?id=tom_xiangqin&mod=vip";
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
}else if($act == "qianxian" && $_GET['formhash'] == FORMHASH){
    
    $outArr = array(
        'status'=> 1,
    );

    $xiangqin_id    = isset($_GET['xiangqin_id'])? intval($_GET['xiangqin_id']):0;
    $qianxians      = intval($_GET['qianxians'])>0? intval($_GET['qianxians']):0;
    
    $xiangqinInfo       = C::t('#tom_xiangqin#tom_xiangqin')->fetch_by_id($xiangqin_id);
    $userinfo           = C::t('#tom_love#tom_love')->fetch_by_id($xiangqinInfo['user_id']);
    
    if(!$xiangqinInfo || !$userinfo){
        $outArr = array(
            'status'=> 301,
        );
        echo json_encode($outArr); exit;
    }
    
    $qianxian_money_listStr = str_replace("\r\n","{n}",$xiangqinConfig['qianxian_money_list']); 
    $qianxian_money_listStr = str_replace("\n","{n}",$qianxian_money_listStr);
    $qianxian_money_listStr = str_replace("\r","{n}",$qianxian_money_listStr);
    $qianxian_money_listTmpArr = explode("{n}", $qianxian_money_listStr);
    
    $qianxian_moneyArr = array();
    if(is_array($qianxian_money_listTmpArr) && !empty($qianxian_money_listTmpArr)){
        foreach ($qianxian_money_listTmpArr as $key => $value){
            if(!empty($value)){
                list($time, $price) = explode("|", $value);
                $time = intval($time);
               // $price = intval($price);
                if(!empty($time) && !empty($price)){
                    $qianxian_moneyArr[$time] = $price;
                }
            }
        }
    }

    if(!isset($qianxian_moneyArr[$qianxians])){
        $outArr = array(
            'status'=> 302,
        );
        echo json_encode($outArr); exit;
    }
    
    $order_no   = "JY".date("YmdHis")."-".mt_rand(111111, 666666);
    $pay_price  = $qianxian_moneyArr[$qianxians];
    
    if(!file_exists(DISCUZ_ROOT.'./source/plugin/tom_pay/tom_pay.inc.php')){
        $outArr = array(
            'status'=> 303,
        );
        echo json_encode($outArr); exit;
    }

    $insertData = array();
    $insertData['order_no']         = $order_no;
    $insertData['order_type']       = 3;
    $insertData['user_id']          = $userinfo['id'];
    $insertData['xiangqin_id']      = $xiangqinInfo['id'];
    $insertData['qianxian_value']   = $qianxians;
    $insertData['pay_price']        = $pay_price;
    $insertData['order_status']     = 1;
    $insertData['order_time']       = TIMESTAMP;
    if(C::t('#tom_xiangqin#tom_xiangqin_order')->insert($insertData)){
        $order_id = C::t('#tom_xiangqin#tom_xiangqin_order')->insert_id();
        
        $insertData = array();
        $insertData['plugin_id']       = 'tom_xiangqin';      
        $insertData['order_no']        = $order_no;            
        $insertData['goods_id']        = $xiangqin_id;
        $insertData['goods_name']      = lang('plugin/tom_xiangqin','wxpay_qianxian_order');
        $insertData['goods_beizu']     = lang('plugin/tom_xiangqin','wxpay_qianxian_order');
        $insertData['goods_url']       = "plugin.php?id=tom_xiangqin&mod=qianxian";
        $insertData['succ_back_url']   = "plugin.php?id=tom_xiangqin&mod=qianxian";
        $insertData['fail_back_url']   = "plugin.php?id=tom_xiangqin&mod=qianxian";
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