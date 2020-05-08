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

function check_subscribe($access_token,$openid){
    $subscribeFlag = 0;
    $get_user_info_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$openid}&lang=zh_CN";
    $return = get_html($get_user_info_url);
    if(!empty($return)){
        $content = json_decode($return,true);
        if(is_array($content) && !empty($content) && isset($content['subscribe'])){
            if($content['subscribe'] == 1){
                $subscribeFlag = 1;
            }else if($content['subscribe'] == 0){
                $subscribeFlag = 2;
            }
        }
    }
    return $subscribeFlag;
}

function tom_num_replace($string){
    $match = "/\d{5}/";
	if(!empty($string)){
		$string = preg_replace($match, '*****', $string);
	}
    return $string;
}


function tom_avatar($picurl = ''){
    global $_G;
    
    if(!preg_match('/^http/', $picurl)){
        if(strpos($picurl, 'data/attachment/tomwx') !== false){
            $picurl  = $_G['siteurl'].$picurl;
        }else if(strpos($picurl, 'uc_server/') !== false){
            $picurl  = $_G['siteurl'].$picurl;
        }else if(strpos($picurl, 'source/plugin') !== false){
            $picurl  = $_G['siteurl'].$picurl;
        }else{
            $picurl = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$picurl;
        }
    }
    return $picurl;
}

function wx_iconv_recurrence($value) {
	if(is_array($value)) {
		foreach($value AS $key => $val) {
			$value[$key] = wx_iconv_recurrence($val);
		}
	} else {
		$value = diconv($value, 'utf-8', CHARSET);
	}
	return $value;
}