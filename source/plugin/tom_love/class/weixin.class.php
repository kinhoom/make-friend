<?php

/*
   [Dashulai!] (C)2009-2019 WWW.DASHULAI.COM.
   技术支持/更新维护：官网 https://www.dashulai.com
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
    
    public function get_short_url($url){
        $access_token = $this->get_access_token();
        $get_short_url = "https://api.weixin.qq.com/cgi-bin/shorturl?access_token={$access_token}";
        $data = '{"action":"long2short","long_url":"'.$url.'"}';  
        $return = httpPost($get_short_url, $data);
        if(!empty($return)){
            $content = json_decode($return,true);
            if(is_array($content) && !empty($content) && isset($content['short_url']) && !empty($content['short_url'])){
                $short_url = $content['short_url'];
            }
        }
        return $short_url;
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

function httpPost($url,$data){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");  
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);  

    $return = curl_exec($curl);  
    curl_close($curl);  
    return $return; 
}