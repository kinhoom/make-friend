<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


$url = $weixinClass->get_url();

# tom oauth start
$tom_oauth_hosts = trim($ucenterConfig['oauth_hosts']);
preg_match("#((http|https)://([^?]*)/)[a-z_0-9]*.php#", $url, $urlmatches);
if(!empty($tom_oauth_hosts) && is_array($urlmatches) && !empty($urlmatches['0'])){
    $tom_visit_hosts = $urlmatches['3'];
    if(strpos($urlmatches['3'],'/') !== FALSE){
        $tom_visit_hosts_arr = explode('/', $urlmatches['3']);
        $tom_visit_hosts = $tom_visit_hosts_arr[0];
    }
    if($tom_visit_hosts !== $tom_oauth_hosts){
        if($ucenterConfig['oauth_http'] == 2){
            $tom_oauth_url = "https://".$tom_oauth_hosts."/tom_oauth.php";
        }else{
            $tom_oauth_url = "http://".$tom_oauth_hosts."/tom_oauth.php";
        }
        $oauth_back_url = $urlmatches['0'];
        $url = str_replace($urlmatches['0'], $tom_oauth_url, $url)."&oauth_back_url=".urlencode($oauth_back_url);
    }
}
# tom oauth end

$redirect_uri = urlencode($url);

$openid = '';
$subscribeFlag = false; 

$oauth2_url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_base&state=1#wechat_redirect";

if(isset($_GET['code']) && !empty($_GET['code'])){
    $code = $_GET['code'];
    $openid = get_oauth2_openid($code,$appid,$appsecret);
    if(!empty($openid)){
    }else{
        dheader('location:'.$oauth2_url);
        exit;
    }
    
}else{
    dheader('location:'.$oauth2_url);
    exit;
}
function get_oauth2_openid($code,$appid,$appsecret){
    $openid = '';
    $get_openid_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$appsecret}&code={$code}&grant_type=authorization_code";
    $return = get_html($get_openid_url);
    if(!empty($return)){
        $content = json_decode($return,true);
        if(is_array($content) && !empty($content) && isset($content['openid']) && !empty($content['openid'])){
            $openid = $content['openid'];
        }
    }
    return $openid;
}

