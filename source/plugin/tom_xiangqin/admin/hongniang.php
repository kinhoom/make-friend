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

$modBaseUrl = $adminBaseUrl.'&tmod=hongniang';
$modListUrl = $adminListUrl.'&tmod=hongniang';
$modFromUrl = $adminFromUrl.'&tmod=hongniang';

$act = $_GET['act'];
$formhash =  $_GET['formhash']? $_GET['formhash']:'';
if($_GET['act'] == 'add'){
    if(submitcheck('submit')){
        $insertData = array();
        $insertData = __get_post_data();
        C::t('#tom_xiangqin#tom_xiangqin_hongniang')->insert($insertData);
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
    
}else if($formhash == FORMHASH && $act == 'edit'){
    $hongnianginfo = C::t('#tom_xiangqin#tom_xiangqin_hongniang')->fetch_by_id($_GET['id']);
    if(submitcheck('submit')){
        $updateData = array();
        $updateData = __get_post_data($hongnianginfo);
        C::t('#tom_xiangqin#tom_xiangqin_hongniang')->update($hongnianginfo['id'],$updateData);
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        tomloadcalendarjs();
        __create_nav_html();
        showformheader($modFromUrl.'&act=edit&id='.$_GET['id'],'enctype');
        showtableheader();
        __create_info_html($hongnianginfo);
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'del'){
    C::t('#tom_xiangqin#tom_xiangqin_hongniang')->delete_by_id($_GET['id']);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    
}else{
    $page = intval($_GET['page'])> 0 ? intval($_GET['page']) : 1;
    $pagesize = 100;
    $start = ($page-1)*$pagesize;
    $hongniangList = C::t('#tom_xiangqin#tom_xiangqin_hongniang')->fetch_all_list("","",$start,$pagesize);
    
    showtableheader();
    showtablefooter();
    __create_nav_html();
    showtableheader();
    echo '<tr class="header">';
    echo '<th>ID</th>';
    echo '<th>' . $Lang['xm'] . '</th>';
    echo '<th>' . $Lang['wx'] . '</th>';
    echo '<th>' . $Lang['tel'] . '</th>';
    echo '<th>' . $Lang['hongniang_avatar'] . '</th>';
    echo '<th>' . $Lang['hongniang_qrcode'] . '</th>';
    echo '<th>' . $Lang['hongniang_desc'] . '</th>';
    echo '<th>' . $Lang['hongniang_paixu'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    foreach ($hongniangList as $key => $value){
       if(!preg_match('/^http/', $value['picurl'])){
            $picurl = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$value['picurl'];
        }else{
            $picurl = $value['picurl'];
        }
        if(!preg_match('/^http/', $value['qrcode'])){
            $qrcode = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$value['qrcode'];
        }else{
            $qrcode = $value['qrcode'];
        }
        
        echo '<tr>';
        echo '<td>' . $value['id'] . '</td>';
        echo '<td>' . $value['name'] . '</td>'; 
        echo '<td>' . $value ['wx']. '</td>';
        echo '<td>' . $value['tel'] . '</td>';
        if(empty($value['picurl'])){
          echo '<td>' .'---'. '</td>';
        }else{
           echo '<td>' . '<img style="height:40px;width:40px;" src="' .$picurl. '">' . '</td>'; 
        }
        if(empty($value['qrcode'])){
          echo '<td>' .'---'. '</td>'; 
        }else{
           echo '<td>' . '<img style="height:40px;width:40px;" src="' .$qrcode. '">' . '</td>'; 
        }
        echo '<td>' . $value['desc'] . '</td>';
        echo '<td>' . $value['paixu'] . '</td>';
        echo '<td style="line-height: 25px;">';
        echo '<a href="'.$modBaseUrl.'&act=edit&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['hongniang_edit'] . '</a>&nbsp;&nbsp;|&nbsp;&nbsp;';
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
    
    $name             = isset($_GET['name'])? addslashes($_GET['name']):'';
    $wx               = isset($_GET['wx'])? addslashes($_GET['wx']):0;
    $tel              = isset($_GET['tel'])? addslashes($_GET['tel']):0;
    $picurl = "";
    $qrcode = "";
    if($_GET['act'] == 'add'){
        $picurl        = tomuploadFile("picurl");
    }else if($_GET['act'] == 'edit'){
        $picurl        = tomuploadFile("picurl",$infoArr['picurl']);
    }
    if($_GET['act'] == 'add'){
        $qrcode        = tomuploadFile("qrcode");
    }else if($_GET['act'] == 'edit'){
        $qrcode        = tomuploadFile("qrcode",$infoArr['qrcode']);
    }
    $desc              = isset($_GET['desc'])? addslashes($_GET['desc']):'';
    $paixu             = isset($_GET['paixu'])? intval($_GET['paixu']):0;

    $data['name']      = $name;
    $data['wx']        = $wx;
    $data['tel']       = $tel;
    $data['picurl']    = $picurl;
    $data['qrcode']    = $qrcode;
    $data['desc']      = $desc;
    $data['paixu']     = $paixu;
    
    return $data;
}

function __create_info_html($infoArr = array()){
    global $Lang;
    $options = array(
        'name'       => '',
        'wx'         => '',
        'tel'        => '',
        'picurl'     => '',
        'qrcode'     => '',
        'desc'       => '',
        'paixu'      => '',
    );
    $options = array_merge($options, $infoArr);
    
    tomshowsetting(array('title'=>$Lang['xm'],'name'=>'name','value'=>$options['name'],'msg'=>$Lang['hongniang_name_msg']),"input");
    tomshowsetting(array('title'=>$Lang['wx'],'name'=>'wx','value'=>$options['wx'],'msg'=>$Lang['hongniang_wx_msg']),"input");
    tomshowsetting(array('title'=>$Lang['tel'],'name'=>'tel','value'=>$options['tel'],'msg'=>$Lang['hongniang_tel_msg']),"input");
    tomshowsetting(array('title'=>$Lang['hongniang_avatar'],'name'=>'picurl','value'=>$options['picurl'],'msg'=>$Lang['hongniang_picurl_msg']),"file");
    tomshowsetting(array('title'=>$Lang['hongniang_qrcode'],'name'=>'qrcode','value'=>$options['qrcode'],'msg'=>$Lang['hongniang_qrcode_msg']),"file");
    tomshowsetting(array('title'=>$Lang['hongniang_desc'],'name'=>'desc','value'=>$options['desc'],'msg'=>$Lang['hongniang_desc_msg']),"input");
    tomshowsetting(array('title'=>$Lang['hongniang_paixu'],'name'=>'paixu','value'=>$options['paixu'],'msg'=>$Lang['hongniang_paixu_msg']),"input");
    
    return;
}

function __create_nav_html($infoArr = array()){
    global $Lang,$modBaseUrl,$adminBaseUrl;
    tomshownavheader();
    if($_GET['act'] == 'add'){
        tomshownavli($Lang['hongniang_list_title'],$modBaseUrl,false);
        tomshownavli($Lang['hongniang_add'],"",true);
    }else if($_GET['act'] == 'edit'){
        tomshownavli($Lang['hongniang_list_title'],$modBaseUrl,false);
        tomshownavli($Lang['hongniang_add'],$modBaseUrl."&act=add",false);
        tomshownavli($Lang['hongniang_edit'],"",true);
    }else{
        tomshownavli($Lang['hongniang_list_title'],$modBaseUrl,true);
        tomshownavli($Lang['hongniang_add'],$modBaseUrl."&act=add",false);
    }
    tomshownavfooter();
}