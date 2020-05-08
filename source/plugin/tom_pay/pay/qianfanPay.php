<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：大叔来 www.dasuhlai.com
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$qf_order_id  = isset($_GET['qf_order_id'])? addslashes($_GET['qf_order_id']):'';

$updateData = array();
$updateData['payment']          = 'qianfan_pay';
$updateData['qf_order_id']      = $qf_order_id;
$updateData['order_time']       = TIMESTAMP;
C::t('#tom_pay#tom_pay_order')->update($orderInfo['id'],$updateData);


$outArr = array(
    'status'=> 200,
);
echo json_encode($outArr); exit;