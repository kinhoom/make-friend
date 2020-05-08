<?php
/*
 * 源码出处：大-叔-来
 * 官方网址: www.dashulai.com
 * 备用网址: https://dwz.cn/q4scNR7Q(请收藏备用!)
 * 本资源来源于网络收集,仅供个人学习研究欣赏，请勿用于商业用途，并于下载24小时后删除!
 * 技术支持/更新维护：官网 https://www.dashulai.com
 * 
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$_G['setting']['switchwidthauto']=0;
$_G['setting']['allowwidthauto']=1;


$page     = isset($_GET['page'])? intval($_GET['page']):1;
$recid     = isset($_GET['recid'])? intval($_GET['recid']):0;

$pagesize = 15;
$start = ($page-1)*$pagesize;

$where = " AND nickname !='' AND year > 0 AND status = 1 AND shenhe_status = 2 AND avatar != 'source/plugin/tom_love/images/avatar_default.jpg' ";

$nowTime = TIMESTAMP;
if($recid == 1){
    $where.= " AND recommend = 1  AND recommend_time > {$nowTime} AND status = 1 ";
}

if($jyConfig['must_info'] == 1){
    $where.=" AND year>0 ";
}

$userData = C::t('#tom_love#tom_love')->fetch_all_list($where,"ORDER BY add_time DESC",$start,$pagesize);
$userDataCount = C::t('#tom_love#tom_love')->fetch_all_count($where);

$userList = array();
if(is_array($userData) && !empty($userData)){
    foreach ($userData as $key => $value){
        $userList[$key] = $value;
        $userList[$key]['describe'] = dhtmlspecialchars($value['describe']);
        if($value['year']> 0 ){
            if($jyConfig['age_type_id'] == 1){
                $userList[$key]['age'] = $nowYear - $value['year'];
            }else{
                $userList[$key]['age'] = $nowYear - $value['year'] + 1;
            }
        }else{
            $userList[$key]['age'] = '';
        }
        $userList[$key]['time'] = dgmdate($value['add_time'], 'Y-m-d',$tomSysOffset);
        $userList[$key]['first_pic'] = $value['avatar'];
        $userList[$key]['first_pic'] = tom_avatar($value['avatar']);
    }
}

$paging = helper_page :: multi($userDataCount, $pagesize, $page, "plugin.php?id=tom_love:pc&mod=index&recid={$recid}", 0, 11, false, false);

$navtitle = $jyConfig['seo_title'];
$metakeywords =  $jyConfig['seo_keywords'];
$metadescription = $jyConfig['seo_description'];

include template("tom_love:pc/index");