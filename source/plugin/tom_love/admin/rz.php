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

$modBaseUrl = $adminBaseUrl.'&tmod=rz'; 
$modListUrl = $adminListUrl.'&tmod=rz';
$modFromUrl = $adminFromUrl.'&tmod=rz';

$act = $_GET['act'];
$formhash =  $_GET['formhash']? $_GET['formhash']:'';

$get_list_url_value = get_list_url("tom_love_admin_rz_list");
if($get_list_url_value){
    $modListUrl = $get_list_url_value;
}

if($formhash == FORMHASH && $act == 'ok'){
    $updateData = array();
    $updateData['renzheng'] = 1;
    C::t('#tom_love#tom_love')->update($_GET['uid'],$updateData);
    $updateData = array();
    $updateData['renzheng_status'] = 2;
    C::t('#tom_love#tom_love_renzheng')->update($_GET['id'],$updateData);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
}else if($formhash == FORMHASH && $act == 'no'){
    if(submitcheck('submit')){
        
        $content    = isset($_GET['content'])? addslashes($_GET['content']):'';
        $uid          = isset($_GET['uid'])? intval($_GET['uid']):0;
        
        $updateData = array();
        $updateData['renzheng'] = 0;
        C::t('#tom_love#tom_love')->update($_GET['uid'],$updateData);
        $updateData = array();
        $updateData['renzheng_status'] = 3;
        C::t('#tom_love#tom_love_renzheng')->update($_GET['id'],$updateData);
        $insertData = array();
        $insertData['user_id']     = $uid;
        $insertData['type']        = 1;
        $insertData['title']       = $Lang['renzheng_status3_title'];
        $insertData['content']     = $content;
        $insertData['tz_time']     = TIMESTAMP;
        $insertData['is_read']     = 0;
        C::t('#tom_love#tom_love_tz')->insert($insertData);
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        $fenhao = $Lang['fenhao'];
        showformheader($modFromUrl.'&act=no&id='.$_GET['id'].'&uid='.$_GET['uid'].'&formhash='.FORMHASH);
        showtableheader();
        echo '<tr><th colspan="15" class="partition">' . $Lang['renzheng_status3_title'] . '</th></tr>';
        tomshowsetting(array('title'=>$Lang['renzheng_status3_msg'],'name'=>'content','value'=>'','msg'=>''),"textarea");
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
}else{
    set_list_url("tom_love_admin_rz_list");
    
    $user_id        = isset($_GET['user_id'])? intval($_GET['user_id']):''; 
    
    $where = " AND renzheng_status IN(1,2,3) ";
    if(!empty($user_id)){
        $where.= " AND user_id={$user_id} ";
    }
    
    $pagesize = 10;
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    $start = ($page-1)*$pagesize;	
    $count = C::t('#tom_love#tom_love_renzheng')->fetch_all_count(" {$where} ");
    $renzhengList = C::t('#tom_love#tom_love_renzheng')->fetch_all_list(" {$where} ","ORDER BY renzheng_time DESC,id DESC",$start,$pagesize);
    
    showformheader($modFromUrl.'&formhash='.FORMHASH);
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $Lang['search_list'] . '</th></tr>';
    echo '<tr><td width="100" align="right"><b> ID </b></td><td><input name="user_id" type="text" value="'.$user_id.'" size="40" /></td></tr>';
    showsubmit('submit', 'submit');
    showtablefooter();
    showformfooter();
    
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $Lang['renzheng_list'] . '</th></tr>';
    echo '<tr class="header">';
    echo '<th>ID</th>';
    echo '<th>' . $Lang['nickname'] . '</th>';
    echo '<th>' . $Lang['renzheng_xm'] . '</th>';
    echo '<th>' . $Lang['renzheng_tel'] . '</th>';
    echo '<th>' . $Lang['renzheng_sfzh'] . '</th>';
    echo '<th>' . $Lang['renzheng_content'] . '</th>';
    echo '<th>' . $Lang['renzheng_pic_z'] . '</th>';
    echo '<th>' . $Lang['renzheng_pic_f'] . '</th>';
    echo '<th>' . $Lang['renzheng_pic_s'] . '</th>';
    echo '<th>' . $Lang['renzheng_status'] . '</th>';
    echo '<th>' . $Lang['renzheng_time'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    foreach ($renzhengList as $key => $value){
        $renzhengTime = dgmdate($value['renzheng_time'], 'Y-m-d H:i:s',$tomSysOffset);
        $__UserInfo = C::t('#tom_love#tom_love')->fetch_by_id($value['user_id']);
        
        $renzheng_name = '';
        if($value['renzheng_status'] == 1){
            $renzheng_name = $Lang['renzheng_status1'];
        }else if($value['renzheng_status'] == 2){
            $renzheng_name = $Lang['renzheng_status2'];
        }else if($value['renzheng_status'] == 3){
            $renzheng_name = $Lang['renzheng_status3'];
        }
        
        if(!preg_match('/^http/', $value['pic_z'])){
            if(strpos($value['pic_z'], 'source/plugin/tom_love') === false){
                $value['pic_z'] = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$value['pic_z'];
            }else{
                $value['pic_z'] = $value['pic_z'];
            }
        }else{
            $value['pic_z'] = $value['pic_z'];
        }
        if(!preg_match('/^http/', $value['pic_f'])){
            if(strpos($value['pic_f'], 'source/plugin/tom_love') === false){
                $value['pic_f'] = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$value['pic_f'];
            }else{
                $value['pic_f'] = $value['pic_f'];
            }
        }else{
            $value['pic_f'] = $value['pic_f'];
        }
        if(!preg_match('/^http/', $value['pic_s'])){
            if(strpos($value['pic_s'], 'source/plugin/tom_love') === false){
                $value['pic_s'] = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$value['pic_s'];
            }else{
                $value['pic_s'] = $value['pic_s'];
            }
        }else{
            $value['pic_s'] = $value['pic_s'];
        }
        
        echo '<tr>';
        echo '<td>' . $value['user_id'] . '</td>';
        echo '<td><a target="_blank" href="'.$adminBaseUrl.'&tmod=user&act=show&id='.$value['user_id'].'&formhash='.FORMHASH.'">' . $__UserInfo['nickname'] . '</a></td>';
        echo '<td>' . $value['xm'] . '</td>';
        echo '<td>' . $value['tel'] . '</td>';
        echo '<td>' . $value['sfzh'] . '</td>';
        echo '<td>' . $value['content'] . '</td>';
        echo '<td><a href="' . $value['pic_z'] . '" target="_blank"><img src="' . $value['pic_z'] . '" width="60" height="40" /></a></td>';
        echo '<td><a href="' . $value['pic_f'] . '" target="_blank"><img src="' . $value['pic_f'] . '" width="60" height="40" /></a></td>';
        echo '<td><a href="' . $value['pic_s'] . '" target="_blank"><img src="' . $value['pic_s'] . '" width="60" height="40" /></a></td>';
        echo '<td>' . $renzheng_name . '</td>';
        echo '<td>' . $renzhengTime . '</td>';
        echo '<td>';
        echo '<a href="'.$modBaseUrl.'&act=ok&uid='.$value['user_id'].'&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['renzheng_ok'] . '</a>&nbsp;|&nbsp;';
        echo '<a href="'.$modBaseUrl.'&act=no&uid='.$value['user_id'].'&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['renzheng_no'] . '</a>';
        echo '</td>';
        echo '</tr>';
    }
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBaseUrl);	
    showsubmit('', '', '', '', $multi, false);
}