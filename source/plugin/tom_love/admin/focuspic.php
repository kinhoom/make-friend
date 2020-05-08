<?php
/*
   [Dashulai!] (C)2009-2019 WWW.DASHULAI.COM.
   技术支持/更新维护：官网 https://www.dashulai.com   
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')){
    exit('Access Denied');
}
$modBaseUrl = $adminBaseUrl.'&tmod=focuspic';
$modListUrl = $adminListUrl.'&tmod=focuspic';
$modFromUrl = $adminFromUrl.'&tmod=focuspic';

if($_GET['act'] == 'add'){
    if(submitcheck('submit')){
        $insertData = array();
        $insertData = __get_post_data();
        C::t('#tom_love#tom_love_focuspic')->insert($insertData);
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
    
}else if($_GET['act'] == 'edit' && $_GET['formhash'] == FORMHASH){
    $focuspicInfo = C::t('#tom_love#tom_love_focuspic')->fetch_by_id($_GET['id']);
    if(submitcheck('submit')){
        $updateData = array();
        $updateData = __get_post_data($focuspicInfo);
        C::t('#tom_love#tom_love_focuspic')->update($focuspicInfo['id'],$updateData);
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        tomloadcalendarjs();
        __create_nav_html();
        showformheader($modFromUrl.'&act=edit&id='.$_GET['id'],'enctype');
        showtableheader();
        __create_info_html($focuspicInfo);
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
    
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'del'){
    C::t('#tom_love#tom_love_focuspic')->delete_by_id($_GET['id']);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    
}else{

    $page = intval($_GET['page'])> 0 ? intval($_GET['page']) : 1;
    $pagesize = 100;
    $start = ($page-1)*$pagesize;
    $focuspicList = C::t('#tom_love#tom_love_focuspic')->fetch_all_list("", " ORDER BY fsort ASC,id DESC", $start, $pagesize);

    showtableheader();
    echo '<tr><th colspan="15" class="partition">'.$Lang['focuspic_help_title'].'</th></tr>';
    echo '<tr><td class="tipsblock" s="1"><ul id="tipslis">';
    echo '<li>'.$Lang['focuspic_help_1'].'</li>';
    echo '</ul></td></tr>';
    showtablefooter();
    __create_nav_html();
    showtableheader();
    echo '<tr class="header"> ';
    echo '<th>'.$Lang['focuspic_title'].'</th>';
    echo '<th>'.$Lang['focuspic_picurl'].'</th>';
    echo '<th>'.$Lang['focuspic_link'].'</th>';
    echo '<th>'.$Lang['focuspic_fsort'].'</th>';
    echo '<th>'.$Lang['handle'].'</th>';
    echo '</tr>';

    $i = 1;
    foreach($focuspicList as $key => $value){
        if(!preg_match('/^http/', $value['picurl'])){
            $picurl = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$value['picurl'];
        }else{
            $picurl = $value['picurl'];
        }
        
        echo '<tr>';
        echo '<td>' . $value['title'] . '</td>';
        echo '<td><img src="'.$picurl.'" width="40" /></td>';
        echo '<td>' . $value['link'] . '</td>';
        echo '<td>' . $value['fsort'] . '</td>';
        echo '<td>';
        echo '<a href="'.$modBaseUrl.'&act=edit&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['focuspic_edit']. '</a>&nbsp;|&nbsp;';
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
    
    $title           = isset($_GET['title'])? addslashes($_GET['title']):'';
    $link           = isset($_GET['link'])? addslashes($_GET['link']):'';
    $fsort       = isset($_GET['fsort'])? intval($_GET['fsort']):10;
    
    $picurl = "";
    if($_GET['act'] == 'add'){
        $picurl        = tomuploadFile("picurl");
    }else if($_GET['act'] == 'edit'){
        $picurl        = tomuploadFile("picurl",$infoArr['picurl']);
    }

    $data['title']      = $title;
    $data['picurl']     = $picurl;
    $data['link']       = $link;
    $data['fsort']      = $fsort;
    
    return $data;
}

function __create_info_html($infoArr = array()){
    global $Lang;
    $options = array(
        'title'              => '',
        'picurl'         => '',
        'link'          => '',
        'fsort'          => 10,
    );
    $options = array_merge($options, $infoArr);
    
    tomshowsetting(array('title'=>$Lang['focuspic_title'],'name'=>'title','value'=>$options['title'],'msg'=>$Lang['focuspic_title_msg']),"input");
    tomshowsetting(array('title'=>$Lang['focuspic_picurl'],'name'=>'picurl','value'=>$options['picurl'],'msg'=>$Lang['focuspic_picurl_msg']),"file");
    tomshowsetting(array('title'=>$Lang['focuspic_link'],'name'=>'link','value'=>$options['link'],'msg'=>$Lang['focuspic_link_msg']),"input");
    tomshowsetting(array('title'=>$Lang['focuspic_fsort'],'name'=>'fsort','value'=>$options['fsort'],'msg'=>$Lang['focuspic_fsort_msg']),"input");
    
    return;
}

function __create_nav_html($infoArr = array()){
    global $Lang,$modBaseUrl,$adminBaseUrl;
    tomshownavheader();
    if($_GET['act'] == 'add'){
        tomshownavli($Lang['focuspic_list_title'],$modBaseUrl,false);
        tomshownavli($Lang['focuspic_add'],"",true);
    }else if($_GET['act'] == 'edit'){
        tomshownavli($Lang['focuspic_list_title'],$modBaseUrl,false);
        tomshownavli($Lang['focuspic_add'],$modBaseUrl."&act=add",false);
        tomshownavli($Lang['focuspic_edit'],"",true);
    }else{
        tomshownavli($Lang['focuspic_list_title'],$modBaseUrl,true);
        tomshownavli($Lang['focuspic_add'],$modBaseUrl."&act=add",false);
    }
    tomshownavfooter();
}