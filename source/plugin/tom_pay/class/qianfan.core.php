<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function qf_nonce($length = 32){
     $chars = "abcdefghijklmnopqrstuvwxyz0123456789";  
     $str ="";
     for ( $i = 0; $i < $length; $i++ )  {  
         $str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);  
     } 
     return $str;
}
function qf_sign($params, $secret) {
    ksort($params);
    $sparams = array();
    foreach ($params as $k => $v) {
        if ("@" != substr($v, 0, 1)) {
            $sparams[] = "$k=$v";
        }
    }
    $sparams[] = "secret=" . $secret;
    return strtoupper(md5(implode("&", $sparams)));
}

function qf_curl($url){
    if(function_exists('curl_init')){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $return = curl_exec($ch);
        curl_close($ch); 
        return $return;
    }
    return false;
}