<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：大叔来 www.dasuhlai.com
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$t_from = isset($_GET['t_from'])? daddslashes($_GET['t_from']):'';
$t_back = isset($_GET['t_back'])? daddslashes($_GET['t_back']):'';
$t_back_url = $t_back;
$t_back = urlencode($t_back);

$login_back_plugin = $t_back_url;
if($t_from == 'tongcheng'){
    $site_id = 1;
    preg_match("#site=([0-9]*)#", $t_back_url, $matches);
    if(is_array($matches) && !empty($matches['1'])){
        $site_id = $matches['1'];
        $site_id = intval($site_id);
    }
    $login_back_plugin = "plugin.php?id=tom_tongcheng&site={$site_id}&mod=index";
}

$last_login_type = 'weixin';
if($__IsWeixin == 1){
    if($ucenterConfig['login_type'] == 1){
        $last_login_type = 'weixin';
    }
    if($ucenterConfig['login_type'] == 3){
        $last_login_type = 'bbs';
    }
}else if($__IsQianfan == 1 && $ucenterConfig['open_app_login'] == 1){
    $last_login_type = 'app';
}else if($__IsXiaoyun == 1 && $ucenterConfig['open_app_login'] == 1){
    $last_login_type = 'app';
}else if($__IsMocuzapp == 1 && $ucenterConfig['open_app_login'] == 1){
    $last_login_type = 'app';
}else if($__IsMagapp == 1 && $ucenterConfig['open_app_login'] == 1){
    $last_login_type = 'app';
}else{
    if($ucenterConfig['login_type'] == 2){
        $last_login_type = 'tel';
    }
    if($ucenterConfig['login_type'] == 3){
        $last_login_type = 'bbs';
    }
    if($ucenterConfig['login_type'] == 4){
        $last_login_type = 'bbs';
    }
}


