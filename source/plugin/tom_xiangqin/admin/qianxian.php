<?php

/*
   [Dashulai!] (C)2009-2019 WWW.DASHULAI.COM.
   技术支持/更新维护：官网 https://www.dashulai.com
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$modBaseUrl = $adminBaseUrl.'&tmod=qianxian&xiangqin_id='.$_GET['xiangqin_id'];
$modListUrl = $adminListUrl.'&tmod=qianxian&xiangqin_id='.$_GET['xiangqin_id'];
$modFromUrl = $adminFromUrl.'&tmod=qianxian&xiangqin_id='.$_GET['xiangqin_id'];

$xiangqin_id    = isset($_GET['xiangqin_id'])? intval($_GET['xiangqin_id']):0;

$xiangqinInfo = C::t('#tom_xiangqin#tom_xiangqin')->fetch_by_id($xiangqin_id);

if($_GET['act'] == 'save' && $_GET['formhash'] == FORMHASH){
    
    $qianxian_user_no    = isset($_GET['qianxian_user_no'])? intval($_GET['qianxian_user_no']):0;
    $qianxians_type      = isset($_GET['qianxians_type'])? intval($_GET['qianxians_type']):0;
    $qianxian_beizu      = isset($_GET['qianxian_beizu'])? addslashes($_GET['qianxian_beizu']):'';
    
    $qianxianXiangqinInfo = C::t('#tom_xiangqin#tom_xiangqin')->fetch_by_user_no($qianxian_user_no);
    
    if(!$qianxianXiangqinInfo){
        cpmsg($Lang['qianxian_user_no_error_msg'], $modListUrl, 'error');exit;
    }
    
    if($qianxians_type == 1){
        if($xiangqinInfo['qianxians'] < 1){
            cpmsg($Lang['qianxian_times_error_msg'], $modListUrl, 'error');exit;
        }
    }
    
    if($qianxians_type == 1){
        
        $updateData = array();
        $updateData['qianxians']        = $xiangqinInfo['qianxians'] - 1;
        $updateData['qianxian_status']  = 4;
        C::t('#tom_xiangqin#tom_xiangqin')->update($xiangqinInfo['id'], $updateData);
        
        $insertData = array();
        $insertData['xiangqin_id']      = $xiangqinInfo['id'];
        $insertData['change_num']       = 1;
        $insertData['old_num']          = $xiangqinInfo['qianxians'];
        $insertData['log_type']         = 3;
        $insertData['log_time']         = TIMESTAMP;
        C::t('#tom_xiangqin#tom_xiangqin_qianxians_log')->insert($insertData);
        
    }else{
        $updateData = array();
        $updateData['qianxian_status']  = 4;
        C::t('#tom_xiangqin#tom_xiangqin')->update($xiangqinInfo['id'], $updateData);
    }
    
    $insertData = array();
    $insertData['xiangqin_id']              = $xiangqinInfo['id'];
    $insertData['qianxian_xiangqin_id']     = $qianxianXiangqinInfo['id'];
    $insertData['qianxian_beizu']           = $qianxian_beizu;
    $insertData['qianxian_time']            = TIMESTAMP;
    C::t('#tom_xiangqin#tom_xiangqin_qianxian')->insert($insertData);
    
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    
}else{
    
    tomshownavheader();
    tomshownavli($xiangqinInfo['xm'].' > ',"",true);
    tomshownavfooter();
    showformheader($modFromUrl.'&act=save&formhash='.$formhash,'enctype');
    showtableheader();
    
    tomshowsetting(array('title'=>$Lang['qianxian_user_no'],'name'=>'qianxian_user_no','value'=>'','msg'=>$Lang['qianxian_user_no_msg']),"input");
    $type_item = array(1=>$Lang['qianxians_type_1'],2=>$Lang['qianxians_type_2']);
    tomshowsetting(array('title'=>$Lang['qianxians_type'],'name'=>'qianxians_type','value'=>1,'msg'=>$Lang['qianxians_type_msg'],'item'=>$type_item),"radio");
    tomshowsetting(array('title'=>$Lang['qianxian_beizu'],'name'=>'qianxian_beizu','value'=>$options['qianxian_beizu'],'msg'=>''),"textarea");
    
    showsubmit('submit', 'submit');
    showtablefooter();
    showformfooter();
    
    tomshownavheader();
    tomshownavli($Lang['back_title'],$adminBaseUrl.'&tmod=user&user_no='.$xiangqinInfo['user_no'].'&formhash='.FORMHASH,false);
    tomshownavfooter();
    
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    $pagesize = 1000;
    $start = ($page-1)*$pagesize;	
    $count = C::t('#tom_xiangqin#tom_xiangqin_qianxian')->fetch_all_count("AND xiangqin_id={$xiangqin_id}");
    $qianxianList = C::t('#tom_xiangqin#tom_xiangqin_qianxian')->fetch_all_list("AND xiangqin_id={$xiangqin_id}"," ORDER BY id DESC ",$start,$pagesize);
    
    tomshownavheader();
    tomshownavli($xiangqinInfo['xm'].' > ',"",true);
    tomshownavli($Lang['qianxian_title'],"",true);
    tomshownavfooter();
    showtableheader();
    echo '<tr class="header">';
    echo '<th>' . $Lang['qianxian_user_no'] . '</th>';
    echo '<th>' . $Lang['qianxian_xiangqin_id'] . '</th>';
    echo '<th>' . $Lang['qianxian_beizu'] . '</th>';
    echo '<th>' . $Lang['qianxian_time'] . '</th>';
    echo '</tr>';
    
    foreach ($qianxianList as $key => $value) {
        
        $qxXiangqinInfoTmp = C::t('#tom_xiangqin#tom_xiangqin')->fetch_by_id($value['qianxian_xiangqin_id']);
        
        echo '<tr>';
        echo '<td>' . $qxXiangqinInfoTmp['user_no'] . '</td>';
        echo '<td><a target="_blank" href="'.$adminBaseUrl.'&tmod=user&user_no='.$qxXiangqinInfoTmp['user_no'].'&formhash='.FORMHASH.'">' . $qxXiangqinInfoTmp['xm'] . '</a></td>';
        echo '<td>' . $value['qianxian_beizu'] . '&nbsp;</td>';
        echo '<td>' . dgmdate($value['qianxian_time'],"Y-m-d H:i",$tomSysOffset) . '</td>';
        
    }
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBaseUrl);	
    showsubmit('', '', '', '', $multi, false);
     
}