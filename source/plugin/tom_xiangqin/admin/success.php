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

$modBaseUrl = $adminBaseUrl.'&tmod=success';
$modListUrl = $adminListUrl.'&tmod=success';
$modFromUrl = $adminFromUrl.'&tmod=success';

$act = $_GET['act'];
$formhash =  $_GET['formhash']? $_GET['formhash']:'';
if($_GET['act'] == 'add'){
    if(submitcheck('submit')){
        $insertData = array();
        $insertData = __get_post_data();
        C::t('#tom_xiangqin#tom_xiangqin_success')->insert($insertData);
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        tomloadcalendarjs();
        __create_nav_html();
        showformheader($modFromUrl.'&act=add','enctype');
        showtableheader();
        __create_info_html();
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
    
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'del'){
    C::t('#tom_xiangqin#tom_xiangqin_success')->delete_by_id($_GET['id']);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    
}else if($formhash == FORMHASH && $act == 'edit'){
    $successinfo = C::t('#tom_xiangqin#tom_xiangqin_success')->fetch_by_id($_GET['id']);
    if(submitcheck('submit')){
        $updateData = array();
        $updateData = __get_post_data($successinfo);
        C::t('#tom_xiangqin#tom_xiangqin_success')->update($successinfo['id'],$updateData);
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        tomloadcalendarjs();
        __create_nav_html();
        showformheader($modFromUrl.'&act=edit&id='.$_GET['id'],'enctype');
        showtableheader();
        __create_info_html($successinfo);
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
}else{
    
    $page = intval($_GET['page'])> 0 ? intval($_GET['page']) : 1;
    $pagesize = 100;
    $start = ($page-1)*$pagesize;
    $successList = C::t('#tom_xiangqin#tom_xiangqin_success')->fetch_all_list("","",$start,$pagesize);
    
    showtableheader();
    showtablefooter();
    __create_nav_html();
    showtableheader();
    echo '<tr class="header">';
    echo '<th>ID</th>';
    echo '<th>' . $Lang['girl_no'] . '</th>';
    echo '<th>' . $Lang['girl_xm'] . '</th>';
    echo '<th>' . $Lang['boy_no'] . '</th>';
    echo '<th>' . $Lang['boy_xm'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    foreach ($successList as $key => $value){
        echo '<tr>';
        echo '<td>' . $value['id'] . '</td>';
        echo '<td>' . $value['girl_no'] . '</td>'; 
        echo '<td>' . $value ['girl_xm']. '</td>';
        echo '<td>' . $value['boy_no'] . '</td>';
        echo '<td>' . $value['boy_xm'] . '</td>';
        echo '<td style="line-height: 25px;">';
        echo '<a href="'.$modBaseUrl.'&act=edit&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['success_edit'] . '</a>&nbsp;&nbsp;|&nbsp;&nbsp;';
        echo '<a href="javascript:void(0);" onclick="del_confirm(\''.$modBaseUrl.'&act=del&id='.$value['id'].'&formhash='.FORMHASH.'\');">' . $Lang['delete'] . '</a>&nbsp;&nbsp;';
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

function __get_post_data($infoArr = array()){
    $data = array();
    
    $girl_no          = isset($_GET['girl_no'])? intval($_GET['girl_no']):0;
    $girl_xm          = isset($_GET['girl_xm'])? addslashes($_GET['girl_xm']):'';
    $boy_no           = isset($_GET['boy_no'])? intval($_GET['boy_no']):0;
    $boy_xm           = isset($_GET['boy_xm'])? addslashes($_GET['boy_xm']):'';

    $data['girl_no']      = $girl_no;
    $data['girl_xm']    = $girl_xm;
    $data['boy_no']       = $boy_no;
    $data['boy_xm']     = $boy_xm;
    
    return $data;
}

function __create_info_html($infoArr = array()){
    global $Lang;
    $options = array(
        'girl_no'      => '',
        'girl_xm'      => '',
        'boy_no'       => '',
        'boy_xm'       => '',
    );
    $options = array_merge($options, $infoArr);
    
    tomshowsetting(array('title'=>$Lang['girl_no'],'name'=>'girl_no','value'=>$options['girl_no'],'msg'=>$Lang['success_girl_no_msg']),"input");
    tomshowsetting(array('title'=>$Lang['girl_xm'],'name'=>'girl_xm','value'=>$options['girl_xm'],'msg'=>$Lang['success_girl_xm_msg']),"input");
    tomshowsetting(array('title'=>$Lang['boy_no'],'name'=>'boy_no','value'=>$options['boy_no'],'msg'=>$Lang['success_boy_no_msg']),"input");
    tomshowsetting(array('title'=>$Lang['boy_xm'],'name'=>'boy_xm','value'=>$options['boy_xm'],'msg'=>$Lang['success_boy_xm_msg']),"input");
    
    return;
}

function __create_nav_html($infoArr = array()){
    global $Lang,$modBaseUrl,$adminBaseUrl;
    tomshownavheader();
    if($_GET['act'] == 'add'){
        tomshownavli($Lang['success_list_title'],$modBaseUrl,false);
        tomshownavli($Lang['success_add'],"",true);
    }else if($_GET['act'] == 'edit'){
        tomshownavli($Lang['success_list_title'],$modBaseUrl,false);
        tomshownavli($Lang['success_add'],$modBaseUrl."&act=add",false);
        tomshownavli($Lang['success_edit'],"",true);
    }else{
        tomshownavli($Lang['success_list_title'],$modBaseUrl,true);
        tomshownavli($Lang['success_add'],$modBaseUrl."&act=add",false);
    }
    tomshownavfooter();
}