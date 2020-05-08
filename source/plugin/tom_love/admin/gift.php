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

$modBaseUrl = $adminBaseUrl.'&tmod=gift';
$modListUrl = $adminListUrl.'&tmod=gift';
$modFromUrl = $adminFromUrl.'&tmod=gift';

$act = $_GET['act'];
$formhash =  $_GET['formhash']? $_GET['formhash']:'';
$get_list_url_value = get_list_url("tom_love_admin_gift_list");
if($get_list_url_value){
    $modListUrl = $get_list_url_value;
}
if($act == 'add'){
    if(submitcheck('submit')){
        $insertData = array();
        $insertData = __get_post_data();
        C::t('#tom_love#tom_love_gift')->insert($insertData);
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        loadeditorjs();
        __create_nav_html();
        showformheader($modFromUrl.'&act=add','enctype');
        showtableheader();
        __create_info_html();
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
    
}else if($act == 'edit'){
    $giftInfo = C::t('#tom_love#tom_love_gift')->fetch_by_id($_GET['id']);
    if(submitcheck('submit')){
        $updateData = array();
        $updateData = __get_post_data($giftInfo);
        C::t('#tom_love#tom_love_gift')->update($_GET['id'], $updateData);
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        loadeditorjs();
        __create_nav_html();
        showformheader($modFromUrl.'&act=edit&id='.$_GET['id'],'enctype');
        showtableheader();
        __create_info_html($giftInfo);
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
}else if($formhash == FORMHASH && $act == 'del'){
    C::t('#tom_love#tom_love_gift')->delete_by_id($_GET['id']);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');

}else if($formhash == FORMHASH && $act == 'import'){
    $gift = array(
        0 => array(
            'gift_name'   => $Lang['gift_pic_1'],
            'gift_picurl' => 'source/plugin/tom_love/images/gift/gift-01.jpg',
            'score_num'   => 20,
            'flowers_num' => 20,
            'is_show'     => 0,
            'add_time'    => TIMESTAMP,
        ),
        1 => array(
            'gift_name'   => $Lang['gift_pic_2'],
            'gift_picurl' => 'source/plugin/tom_love/images/gift/gift-02.jpg',
            'score_num'   => 80,
            'flowers_num' => 80,
            'is_show'     => 0,
            'add_time'    => TIMESTAMP,
        ),
        2 => array(
            'gift_name'   => $Lang['gift_pic_3'],
            'gift_picurl' => 'source/plugin/tom_love/images/gift/gift-03.jpg',
            'score_num'   => 10,
            'flowers_num' => 10,
            'is_show'     => 1,
            'add_time'    => TIMESTAMP,
        ),
        3 => array(
            'gift_name'   => $Lang['gift_pic_4'],
            'gift_picurl' => 'source/plugin/tom_love/images/gift/gift-04.jpg',
            'score_num'   => 100,
            'flowers_num' => 100,
            'is_show'     => 0,
            'add_time'    => TIMESTAMP,
        ),
        4 => array(
            'gift_name'   => $Lang['gift_pic_5'],
            'gift_picurl' => 'source/plugin/tom_love/images/gift/gift-05.jpg',
            'score_num'   => 10,
            'flowers_num' => 10,
            'is_show'     => 0,
            'add_time'    => TIMESTAMP,
        ),
        5 => array(
            'gift_name'   => $Lang['gift_pic_6'],
            'gift_picurl' => 'source/plugin/tom_love/images/gift/gift-06.jpg',
            'score_num'   => 10,
            'flowers_num' => 10,
            'is_show'     => 0,
            'add_time'    => TIMESTAMP,
        ),
        6 => array(
            'gift_name'   => $Lang['gift_pic_7'],
            'gift_picurl' => 'source/plugin/tom_love/images/gift/gift-07.jpg',
            'score_num'   => 60,
            'flowers_num' => 60,
            'is_show'     => 0,
            'add_time'    => TIMESTAMP,
        ),
        7 => array(
            'gift_name'   => $Lang['gift_pic_8'],
            'gift_picurl' => 'source/plugin/tom_love/images/gift/gift-08.jpg',
            'score_num'   => 30,
            'flowers_num' => 30,
            'is_show'     => 0,
            'add_time'    => TIMESTAMP,
        ),
        8 => array(
            'gift_name'   => $Lang['gift_pic_9'],
            'gift_picurl' => 'source/plugin/tom_love/images/gift/gift-09.jpg',
            'score_num'   => 20,
            'flowers_num' => 20,
            'is_show'     => 0,
            'add_time'    => TIMESTAMP,
        ),
        9 => array(
            'gift_name'   => $Lang['gift_pic_10'],
            'gift_picurl' => 'source/plugin/tom_love/images/gift/gift-10.jpg',
            'score_num'   => 30,
            'flowers_num' => 30,
            'is_show'     => 0,
            'add_time'    => TIMESTAMP,
        ),
        10 => array(
            'gift_name'   => $Lang['gift_pic_11'],
            'gift_picurl' => 'source/plugin/tom_love/images/gift/gift-11.jpg',
            'score_num'   => 20,
            'flowers_num' => 20,
            'is_show'     => 0,
            'add_time'    => TIMESTAMP,
        ),
        11 => array(
            'gift_name'   => $Lang['gift_pic_12'],
            'gift_picurl' => 'source/plugin/tom_love/images/gift/gift-12.jpg',
            'score_num'   => 10,
            'flowers_num' => 10,
            'is_show'     => 0,
            'add_time'    => TIMESTAMP,
        ),
        12 => array(
            'gift_name'   => $Lang['gift_pic_13'],
            'gift_picurl' => 'source/plugin/tom_love/images/gift/gift-13.jpg',
            'score_num'   => 30,
            'flowers_num' => 30,
            'is_show'     => 0,
            'add_time'    => TIMESTAMP,
        ),
        13 => array(
            'gift_name'   => $Lang['gift_pic_14'],
            'gift_picurl' => 'source/plugin/tom_love/images/gift/gift-14.jpg',
            'score_num'   => 10,
            'flowers_num' => 10,
            'is_show'     => 0,
            'add_time'    => TIMESTAMP,
        ),
        14 => array(
            'gift_name'   => $Lang['gift_pic_15'],
            'gift_picurl' => 'source/plugin/tom_love/images/gift/gift-15.jpg',
            'score_num'   => 10,
            'flowers_num' => 10,
            'is_show'     => 0,
            'add_time'    => TIMESTAMP,
        ),
        15 => array(
            'gift_name'   => $Lang['gift_pic_16'],
            'gift_picurl' => 'source/plugin/tom_love/images/gift/gift-16.jpg',
            'score_num'   => 10,
            'flowers_num' => 10,
            'is_show'     => 0,
            'add_time'    => TIMESTAMP,
        ),
        16 => array(
            'gift_name'   => $Lang['gift_pic_17'],
            'gift_picurl' => 'source/plugin/tom_love/images/gift/gift-17.jpg',
            'score_num'   => 10,
            'flowers_num' => 10,
            'is_show'     => 0,
            'add_time'    => TIMESTAMP,
        ),
        17 => array(
            'gift_name'   => $Lang['gift_pic_18'],
            'gift_picurl' => 'source/plugin/tom_love/images/gift/gift-18.jpg',
            'score_num'   => 60,
            'flowers_num' => 60,
            'is_show'     => 0,
            'add_time'    => TIMESTAMP,
        ),
    );
    foreach($gift as $key => $value){
        C::t('#tom_love#tom_love_gift')->insert($value);
    }
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    
}else{
    set_list_url("tom_love_admin_gift_list");
    $pagesize = 10;
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    $start = ($page-1)*$pagesize;	
    $count = C::t('#tom_love#tom_love_gift')->fetch_all_count("");
    $giftList = C::t('#tom_love#tom_love_gift')->fetch_all_list("","ORDER BY add_time DESC",$start,$pagesize);
    showtableheader();
    $Lang['love_help_3']  = str_replace("{SITEURL}", $_G['siteurl'], $Lang['love_help_3']);
    echo '<tr><th colspan="15" class="partition">' . $Lang['love_help_title'] . '</th></tr>';
    echo '<tr><td  class="tipsblock" s="1"><ul id="tipslis">';
    echo '<li>' . $Lang['gift_do_msg'].'<a href="'.$modBaseUrl.'&act=import&formhash='.FORMHASH.'">' .$Lang['gift_do_title']. '</a></li>';
    echo '</ul></td></tr>';
    showtablefooter();
    __create_nav_html();
    showtableheader();
    echo '<tr class="header">';
    echo '<th>ID</th>';
    echo '<th>' . $Lang['gift_shop_name'] . '</th>';
    echo '<th>' . $Lang['gift_shop_picurl'] . '</th>';
    echo '<th>' . $Lang['gift_shop_score_num'] . '</th>';
    echo '<th>' . $Lang['gift_shop_flowers_num'] . '</th>';
    echo '<th>' . $Lang['gift_shop_is_show'] . '</th>';
    echo '<th>' . $Lang['gift_shop_add_time'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    foreach ($giftList as $key => $value){
        if($value['is_show'] == 1){
            $value['is_show'] =  $Lang['gift_shop_is_show_1'];
        }else{
            $value['is_show'] =  $Lang['gift_shop_is_show_0'];
        }
        if(!preg_match('/^http/',$value['gift_picurl'])){
            if(strpos($value['gift_picurl'], 'source/plugin/tom_love') === false){
                $gift_picurl = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$value['gift_picurl'];
            }else{
                $gift_picurl = $value['gift_picurl'];
            }
        }else{
            $gift_picurl = $value['gift_picurl'];
        }
        
        echo '<tr>';
        echo '<td>' . $value['id'] . '</td>';
        echo '<td>' . $value['gift_name'] . '</td>';
        echo '<td><img width="40" height="40" src="' . $gift_picurl . '"></td>';
        echo '<td>' . $value['score_num'] . '</td>';
        echo '<td>' . $value['flowers_num'] . '</td>';
        echo '<td>' . $value['is_show'] . '</td>';
        echo '<td>' . dgmdate($value['add_time'], 'Y-m-d H:i:s',$tomSysOffset) . '</td>';
        echo '<td>';
        echo '<a href="'.$modBaseUrl.'&act=edit&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['gift_shop_edit'] . '</a>&nbsp;|&nbsp;';
        echo '<a href="'.$modBaseUrl.'&act=del&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['delete'] . '</a>';
        echo '</td>';
        echo '</tr>';
    }
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBaseUrl);	
    showsubmit('', '', '', '', $multi, false);
}

function __get_post_data($infoArr = array()){
    global $jyConfig;
    $data = array();
    
    $gift_name    = isset($_GET['gift_name'])? addslashes($_GET['gift_name']):'';
    $score_num    = isset($_GET['score_num'])? intval($_GET['score_num']):0;
    $flowers_num  = isset($_GET['flowers_num'])? intval($_GET['flowers_num']):0;
    $add_time     = TIMESTAMP;
    $is_show      = isset($_GET['is_show'])? addslashes($_GET['is_show']):1;
    
    $gift_picurl = "";
    if($_GET['act'] == 'add'){
        $gift_picurl        = tomuploadFile("gift_picurl");
    }else if($_GET['act'] == 'edit'){
        $gift_picurl        = tomuploadFile("gift_picurl",$infoArr['goods_picurl']);
    }

    $data['gift_name']      = $gift_name;
    $data['gift_picurl']    = $gift_picurl;
    $data['score_num']      = $score_num;
    $data['flowers_num']    = $flowers_num;
    $data['add_time']       = $add_time;
    $data['is_show']        = $is_show;
    
    
    return $data;
}

function __create_info_html($infoArr = array()){
    global $Lang;
    $options = array(
        'gift_name'         => '',
        'gift_picurl'       => '',
        'score_num'         => '',
        'flowers_num'       => '',
        'is_show'           => 1,
        
    );
    $options = array_merge($options, $infoArr);
    
    tomshowsetting(array('title'=>$Lang['gift_shop_name'],'name'=>'gift_name','value'=>$options['gift_name'],'msg'=>$Lang['gift_shop_name_msg']),"input");
    tomshowsetting(array('title'=>$Lang['gift_shop_picurl'],'name'=>'gift_picurl','value'=>$options['gift_picurl'],'msg'=>$Lang['gift_shop_picurl_msg']),"file");
    tomshowsetting(array('title'=>$Lang['gift_shop_score_num'],'name'=>'score_num','value'=>$options['score_num'],'msg'=>$Lang['gift_shop_score_num_msg']),"input");
    tomshowsetting(array('title'=>$Lang['gift_shop_flowers_num'],'name'=>'flowers_num','value'=>$options['flowers_num'],'msg'=>$Lang['gift_shop_flowers_num_msg']),"input");
    
    $is_show_item = array(1=>$Lang['gift_shop_is_show_1'],2=>$Lang['gift_shop_is_show_0']);
    tomshowsetting(array('title'=>$Lang['gift_shop_is_show'],'name'=>'is_show','value'=>$options['is_show'],'msg'=>$Lang['gift_shop_is_show_msg'], 'item'=>$is_show_item),"radio");
    return;
}

function __create_nav_html(){
    global $Lang,$modBaseUrl,$adminBaseUrl;
    tomshownavheader();
    if($_GET['act'] == 'add'){
        tomshownavli($Lang['gift_shop_title'],$modBaseUrl,false);
        tomshownavli($Lang['gift_shop_add'],"",true);
    }else if($_GET['act'] == 'edit'){
        tomshownavli($Lang['gift_shop_title'],$modBaseUrl,false);
        tomshownavli($Lang['gift_shop_add'],$modBaseUrl."&act=add",false);
        tomshownavli($Lang['gift_shop_edit'],"",true);
    }else{
        tomshownavli($Lang['gift_shop_title'],$modBaseUrl,true);
        tomshownavli($Lang['gift_shop_add'],$modBaseUrl."&act=add",false);
    }
    tomshownavfooter();
}