<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once libfile('function/plugin');

if(isset($_G['uid']) && $_G['uid'] > 0 && $_G['groupid'] == 1){
    
    $sql = '';

    $tom_ucenter_member_field = C::t('#tom_ucenter#tom_ucenter_member')->fetch_all_field();
    if (!isset($tom_ucenter_member_field['bbs_uid'])) {
        $sql .= "ALTER TABLE `pre_tom_ucenter_member` ADD `bbs_uid` int(11) DEFAULT '0';\n";
    }
    if (!isset($tom_ucenter_member_field['mykey'])) {
        $sql .= "ALTER TABLE `pre_tom_ucenter_member` ADD `mykey` varchar(255) DEFAULT NULL;\n";
    }
    if (!isset($tom_ucenter_member_field['pwd'])) {
        $sql .= "ALTER TABLE `pre_tom_ucenter_member` ADD `pwd` varchar(255) DEFAULT NULL;\n";
    }
    if (!isset($tom_ucenter_member_field['last_login_type'])) {
        $sql .= "ALTER TABLE `pre_tom_ucenter_member` ADD `last_login_type` varchar(255) DEFAULT NULL;\n";
    }
    if (!isset($tom_ucenter_member_field['last_login_time'])) {
        $sql .= "ALTER TABLE `pre_tom_ucenter_member` ADD `last_login_time` int(11) DEFAULT '0';\n";
    }
    if (!isset($tom_ucenter_member_field['unionid'])) {
        $sql .= "ALTER TABLE `pre_tom_ucenter_member` ADD `unionid` varchar(255) DEFAULT NULL;\n";
    }

    if (!empty($sql)) {
        runquery($sql);
    }
    

    echo 'OK';exit;
    
}else{
    exit('Access Denied');
}



