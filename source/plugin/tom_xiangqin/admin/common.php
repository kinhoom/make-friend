<?php

/*
   [Dashulai!] (C)2009-2019 WWW.DASHULAI.COM.
   技术支持/更新维护：官网 https://www.dashulai.com
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$modBaseUrl = $adminBaseUrl.'&tmod=common'; 
$modListUrl = $adminListUrl.'&tmod=common';
$modFromUrl = $adminFromUrl.'&tmod=common';

$commonInfo = C::t('#tom_xiangqin#tom_xiangqin_common')->fetch_by_id(1);
if(!$commonInfo){
    $insertData = array();
    $insertData['id']      = 1;
    C::t('#tom_xiangqin#tom_xiangqin_common')->insert($insertData);
}
if(submitcheck('submit')){
    $updateData = array();
    $updateData = __get_post_data($commonInfo);
    C::t('#tom_xiangqin#tom_xiangqin_common')->update(1,$updateData);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
}else{
    tomloadcalendarjs();
    loadeditorjs();
    __create_nav_html();
    showformheader($modFromUrl,'enctype');
    showtableheader();

    __create_info_html($commonInfo);
    showsubmit('submit', 'submit');
    showtablefooter();
    showformfooter();
}

function __get_post_data($infoArr = array()){
    $data = array();
    
    $xieyi_txt          = isset($_GET['xieyi_txt'])? addslashes($_GET['xieyi_txt']):'';
    $vip_txt            = isset($_GET['vip_txt'])? addslashes($_GET['vip_txt']):'';
    $top_txt            = isset($_GET['top_txt'])? addslashes($_GET['top_txt']):'';
    $qianxian_txt       = isset($_GET['qianxian_txt'])? addslashes($_GET['qianxian_txt']):'';
  
    $data['xieyi_txt']    = $xieyi_txt;
    $data['vip_txt']      = $vip_txt;
    $data['top_txt']      = $top_txt;
    $data['qianxian_txt'] = $qianxian_txt;
    
    return $data;
}

function __create_info_html($infoArr = array()){
    global $Lang;
    $options = array(
        'xieyi_txt'       => '',
        'vip_txt'         => '',
        'top_txt'         => '',
        'qianxian_txt'    => '',
    );
    $options = array_merge($options, $infoArr);
    
    tomshowsetting(array('title'=>$Lang['xieyi_title'],'name'=>'xieyi_txt','value'=>$options['xieyi_txt'],'msg'=>$Lang['xieyi_title_msg']),"edit");
    tomshowsetting(array('title'=>$Lang['vip_title'],'name'=>'vip_txt','value'=>$options['vip_txt'],'msg'=>$Lang['vip_title_msg']),"edit");
    tomshowsetting(array('title'=>$Lang['top_title'],'name'=>'top_txt','value'=>$options['top_txt'],'msg'=>$Lang['top_title_msg']),"edit");
    tomshowsetting(array('title'=>$Lang['qianxians_title'],'name'=>'qianxian_txt','value'=>$options['qianxian_txt'],'msg'=>$Lang['qianxians_title_msg']),"edit");
    return;
}

function __create_nav_html($infoArr = array()){
    global $Lang,$modBaseUrl,$adminBaseUrl;
    tomshownavheader();
    tomshownavli($Lang['common_title'],"",true);
    tomshownavfooter();
}