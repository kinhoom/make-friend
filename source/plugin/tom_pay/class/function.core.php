<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function checkDirNameChar($str = ''){
    $flag = false;
    if ($str && preg_match("#^[a-zA-Z0-9_]+$#", $str)){
        $flag = true;
    }
    return  $flag;				
}

function iconv_to_utf8($value){
    if(is_array($value)) {
        foreach($value AS $key => $val) {
            $value[$key] = iconv_to_utf8($val);
        }
    } else {
        $value = diconv($value,CHARSET,'utf-8');
    }
    return $value;
}

function iconv_utf8_to_gbk($value){
    if(is_array($value)) {
        foreach($value AS $key => $val) {
            $value[$key] = iconv_utf8_to_gbk($val);
        }
    } else {
        $value = diconv($value,'utf-8',CHARSET);
    }
    return $value;
}

function getHtml($url){
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

