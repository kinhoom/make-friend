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

$act        = isset($_GET['act'])? trim($_GET['act']):'';
$do_from    = isset($_GET['do_from'])? daddslashes($_GET['do_from']):'';

$girlTequan = 0;
if($__UserInfo['sex'] == 2 && $jyConfig['open_girl_tequan'] == 1){
    $girlTequan = 1;
}

if($act == 'create' && $_GET['formhash'] == FORMHASH){
    
    $to_user_id = isset($_GET['to_user_id'])? intval($_GET['to_user_id']):0;
    
    $max_use_id = $min_use_id = 0;
    if($to_user_id == $__UserInfo['id']){
        dheader('location:'.$_G['siteurl']."plugin.php?id=tom_love&mod=sms");exit;
    }else if($to_user_id > $__UserInfo['id']){
        $max_use_id = $to_user_id;
        $min_use_id = $__UserInfo['id'];
    }else if($to_user_id < $__UserInfo['id']){
        $max_use_id = $__UserInfo['id'];
        $min_use_id = $to_user_id;
    }
    $pmListTmp = C::t('#tom_love#tom_love_pm_lists')->fetch_all_list(" AND min_use_id={$min_use_id} AND max_use_id={$max_use_id} "," ORDER BY id DESC ",0,1);
    
    if(is_array($pmListTmp) && !empty($pmListTmp[0]['id']) ){
        $pm_lists_id = $pmListTmp[0]['id'];
    }else{
        $insertData = array();
        $insertData['user_id']      = $__UserInfo['id'];
        $insertData['min_use_id']   = $min_use_id;
        $insertData['max_use_id']   = $max_use_id;
        $insertData['last_content'] = 'NULL-NULL-NULL-NULL-NULL-NULL';
        $insertData['last_time']    = TIMESTAMP;
        C::t('#tom_love#tom_love_pm_lists')->insert($insertData);
        $pm_lists_id = C::t('#tom_love#tom_love_pm_lists')->insert_id();
        
        $insertData = array();
        $insertData['user_id']      = $__UserInfo['id'];
        $insertData['pm_lists_id']  = $pm_lists_id;
        $insertData['new_num']      = 0;
        $insertData['last_time']    = TIMESTAMP;
        C::t('#tom_love#tom_love_pm')->insert($insertData);
        
        $insertData = array();
        $insertData['user_id']      = $to_user_id;
        $insertData['pm_lists_id']  = $pm_lists_id;
        $insertData['new_num']      = 0;
        $insertData['last_time']    = TIMESTAMP;
        C::t('#tom_love#tom_love_pm')->insert($insertData);
        
    }
    
    dheader('location:'.$_G['siteurl']."plugin.php?id=tom_love&mod=sms&act=view&pm_lists_id=".$pm_lists_id);exit;
    
}else if($act == 'send' && $_GET['formhash'] == FORMHASH){
    
    $content = isset($_GET['content'])? daddslashes(diconv(urldecode($_GET['content']),'utf-8')):'';
    $content = strip_tags($content);
    $pm_lists_id = isset($_GET['pm_lists_id'])? intval($_GET['pm_lists_id']):0;
    $to_user_id = isset($_GET['to_user_id'])? intval($_GET['to_user_id']):0;
    
    if($__UserInfo['vip_id'] == 0 && $girlTequan == 0){
        if($__UserInfo['score'] >= $jyConfig['sms_score'] ){
            $updateData = array();
            $updateData['score'] = $__UserInfo['score']-$jyConfig['sms_score'];
            C::t('#tom_love#tom_love')->update($__UserInfo['id'],$updateData);

            $insertData = array();
            $insertData['user_id']      = $__UserInfo['id'];
            $insertData['score_value']  = $jyConfig['sms_score'];
            $insertData['log_type']     = 13;
            $insertData['log_time']     = TIMESTAMP;
            C::t('#tom_love#tom_love_scorelog')->insert($insertData);

        }else{
            echo '101';exit;
        }
    }
    
    $insertData = array();
    $insertData['user_id']      = $__UserInfo['id'];
    $insertData['to_id']      = $to_user_id;
    $insertData['pm_lists_id']  = $pm_lists_id;
    $insertData['content']      = $content;
    $insertData['add_time']     = TIMESTAMP;
    if(C::t('#tom_love#tom_love_pm_message')->insert($insertData)){
        
        $updateData = array();
        $updateData['last_content'] = $content;
        $updateData['last_time'] = TIMESTAMP;
        C::t('#tom_love#tom_love_pm_lists')->update($pm_lists_id,$updateData);
        
        DB::query("UPDATE ".DB::table('tom_love_pm')." SET new_num=new_num+1,last_time='".TIMESTAMP."' WHERE user_id='$to_user_id' AND pm_lists_id='$pm_lists_id' ", 'UNBUFFERED');
        
        include DISCUZ_ROOT.'./source/plugin/tom_love/class/templatesms.class.php';
        $toUserInfo = C::t('#tom_love#tom_love')->fetch_by_id($to_user_id);
        $access_token = $weixinClass->get_access_token();
        $nextSmsTime = $toUserInfo['last_smstp_time'] + 300;
        if($access_token && !empty($toUserInfo['openid']) && $toUserInfo['smstp_open'] == 1 && TIMESTAMP > $nextSmsTime ){
            $templateSmsClass = new templateSms($access_token, $_G['siteurl']."plugin.php?id=tom_love&mod=sms");
            $sms_template_first = str_replace("{NICKNAME}",$__UserInfo['nickname'], lang('plugin/tom_love','sms_template_first'));
            $smsData = array(
                'first'         => $sms_template_first,
                'keyword1'      => '-',
                'keyword2'      => dgmdate(TIMESTAMP,"Y-m-d H:i:s",$tomSysOffset),
                //'remark'        => tom_num_replace($text),
                'remark'        => $text,
            );
            $r = $templateSmsClass->sendSmsTm20702951($toUserInfo['openid'],$jyConfig['template_tm20702951'],$smsData);

            $updateData = array();
            $updateData['last_smstp_time'] = TIMESTAMP;
            C::t('#tom_love#tom_love')->update($toUserInfo['id'],$updateData);

        }
        
        echo '200';exit;
    }
    
    echo '1';exit;
    
}else if($act == 'receive' && $_GET['formhash'] == FORMHASH){
    $content = isset($_GET['content'])? daddslashes(diconv(urldecode($_GET['content']),'utf-8')):'';
    $content = strip_tags($content);
    $self_id = isset($_GET['self_id'])? intval($_GET['self_id']):0;
    
    //$to_user_id = isset($_GET['to_user_id'])? intval($_GET['to_user_id']):0;
   // $pmUserInfo = C::t('#tom_love#tom_love_pm_message')->fetch_all("and to_id =".$self_id." limit 1 desc");
    $lastMessage = DB::fetch_all("select user_id,content,add_time from pre_tom_love_pm_message where to_id={$self_id}  order by add_time desc limit 1;");
   //echo $_GET['ltime'],$lastMessage[0]['add_time'];
    if($_GET['ltime'] == $lastMessage[0]['add_time']) {
	echo 808;exit;
    }
    echo "{'from_id':{$lastMessage[0]['user_id']},'content':'{$lastMessage[0]['content']}','add_time':{$lastMessage[0]['add_time']}}";exit;

}else if($act == 'view'){
    $pageType = 'view';
    
    $pm_lists_id    = intval($_GET['pm_lists_id'])>0? intval($_GET['pm_lists_id']):0;
    $page           = intval($_GET['page'])>0? intval($_GET['page']):1;
    
    $pmListsInfo = C::t('#tom_love#tom_love_pm_lists')->fetch_by_id($pm_lists_id);
    if($pmListsInfo['min_use_id'] == $__UserInfo['id']){
        $toUserInfo = C::t('#tom_love#tom_love')->fetch_by_id($pmListsInfo['max_use_id']);
    }else{
        $toUserInfo = C::t('#tom_love#tom_love')->fetch_by_id($pmListsInfo['min_use_id']);
    }
    
    $pagesize = 10;
    $start = ($page-1)*$pagesize;
    
    $messageListTmp = C::t('#tom_love#tom_love_pm_message')->fetch_all_list(" AND pm_lists_id={$pm_lists_id} "," ORDER BY add_time DESC,id DESC ",$start,$pagesize);
    $count = C::t('#tom_love#tom_love_pm_message')->fetch_all_count(" AND pm_lists_id={$pm_lists_id} ");
    $messageList = array();
    if(is_array($messageListTmp) && !empty($messageListTmp)){
        asort($messageListTmp);
        foreach ($messageListTmp as $key => $value){
            $messageList[$key] = $value;
            //$messageList[$key]['content'] = tom_num_replace(strip_tags($value['content'],'<a><br/>'));
            $messageList[$key]['content'] = strip_tags($value['content'],'<a><br/>');
            $userInfoTmp = C::t('#tom_love#tom_love')->fetch_by_id($value['user_id']);
            $userInfoTmp['avatar'] = tom_avatar($userInfoTmp['avatar']);
            $messageList[$key]['userInfo'] = $userInfoTmp;
        }
    }
    
    DB::query("UPDATE ".DB::table('tom_love_pm')." SET new_num=0 WHERE user_id='{$__UserInfo['id']}' AND pm_lists_id='$pm_lists_id' ", 'UNBUFFERED');
    
    $showNextPage = 1;
    if(($start + $pagesize) >= $count){
        $showNextPage = 0;
    }
    $allPageNum = ceil($count/$pagesize);
    $prePage = $page - 1;
    $nextPage = $page + 1;
    $prePageUrl = "plugin.php?id=tom_love&mod=sms&act=view&pm_lists_id={$pm_lists_id}&page={$prePage}";
    $nextPageUrl = "plugin.php?id=tom_love&mod=sms&act=view&pm_lists_id={$pm_lists_id}&page={$nextPage}";
    
    $smsUrl = "plugin.php?id=tom_love&mod=sms";
    
}else if($act == 'tzlist'){
    $pageType = 'tzlist';
    $page     = isset($_GET['page'])? intval($_GET['page']):1;

    $pagesize = 6;
    $start = ($page-1)*$pagesize;

    $where = " AND user_id={$__UserInfo['id']} AND type=1 ";
    $tzData = C::t('#tom_love#tom_love_tz')->fetch_all_list($where,"ORDER BY tz_time DESC",$start,$pagesize);
    $tzDataCount = C::t('#tom_love#tom_love_tz')->fetch_all_count($where);
    
    $tzList = array();
    if(is_array($tzData) && !empty($tzData)){
        foreach ($tzData as $key => $value){
            $updateData = array();
            $updateData['is_read'] = 1;
            C::t('#tom_love#tom_love_tz')->update($value['id'],$updateData);
            $value['content'] = htmlspecialchars_decode($value['content']);
            $tzList[$key] = $value;
        }
    }
    
    $showNextPage = 1;
    if(($start + $pagesize) >= $tzDataCount){
        $showNextPage = 0;
    }
    $prePage = $page - 1;
    $nextPage = $page + 1;
    $prePageUrl = "plugin.php?id=tom_love&mod=sms&act=tzlist&page={$prePage}";
    $nextPageUrl = "plugin.php?id=tom_love&mod=sms&act=tzlist&page={$nextPage}";
}else{
    $pageType = 'list';
    
    $smsDataCount = C::t('#tom_love#tom_love_pm')->fetch_all_count(" AND user_id={$__UserInfo['id']} ");
    
    $smsOldNum = 0;
    if($__UserInfo['bbs_uid'] > 0){
        $result = uc_pm_list($__UserInfo['bbs_uid'], 1, 10, 'inbox', "privatepm", 100);
        $smsOldNum = $result['count'];
    }
    
    $ajaxLoadPmListUrl = 'plugin.php?id=tom_love:ajax&act=loadPmlist&formhash='.$formhash;
}

$smsUrl = "plugin.php?id=tom_love&mod=sms";

$isgbk = false;
if (CHARSET == 'gbk') $isgbk = true;
include template("tom_love:sms");
