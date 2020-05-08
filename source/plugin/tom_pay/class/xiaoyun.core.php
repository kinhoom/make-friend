<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function xy_getNonceStr($length = 32) 
{
    $chars = "abcdefghijklmnopqrstuvwxyz0123456789";  
    $str ="";
    for ( $i = 0; $i < $length; $i++ )  {  
        $str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);  
    } 
    return $str;
}

function xy_ToUrlParams($param)
{
    $buff = "";
    foreach ($param as $k => $v)
    {
        if($k != "sign" && $v != "" && !is_array($v)){
            $buff .= $k . "=" . $v . "&";
        }
    }

    $buff = trim($buff, "&");
    return $buff;
}

function xy_MakeSign($param)
{
    //签名步骤一：按字典序排序参数
    ksort($param);
    $string = xy_ToUrlParams($param);
    //签名步骤二：在string后加入KEY
    $string = $string . "&key=".TOM_WXPAY_KEY;
    //签名步骤三：MD5加密
    $string = md5($string);
    //签名步骤四：所有字符转为大写
    $result = strtoupper($string);
    return $result;
}