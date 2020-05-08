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

if($_GET['f'] == 'miniprogram'){
    $lifeTime = 120;
    dsetcookie('tom_miniprogram', 1, $lifeTime);
}

$__IsWeixin = $__IsQianfan = $__IsXiaoyun = $__IsMagapp = $__IsMocuzapp = $__IsMiniprogram = $__Ios = $__Android = 0;
$__HideHeader = $__HideFooter = 0;
if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false){ $__IsWeixin = 1;}
if(strpos($_SERVER['HTTP_USER_AGENT'], 'QianFan') !== false){ $__IsQianfan = 1;$__HideHeader = 1;}
if(strpos($_SERVER['HTTP_USER_AGENT'], 'Appbyme') !== false){ $__IsXiaoyun = 1;$__HideHeader = 1;}
if(strpos($_SERVER['HTTP_USER_AGENT'], 'MAGAPP') !== false){ $__IsMagapp = 1;$__HideHeader = 1;}
if(strpos($_SERVER['HTTP_USER_AGENT'], 'MocuzApp') !== false){ $__IsMocuzapp = 1;$__HideHeader = 1;}
if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== false){$__Ios = 1;}
if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false){$__Android = 1;}
$cookie_tom_miniprogram = getcookie('tom_miniprogram');
if($cookie_tom_miniprogram == 1 || $_GET['f'] == 'miniprogram'){ $__IsMiniprogram = 1;$__HideHeader = 1;}

if($__IsMiniprogram == 1 && $jyConfig['closed_xiao'] == 1 && $_GET['mod'] != 'noxiao'){
    dheader('location:'.$_G['siteurl']."plugin.php?id=tom_love&mod=noxiao");exit;
}

$__UserInfo         = array();
$__MemberInfo       = array();
$userStatus         = false;
$firstLoginStatus   = false;
$loginStatus        = 0;
$noReadSmsNum = $noReadTzNum = 0;
$footerNavSmsClass = "footer_nav_sms1";
$footerNavMyClass = "footer_nav_my1";

$mustLogin = true;
if($_GET['id'] == 'tom_love' && ($_GET['mod'] == 'index' || $_GET['mod'] == 'list' || $_GET['mod'] == 'phb' || $_GET['mod'] == 'noxiao' || $_GET['mod'] == 'article' || ($_GET['mod'] == 'info' && $_GET['miniprogram_get_title'] == 1))){
    $mustLogin = false;
}
if($_GET['miniprogram_get_title'] == 1){
    if($_GET['id'] == 'tom_xiangqin' && ( $_GET['mod'] == 'index' || $_GET['mod'] == 'list'  || $_GET['mod'] == 'info')){
        $mustLogin = false;
    }
}
if($__IsWeixin == 0){
    if($_GET['id'] == 'tom_xiangqin' && ( $_GET['mod'] == 'index' || $_GET['mod'] == 'list')){
        $mustLogin = false;
    }
}

#### login

