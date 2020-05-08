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

$__UserInfo = array();
$userStatus = false;

$ucenterfilenameExists = false;
$ucenterfilename = DISCUZ_ROOT.'./source/plugin/tom_ucenter/tom_ucenter.inc.php';
if(file_exists($ucenterfilename)){
    $ucenterfilenameExists = true;
}
if($jyConfig['open_ucenter'] == 1 && $ucenterfilenameExists){
    
    $__MemberInfo = array();
    $cookieUid = getcookie('tom_ucenter_member_uid');
    $cookieKey = getcookie('tom_ucenter_member_key');
    
    if(!empty($cookieUid) && !empty($cookieKey)){
        $__MemberInfoTmp = C::t('#tom_ucenter#tom_ucenter_member')->fetch_by_uid($cookieUid);
        if($__MemberInfoTmp && !empty($__MemberInfoTmp['mykey'])){
            if(md5($__MemberInfoTmp['uid'].'|||'.$__MemberInfoTmp['mykey']) == $cookieKey){
                $__MemberInfo = $__MemberInfoTmp;
                $userInfoTmp = C::t('#tom_love#tom_love')->fetch_by_member_id($__MemberInfo['uid']);
                if($userInfoTmp){
                    $__UserInfo = $userInfoTmp;
                    $userStatus = true;
                }
            }
        }
    }
    
}else{
    $cookieUserid = getcookie('tom_love_uid');
    if(!empty($cookieUserid)){
        $__UserInfo = C::t('#tom_love#tom_love')->fetch_by_id($cookieUserid);
        if($__UserInfo){
            $userStatus = true;
        }
    }   
}