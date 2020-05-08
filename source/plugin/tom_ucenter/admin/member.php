<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：大叔来 www.dasuhlai.com
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$modBaseUrl = $adminBaseUrl.'&tmod=member';
$modListUrl = $adminListUrl.'&tmod=member';
$modFromUrl = $adminFromUrl.'&tmod=member';

$act = $_GET['act'];
$formhash =  $_GET['formhash']? $_GET['formhash']:'';

$get_list_url_value = get_list_url("tom_ucenter_admin_member_list");
if($get_list_url_value){
    $modListUrl = $get_list_url_value;
}

if($formhash == FORMHASH && $act == 'address'){
    $uid = isset($_GET['uid'])? intval($_GET['uid']):0;
    $addressList = C::t('#tom_ucenter#tom_ucenter_address')->fetch_all_list(" AND uid={$uid} ","ORDER BY id DESC",0,100);
    
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $Lang['address_title'] . '</th></tr>';
    echo '<tr class="header">';
    echo '<th>' . $Lang['address_xm'] . '</th>';
    echo '<th>' . $Lang['address_tel'] . '</th>';
    echo '<th>' . $Lang['address_str'] . '</th>';
    echo '</tr>';
    foreach ($addressList as $key => $value){
        
        echo '<tr>';
        echo '<td>'.$value['xm'].'</td>';
        echo '<td>'.$value['tel'].'</td>';
        echo '<td>'.$value['area_str'].' '.$value['info'].'</td>';
        echo '</tr>';
    }
    showtablefooter();
     
}else if($formhash == FORMHASH && $act == 'scorelog'){
    
    $uid = isset($_GET['uid'])? intval($_GET['uid']):0;
    
    $pagesize = 100;
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    $start = ($page-1)*$pagesize;	
    $count = C::t('#tom_ucenter#tom_ucenter_scorelog')->fetch_all_count(" AND uid={$uid} ");
    $scorelogList = C::t('#tom_ucenter#tom_ucenter_scorelog')->fetch_all_list(" AND uid={$uid} ","ORDER BY id DESC",$start,$count);
    
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $Lang['scorelog_title'] . '</th></tr>';
    echo '<tr class="header">';
    echo '<th>' . $Lang['scorelog_add_score'] . '</th>';
    echo '<th>' . $Lang['scorelog_reduce_score'] . '</th>';
    echo '<th>' . $Lang['scorelog_old_score'] . '</th>';
    echo '<th>' . $Lang['scorelog_message'] . '</th>';
    echo '<th>' . $Lang['scorelog_log_time'] . '</th>';
    echo '</tr>';
    foreach ($scorelogList as $key => $value){
        echo '<tr>';
        echo '<td>'.$value['add_score'].'</td>';
        echo '<td>'.$value['reduce_score'].'</td>';
        echo '<td>'.$value['old_score'].'</td>';
        echo '<td>'.$value['message'].'</td>';
        echo '<td>' . dgmdate($value['log_time'],"Y-m-d H:i",$tomSysOffset) . '</td>';
        echo '</tr>';
    }
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBaseUrl."&act=scorelog");	
    showsubmit('', '', '', '', $multi, false);
    
}else{
    
    set_list_url("tom_ucenter_admin_member_list");
    
    $nickname = !empty($_GET['nickname'])? addslashes($_GET['nickname']):'';
    
    $where = "";
    
    $pagesize = 10;
    if(!empty($nickname)){
		$pagesize = 100;
	}
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    $start = ($page-1)*$pagesize;	
    $count = C::t('#tom_ucenter#tom_ucenter_member')->fetch_all_like_count($where,$nickname);
    $memberList = C::t('#tom_ucenter#tom_ucenter_member')->fetch_all_like_list($where,"ORDER BY add_time DESC",$start,$pagesize,$nickname);
    
    showtableheader();
    $Lang['ucenter_help_3']  = str_replace("{SITEURL}", $_G['siteurl'], $Lang['ucenter_help_3']);
    echo '<tr><th colspan="15" class="partition">' . $Lang['ucenter_help_title'] . '</th></tr>';
    echo '<tr><td  class="tipsblock" s="1"><ul id="tipslis">';
    echo '<li>' . $Lang['ucenter_help_3'] . '</li>';
    echo '</ul></td></tr>';
    showtablefooter();
    
    showformheader($modFromUrl.'&formhash='.FORMHASH);
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $Lang['member_search_list'] . '</th></tr>';
    echo '<tr><td width="100" align="right"><b>' . $Lang['member_nickname'] . '</b></td><td><input name="nickname" type="text" value="'.$nickname.'" size="40" /></td></tr>';
    showsubmit('submit', 'submit');
    showtablefooter();
    showformfooter();
    
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $Lang['member_list_title'] . '</th></tr>';
    echo '<tr class="header">';
    echo '<th>' . $Lang['uid'] . '</th>';
    echo '<th>' . $Lang['member_picurl'] . '</th>';
    echo '<th>' . $Lang['member_nickname'] . '</th>';
    echo '<th>' . $Lang['member_openid'] . '</th>';
    echo '<th>unionid</th>';
    //echo '<th>' . $Lang['member_xm'] . '</th>';
    //echo '<th>' . $Lang['member_tel'] . '</th>';
    //echo '<th>' . $Lang['member_score'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    foreach ($memberList as $key => $value){
        
        echo '<tr>';
        echo '<td>'.$value['id'].'</td>';
        echo '<td><img src="'.$value['picurl'].'" width="40" /></td>';
        echo '<td>'.$value['nickname'].'</td>';
        echo '<td>'.$value['openid'].'</td>';
        echo '<td>'.$value['unionid'].'</td>';
        //echo '<td>'.$value['xm'].'</td>';
        //echo '<td>'.$value['tel'].'</td>';
        //echo '<td>'.$value['score'].'</td>';
        echo '<td>';
        //echo '<a href="'.$modBaseUrl.'&act=scorelog&uid='.$value['uid'].'&formhash='.FORMHASH.'">' . $Lang['scorelog_title'] . '</a>&nbsp;|&nbsp;';
        echo '<a href="'.$modBaseUrl.'&act=address&uid='.$value['uid'].'&formhash='.FORMHASH.'">' . $Lang['member_address'] . '</a>';
        echo '</td>';
        echo '</tr>';
    }
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBaseUrl);	
    showsubmit('', '', '', '', $multi, false);
}