$ucenterfilenameExists = false;
$ucenterfilename = DISCUZ_ROOT.'./source/plugin/tom_ucenter/tom_ucenter.inc.php';
if(file_exists($ucenterfilename)){
    $ucenterfilenameExists = true;
}
if($jyConfig['open_ucenter'] == 1 && $ucenterfilenameExists){
    
    $ucenterConfig = $_G['cache']['plugin']['tom_ucenter'];
    
    # new login start
    $cookieUid = getcookie('tom_ucenter_member_uid');
    $cookieKey = getcookie('tom_ucenter_member_key');
    if(!empty($cookieUid) && !empty($cookieKey)){
        $__MemberInfoTmp = C::t('#tom_ucenter#tom_ucenter_member')->fetch_by_uid($cookieUid);
        if($__MemberInfoTmp && !empty($__MemberInfoTmp['mykey'])){
            if(md5($__MemberInfoTmp['uid'].'|||'.$__MemberInfoTmp['mykey']) == $cookieKey){
                $__MemberInfo = $__MemberInfoTmp;
                $userStatus = true;
                $mustLogin = true;
            }
        }
    }

    if($userStatus){
        $loginStatus = 1;
        
        $userInfoTmp = C::t('#tom_love#tom_love')->fetch_by_member_id($__MemberInfo['uid']);
        if($userInfoTmp){
            $__UserInfo = $userInfoTmp;
            if(!empty($__MemberInfo['unionid']) && $__UserInfo['unionid'] != $__MemberInfo['unionid'] && $__UserInfo['openid'] == $__MemberInfo['openid']){
                $updateData             = array();
                $updateData['unionid']  = $__MemberInfo['unionid'];
                C::t('#tom_love#tom_love')->update($__UserInfo['id'],$updateData);
            }
            if(!empty($__MemberInfo['tel']) && $__UserInfo['tel'] != $__MemberInfo['tel']){
                $updateData             = array();
                $updateData['tel']      = $__MemberInfo['tel'];
                C::t('#tom_love#tom_love')->update($__UserInfo['id'],$updateData);
            }
            if(!empty($__MemberInfo['openid']) && $__MemberInfo['openid'] != $__UserInfo['openid']){
                $userInfoTmpOpenid = C::t('#tom_love#tom_love')->fetch_by_openid($__MemberInfo['openid']);
                if($userInfoTmpOpenid){
                }else{
                    $updateData             = array();
                    $updateData['openid']   = $__MemberInfo['openid'];
                    C::t('#tom_love#tom_love')->update($__UserInfo['id'],$updateData);
                }
            }
        }else{
            $createNewUser = false;
            if($__MemberInfo['last_login_type'] == 'weixin'){

                $userInfoTmpOpenid = C::t('#tom_love#tom_love')->fetch_by_openid($__MemberInfo['openid']);
                $userInfoTmpUnionid = C::t('#tom_love#tom_love')->fetch_by_unionid($__MemberInfo['unionid']);
                if(!empty($__MemberInfo['openid']) && $userInfoTmpOpenid){
                    $__UserInfo = $userInfoTmpOpenid;

                    $updateData                 = array();
                    $updateData['member_id']    = $__MemberInfo['uid'];
                    C::t('#tom_love#tom_love')->update($userInfoTmpOpenid['id'],$updateData);

                    if(empty($__MemberInfo['tel']) && !empty($userInfoTmpOpenid['tel']) && $userInfoTmpOpenid['phone_renzheng'] == 1){
                        $memberInfoTmpTel = C::t('#tom_ucenter#tom_ucenter_member')->fetch_by_tel($userInfoTmpOpenid['tel']);
                        if(!$memberInfoTmpTel){
                            $updateData = array();
                            $updateData['tel']     = $userInfoTmpOpenid['tel'];
                            C::t('#tom_ucenter#tom_ucenter_member')->update($__MemberInfo['uid'],$updateData);
                        }
                    }
                }else if(!empty($__MemberInfo['unionid']) && $userInfoTmpUnionid){
                    $__UserInfo = $userInfoTmpUnionid;
                    $updateData                 = array();
                    $updateData['openid']       = $__MemberInfo['openid'];
                    $updateData['member_id']    = $__MemberInfo['uid'];
                    C::t('#tom_love#tom_love')->update($userInfoTmpUnionid['id'],$updateData);
                }else{
                    $createNewUser = true;
                }
            }else if($__MemberInfo['last_login_type'] == 'tel'){
                $userInfoTmpTel = C::t('#tom_love#tom_love')->fetch_by_tel($__MemberInfo['tel']);
                if(!empty($__MemberInfo['tel']) && $userInfoTmpTel){
                    $__UserInfo = $userInfoTmpTel;

                    $updateData                 = array();
                    $updateData['member_id']    = $__MemberInfo['uid'];
                    C::t('#tom_love#tom_love')->update($userInfoTmpTel['id'],$updateData);

                    if(empty($__MemberInfo['openid']) && !empty($userInfoTmpTel['openid'])){
                        $memberInfoTmpOpenid = C::t('#tom_ucenter#tom_ucenter_member')->fetch_by_openid($userInfoTmpTel['openid']);
                        if(!$memberInfoTmpOpenid){
                            $updateData = array();
                            $updateData['openid']     = $userInfoTmpTel['openid'];
                            C::t('#tom_ucenter#tom_ucenter_member')->update($__MemberInfo['uid'],$updateData);
                        }
                    }

                }else{
                    $createNewUser = true;
                }

            }else if($__MemberInfo['last_login_type'] == 'app'){
                $userInfoTmpUnionid = C::t('#tom_love#tom_love')->fetch_by_unionid($__MemberInfo['unionid']);
                if(!empty($__MemberInfo['unionid']) && $userInfoTmpUnionid){
                    $__UserInfo = $userInfoTmpUnionid;
                    $updateData                 = array();
                    $updateData['member_id']    = $__MemberInfo['uid'];
                    C::t('#tom_love#tom_love')->update($userInfoTmpUnionid['id'],$updateData);
                }else{
                    $createNewUser = true;
                }
            }else if($__MemberInfo['last_login_type'] == 'bbs'){
                $createNewUser = true;
            }else if($__MemberInfo['last_login_type'] == 'majia'){
                $createNewUser = true;
            }

            if($createNewUser){
                
                if(function_exists('curl_init') && strpos($__MemberInfo['picurl'],'qlogo.cn') !== false){
                    $__MemberInfo['picurl'] = str_replace("/132","/0",$__MemberInfo['picurl']);
                    $imageData = get_html($__MemberInfo['picurl']);
                    $imageDir = "/source/plugin/tom_love/data/avatar/".date("Ym")."/";
                    $imageName = "source/plugin/tom_love/data/avatar/".date("Ym")."/".md5($__MemberInfo['picurl']).".jpg";

                    $tomDir = DISCUZ_ROOT.'.'.$imageDir;
                    if(!is_dir($tomDir)){
                        mkdir($tomDir, 0777,true);
                    }else{
                        chmod($tomDir, 0777); 
                    }
                    $upload =  file_put_contents(DISCUZ_ROOT.'./'.$imageName, $imageData);
                    if($upload){
                        $__MemberInfo['picurl'] = $imageName;
                    }
                }
                
                $insertData = array();
                $insertData['member_id']        = $__MemberInfo['uid'];
                $insertData['openid']           = $__MemberInfo['openid'];
                $insertData['unionid']          = $__MemberInfo['unionid'];
                $insertData['nickname']         = $__MemberInfo['nickname'];
                $insertData['avatar']           = $__MemberInfo['picurl'];;
                $insertData['score']            = $jyConfig['score_num'];
                $insertData['sex']              = 0;
                if(!empty($__MemberInfo['tel'])){
                    $insertData['tel']              = $__MemberInfo['tel'];
                    $insertData['phone_renzheng']   = 1;
                }
                if($jyConfig['open_user_shenhe'] == 1){
                    $insertData['shenhe_status'] = 1;
                }else{
                    $insertData['shenhe_status'] = 2;
                }
                $insertData['add_time'] = TIMESTAMP;
                if(C::t('#tom_love#tom_love')->insert($insertData)){
                    $__UserInfo = C::t('#tom_love#tom_love')->fetch_by_member_id($__MemberInfo['uid']);
                    $firstLoginStatus = true;
                }
            }
        }

    }else if($mustLogin){
        $login_back_url = $weixinClass->get_url();
        $login_back_url = urlencode($login_back_url);
        dheader('location:'.$_G['siteurl']."plugin.php?id=tom_ucenter&mod=login&t_from=love&t_back=".$login_back_url);exit;
    }

    # new login end
    
}else{

    # old login start
    $cookieUserid = getcookie('tom_love_uid');
    if(!$cookieUserid && $_SESSION['tom_love_uid']){
        $cookieUserid = $_SESSION['tom_love_uid'];
    }
    $cookieUserInfo = C::t('#tom_love#tom_love')->fetch_by_id($cookieUserid);
    if($cookieUserInfo){
        $userStatus = true;
        $mustLogin = true;
        $__UserInfo = $cookieUserInfo;
    }

    if($mustLogin){
        $loginStatus = 1;
        if(!$userStatus){
            dheader('location:'.$_G['siteurl']."plugin.php?id=tom_love:register");exit;
        }

    }

    # old login end
}

