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

$xiangqin_id    = isset($_GET['xiangqin_id'])? intval($_GET['xiangqin_id']):0;

$where = " AND order_status=2 ";
if($xiangqin_id > 0){
    $where.= " AND xiangqin_id={$xiangqin_id} ";
}

$pagesize = 100;
$page = intval($_GET['page'])>0? intval($_GET['page']):1;
$start = ($page-1)*$pagesize;	
$count = C::t('#tom_xiangqin#tom_xiangqin_order')->fetch_all_count(" {$where} ");
$orderList = C::t('#tom_xiangqin#tom_xiangqin_order')->fetch_all_list(" {$where} ","ORDER BY id DESC",$start,$pagesize);
showtableheader();
echo '<tr><th colspan="15" class="partition">' . $Lang['order_list'] . '</th></tr>';
echo '<tr class="header">';
echo '<th>' . $Lang['user_id'] . '</th>';
echo '<th>' . $Lang['user_no'] . '</th>';
echo '<th>' . $Lang['xm'] . '</th>';
echo '<th>' . $Lang['order_order_type'] . '</th>';
echo '<th>' . $Lang['order_pay_price'] . '</th>';
echo '<th>' . $Lang['order_pay_time'] . '</th>';
echo '</tr>';
foreach ($orderList as $key => $value){
    $pay_time = dgmdate($value['pay_time'], 'Y-m-d H:i:s',$tomSysOffset);
    $userInfo = C::t('#tom_xiangqin#tom_xiangqin')->fetch_by_id($value['xiangqin_id']);
    $loveInfo  = C::t('#tom_love#tom_love')->fetch_by_id($userInfo['user_id']);
    $vipInfo = C::t('#tom_xiangqin#tom_xiangqin_vip')->fetch_by_id($value['vip_id']);
    echo '<tr>';
    echo '<td>'.$loveInfo['nickname'].'<font color="#fd0d0d">(ID:' . $userInfo['user_id'] . ')</font></td>';
    echo '<td>' . $userInfo['user_no'] . '</td>';
    echo '<td><a target="_blank" href="'.$adminBaseUrl.'&tmod=user&user_no='.$userInfo['user_no'].'&formhash='.FORMHASH.'">' . $userInfo['xm'] . '</a></td>';
    if($value['order_type'] == 1){
        echo '<td>' . $Lang['order_top_type'] .'<font color="#238206">(' . $value['time_value'] . '' . $Lang['order_days']  .')</font></td>';
    }else if($value['order_type'] == 2){
        echo '<td>' . $Lang['order_vip_type']  .'<font color="#238206">(' . $vipInfo['name'] . ')</font></td>';
    }else if($value['order_type'] == 3){
        echo '<td>' . $Lang['order_qianxian_type']  .'<font color="#238206">(' . $value['qianxian_value'] . '' . $Lang['order_ci']  .')</font></td>';
    }
    echo '<td><font color="#fd0d0d">' . $value['pay_price'] . '</font></td>';
    echo '<td>' . $pay_time . '</td>';
    echo '</tr>';
}
showtablefooter();
$multi = multi($count, $pagesize, $page, $modBaseUrl);	
showsubmit('', '', '', '', $multi, false);