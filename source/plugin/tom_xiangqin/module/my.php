<?php
// +----------------------------------------------------------------------
// | Copyright:    (c) 2009-2019 https://www.dashulai.com All rights reserved.
// +----------------------------------------------------------------------
// | Developer:    大叔来 (https://dwz.cn/q4scNR7Q请收藏备用!)
// +----------------------------------------------------------------------
// | Author:       by Dashulai.com. 技术支持/更新维护：官网 https://www.dashulai.com
// +----------------------------------------------------------------------
if(!defined('IN_DISCUZ')){
	exit('Access Denied');
}

$vip_time = dgmdate($__Xiangqin['vip_time'], 'Y-m-d',$tomSysOffset);
$top_time = dgmdate($__Xiangqin['top_time'], 'Y-m-d',$tomSysOffset);
$now_time = dgmdate($_G['timestamp'], 'Y-m-d',$tomSysOffset);

$vipInfo  = C::t('#tom_xiangqin#tom_xiangqin_vip')->fetch_by_id($__Xiangqin['vip_id']);

$pic_url = tom_xiangqin_avatar($__Xiangqin['id']);

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
            if(!empty($time) && !empty($price)){
                $qianxian_moneyArr[] = $price;
            }
        }
    }
}

$ajaxOpenUrl     = "plugin.php?id=tom_xiangqin:ajax&act=opend";
$ajaxCloseUrl    = "plugin.php?id=tom_xiangqin:ajax&act=closed";

$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
include template("tom_xiangqin:my");