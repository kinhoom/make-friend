<?php
// +----------------------------------------------------------------------
// | Copyright:    (c) 2009-2019 https://www.dashulai.com All rights reserved.
// +----------------------------------------------------------------------
// | Developer:    大叔来 (https://dwz.cn/q4scNR7Q请收藏备用!)
// +----------------------------------------------------------------------
// | Author:       by Dashulai.com. 技术支持/更新维护：官网 https://www.dashulai.com
// +----------------------------------------------------------------------
if(!defined('IN_DISCUZ')){
	exit('Access Denied');
}

$ssid      = isset($_GET['ssid'])? intval($_GET['ssid']):0;

$ssInfo = C::t('#tom_love#tom_love_shuoshuo')->fetch_by_id($ssid);

$user = C::t('#tom_love#tom_love')->fetch_by_id($ssInfo['user_id']);
$userStatus = 1;
if($user['status'] == 2){
    $userStatus = 2;
}
$ssInfo['content']    = tom_num_replace(dhtmlspecialchars($ssInfo['content']));

$user['avatar'] = tom_avatar($user['avatar']);

$ssPhotoData = C::t('#tom_love#tom_love_shuoshuo_photo')->fetch_all_list(" AND ss_id={$ssid} ","ORDER BY id DESC",0,2);
$count = count($ssPhotoData);

$ssPhotoList = array();
if(is_array($ssPhotoData) && !empty($ssPhotoData)){    
    foreach($ssPhotoData as $kp => $vp){
        $ssPhotoList[$kp] = $vp;
        if(!preg_match('/^http/', $vp['picurl'])){
            if(strpos($vp['picurl'], 'source/plugin/tom_love') === false){
                $ssPhotoList[$kp]['picurl'] = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$vp['picurl'];
            }else{
                $ssPhotoList[$kp]['picurl'] = $vp['picurl'];
            }
        }else{
            $ssPhotoList[$kp]['picurl'] = $vp['picurl'];
        }
    }
}

$ssReplyDataTmp = C::t('#tom_love#tom_love_shuoshuo_reply')->fetch_all_list(" AND ss_id={$ssid} ","ORDER BY id DESC",0,100);
$ssReplyData = array();
if(is_array($ssReplyDataTmp) && !empty($ssReplyDataTmp)){
    foreach ($ssReplyDataTmp as $k => $v){
        $ssReplyData[$k] = $v;
        $ssReplyData[$k]['content']             = tom_num_replace(dhtmlspecialchars($v['content']));
        $ssReplyData[$k]['reply_user_avatar']   = tom_avatar($v['reply_user_avatar']);
    }
}

$ssZanData = C::t('#tom_love#tom_love_shuoshuo_zan')->fetch_all_list(" AND ss_id={$ssid} ","ORDER BY id DESC",0,20);
$ssZanList = array();
if(is_array($ssZanData) && !empty($ssZanData)){
    foreach($ssZanData as $k => $v){
        $ssZanList[$k] = $v;
        $ssZanList[$k]['zan_user_avatar']   = tom_avatar($v['zan_user_avatar']);
    }
}

$is_zan_flag = 0;
if(is_array($ssZanData) && !empty($ssZanData)){
    foreach ($ssZanData as $kk => $vv){
        if($vv['zan_user_id'] == $__UserInfo['id']){
            $is_zan_flag = 1;
        }
    }
}

$shuoshuoUrl = "plugin.php?id=tom_love&mod=shuoshuo";

$shareLogo = $user['avatar'];
$shareUrl   = $_G['siteurl']."plugin.php?id=tom_love&mod=shuoshuoinfo&ssid=".$ssid;
$shareDesc = str_replace("\n","",$ssInfo['content']);
$shareDesc = str_replace("\r","",$shareDesc);
$shareDesc = str_replace("\r\n","",$shareDesc);

$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
include template("tom_love:shuoshuoinfo");