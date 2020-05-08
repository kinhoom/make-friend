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

$modBaseUrl = $adminBaseUrl.'&tmod=viptype';
$modListUrl = $adminListUrl.'&tmod=viptype';
$modFromUrl = $adminFromUrl.'&tmod=viptype';

if($_GET['act'] == 'add'){
    if(submitcheck('submit')){
        $insertData = array();
        $insertData = __get_post_data();
        C::t('#tom_xiangqin#tom_xiangqin_vip')->insert($insertData);
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        tomloadcalendarjs();
        loadeditorjs();
        __create_nav_html();
        showformheader($modFromUrl.'&act=add','enctype');
        showtableheader();
        __create_info_html();
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
    
}else if($_GET['act'] == 'edit'){
    
    $vipInfo = C::t('#tom_xiangqin#tom_xiangqin_vip')->fetch_by_id($_GET['id']);
    
    if(submitcheck('submit')){
        $updateData = array();
        $updateData = __get_post_data($vipInfo);
        C::t('#tom_xiangqin#tom_xiangqin_vip')->update($vipInfo['id'],$updateData);
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
       
        tomloadcalendarjs();
        loadeditorjs();
        __create_nav_html();
        showformheader($modFromUrl.'&act=edit&id='.$_GET['id'],'enctype');
        showtableheader();
        __create_info_html($vipInfo);
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }

}else if($_GET['act'] == 'import' && $_GET['formhash'] == FORMHASH){
    
    $importArr = array(
        0 => array(
            'name'                  => $Lang['viptype_import_name_1'],
            'price'                 => 99,
            'days'                  => 30,
            'qianxian_times'        => 1,
            'tsort'                 => 1,
        ),
        1 => array(
            'name'                  => $Lang['viptype_import_name_2'],
            'price'                 => 199,
            'days'                  => 90,
            'qianxian_times'        => 2,
            'tsort'                 => 2,
        ),
        2 => array(
            'name'                  => $Lang['viptype_import_name_3'],
            'price'                 => 499,
            'days'                  => 365,
            'qianxian_times'        => 10,
            'tsort'                 => 3,
        ),
    );
    
    foreach($importArr as $key => $value){
        $insertData = array();
        $insertData['name']       = $value['name'];
        $insertData['price']      = $value['price'];
        $insertData['days']       = $value['days'];
        $insertData['qianxian_times']= $value['qianxian_times'];
        $insertData['vsort']      = $value['tsort'];
        C::t('#tom_xiangqin#tom_xiangqin_vip')->insert($insertData);
    }
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'del'){
    
    C::t('#tom_xiangqin#tom_xiangqin_vip')->delete_by_id($_GET['id']);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    
}else {
    
  $pagesize   = 10;
  $page       = intval($_GET['page'])>0? intval($_GET['page']):1;
  $start      = ($page-1)*$pagesize;	
  $count      = C::t('#tom_xiangqin#tom_xiangqin_vip')->fetch_all_count("");
  $vipList    = C::t('#tom_xiangqin#tom_xiangqin_vip')->fetch_all_list(""," ",$start,$pagesize);
  
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $Lang['vip_help_title'] . '</th></tr>';
    echo '<tr><td  class="tipsblock" s="1"><ul id="tipslis">';
    echo '<li><a href="javascript:void(0);" onclick="import_confirm(\''.$modBaseUrl.'&act=import&formhash='.FORMHASH.'\');" class="addtr" ><font color="#F60">'.$Lang['viptype_import'].'</font></a></li>';
    echo '</ul></td></tr>';
    showtablefooter();

    __create_nav_html();
    showtableheader();
    echo '<tr class="header">';
    echo '<th>' . $Lang['vip_name'] . '</th>';
    echo '<th>' . $Lang['vip_price'] . '</th>';
    echo '<th>' . $Lang['vip_days'] . '</th>';
    echo '<th>' . $Lang['vip_qianxian_times'] . '</th>';
    echo '<th>' . $Lang['vip_chakan_times'] . '</th>';
    //echo '<th>' . $Lang['vip_picurl'] . '</th>';
    echo '<th>' . $Lang['paixu'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    $i = 1;
    foreach ($vipList as $key => $value) {
        if(!preg_match('/^http/', $value['vip_picurl'])){
            if(strpos($value['vip_picurl'], 'source/plugin/') === false){
                $vip_picurl = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$value['vip_picurl'];
            }else{
                $vip_picurl = $_G['siteurl'].$value['vip_picurl'];
            }
        }else{
            $vip_picurl = $value['vip_picurl'];
        }
        echo '<tr>';
        echo '<td>' . $value['name'] . '</td>';
        echo '<td>' . $value['price'] . '</td>';
        echo '<td>' . $value['days'] . '</td>';
        echo '<td><font color="#fd0d0d">' . $value['qianxian_times'] . '</font></td>';
        if($value['chakan_times'] > 0){
            echo '<td><font color="#fd0d0d">' . $value['chakan_times'] . '</font></td>';
        }else{
            echo '<td><font color="#8e8e8e">' . $Lang['vip_chakan_times_0'] . '</font></td>';
        }
        //echo '<td>' . '<img style="height:30px;width:60px;" src="' .$vip_picurl. '">' . '</td>';
        echo '<td>' . $value['vsort'] . '</td>';
        echo '<td>';
        echo '<a href="'.$modBaseUrl.'&act=edit&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['edit']. '</a>&nbsp;|&nbsp;';
        echo '<a href="javascript:void(0);" onclick="del_confirm(\''.$modBaseUrl.'&act=del&id='.$value['id'].'&formhash='.FORMHASH.'\');">' . $Lang['delete'] . '</a>';
        echo '</td>';
        echo '</tr>';
        
        $i++;
    }
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBasePageUrl);	
    showsubmit('', '', '', '', $multi, false);
    
    
    $jsstr = <<<EOF
<script type="text/javascript">
function import_confirm(url){
  var r = confirm("{$Lang['viptype_import_msg']}")
  if (r == true){
    window.location = url;
  }else{
    return false;
  }
}
            
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
    
    $name           = isset($_GET['name'])? addslashes($_GET['name']):'';
    $price          = isset($_GET['price'])? floatval($_GET['price']):0.00;
    $days           = isset($_GET['days'])? intval($_GET['days']):0;
    $qianxian_times = isset($_GET['qianxian_times'])? intval($_GET['qianxian_times']):0;
    $chakan_times   = isset($_GET['chakan_times'])? intval($_GET['chakan_times']):0;
    $vsort          = isset($_GET['vsort'])? intval($_GET['vsort']):100;
    
    $vip_picurl     = "";
    if($_GET['act'] == 'add'){
        $vip_picurl        = tomuploadFile("vip_picurl");
    }else if($_GET['act'] == 'edit'){
        $vip_picurl        = tomuploadFile("vip_picurl",$infoArr['vip_picurl']);
    }
    
    $data['name']               = $name;
    $data['price']              = $price;
    $data['days']               = $days;
    $data['qianxian_times']     = $qianxian_times;
    $data['chakan_times']       = $chakan_times;
    //$data['vip_picurl']         = $vip_picurl;
    $data['vsort']              = $vsort;
    
    return $data;
}

function __create_info_html($infoArr = array()){
    global $Lang;
    $options = array(
        'name'           => '',
        'price'          => 0.00,
        'days'           => 0,
        'qianxian_times' => 0,
        'chakan_times'   => 0,
        'vip_picurl'     => '',
        'vsort'          => 0,
    );
    $options = array_merge($options, $infoArr);
    
    tomshowsetting(array('title'=>$Lang['vip_name'],'name'=>'name','value'=>$options['name'],'msg'=>$Lang['vip_name_msg']),"input");
    tomshowsetting(array('title'=>$Lang['vip_price'],'name'=>'price','value'=>$options['price'],'msg'=>$Lang['vip_price_msg']),"input");
    tomshowsetting(array('title'=>$Lang['vip_days'],'name'=>'days','value'=>$options['days'],'msg'=>$Lang['vip_days_msg']),"input");
    tomshowsetting(array('title'=>$Lang['vip_qianxian_times'],'name'=>'qianxian_times','value'=>$options['qianxian_times'],'msg'=>$Lang['vip_qianxian_times_msg']),"input");
    tomshowsetting(array('title'=>$Lang['vip_chakan_times'],'name'=>'chakan_times','value'=>$options['chakan_times'],'msg'=>$Lang['vip_chakan_times_msg']),"input");
    //tomshowsetting(array('title'=>$Lang['vip_picurl'],'name'=>'vip_picurl','value'=>$options['vip_picurl'],'msg'=>$Lang['vip_vip_picurl_msg']),"file");
    tomshowsetting(array('title'=>$Lang['vip_vsort'],'name'=>'vsort','value'=>$options['vsort'],'msg'=>$Lang['vip_vsort_msg']),"input");
    return;
}
function __create_nav_html($infoArr = array()){
    global $Lang,$modBaseUrl,$adminBaseUrl;
    tomshownavheader();
    if($_GET['act'] == 'add'){
        tomshownavli($Lang['vip_type'],$modBaseUrl,false);
        tomshownavli($Lang['vip_add_type'],"",true);
    }else if($_GET['act'] == 'edit'){
        tomshownavli($Lang['vip_type'],$modBaseUrl,false);
        tomshownavli($Lang['vip_add_type'],$modBaseUrl."&act=add",false);
        tomshownavli($Lang['vip_edit_type'],"",true);
    }else{
        tomshownavli($Lang['vip_type'],$modBaseUrl,true);
        tomshownavli($Lang['vip_add_type'],$modBaseUrl."&act=add",false);
    }
    tomshownavfooter();
}