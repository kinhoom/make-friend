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

$modBaseUrl = $adminBaseUrl.'&tmod=report';
$modListUrl = $adminListUrl.'&tmod=report';
$modFromUrl = $adminFromUrl.'&tmod=report';

$act = $_GET['act'];
$formhash =  $_GET['formhash']? $_GET['formhash']:'';
if($formhash == FORMHASH && $act == 'del'){
    C::t('#tom_love#tom_love_report')->delete($_GET['id']);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    
}else if($formhash == FORMHASH && $act == 'fenghao'){
    $updateData = array();
    $updateData['status'] = 1;
    C::t('#tom_love#tom_love_report')->update($_GET['id'],$updateData);
    $updateData = array();
    $updateData['status'] = 2;
    C::t('#tom_love#tom_love')->update($_GET['report_user_id'],$updateData);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    
}else{
    $pagesize = 10;
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    $start = ($page-1)*$pagesize;	
    $count = C::t('#tom_love#tom_love_report')->fetch_all_count("");
    $reportList = C::t('#tom_love#tom_love_report')->fetch_all_list("","ORDER BY report_time DESC",$start,$pagesize);
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $Lang['report_list'] . '</th></tr>';
    echo '<tr class="header">';
    echo '<th>ID</th>';
    echo '<th>' . $Lang['re_user_id'] . '</th>';
    echo '<th>' . $Lang['report_user_id'] . '</th>';
    echo '<th>' . $Lang['report_content'] . '</th>';
    echo '<th>' . $Lang['report_pic'] . '</th>';
    echo '<th>' . $Lang['report_status'] . '</th>';
    echo '<th>' . $Lang['report_time'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    foreach ($reportList as $key => $value){
        $reportTime = dgmdate($value['report_time'], 'Y-m-d H:i:s',$tomSysOffset);
        $__UserInfo = C::t('#tom_love#tom_love')->fetch_by_id($value['user_id']);
        $reportUserInfo = C::t('#tom_love#tom_love')->fetch_by_id($value['report_user_id']);
        if($value['status'] == 1){
            $value['status'] =  $Lang['report_status_1'];
        }else{
            $value['status'] =  $Lang['report_status_0'];
        }
        
        if(!empty($value['report_pic_1'])){
            if(!preg_match('/^http/', $value['report_pic_1'])){
                if(strpos($value['report_pic_1'], 'source/plugin/tom_love') === false){
                    $report_pic_1 = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$value['report_pic_1'];
                }else{
                    $report_pic_1 = $value['report_pic_1'];
                }
            }else{
                $report_pic_1 = $value['report_pic_1'];
            }
            $report_pic_1 = '<a target="_blank" href="'.$report_pic_1.'"><img src="'.$report_pic_1.'" width="40" height="40"></a>';
        }else{
            $report_pic_1 = '';
        }
            
        if(!empty($value['report_pic_2'])){
            if(!preg_match('/^http/', $value['report_pic_2'])){
                if(strpos($value['report_pic_2'], 'source/plugin/tom_love') === false){
                    $report_pic_2 = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$value['report_pic_2'];
                }else{
                    $report_pic_2 = $value['report_pic_2'];
                }
            }else{
                $report_pic_2 = $value['report_pic_2'];
            }
            $report_pic_2 = '<a target="_blank" href="'.$report_pic_2.'"><img src="'.$report_pic_2.'" width="40" height="40"></a>';
        }else{
            $report_pic_2 = '';
        }
        
        echo '<tr>';
        echo '<td>' . $value['id'] . '</td>';
        echo '<td><a target="_blank" href="'.$adminBaseUrl.'&tmod=user&act=show&id='.$value['user_id'].'&formhash='.FORMHASH.'">' . $__UserInfo['nickname'] . '</a></td>';
        echo '<td><a target="_blank" href="'.$adminBaseUrl.'&tmod=user&act=show&id='.$value['report_user_id'].'&formhash='.FORMHASH.'">' . $reportUserInfo['nickname'] . '</a></td>';
        echo '<td>' . $value['report_content'] . '</td>';
        echo '<td>' . $report_pic_1 .'-'. $report_pic_2 . '</td>';
        echo '<td>' . $value['status'] . '</td>';
        echo '<td>' . $reportTime . '</td>';
        echo '<td>';
        echo '<a href="'.$modBaseUrl.'&act=del&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['delete'] . '</a>&nbsp;|&nbsp;';
        echo '<a href="'.$modBaseUrl.'&act=fenghao&id='.$value['id'].'&report_user_id='.$value['report_user_id'].'&formhash='.FORMHASH.'">' . $Lang['envelope'] . '</a>';
        echo '</td>';
        echo '</tr>';
    }
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBaseUrl);	
    showsubmit('', '', '', '', $multi, false);
}