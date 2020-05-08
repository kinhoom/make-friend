<?php
/*
 * CopyRight  : [Dashulai!] (C)2009-2019
 * Document   : 大叔来：www.dashulai.com
 * Created on : 2019-01-02,10:23:46
 * Author     : 大叔来(旺旺：https://dwz.cn/bEeiwujz) www.dashulai.com $
 * Description: [Dashulai!] (C)2009-2019 WWW.DASHULAI.COM..
 *              本资源来源于网络收集,仅供个人学习研究欣赏，请勿用于商业用途，并于下载24小时后删除!
 *              大叔来社区 全网首发 https://www.dashulai.com；
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$modBaseUrl = $adminBaseUrl.'&tmod=usershenhe';
$modListUrl = $adminListUrl.'&tmod=usershenhe';
$modFromUrl = $adminFromUrl.'&tmod=usershenhe';

$act = $_GET['act'];
$formhash =  $_GET['formhash']? $_GET['formhash']:'';

$get_list_url_value = get_list_url("tom_love_admin_usershenhe_list");
if($get_list_url_value){
    $modListUrl = $get_list_url_value;
}

if($formhash == FORMHASH && $act == 'ok'){
    
    $updateData = array();
    $updateData['shenhe_status'] = 2;
    C::t('#tom_love#tom_love')->update($_GET['id'],$updateData);
    
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
}else if($formhash == FORMHASH && $act == 'no'){
    
    $updateData = array();
    $updateData['shenhe_status'] = 3;
    C::t('#tom_love#tom_love')->update($_GET['id'],$updateData);
    
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
}else{
    
    set_list_url("tom_love_admin_usershenhe_list");
    $pagesize = 30;
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    $start = ($page-1)*$pagesize;	
    $count = C::t('#tom_love#tom_love')->fetch_all_count(" AND shenhe_status IN(1,3) ");
    $shenheList = C::t('#tom_love#tom_love')->fetch_all_list(" AND shenhe_status IN(1,3) ","ORDER BY add_time DESC,id DESC",$start,$pagesize);
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $Lang['usershenhe_list'] . '</th></tr>';
    echo '<tr class="header">';
    echo '<th> ID </th>';
    echo '<th>' . $Lang['nickname'] . '</th>';
    echo '<th>' . $Lang['usershenhe_status'] . '</th>';
    echo '<th>' . $Lang['add_time'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    foreach ($shenheList as $key => $value){
        $shenhe_status = '--';
        if($value['shenhe_status'] == 1){
            $shenhe_status = $Lang['usershenhe_status_1'];
        }else if($value['shenhe_status'] == 3){
            $shenhe_status = $Lang['usershenhe_status_3'];
        }
        
        echo '<tr>';
        echo '<td>'.$value['id'].'</td>';
        echo '<td><a target="_blank" href="'.$adminBaseUrl.'&tmod=user&act=show&id='.$value['id'].'&formhash='.FORMHASH.'">' . $value['nickname'] . '</a></td>';
        echo '<td>' . $shenhe_status . '</td>';
        echo '<td>' . dgmdate($value['add_time'], 'Y-m-d H:i:s',$tomSysOffset) . '</td>';
        echo '<td>';
        echo '<a href="'.$modBaseUrl.'&act=ok&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['usershenhe_ok'] . '</a>&nbsp;|&nbsp;';
        echo '<a href="'.$modBaseUrl.'&act=no&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['usershenhe_no'] . '</a>';
        echo '</td>';
        echo '</tr>';
    }
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBaseUrl);	
    showsubmit('', '', '', '', $multi, false);
}