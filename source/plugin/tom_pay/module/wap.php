<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：大叔来 www.dasuhlai.com
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$order_no  = isset($_GET['order_no'])? addslashes($_GET['order_no']):'';

$orderInfo = C::t('#tom_pay#tom_pay_order')->fetch_by_order_no($order_no);

if($_isWeiXin == 1){
    $payConfig['open_alipay'] = 0;
}

$payUrl = "plugin.php?id=tom_pay:pay";

$syTime = 300*1000;

$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
include template("tom_pay:wap");


