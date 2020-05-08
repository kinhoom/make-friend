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

$modBaseUrl = $adminBaseUrl.'&tmod=order';
$modListUrl = $adminListUrl.'&tmod=order';
$modFromUrl = $adminFromUrl.'&tmod=order';

$pagesize = 100;
$page = intval($_GET['page'])>0? intval($_GET['page']):1;
$start = ($page-1)*$pagesize;	
$count = C::t('#tom_love#tom_love_order')->fetch_all_count(" AND order_status=2 ");
$orderList = C::t('#tom_love#tom_love_order')->fetch_all_list(" AND order_status=2 ","ORDER BY id DESC",$start,$pagesize);
showtableheader();
echo '<tr><th colspan="15" class="partition">' . $Lang['order_list'] . '</th></tr>';
echo '<tr class="header">';
echo '<th>' . $Lang['nickname'] . '</th>';
echo '<th>' . $Lang['order_order_type'] . '</th>';
echo '<th>' . $Lang['order_pay_price'] . '</th>';
echo '<th>' . $Lang['order_pay_time'] . '</th>';
echo '</tr>';
foreach ($orderList as $key => $value){
    $pay_time = dgmdate($value['pay_time'], 'Y-m-d H:i:s',$tomSysOffset);
    $userInfo = C::t('#tom_love#tom_love')->fetch_by_id($value['user_id']);
    echo '<tr>';
    echo '<td><a target="_blank" href="'.$adminBaseUrl.'&tmod=user&act=show&id='.$value['user_id'].'&formhash='.FORMHASH.'">' . $userInfo['nickname'] . '</a></td>';
    if($value['order_type'] == 1){
        echo '<td>' . $value['score_value']  . $jyConfig['score_name'] . '</td>';
    }else if($value['order_type'] == 2){
        echo '<td>' . $value['time_value']  . $Lang['order_vip1_value'] . '</td>';
    }

    echo '<td>' . $value['pay_price'] . '</td>';
    echo '<td>' . $pay_time . '</td>';
    echo '</tr>';
}
showtablefooter();
$multi = multi($count, $pagesize, $page, $modBaseUrl);	
showsubmit('', '', '', '', $multi, false);