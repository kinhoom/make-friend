<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$sql = '';

$tom_pay_order_field = C::t('#tom_pay#tom_pay_order')->fetch_all_field();
if (!isset($tom_pay_order_field['qf_order_id'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_pay_order')." ADD `qf_order_id` int(11) DEFAULT '0';\n";
}
if (!isset($tom_pay_order_field['mag_order_id'])) {
    $sql .= "ALTER TABLE ".DB::table('tom_pay_order')." ADD `mag_order_id` varchar(255) DEFAULT NULL;\n";
}

if (!empty($sql)) {
	runquery($sql);
}

$finish = TRUE;

