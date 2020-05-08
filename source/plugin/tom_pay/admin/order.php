<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：大叔来 www.dasuhlai.com
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$modBaseUrl = $adminBaseUrl.'&tmod=order';
$modListUrl = $adminListUrl.'&tmod=order';
$modFromUrl = $adminFromUrl.'&tmod=order';

if($_GET['act'] == 'add'){
}else{
    
    $pagesize = 15;
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    $start = ($page-1)*$pagesize;	
    $count = C::t('#tom_pay#tom_pay_order')->fetch_all_count(" ");
    $orderList = C::t('#tom_pay#tom_pay_order')->fetch_all_list(" ","ORDER BY id DESC",$start,$pagesize);
    
    showtableheader();
    $Lang['pay_help_1']  = str_replace("{SITEURL}", $_G['siteurl'], $Lang['pay_help_1']);
    echo '<tr><th colspan="15" class="partition">' . $Lang['pay_help_title'] . '</th></tr>';
    echo '<tr><td  class="tipsblock" s="1"><ul id="tipslis">';
    echo '<li>' . $Lang['pay_help_1'] . '</font></a></li>';
    echo '</ul></td></tr>';
    showtablefooter();
    
    $todayPayPrice = C::t('#tom_pay#tom_pay_order')->fetch_all_sun_pay_price(" AND pay_time > $nowDayTime AND order_status=2 ");
    $monthPayPrice = C::t('#tom_pay#tom_pay_order')->fetch_all_sun_pay_price(" AND pay_time > $nowMonthTime AND order_status=2 ");
    $allPayPrice = C::t('#tom_pay#tom_pay_order')->fetch_all_sun_pay_price(" AND order_status=2 ");
    echo '<div style="background-color: #f1f1f1;line-height: 30px;height: 30px;margin-top: 10px;" >&nbsp;&nbsp;';
    echo $Lang['today_pay_price_title'].'<font color="#fd0d0d">('.$todayPayPrice.')</font>&nbsp;&nbsp;';
    echo $Lang['month_pay_price_title'].'<font color="#fd0d0d">('.$monthPayPrice.')</font>&nbsp;&nbsp;';
    echo $Lang['all_pay_price_title'].'<font color="#fd0d0d">('.$allPayPrice.')</font>&nbsp;&nbsp;';
    echo '</div>';
    
    showtableheader();
    echo '<tr class="header">';
    echo '<th>' . $Lang['order_no'] . '</th>';
    echo '<th style="width: 200px;">' . $Lang['goods_name'] . '</th>';
    echo '<th>' . $Lang['pay_price'] . '</th>';
    echo '<th>' . $Lang['payment'] . '</th>';
    echo '<th>' . $Lang['order_status'] . '</th>';
    echo '<th>' . $Lang['add_time'] . '</th>';
    echo '<th>' . $Lang['order_time'] . '</th>';
    echo '<th>' . $Lang['pay_time'] . '</th>';
    echo '</tr>';
    
    $i = 1;
    foreach ($orderList as $key => $value) {
        echo '<tr>';
        echo '<td>' . $value['order_no'] . '</td>';
        echo '<td>' . $value['goods_name'] . '</td>';
        echo '<td><font color="#238206">' . $value['pay_price'] . '</font></td>';
        if($value['payment'] == 'wxpay_jsapi'){
            echo '<td><font color="#238206">' . $Lang['wxpay_jsapi'] . '</font></td>';
        }else if($value['payment'] == 'wxpay_native'){
            echo '<td><font color="#238206">' . $Lang['wxpay_native'] . '</font></td>';
        }else if($value['payment'] == 'wxpay_h5'){
            echo '<td><font color="#238206">' . $Lang['wxpay_h5'] . '</font></td>';
        }else if($value['payment'] == 'wxpay_xiao'){
            echo '<td><font color="#238206">' . $Lang['wxpay_xiao'] . '</font></td>';
        }else if($value['payment'] == 'alipay_wap'){
            echo '<td><font color="#0894fb">' . $Lang['alipay_wap'] . '</font></td>';
        }else if($value['payment'] == 'qianfan_pay'){
            echo '<td>';
            echo '<font color="#0894fb">' . $Lang['qianfan_pay'] . '(ID:'.$value['qf_order_id'].')</font>';
            if($value['order_status'] == 1 && $value['qf_order_id'] > 0 && (TIMESTAMP - $value['order_time']) < 3500){
                echo '<a href="'.$_G['siteurl'].'source/plugin/tom_pay/qianfanReturn.php?qf_order_id='.$value['qf_order_id'].'" target="_blank"><font color="#fd0d0d">(' . $Lang['qianfan_pay_btn'] . ')</font></>';
            }
            echo '</td>';
        }else if($value['payment'] == 'appbyme_pay'){
            echo '<td><font color="#0894fb">' . $Lang['appbyme_pay'] . '</font></td>';
        }else if($value['payment'] == 'magapp_pay'){
            echo '<td>';
            echo '<font color="#0894fb">' . $Lang['magapp_pay'] . '<br/>(ID:'.$value['mag_order_id'].')</font>';
            if($value['order_status'] == 1 && $value['mag_order_id'] > 0 && (TIMESTAMP - $value['order_time']) < 3500){
                echo '<a href="'.$_G['siteurl'].'source/plugin/tom_pay/magappReturn.php?mag_order_id='.$value['mag_order_id'].'" target="_blank"><font color="#fd0d0d">(' . $Lang['magapp_pay_btn'] . ')</font></>';
            }
            echo '</td>';
        }else{
            echo '<td>-</td>';
        }
        if($value['order_status'] == 1){
            echo '<td><font color="#fd0d0d">' . $Lang['order_status_1'] . '</font></td>';
        }else if($value['order_status'] == 2){
            echo '<td><font color="#238206">' . $Lang['order_status_2'] . '</font></td>';
        }else if($value['order_status'] == 3){
            echo '<td><font color="#8e8e8e">' . $Lang['order_status_3'] . '</font></td>';
        }else{
            echo '<td><font color="#fd0d0d">' . $Lang['order_status_1'] . '</font></td>';
        }
        if($value['add_time'] > 0){
            echo '<td>' . dgmdate($value['add_time'],"Y-m-d H:i",$tomSysOffset) . '</td>';
        }else{
            echo '<td>-</td>';
        }
        if($value['order_time'] > 0){
            echo '<td>' . dgmdate($value['order_time'],"Y-m-d H:i",$tomSysOffset) . '</td>';
        }else{
            echo '<td>-</td>';
        }
        if($value['pay_time'] > 0){
            echo '<td>' . dgmdate($value['pay_time'],"Y-m-d H:i",$tomSysOffset) . '</td>';
        }else{
            echo '<td>-</td>';
        }
        echo '</tr>';
        $i++;
    }
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBaseUrl);	
    showsubmit('', '', '', '', $multi, false);
}
