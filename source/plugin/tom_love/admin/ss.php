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

$modBaseUrl = $adminBaseUrl.'&tmod=ss'; 
$modListUrl = $adminListUrl.'&tmod=ss';
$modFromUrl = $adminFromUrl.'&tmod=ss';

$get_list_url_value = get_list_url("tom_love_admin_ss_list");
if($get_list_url_value){
    $modListUrl = $get_list_url_value;
}

$act = $_GET['act'];
$formhash =  $_GET['formhash']? $_GET['formhash']:'';
if($formhash == FORMHASH && $act == 'del'){
    C::t('#tom_love#tom_love_shuoshuo')->delete($_GET['id']);
    C::t('#tom_love#tom_love_shuoshuo_photo')->delete_by_ssid($_GET['id']);
    C::t('#tom_love#tom_love_shuoshuo_reply')->delete_by_ssid($_GET['id']);
    C::t('#tom_love#tom_love_shuoshuo_zan')->delete_by_ssid($_GET['id']);
    
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
}else if($formhash == FORMHASH && $act == 'delReply'){
    $replyInfo = C::t('#tom_love#tom_love_shuoshuo_reply')->fetch_by_id($_GET['id']);
    C::t('#tom_love#tom_love_shuoshuo_reply')->delete($_GET['id']);
    $ssReplyDataCount = C::t('#tom_love#tom_love_shuoshuo_reply')->fetch_all_count(" AND ss_id={$replyInfo['ss_id']} ");
    $updateData = array();
    $updateData['reply_count'] = $ssReplyDataCount;
    C::t('#tom_love#tom_love_shuoshuo')->update($replyInfo['ss_id'],$updateData);
    
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
}else{
    
    set_list_url("tom_love_admin_ss_list");
    
    $pagesize = 10;
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    $start = ($page-1)*$pagesize;	
    $count = C::t('#tom_love#tom_love_shuoshuo')->fetch_all_count("");
    $gbList = C::t('#tom_love#tom_love_shuoshuo')->fetch_all_list("","ORDER BY ss_time DESC",$start,$pagesize);
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $Lang['gaibai_list'] . '</th></tr>';
    echo '<tr class="header">';
    echo '<th>ID</th>';
    echo '<th>' . $Lang['nickname'] . '</th>';
    echo '<th>' . $Lang['ss_content'] . '</th>';
    echo '<th>' . $Lang['ss_pic'] . '</th>';
    echo '<th>' . $Lang['ss_time'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    foreach ($gbList as $key => $value){
        $ssTime = dgmdate($value['ss_time'], 'Y-m-d H:i:s',$tomSysOffset);
        $__UserInfo = C::t('#tom_love#tom_love')->fetch_by_id($value['user_id']);
        $photoList = C::t('#tom_love#tom_love_shuoshuo_photo')->fetch_all_list("AND ss_id = {$value['id']}", "ORDER BY id DESC", 0, 2);

        echo '<tr style="background-color: #FCFAFA;">';
        echo '<td><b>' . $value['id'] . '</b></td>';
        echo '<td><a target="_blank" href="'.$adminBaseUrl.'&tmod=user&act=show&id='.$value['user_id'].'&formhash='.FORMHASH.'">' . $__UserInfo['nickname'] . '</a></td>';
        echo '<td>' . $value['content'] . '</td>';
        echo '<td>';
        if(is_array($photoList) && !empty($photoList)){
            foreach ($photoList as $k => $v){
                if(!preg_match('/^http/', $v['picurl'])){
                    if(strpos($v['picurl'], 'source/plugin/tom_love') === false){
                        $v['picurl'] = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$v['picurl'];
                    }else{
                        $v['picurl'] = $v['picurl'];
                    }
                }
                echo '<a style="display:inline-block;" href="'.$v['picurl'].'" target="_blank"><img style="height:40px;" src="' . $v['picurl'] . '"></a>&nbsp;&nbsp;';
            }
        }else{
            echo ' -- ';
        }
        echo '</td>';
        echo '<td>' . $ssTime . '</td>';
        echo '<td>';
        echo '<a href="'.$modBaseUrl.'&act=del&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['ss_del'] . '</a>';
        echo '</td>';
        echo '</tr>';
        
        $ssReplyData = C::t('#tom_love#tom_love_shuoshuo_reply')->fetch_all_list(" AND ss_id={$value['id']} ","ORDER BY id DESC",0,50);
        if(is_array($ssReplyData) && !empty($ssReplyData)){
            foreach ($ssReplyData as $k => $v){
                
                echo '<tr>';
                echo '<td><img src="source/plugin/tom_love/images/ss_admin_ico.png"/></td>';
                echo '<td><a target="_blank" href="'.$adminBaseUrl.'&tmod=user&act=show&id='.$v['reply_user_id'].'&formhash='.FORMHASH.'">' . $v['reply_user_nickname'] . '</a></td>';
                echo '<td>' . $v['content'] . '</td>';
                echo '<td>-</td>';
                echo '<td>';
                echo '<a href="'.$modBaseUrl.'&act=delReply&id='.$v['id'].'&formhash='.FORMHASH.'">' . $Lang['ss_reply_del'] . '</a>';
                echo '</td>';
                echo '</tr>';
                
            }
        }
        
        
    }
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBaseUrl);	
    showsubmit('', '', '', '', $multi, false);
}