if($mustLogin){
    
    if(!empty($__UserInfo['avatar'])){
        $__UserInfo['avatar'] = tom_avatar($__UserInfo['avatar']);
    }
    
    if($_GET['id'] == 'tom_love'){
        if($_GET['mod'] != 'index' && $_GET['mod'] != 'list' && $_GET['mod'] != 'article' && $_GET['mod'] != 'phb' && $_GET['mod'] != 'my' && $_GET['mod'] != 'avatar' && $_GET['mod'] != 'renzheng' && $_GET['mod'] != 'phone' && $_GET['mod'] != 'upload' && $_GET['mod'] != 'report'){
            if(empty($__UserInfo['nickname'])){
                dheader('location:'.$_G['siteurl']."plugin.php?id=tom_love&mod=my&act=info");exit;
            }
            if(empty($__UserInfo['avatar']) || $__UserInfo['avatar'] == "source/plugin/tom_love/images/avatar_default.jpg"){
                dheader('location:'.$_G['siteurl']."plugin.php?id=tom_love&mod=avatar");exit;
            }
            if($__UserInfo['phone_renzheng'] == 0 && $jyConfig['open_must_tel_renzheng'] == 1){
                dheader('location:'.$_G['siteurl'].$phoneUrl);exit;
            }
            if($jyConfig['must_info'] == 1 && $__UserInfo['year'] == 0){
                dheader('location:'.$_G['siteurl']."plugin.php?id=tom_love&mod=my&act=info&mustinfo=1");exit;
            }
            if($jyConfig['must_renzheng'] == 1){
                if($_GET['mod'] == 'sms'){
                    if(isset($_GET['act']) && $_GET['act'] == 'view'){
                        if(empty($__UserInfo['renzheng'])){
                            dheader('location:'.$_G['siteurl']."plugin.php?id=tom_love&mod=renzheng");exit;
                        }
                    }
                }else{
                   if(empty($__UserInfo['renzheng'])){
                        dheader('location:'.$_G['siteurl']."plugin.php?id=tom_love&mod=renzheng");exit;
                    } 
                }
            }
            if($jyConfig['open_user_shenhe'] == 1 && $__UserInfo['shenhe_status'] != 2){
                dheader('location:'.$_G['siteurl']."plugin.php?id=tom_love&mod=my");exit;
            }
        }
        
    }
    
    $pmNewNum       = C::t('#tom_love#tom_love_pm')->fetch_all_newnum(" AND user_id={$__UserInfo['id']} ");
    $noReadTzNum    = C::t('#tom_love#tom_love_tz')->fetch_all_count(" AND user_id={$__UserInfo['id']} AND type=1 AND is_read=0 ");
    $noReadNum      = $pmNewNum + $noReadTzNum;
    if($noReadNum > 0){
        $footerNavSmsClass = "footer_nav_sms3";
        $footerNavMyClass = "footer_nav_my3";
    }
    
    if($__UserInfo['status'] == 2 && $_GET['mod'] != 'my' && $_GET['mod'] != 'article'){
        dheader('location:'.$_G['siteurl']."plugin.php?id=tom_love&mod=my");exit;
    }
    
    if(!empty($__UserInfo['openid'])){
        if(isset($_SESSION['tom_love_subscribe']) && $_SESSION['tom_love_subscribe'] == 1){
        }else{
            $common_access_token = $weixinClass->get_access_token();
            if(!empty($common_access_token)){
                $check_return = check_subscribe($common_access_token, $__UserInfo['openid']);
                if($check_return == 1){
                    $_SESSION['tom_love_subscribe'] = 1;
                    $updateData = array();
                    $updateData['subscribe'] = 1;
                    C::t('#tom_love_#tom_love')->update($__UserInfo['id'], $updateData);
                }else if($check_return == 2){
                    $_SESSION['tom_love_subscribe'] = 1;
                    $updateData = array();
                    $updateData['subscribe'] = 0;
                    C::t('#tom_love_#tom_love')->update($__UserInfo['id'], $updateData);
                }
            }
        }
    }
    
}