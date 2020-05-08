<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function bbs_avatar($uid){
    $avatar_url = '';
    
    $avatar = 'uc_server/data/avatar/'.get_avatar($uid);
    if(file_exists(DISCUZ_ROOT.'/'.$avatar)) {
        $avatar_url = $avatar;
    }else{
        $avatar_url = 'uc_server/images/noavatar_middle.gif';
    }
    
    return $avatar_url;
}

function get_avatar($uid, $size = 'middle', $type = '') {
	$size = in_array($size, array('big', 'middle', 'small')) ? $size : 'middle';
	$uid = abs(intval($uid));
	$uid = sprintf("%09d", $uid);
	$dir1 = substr($uid, 0, 3);
	$dir2 = substr($uid, 3, 2);
	$dir3 = substr($uid, 5, 2);
	$typeadd = $type == 'real' ? '_real' : '';
	return $dir1.'/'.$dir2.'/'.$dir3.'/'.substr($uid, -2).$typeadd."_avatar_$size.jpg";
}