<?php

/*
   [Dashulai!] (C)2009-2019 WWW.DASHULAI.COM.
   技术支持/更新维护：官网 https://www.dashulai.com
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$modBaseUrl = $adminBaseUrl.'&tmod=qianxiansLog&xiangqin_id='.$_GET['xiangqin_id'];
$modListUrl = $adminListUrl.'&tmod=qianxiansLog&xiangqin_id='.$_GET['xiangqin_id'];
$modFromUrl = $adminFromUrl.'&tmod=qianxiansLog&xiangqin_id='.$_GET['xiangqin_id'];

$xiangqin_id    = isset($_GET['xiangqin_id'])? intval($_GET['xiangqin_id']):0;

$xiangqinInfo = C::t('#tom_xiangqin#tom_xiangqin')->fetch_by_id($xiangqin_id);

if($_GET['act'] == 'save' && $_GET['formhash'] == FORMHASH){
    
    $qianxians_num = isset($_GET['qianxians_num'])? intval($_GET['qianxians_num']):0;
    
    $type           = isset($_GET['type'])? intval($_GET['type']):0;
    
    
    if($type == 1){
        
        $updateData = array();
        $updateData['qianxians'] = $xiangqinInfo['qianxians'] + $qianxians_num;
        C::t('#tom_xiangqin#tom_xiangqin')->update($xiangqinInfo['id'], $updateData);
        
        $insertData = array();
        $insertData['xiangqin_id']      = $xiangqinInfo['id'];
        $insertData['change_num']       = $qianxians_num;
        $insertData['old_num']          = $xiangqinInfo['qianxians'];
        $insertData['log_type']         = 1;
        $insertData['log_time']         = TIMESTAMP;
        C::t('#tom_xiangqin#tom_xiangqin_qianxians_log')->insert($insertData);
        
    }else if($type == 2){
        
        $shengyuQianxians = $xiangqinInfo['qianxians'] - $qianxians_num;
        if($shengyuQianxians < 0){
            $shengyuQianxians = 0;
            $qianxians_num = $xiangqinInfo['qianxians'];
        }
        
        $updateData = array();
        $updateData['qianxians'] = $shengyuQianxians;
        C::t('#tom_xiangqin#tom_xiangqin')->update($xiangqinInfo['id'], $updateData);
        
        $insertData = array();
        $insertData['xiangqin_id']      = $xiangqinInfo['id'];
        $insertData['change_num']       = $qianxians_num;
        $insertData['old_num']          = $xiangqinInfo['qianxians'];
        $insertData['log_type']         = 2;
        $insertData['log_time']         = TIMESTAMP;
        C::t('#tom_xiangqin#tom_xiangqin_qianxians_log')->insert($insertData);
        
    }
    
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    
}else{
    
    tomshownavheader();
    tomshownavli($xiangqinInfo['xm'].' > ',"",true);
    tomshownavli($Lang['qianxians_log_shengyu_qianxians'].' '.$xiangqinInfo['qianxians'],"",true);
    tomshownavfooter();
    showformheader($modFromUrl.'&act=save&formhash='.$formhash,'enctype');
    showtableheader();
    
    tomshowsetting(array('title'=>$Lang['qianxians_log_num'],'name'=>'qianxians_num','value'=>$options['qianxians_num'],'msg'=>$Lang['qianxians_log_num_msg']),"input");
    $type_item = array(1=>$Lang['qianxians_log_num_1'],2=>$Lang['qianxians_log_num_2']);
    tomshowsetting(array('title'=>$Lang['qianxians_log_num_type'],'name'=>'type','value'=>1,'msg'=>$Lang['qianxians_log_num_type_msg'],'item'=>$type_item),"radio");
    
    showsubmit('submit', 'submit');
    showtablefooter();
    showformfooter();
    
    tomshownavheader();
    tomshownavli($Lang['back_title'],$adminBaseUrl.'&tmod=user&user_no='.$xiangqinInfo['user_no'].'&formhash='.FORMHASH,false);
    tomshownavfooter();
    
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    $pagesize = 1000;
    $start = ($page-1)*$pagesize;	
    $count = C::t('#tom_xiangqin#tom_xiangqin_qianxians_log')->fetch_all_count("AND xiangqin_id={$xiangqin_id}");
    $qianxianslogList = C::t('#tom_xiangqin#tom_xiangqin_qianxians_log')->fetch_all_list("AND xiangqin_id={$xiangqin_id}"," ORDER BY id DESC ",$start,$pagesize);
    
    tomshownavheader();
    tomshownavli($xiangqinInfo['xm'].' > ',"",true);
    tomshownavli($Lang['qianxians_log_list_title'],"",true);
    tomshownavfooter();
    showtableheader();
    echo '<tr class="header">';
    echo '<th>ID</th>';
    echo '<th>' . $Lang['qianxians_log_list_type'] . '</th>';
    echo '<th>' . $Lang['qianxians_log_list_change_value'] . '</th>';
    echo '<th>' . $Lang['qianxians_log_list_old_value'] . '</th>';
    echo '<th>' . $Lang['qianxians_log_list_log_time'] . '</th>';
    echo '</tr>';
    
    $i = 1;
    foreach ($qianxianslogList as $key => $value) {
        $log_type = '';
        if($value['log_type'] == 1){
            $log_type = $Lang['qianxians_log_type_1'];
        }else if($value['log_type'] == 2){
            $log_type = $Lang['qianxians_log_type_2'];
        }else if($value['log_type'] == 3){
            $log_type = $Lang['qianxians_log_type_3'];
        }else if($value['log_type'] == 4){
            $log_type = $Lang['qianxians_log_type_4'];
        }else if($value['log_type'] == 5){
            $log_type = $Lang['qianxians_log_type_5'];
        }
        
        echo '<tr>';
        echo '<td>' . $value['id'] . '</td>';
        echo '<td>' . $log_type . '</td>';
        echo '<td>' . $value['change_num'] . '</td>';
        echo '<td>' . $value['old_num'] . '</td>';
        echo '<td>' . dgmdate($value['log_time'],"Y-m-d H:i",$tomSysOffset) . '</td>';
        
        $i++;
    }
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBaseUrl);	
    showsubmit('', '', '', '', $multi, false);
     
}