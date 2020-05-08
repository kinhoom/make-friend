<?php
/**
 * 
 * 大叔来出品 必属精品
 * 大叔来  全网首发 https://dwz.cn/bEeiwujz
 * 本资源来源于网络收集,仅供个人学习研究欣赏，请勿用于商业用途，并于下载24小时后删除!
 * 感谢支持！您的支持是我们最大的动力！为站长提供最适合的运营资源！
 * 欢迎大家来访获得最新更新的优秀资源！更多VIP特色资源不容错过！！
 * [大叔来]站长交流群: ①群 205670720
 * 永久域名：https://www.dashulai.com/ (请收藏备用!)
 * 
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$openid = '';
$nickname = '';
$headimgurl = '';

$url = $weixinClass->get_url();

# tom oauth start
$tom_oauth_hosts = trim($jyConfig['oauth_hosts']);
preg_match("#((http|https)://([^?]*)/)[a-z_0-9]*.php#", $url, $urlmatches);
if(!empty($tom_oauth_hosts) && is_array($urlmatches) && !empty($urlmatches['0'])){
    $tom_visit_hosts = $urlmatches['3'];
    if(strpos($urlmatches['3'],'/') !== FALSE){
        $tom_visit_hosts_arr = explode('/', $urlmatches['3']);
        $tom_visit_hosts = $tom_visit_hosts_arr[0];
    }
    if($tom_visit_hosts !== $tom_oauth_hosts){
        $tom_oauth_url = "http://".$tom_oauth_hosts."/tom_oauth.php";
        $oauth_back_url = $urlmatches['0'];
        $url = str_replace($urlmatches['0'], $tom_oauth_url, $url)."&oauth_back_url=".urlencode($oauth_back_url);
    }
}
# tom oauth end

$redirect_uri = urlencode($url);

$subscribeFlag = false; 

$oauth2_url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect";

if(isset($_SESSION['tom_love_openid']) && !empty($_SESSION['tom_love_openid'])){
    $openid = $_SESSION['tom_love_openid'];
    $nickname = $_SESSION['tom_love_nickname'];
    $headimgurl = $_SESSION['tom_love_headimgurl'];
}else{
    if(isset($_GET['code']) && !empty($_GET['code'])){
        $code = $_GET['code'];
        $openid_access_token = get_oauth2_openid_access_token($code,$appid,$appsecret);
        $openid = $openid_access_token['openid'];
        $access_token = $openid_access_token['access_token'];
        if(!empty($openid) && !empty($access_token)){
            $oauth2_snsapi_userinfo = get_oauth2_snsapi_userinfo($access_token,$openid);
            if($oauth2_snsapi_userinfo && isset($oauth2_snsapi_userinfo['nickname'])){
                $nickname = $oauth2_snsapi_userinfo['nickname'];
                $headimgurl = $oauth2_snsapi_userinfo['headimgurl'];
                $_SESSION['tom_love_openid'] = $openid;
                $_SESSION['tom_love_nickname'] = $nickname;
                $_SESSION['tom_love_headimgurl'] = $headimgurl;
            }else{
				dheader('location:'.$oauth2_url);
				exit;
			}
        }else{
            dheader('location:'.$oauth2_url);
            exit;
        }

    }else{
        dheader('location:'.$oauth2_url);
        exit;
    }
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

function get_oauth2_openid_access_token($code,$appid,$appsecret){
    $outArr = array(
        'access_token' => '',
        'openid' => '',
    );
    $get_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$appsecret}&code={$code}&grant_type=authorization_code";
    $return = get_html($get_url);
    if(!empty($return)){
        $content = json_decode($return,true);
        if(is_array($content) && !empty($content) && isset($content['access_token']) && !empty($content['access_token'])){
            $outArr = array(
                'access_token' => $content['access_token'],
                'openid' => $content['openid'],
            );
        }
    }
    return $outArr;
}

function get_oauth2_snsapi_userinfo($access_token,$openid){
    $outArr = array();
    
    $get_url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";
    $return = get_html($get_url);
    if(!empty($return)){
        $content = json_decode($return,true);
        if(is_array($content) && !empty($content) && isset($content['nickname']) && !empty($content['nickname'])){
            $outArr = $content;
        }
    }
    return $outArr;
}