<?php

/*
   [Dashulai!] (C)2009-2019 WWW.DASHULAI.COM.
   技术支持/更新维护：官网 https://www.dashulai.com
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$modBaseUrl = $adminBaseUrl.'&tmod=allqianxian';
$modListUrl = $adminListUrl.'&tmod=allqianxian';
$modFromUrl = $adminFromUrl.'&tmod=allqianxian';

if($_GET['act'] == 'save' && $_GET['formhash'] == FORMHASH){
    
}else{
    
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    $pagesize = 100;
    $start = ($page-1)*$pagesize;	
    $count = C::t('#tom_xiangqin#tom_xiangqin_qianxian')->fetch_all_count(" ");
    $qianxianList = C::t('#tom_xiangqin#tom_xiangqin_qianxian')->fetch_all_list(" "," ORDER BY id DESC ",$start,$pagesize);
    
    tomshownavheader();
    tomshownavli($Lang['allqianxian_title'],"",true);
    tomshownavfooter();
    showtableheader();
    echo '<tr class="header">';
    echo '<th>' . $Lang['user_no'] . '</th>';
    echo '<th>' . $Lang['xm'] . '</th>';
    echo '<th>' . $Lang['qianxian_user_no'] . '</th>';
    echo '<th>' . $Lang['qianxian_xiangqin_id'] . '</th>';
    echo '<th>' . $Lang['qianxian_beizu'] . '</th>';
    echo '<th>' . $Lang['qianxian_time'] . '</th>';
    echo '</tr>';
    
    foreach ($qianxianList as $key => $value) {
        
        $xiangqinInfoTmp = C::t('#tom_xiangqin#tom_xiangqin')->fetch_by_id($value['xiangqin_id']);
        $qxXiangqinInfoTmp = C::t('#tom_xiangqin#tom_xiangqin')->fetch_by_id($value['qianxian_xiangqin_id']);
        
        echo '<tr>';
        echo '<td>' . $xiangqinInfoTmp['user_no'] . '</td>';
        echo '<td><a target="_blank" href="'.$adminBaseUrl.'&tmod=user&user_no='.$xiangqinInfoTmp['user_no'].'&formhash='.FORMHASH.'">' . $xiangqinInfoTmp['xm'] . '</a></td>';
        echo '<td>' . $qxXiangqinInfoTmp['user_no'] . '</td>';
        echo '<td><a target="_blank" href="'.$adminBaseUrl.'&tmod=user&user_no='.$qxXiangqinInfoTmp['user_no'].'&formhash='.FORMHASH.'">' . $qxXiangqinInfoTmp['xm'] . '</a></td>';
        echo '<td>' . $value['qianxian_beizu'] . '&nbsp;</td>';
        echo '<td>' . dgmdate($value['qianxian_time'],"Y-m-d H:i",$tomSysOffset) . '</td>';
        
    }
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBaseUrl);	
    showsubmit('', '', '', '', $multi, false);
     
}