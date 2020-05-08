<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：大叔来 www.dasuhlai.com
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class weixinClass{
    
    private $appId;
    private $appSecret;
    private $accessTokenCachename;
    private $jsApiTicketCachename;

    public function __construct($appId, $appSecret) {
        
        $this->appId = trim($appId);
        $this->appSecret = trim($appSecret);
        $key = md5($this->appId."-".$this->appSecret);
        $this->accessTokenCachename = 'tom_weixin_access_token_'.$key;
        $this->jsApiTicketCachename = 'tom_weixin_js_api_ticket_'.$key;
    }
    
    public function get_url(){
        global $_G;
        
        //$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        
        $protocol = "http://";
        if(strpos($_G['siteurl'], 'https:') !== FALSE){
            $protocol = "https://";
        }
        
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        
        return $url;
    }


    public function get_jssdk_config() {
        
        $jsapiTicket = $this->get_js_api_ticket();
        $url = $this->get_url();
        
        $timestamp = TIMESTAMP;
        $nonceStr = $this->create_nonce_str();

        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1($string);

        $signConfig = array(
            "appId"     => $this->appId,
            "nonceStr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        return $signConfig; 
    }

    public function get_access_token(){
        $appid = $this->appId;
        $appsecret = $this->appSecret;
        $cachename = $this->accessTokenCachename;

        $access_token = '';
        $cache_time = 0;

        require_once libfile('function/cache');

        @include(DISCUZ_ROOT.'./data/sysdata/cache_'.$cachename.'.php');
        if(!file_exists(DISCUZ_ROOT.'./data/sysdata/cache_'.$cachename.'.php') || ($cache_time + 600 < TIMESTAMP)){
            $get_access_token_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
            $return = get_html($get_access_token_url);
            if(!empty($return)){
                $content = json_decode($return,true);
                if(is_array($content) && !empty($content) && isset($content['access_token']) && !empty($content['access_token'])){
                    $access_token = $content['access_token'];
                }
            }

            $cachedata = "\$access_token='".$access_token."';\n\$cache_time='".TIMESTAMP."';\n";
            writetocache($cachename, $cachedata);
            @include(DISCUZ_ROOT.'./data/sysdata/cache_'.$cachename.'.php');
        }
        return $access_token;

    }
    
    public function get_js_api_ticket(){
        $appid = $this->appId;
        $appsecret = $this->appSecret;
        $cachename = $this->jsApiTicketCachename;

        $js_api_ticket = '';
        $cache_time = 0;

        require_once libfile('function/cache');

        @include(DISCUZ_ROOT.'./data/sysdata/cache_'.$cachename.'.php');
        if(!file_exists(DISCUZ_ROOT.'./data/sysdata/cache_'.$cachename.'.php') || ($cache_time + 3600 < TIMESTAMP)){
            
            $access_token = $this->get_access_token();
            $get_js_api_ticket = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$access_token";
            $return = get_html($get_js_api_ticket);
            if(!empty($return)){
                $content = json_decode($return,true);
                if(is_array($content) && !empty($content) && isset($content['ticket']) && !empty($content['ticket'])){
                    $js_api_ticket = $content['ticket'];
                }
            }

            $cachedata = "\$js_api_ticket='".$js_api_ticket."';\n\$cache_time='".TIMESTAMP."';\n";
            writetocache($cachename, $cachedata);
            @include(DISCUZ_ROOT.'./data/sysdata/cache_'.$cachename.'.php');
        }
        return $js_api_ticket;

    }
    
    private function create_nonce_str($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
}


function get_html($url){
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


