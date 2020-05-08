<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$sql = '';


if (!empty($sql)) {
	runquery($sql);
}

$finish = TRUE;

