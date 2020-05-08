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

$modBaseUrl = $adminBaseUrl.'&tmod=user';
$modListUrl = $adminListUrl.'&tmod=user';
$modFromUrl = $adminFromUrl.'&tmod=user';

$get_list_url_value = get_list_url("tom_xiangqin_admin_user_list");
if($get_list_url_value){
    $modListUrl = $get_list_url_value;
}

$act = $_GET['act'];
$formhash =  $_GET['formhash']? $_GET['formhash']:'';
if($formhash == FORMHASH && $act == 'show'){
}else if($formhash == FORMHASH && $act == 'del'){
    C::t('#tom_xiangqin#tom_xiangqin')->delete($_GET['id']);
    C::t('#tom_xiangqin#tom_xiangqin_photo')->delete_by_xiangqin_id($_GET['id']);
    C::t('#tom_xiangqin#tom_xiangqin_collect')->delete_by_xiangqin_id($_GET['id']);
    C::t('#tom_xiangqin#tom_xiangqin_chakan')->delete_by_xiangqin_id($_GET['id']);
    C::t('#tom_xiangqin#tom_xiangqin_qianxian')->delete_by_xiangqin_id($_GET['id']);
    C::t('#tom_xiangqin#tom_xiangqin_qianxians_log')->delete_by_xiangqin_id($_GET['id']);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
}else if($formhash == FORMHASH && $act == 'editvip'){
    $info = C::t('#tom_xiangqin#tom_xiangqin')->fetch_by_id($_GET['id']);
    if(submitcheck('submit')){
        $vip_id       = intval($_GET['vip_id']);
        $vip_time     = isset($_GET['vip_time'])? addslashes($_GET['vip_time']):'';
        if($vip_id == 0){
            $vip_time = 0;
        }else{
            $vip_time   = strtotime($vip_time);
        }
        $updateData = array();
        $updateData['vip_id']   = $vip_id;
        $updateData['vip_time'] = $vip_time;
        C::t('#tom_xiangqin#tom_xiangqin')->update($_GET['id'],$updateData);

        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        tomloadcalendarjs();
        showformheader($modFromUrl.'&act=editvip&id='.$_GET['id'].'&formhash='.FORMHASH);
        showtableheader();
        $vipList = C::t('#tom_xiangqin#tom_xiangqin_vip')->fetch_all_list("");
        echo '<tr><th colspan="15" class="partition">' . $Lang['edit_vip_title'] .'('.$info['xm']. ')</th></tr>';
        echo '<tr><td width="100" ><b>' . $Lang['vip_id'] . '</b><tr></tr><td><select name="vip_id" >';
        echo '<option value="0">'.$Lang['edit_vip_id_0'].'</option>';
        if(is_array($vipList) && !empty($vipList)){
            foreach ($vipList as $key => $value){
                if($value['id'] == $vip_id){
                    echo  '<option value='.$value['id'].' selected>'.$value['name'].'</option>';
                }else{
                    echo  '<option value='.$value['id'].'>'.$value['name'].'</option>';
                }
            }
        }
        echo '</select></td>';
        tomshowsetting(array('title'=>$Lang['edit_vip_time'],'name'=>'vip_time','value'=>$info['vip_time'],'msg'=>$Lang['edit_vip_time_msg']),"calendar");
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
}else if($formhash == FORMHASH && $act == 'edittop'){
    $info = C::t('#tom_xiangqin#tom_xiangqin')->fetch_by_id($_GET['id']);
    if(submitcheck('submit')){
        $top_status       = intval($_GET['top_status']);
        $top_time         = isset($_GET['top_time'])? addslashes($_GET['top_time']):'';
        if($top_status == 0){
            $top_time   = 0;
            $top_do_time= 0;
        }else{
            $top_time         = strtotime($top_time);
            $top_do_time      = TIMESTAMP;
        }
        $updateData = array();
        $updateData['top_status'] = $top_status;
        $updateData['top_time'] = $top_time;
        $updateData['top_do_time'] = $top_do_time;
        C::t('#tom_xiangqin#tom_xiangqin')->update($_GET['id'],$updateData);

        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        tomloadcalendarjs();
        showformheader($modFromUrl.'&act=edittop&id='.$_GET['id'].'&formhash='.FORMHASH);
        showtableheader();
        echo '<tr><th colspan="15" class="partition">' . $Lang['edit_top_status'] .'('.$info['xm']. ')</th></tr>';
        $vip_id_item = array(0=>$Lang['edit_top_status_0'],1=>$Lang['edit_top_status_1']);
        tomshowsetting(array('title'=>$Lang['top_status'],'name'=>'top_status','value'=>$info['top_status'],'msg'=>$Lang['edit_vip_id_msg'],'item'=>$vip_id_item),"radio");
        tomshowsetting(array('title'=>$Lang['edit_vip_time'],'name'=>'top_time','value'=>$info['top_time'],'msg'=>$Lang['edit_vip_time_msg']),"calendar");
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
}else if($formhash == FORMHASH && $act == 'editqianxian'){
    $info = C::t('#tom_xiangqin#tom_xiangqin')->fetch_by_id($_GET['id']);
    if(submitcheck('submit')){
        $qianxian_status       = intval($_GET['qianxian_status']);
        $updateData = array();
        $updateData['qianxian_status'] = $qianxian_status;
        C::t('#tom_xiangqin#tom_xiangqin')->update($_GET['id'],$updateData);

        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        tomloadcalendarjs();
        showformheader($modFromUrl.'&act=editqianxian&id='.$_GET['id'].'&formhash='.FORMHASH);
        showtableheader();
        echo '<tr><th colspan="15" class="partition">' . $Lang['qianxian_status'] .'('.$info['xm']. ')</th></tr>';
        $qianxian_status_item = array(1=>$Lang['qianxian_status_1'],2=>$Lang['qianxian_status_2'],3=>$Lang['qianxian_status_3'],4=>$Lang['qianxian_status_4']);
        tomshowsetting(array('title'=>$Lang['qianxian_status'],'name'=>'qianxian_status','value'=>$info['qianxian_status'],'msg'=>'','item'=>$qianxian_status_item),"radio");
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
}else if($formhash == FORMHASH && $act == 'shenheok'){
    $updateData = array();
    $updateData['shenhe_status'] = 1;
    C::t('#tom_xiangqin#tom_xiangqin')->update($_GET['id'],$updateData);
    cpmsg($Lang['act_success'],$modListUrl, 'succeed');
}else if($formhash == FORMHASH && $act == 'shenheno'){
    
    if(submitcheck('submit')){
        
        $content    = isset($_GET['content'])? addslashes($_GET['content']):'';
        
        $info = C::t('#tom_xiangqin#tom_xiangqin')->fetch_by_id($_GET['id']);
        
        $updateData = array();
        $updateData['shenhe_status'] = 3;
        C::t('#tom_xiangqin#tom_xiangqin')->update($_GET['id'],$updateData);
    
        $insertData = array();
        $insertData['user_id']     = $info['user_id'];
        $insertData['type']        = 1;
        $insertData['title']       = $Lang['shenhe_no_title'];
        $insertData['content']     = $content;
        $insertData['tz_time']     = TIMESTAMP;
        $insertData['is_read']     = 0;
        C::t('#tom_love#tom_love_tz')->insert($insertData);
        
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        showformheader($modFromUrl.'&act=shenheno&id='.$_GET['id'].'&formhash='.FORMHASH);
        showtableheader();
        echo '<tr><th colspan="15" class="partition">' . $Lang['shenhe_no_title'] . '</th></tr>';
        tomshowsetting(array('title'=>$Lang['shenhe_no_msg'],'name'=>'content','value'=>'','msg'=>''),"textarea");
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
    
}else if($formhash == FORMHASH && $act == 'shangjia'){
    $updateData = array();
    $updateData['status'] = 1;
    C::t('#tom_xiangqin#tom_xiangqin')->update($_GET['id'],$updateData);
    cpmsg($Lang['act_success'],$modListUrl, 'succeed');
}else if($formhash == FORMHASH && $act == 'xiajia'){
    
    if(submitcheck('submit')){
        
        $content    = isset($_GET['content'])? addslashes($_GET['content']):'';
        
        $info = C::t('#tom_xiangqin#tom_xiangqin')->fetch_by_id($_GET['id']);
        
        $updateData = array();
        $updateData['status'] = 2;
        C::t('#tom_xiangqin#tom_xiangqin')->update($_GET['id'],$updateData);
    
        $insertData = array();
        $insertData['user_id']     = $info['user_id'];
        $insertData['type']        = 1;
        $insertData['title']       = $Lang['xiajia_title'];
        $insertData['content']     = $content;
        $insertData['tz_time']     = TIMESTAMP;
        $insertData['is_read']     = 0;
        C::t('#tom_love#tom_love_tz')->insert($insertData);
        
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        showformheader($modFromUrl.'&act=xiajia&id='.$_GET['id'].'&formhash='.FORMHASH);
        showtableheader();
        echo '<tr><th colspan="15" class="partition">' . $Lang['xiajia_title'] . '</th></tr>';
        tomshowsetting(array('title'=>$Lang['xiajia_msg'],'name'=>'content','value'=>'','msg'=>''),"textarea");
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
    
}else{
    set_list_url("tom_xiangqin_admin_user_list");
    
    $user_no        = isset($_GET['user_no'])? intval($_GET['user_no']):'';
    $xm             = !empty($_GET['xm'])? addslashes($_GET['xm']):'';
    $vip_id         = isset($_GET['vip_id'])? intval($_GET['vip_id']):0;
    $top_status     = isset($_GET['top_status'])? intval($_GET['top_status']):0;
    $is_renzheng    = isset($_GET['is_renzheng'])? intval($_GET['is_renzheng']):0;
    $is_ok          = isset($_GET['is_ok'])? intval($_GET['is_ok']):2;
    $sex            = isset($_GET['sex'])? intval($_GET['sex']):0;
    $shenhe_status  = isset($_GET['shenhe_status'])? intval($_GET['shenhe_status']):0;
    $qianxian_status= isset($_GET['qianxian_status'])? intval($_GET['qianxian_status']):0;
    
    $pagesize   = 10;
    $page       = intval($_GET['page'])>0? intval($_GET['page']):1;
    $start      = ($page-1)*$pagesize;	
    
    $where = "";
    if(!empty($user_no)){
        $where.= " AND user_no={$user_no} ";
    }
    if(!empty($vip_id)){
        $where.= " AND vip_id= {$vip_id}";
    }
    if(!empty($top_status)){
        if($top_status == 1){
            $where.= " AND top_status=0 ";
        }
        if($top_status == 2){
            $where.= " AND top_status=1 ";
        }
    }
    if(!empty($sex)){
        if($sex == 1){
            $where.= " AND sex=1 ";
        }
        if($sex == 2){
            $where.= " AND sex=2 ";
        }
    }
    if(!empty($shenhe_status)){
        if($shenhe_status == 2){
            $where.= " AND shenhe_status=2 ";
        }
        if($shenhe_status == 3){
            $where.= " AND shenhe_status=3 ";
        }
    }
    if(!empty($is_renzheng)){
        $loveUserListTmp = array();
        if($is_renzheng == 1){
            $loveUserListTmp = C::t('#tom_love#tom_love')->fetch_all_list(" AND renzheng=0 ","ORDER BY id DESC",0,10000,'','');
        }else if($is_renzheng == 2){
            $loveUserListTmp = C::t('#tom_love#tom_love')->fetch_all_list(" AND renzheng=1 ","ORDER BY id DESC",0,10000,'','');
        }
        $userIdArr = array();
        if(is_array($loveUserListTmp) && !empty($loveUserListTmp)){
            foreach ($loveUserListTmp as $key => $value){
                $userIdArr[] = $value['id'];
            }
        }
        if(is_array($userIdArr) && !empty($userIdArr)){
            $where.= " AND user_id IN (".  implode(',', $userIdArr).") ";
        }
    }
    if(!empty($is_ok)){
        if($is_ok == 1){
            $where.= " AND is_ok=0 ";
        }
        if($is_ok == 2){
            $where.= " AND is_ok=1 ";
        }
    }
    if($qianxian_status > 0){
        $where.= " AND qianxian_status={$qianxian_status} ";
    }
    
    $count = C::t('#tom_xiangqin#tom_xiangqin')->fetch_all_count($where,$xm);
    $userList = C::t('#tom_xiangqin#tom_xiangqin')->fetch_all_list($where,"ORDER BY add_time DESC",$start,$pagesize,$xm);
    
    $modBasePageUrl = $modBaseUrl."&vip_id={$vip_id}&top_status={$top_status}&sex={$sex}&shenhe_status={$shenhe_status}&is_ok={$is_ok}&qianxian_status={$qianxian_status}";
    
    showtableheader();
    $Lang['xiangqin_help_1']  = str_replace("{SITEURL}", $_G['siteurl'], $Lang['xiangqin_help_1']);
    $Lang['xiangqin_help_2']  = str_replace("{SITEURL}", $_G['siteurl'], $Lang['xiangqin_help_2']);
    echo '<tr><th colspan="15" class="partition">' . $Lang['xiangqin_help_title'] . '</th></tr>';
    echo '<tr><td  class="tipsblock" s="1"><ul id="tipslis">';
    echo '<li>' . $Lang['xiangqin_help_1'] . '</li>';
    echo '<li>' . $Lang['xiangqin_help_2'] . '</li>';
    echo '<li>' . $Lang['xiangqin_help_3'] . '</li>';
    echo '</ul></td></tr>';
    showtablefooter();
    
    showformheader($modFromUrl.'&formhash='.FORMHASH);
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $Lang['search_list'] . '</th></tr>';
    echo '<tr><td width="100" align="right"><b>'.$Lang['xm'].'</b></td><td><input name="xm" type="text" value="'.$xm.'" size="40" /></td></tr>';
    echo '<tr><td width="100" align="right"><b>'.$Lang['user_no'].'</b></td><td><input name="user_no" type="text" value="'.$user_no.'" size="40" /></td></tr>';
    
    $vipList = C::t('#tom_xiangqin#tom_xiangqin_vip')->fetch_all_list("");
    echo '<tr><td width="100" align="right"><b>' . $Lang['vip_id'] . '</b></td><td><select name="vip_id" >';
    echo '<option value="0">'.$Lang['edit_vip_id_0'].'</option>';
    if(is_array($vipList) && !empty($vipList)){
        foreach ($vipList as $key => $value){
            if($value['id'] == $vip_id){
                echo  '<option value='.$value['id'].' selected>'.$value['name'].'</option>';
            }else{
                echo  '<option value='.$value['id'].'>'.$value['name'].'</option>';
            }
        }
    }
    echo '</select></td></tr>';
    
    $top_0 = $top_1 = $top_2 ="";
    if($top_status == 0){ $top_0 = "selected";}
    if($top_status == 1){ $top_1 = "selected";}
    if($top_status == 2){ $top_2 = "selected";}
    echo '<tr><td width="100" align="right"><b>' . $Lang['top_status'] . '</b></td><td><select name="top_status" >';
    echo '<option value="0">'.$Lang['top_status'].'</option>';
    echo '<option value="1" '.$top_1.'>'.$Lang['edit_top_status_0'].'</option>';
    echo '<option value="2" '.$top_2.'>'.$Lang['edit_top_status_1'].'</option>';
    echo '</select></td></tr>';
       
    $sex_0 = $sex_1 = $sex_2 ="";
    if($sex == 0){ $sex_0 = "selected";}
    if($sex == 1){ $sex_1 = "selected";}
    if($sex == 2){ $sex_2 = "selected";}
    echo '<tr><td width="100" align="right"><b>' . $Lang['sex'] . '</b></td><td><select name="sex" >';
    echo '<option value="0">'.$Lang['sex'].'</option>';
    echo '<option value="1" '.$sex_1.'>'.$Lang['man'].'</option>';
    echo '<option value="2" '.$sex_2.'>'.$Lang['woman'].'</option>';
    echo '</select></td></tr>';
    
    $qianxian_status_1 = $qianxian_status_2 = $qianxian_status_3 = $qianxian_status_4 = "";
    if($qianxian_status == 1){ $qianxian_status_1 = "selected";}
    if($qianxian_status == 2){ $qianxian_status_2 = "selected";}
    if($qianxian_status == 3){ $qianxian_status_3 = "selected";}
    if($qianxian_status == 4){ $qianxian_status_4 = "selected";}
    echo '<tr><td width="100" align="right"><b>' . $Lang['qianxian_status'] . '</b></td><td><select name="qianxian_status" >';
    echo '<option value="0">'.$Lang['qianxian_status'].'</option>';
    echo '<option value="1" '.$qianxian_status_1.'>'.$Lang['qianxian_status_1'].'</option>';
    echo '<option value="2" '.$qianxian_status_2.'>'.$Lang['qianxian_status_2'].'</option>';
    echo '<option value="3" '.$qianxian_status_3.'>'.$Lang['qianxian_status_3'].'</option>';
    echo '<option value="4" '.$qianxian_status_4.'>'.$Lang['qianxian_status_4'].'</option>';
    echo '</select></td></tr>';
    
    $is_renzheng_1 = $is_renzheng_2 ="";
    if($is_renzheng == 1){ $is_renzheng_1 = "selected";}
    if($is_renzheng == 2){ $is_renzheng_2 = "selected";}
    echo '<tr><td width="100" align="right"><b>' . $Lang['is_renzheng'] . '</b></td><td><select name="is_renzheng" >';
    echo '<option value="0">'.$Lang['is_renzheng'].'</option>';
    echo '<option value="1" '.$is_renzheng_1.'>'.$Lang['is_renzheng_0'].'</option>';
    echo '<option value="2" '.$is_renzheng_2.'>'.$Lang['is_renzheng_1'].'</option>';
    echo '</select></td></tr>';
    
    $is_ok_1 = $is_ok_2 ="";
    if($is_ok == 1){ $is_ok_1 = "selected";}
    if($is_ok == 2){ $is_ok_2 = "selected";}
    echo '<tr><td width="100" align="right"><b>' . $Lang['is_ok'] . '</b></td><td><select name="is_ok" >';
    echo '<option value="3">'.$Lang['is_ok'].'</option>';
    echo '<option value="1" '.$is_ok_1.'>'.$Lang['is_ok_0'].'</option>';
    echo '<option value="2" '.$is_ok_2.'>'.$Lang['is_ok_1'].'</option>';
    echo '</select></td></tr>';
    
    showsubmit('submit', 'submit');
    showtablefooter();
    showformfooter();
    
    $countShenheStatus2 = C::t('#tom_xiangqin#tom_xiangqin')->fetch_all_count(" AND shenhe_status=2 ");
    $countShenheStatus3 = C::t('#tom_xiangqin#tom_xiangqin')->fetch_all_count(" AND shenhe_status=3 ");
    echo '<div class="order_nav">';
    echo '<a style="border-color: #f0962a;color: #f0962a;" href="'.$modBaseUrl.'&shenhe_status=2'.'">'.$Lang['usershenhe_ing'].'&nbsp;<span>('.$countShenheStatus2.')</span></a>';
    echo '<a style="border-color: #1fbf8c;color: #1fbf8c;" href="'.$modBaseUrl.'&shenhe_status=3'.'">'.$Lang['usershenhe_status_3'].'&nbsp;<span>('.$countShenheStatus3.')</span></a>';
    echo '</div>';
    
    tomshownavheader();
  
    tomshownavli($Lang['add_user'],$manageUrl.'&mod=add',false,true);
    tomshownavli($Lang['daochu'],$adminBaseUrl.'&tmod=doDao',false);
    tomshownavli($Lang['xieyi_title'],$adminBaseUrl.'&tmod=common',false);
    tomshownavli($Lang['vip_title'],$adminBaseUrl.'&tmod=common',false);
    tomshownavli($Lang['top_title'],$adminBaseUrl.'&tmod=common',false);
    tomshownavli($Lang['qianxians_title'],$adminBaseUrl.'&tmod=common',false);
    tomshownavfooter();
    
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $Lang['user_list'] . '</th></tr>';
    echo '<tr class="header">';
    echo '<th>ID</th>';
    echo '<th>' . $Lang['user_id'] . '</th>';
    echo '<th>' . $Lang['xm'] . '</th>';
    echo '<th>' . $Lang['user_no'] . '</th>';
    echo '<th>' . $Lang['sex'] . '</th>';
    echo '<th>' . $Lang['age'] . '</th>';
    echo '<th>' . $Lang['vip_id'] . '</th>';
    echo '<th>' . $Lang['top_status'] . '</th>';
    echo '<th>' . $Lang['qianxians'] . '</th>';
    echo '<th>' . $Lang['qianxian_status'] . '</th>';
    echo '<th>' . $Lang['user_status'] . '</th>';
    echo '<th>' . $Lang['add_time'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    foreach ($userList as $key => $value){
        
        $loveInfo  = C::t('#tom_love#tom_love')->fetch_by_id($value['user_id']);
        
        $addTime = dgmdate($value['add_time'], 'Y-m-d H:i',$tomSysOffset);
        $closeName = "";
        if($value['closed'] == 1){
            $closeName = '<font color="#FF0000">'.$Lang['close'].'</font>';
        }else{
            $closeName = '<font color="#009933">'.$Lang['open'].'</font>';
        }
        $sexName = '';
        if($value['sex'] == 1){
            $sexName = $Lang['man'];
        }else if($value['sex'] == 2){
            $sexName = $Lang['woman'];
        }else{
            $sexName = '-';
        }
        
        $vipInfo = C::t('#tom_xiangqin#tom_xiangqin_vip')->fetch_by_id($value['vip_id']);
        if($value['vip_id'] < 1){
            $vip = $Lang['edit_vip_id_0'];
        }else{
            $vip = $vipInfo['name'];
        }
        
        $top = '';
        if($value['top_status'] == 0){
            $top = $Lang['edit_top_status_0'];
        }else if($value['top_status'] == 1){
            $top = $Lang['edit_top_status_1'];
        }else{
            $top = '-';
        }
        if($value['birth_year'] > 0){
            if($jyConfig['age_type_id'] == 1){
                $age = $nowYear - $value['birth_year'];
            }else{
                $age = $nowYear - $value['birth_year'] + 1;
            }
        }else{
            $age = '-';
        }
        $shenhe_status = '';
        if($value['shenhe_status'] == 1){
            $shenhe_status = $Lang['usershenhe_ok'];
        }else if($value['shenhe_status'] == 2){
            $shenhe_status = $Lang['usershenhe_ing'];
        }else if($value['shenhe_status'] == 3){
            $shenhe_status = $Lang['usershenhe_no'];
        }else{
            $shenhe_status = '-';
        }
        $status = '';
        if($value['status'] == 1){
            $status = $Lang['status_yes'];
        }else{
            $status = $Lang['status_no'];
        }
        $is_ok = '';
        if($value['is_ok'] == 0){
            $is_ok = '<font color="#fd0d0d">' .$Lang['is_ok_0'].'</font>';
        }else{
            $is_ok = '<font color="#238206">' .$Lang['is_ok_1'].'</font>';
        }
        
        echo '<tr>';
        echo '<td>' . $value['id'] . '</td>';
        echo '<td>' . $value['user_id'] . '</td>';
        echo '<td>' . $value['xm'] . '</td>'; 
        echo '<td>' . $value['user_no'] . '</td>';
        echo '<td>' . $sexName . '</td>';
        echo '<td>' . $age . '</td>';
        echo '<td>' . $vip . '</td>';
        echo '<td>' . $top . '</td>';
        echo '<td><font color="#fd0d0d">' . $value['qianxians'] . '</font></td>';
        echo '<td>';
        if($value['qianxian_status'] == 1){
            echo '<font color="#8e8e8e">' . $Lang['qianxian_status_1'] . '</font>';
        }else if($value['qianxian_status'] == 2){
            echo '<font color="#0894fb">' . $Lang['qianxian_status_2'] . '</font>';
        }else if($value['qianxian_status'] == 3){
            echo '<font color="#fd0d0d">' . $Lang['qianxian_status_3'] . '</font>';
        }else if($value['qianxian_status'] == 4){
            echo '<font color="#238206">' . $Lang['qianxian_status_4'] . '</font>';
        }
        echo '(</font><a href="'.$modBaseUrl.'&act=editqianxian&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['qianxian_status_do'] . '</a>)<br/>';
        echo '</td>';
        echo '<td style="line-height: 25px;">';
            echo $Lang['closed']." : ".$closeName."<br/>";
            echo $Lang['is_open']." : ";
            if($value['is_open'] == 1){
                echo '<font color="#238206">' . $Lang['is_open_1'] . '</font><br/>';
            }else{
                echo '<font color="#fd0d0d">' . $Lang['is_open_0'] . '</font><br/>';
            }
            echo $Lang['is_renzheng']." : ";
            if($loveInfo['renzheng'] == 1){
                echo '<font color="#238206">' . $Lang['is_renzheng_1'] . '</font><br/>';
            }else{
                echo '<font color="#fd0d0d">' . $Lang['is_renzheng_0'] . '</font><br/>';
            }
            echo $Lang['is_ok']." : ".$is_ok."<br/>";
            echo $Lang['shenhe_status']." : ";
            if($value['shenhe_status'] == 1){
                echo ''.$shenhe_status.'(</font><a href="'.$modBaseUrl.'&act=shenheno&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['usershenhe_no'] . '</a>)<br/>';
            }else if($value['shenhe_status'] == 2){
                echo ''.$shenhe_status.'(</font><a href="'.$modBaseUrl.'&act=shenheok&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['usershenhe_ok'] . '</a>)(<a href="'.$modBaseUrl.'&act=shenheno&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['usershenhe_no'] . '</a>)<br/>';
            }else{
                echo ''.$shenhe_status.'(</font><a href="'.$modBaseUrl.'&act=shenheok&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['usershenhe_ok'] . '</a>)<br/>';
            }
            echo $Lang['status_show']." : ";
            if($value['status'] == 1){
                echo ''.$status.'(</font><a href="'.$modBaseUrl.'&act=xiajia&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['status_no'] . '</a>)<br/>';
            }else{
                echo ''.$status.'(</font><a href="'.$modBaseUrl.'&act=shangjia&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['status_yes'] . '</a>)<br/>';
            }
        echo '</td>';
        echo '<td>' . $addTime . '</td>';
        echo '<td style="line-height: 25px;">';
        echo '<a href="'.$adminBaseUrl.'&tmod=qianxian&xiangqin_id='.$value['id'].'"><font color="#0894fb">' . $Lang['qianxian_title'] . '</font></a>&nbsp;&nbsp;|&nbsp;&nbsp;';
        echo '<a href="'.$adminBaseUrl.'&tmod=qianxiansLog&xiangqin_id='.$value['id'].'">' . $Lang['qianxians_log_title'] . '</a><br/>';
        //echo '<a href="'.$modBaseUrl.'&act=show&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['show'] . '</a>&nbsp;&nbsp;|&nbsp;&nbsp;';
        echo '<a href="'.$manageUrl.'&mod=edit&user_id='.$value['id'].'" target="_blank">' . $Lang['edit_user'] . '</a>&nbsp;&nbsp;|&nbsp;&nbsp;';
        echo '<a href="'.$modBaseUrl.'&act=editvip&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['edit_vip_title'] . '</a><br/>';
        echo '<a href="'.$modBaseUrl.'&act=edittop&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['edit_top_status'] . '</a>&nbsp;&nbsp;|&nbsp;&nbsp;';
        echo '<a href="'.$adminBaseUrl.'&tmod=order&xiangqin_id='.$value['id'].'">' . $Lang['edit_order_title'] . '</a><br/>';
        echo '<a href="'.$manageUrl.'&mod=usercard&uid='.$value['id'].'" target="_blank"><font color="#fd0d0d">' . $Lang['edit_card'] . '</font></a>&nbsp;&nbsp;|&nbsp;&nbsp;';
        echo '<a href="javascript:void(0);" onclick="del_confirm(\''.$modBaseUrl.'&act=del&id='.$value['id'].'&formhash='.FORMHASH.'\');">' . $Lang['delete'] . '</a>';
        echo '</td>';
        echo '</tr>';
    }
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBasePageUrl);	
    showsubmit('', '', '', '', $multi, false);
    
    $jsstr = <<<EOF
<script type="text/javascript">
function del_confirm(url){
  var r = confirm("{$Lang['makesure_del_msg']}")
  if (r == true){
    window.location = url;
  }else{
    return false;
  }
}
</script>
EOF;
    echo $jsstr;
}