if($last_login_type == 'weixin'){
    
    $openid     = '';
    $unionid    = '';
    $nickname   = '';
    $headimgurl = '';
    
    include DISCUZ_ROOT.'./source/plugin/tom_ucenter/oauth3.php';
    $__MemberInfo = C::t('#tom_ucenter#tom_ucenter_member')->fetch_by_openid($openid);
    if(empty($__MemberInfo) && !empty($unionid)){
        $__MemberInfo = C::t('#tom_ucenter#tom_ucenter_member')->fetch_by_unionid($unionid);
    }
    if($__MemberInfo){
        $mykey = substr(str_shuffle("012345678901234567890123456789"), 0, 6);
        $updateData = array();
        if(empty($__MemberInfo['openid'])){
            $updateData['openid']          = $openid;
        }
        $updateData['unionid']             = $unionid;
        if(empty($__MemberInfo['mykey'])){
            $updateData['mykey']           = $mykey;
        }
        $updateData['picurl']               = $headimgurl;
        $updateData['last_login_type']     = 'weixin';
        $updateData['last_login_time']     = TIMESTAMP;
        C::t('#tom_ucenter#tom_ucenter_member')->update($__MemberInfo['uid'],$updateData);
        
    }else{
        
        //include DISCUZ_ROOT.'./source/plugin/tom_ucenter/oauth3.php';
        $nickname = diconv($nickname,'utf-8');
        
        $mykey = substr(str_shuffle("012345678901234567890123456789"), 0, 6);
        
        $insertData = array();
        $insertData['openid']               = $openid;
        $insertData['unionid']              = $unionid;
        $insertData['nickname']             = $nickname;
        $insertData['picurl']               = $headimgurl;
        $insertData['mykey']                = $mykey;
        $insertData['last_login_type']      = 'weixin';
        $insertData['last_login_time']      = TIMESTAMP;
        $insertData['add_time']             = TIMESTAMP;
        if(C::t('#tom_ucenter#tom_ucenter_member')->insert($insertData)){
            $__MemberInfo = C::t('#tom_ucenter#tom_ucenter_member')->fetch_by_openid($openid);
        }
    }
    
    $lifeTime = 86400;
    dsetcookie('tom_ucenter_member_uid',$__MemberInfo['uid'],$lifeTime);
    dsetcookie('tom_ucenter_member_key',md5($__MemberInfo['uid'].'|||'.$__MemberInfo['mykey']),$lifeTime);

    dheader('location:'.$t_back_url);exit;
    
}else if($last_login_type == 'app'){
    if($__IsMocuzapp == 1){
        if(empty($_G['uid']) && isset($_SERVER['HTTP_MOCUZUID']) && !empty($_SERVER['HTTP_MOCUZUID'])){
            $_G['uid'] = $_SERVER['HTTP_MOCUZUID'];
        }
    }
        
    if(!empty($_G['uid'])){
        $user        = uc_get_user($_G['uid'],1);
        $appUserInfo = array();
        $unionid     = '';
        if($__IsQianfan == 1){
            $appUserInfo = C::t('#tom_ucenter#thirdbind')->fetch_by_uid($_G['uid']);
            if($appUserInfo){
                $unionid     = $appUserInfo['unionid'];
            }
        }else if($__IsXiaoyun == 1){
            $appUserInfo = C::t('#tom_ucenter#appbyme_connection')->fetch_by_uid($_G['uid']);
            if($appUserInfo){
                $unionid     = $appUserInfo['param'];
            }
        }else if($__IsMocuzapp == 1){
            $appUserInfo = C::t('#tom_ucenter#common_member_wechatmp_new')->fetch_by_uid($_G['uid']);
            if($appUserInfo){
                $unionid     = $appUserInfo['unionid'];
            }
        }else if($__IsMagapp == 1){
            $appUserInfo = C::t('#tom_ucenter#user_weixin_relations')->fetch_by_uid($_G['uid']);
            if($appUserInfo){
                $unionid     = $appUserInfo['unionid'];
            }
        }
        
        $__MemberInfo = array();
        if(!empty($unionid)){
            $__MemberInfo = C::t('#tom_ucenter#tom_ucenter_member')->fetch_by_unionid($unionid);
            $memberCount = C::t('#tom_ucenter#tom_ucenter_member')->fetch_all_count(" AND unionid='$unionid' ");
            if($memberCount > 1){
                $memberList = C::t('#tom_ucenter#tom_ucenter_member')->fetch_all_list(" AND unionid='$unionid' ","ORDER BY add_time DESC",0,10);
                foreach ($memberList as $key => $value){
                    if(!empty($value['openid']) && !empty($value['unionid'])){
                        $__MemberInfo = $value;
                        break;
                    }
                }
            }
        }else{
            $__MemberInfo = C::t('#tom_ucenter#tom_ucenter_member')->fetch_by_bbs_uid($user['0']);
        }
        if(!empty($__MemberInfo) && is_array($__MemberInfo)){
            $updateData = array();
            $updateData['last_login_type']     = 'app';
            $updateData['last_login_time']     = TIMESTAMP;
            C::t('#tom_ucenter#tom_ucenter_member')->update($__MemberInfo['uid'],$updateData);
        }else{
            
            $avatarUrl = bbs_avatar($user['0']);

            $mykey = substr(str_shuffle("012345678901234567890123456789"), 0, 6);

            $insertData = array();
            $insertData['bbs_uid']              = $user['0'];
            $insertData['unionid']              = $unionid;
            $insertData['nickname']             = $user['1'];
            $insertData['picurl']               = $avatarUrl;
            $insertData['mykey']                = $mykey;
            $insertData['last_login_type']      = 'app';
            $insertData['last_login_time']      = TIMESTAMP;
            $insertData['add_time']             = TIMESTAMP;
            if(C::t('#tom_ucenter#tom_ucenter_member')->insert($insertData)){
                $__MemberInfo = C::t('#tom_ucenter#tom_ucenter_member')->fetch_by_bbs_uid($user['0']);
            }
        }
        
    }else{
        $isGbk = false;
        if (CHARSET == 'gbk') $isGbk = true;
        if($__IsQianfan == 1){
            include template("tom_ucenter:qianfan");
        }else if($__IsXiaoyun == 1){
            include template("tom_ucenter:xiaoyun");
        }else if($__IsMocuzapp == 1){
            include template("tom_ucenter:mocuzapp");
        }else if($__IsMagapp == 1){
            include template("tom_ucenter:magapp");
        }
        exit;
    }
    
    $lifeTime = 86400;
    dsetcookie('tom_ucenter_member_uid',$__MemberInfo['uid'],$lifeTime);
    dsetcookie('tom_ucenter_member_key',md5($__MemberInfo['uid'].'|||'.$__MemberInfo['mykey']),$lifeTime);
    
    dheader('location:'.$t_back_url);exit;
    
}else if($last_login_type == 'bbs'){
    if (empty($_G['uid'])){
        dheader('location:'.$_G['siteurl']."member.php?mod=logging&action=login");exit;
        //showmessage('', '', array(), array('login' => true));exit;
    }else{
        $user = uc_get_user($_G['uid'],1);
        if($user['0'] > 0){
            $__MemberInfo = C::t('#tom_ucenter#tom_ucenter_member')->fetch_by_bbs_uid($user['0']);
            if($__MemberInfo){

                $updateData = array();
                $updateData['last_login_type']     = 'bbs';
                $updateData['last_login_time']     = TIMESTAMP;
                C::t('#tom_ucenter#tom_ucenter_member')->update($__MemberInfo['uid'],$updateData);

            }else{

                $avatarUrl = bbs_avatar($user['0']);

                $mykey = substr(str_shuffle("012345678901234567890123456789"), 0, 6);

                $insertData = array();
                $insertData['bbs_uid']              = $user['0'];
                $insertData['nickname']             = $user['1'];
                $insertData['picurl']               = $avatarUrl;
                $insertData['mykey']                = $mykey;
                $insertData['last_login_type']      = 'bbs';
                $insertData['last_login_time']      = TIMESTAMP;
                $insertData['add_time']             = TIMESTAMP;
                if(C::t('#tom_ucenter#tom_ucenter_member')->insert($insertData)){
                    $__MemberInfo = C::t('#tom_ucenter#tom_ucenter_member')->fetch_by_bbs_uid($user['0']);
                }
            }
        }else{
            showmessage('', '', array(), array('login' => true));exit;
        }
    }
    
    $lifeTime = 86400;
    dsetcookie('tom_ucenter_member_uid',$__MemberInfo['uid'],$lifeTime);
    dsetcookie('tom_ucenter_member_key',md5($__MemberInfo['uid'].'|||'.$__MemberInfo['mykey']),$lifeTime);
    
    dheader('location:'.$t_back_url);exit;
    
}else{
    
    $loginUrl = "plugin.php?id=tom_ucenter:ajax&act=login&t_from={$t_from}&formhash=".FORMHASH;

    $isGbk = false;
    if (CHARSET == 'gbk') $isGbk = true;
    include template("tom_ucenter:login");
}
