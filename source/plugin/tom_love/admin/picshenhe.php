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

$modBaseUrl = $adminBaseUrl.'&tmod=picshenhe';
$modListUrl = $adminListUrl.'&tmod=picshenhe';
$modFromUrl = $adminFromUrl.'&tmod=picshenhe';

$act = $_GET['act'];
$formhash =  $_GET['formhash']? $_GET['formhash']:'';

$get_list_url_value = get_list_url("tom_love_admin_picshenhe_list");
if($get_list_url_value){
    $modListUrl = $get_list_url_value;
}

if($formhash == FORMHASH && $act == 'ok'){
    
    $updateData = array();
    $updateData['shenhe_status'] = 1;
    C::t('#tom_love#tom_love_pic')->update($_GET['id'],$updateData);
    
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
}else if($formhash == FORMHASH && $act == 'del'){
    
    $picInfo = C::t('#tom_love#tom_love_pic')->fetch_by_id($_GET['id']);
    
    C::t('#tom_love#tom_love_pic')->delete($_GET['id']);
    
    DB::query("UPDATE ".DB::table('tom_love')." SET pic_num=pic_num-1 WHERE id='{$picInfo['user_id']}'", 'UNBUFFERED');
    
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'batch_ok'){
    
    if(is_array($_GET['ids']) && !empty($_GET['ids'])){
        foreach ($_GET['ids'] as $key => $value){
            $id = intval($value);
            $updateData = array();
            $updateData['shenhe_status']     = 1;
            C::t('#tom_love#tom_love_pic')->update($id,$updateData);
        }
    }
    
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'batch_del'){
    
    if(is_array($_GET['ids']) && !empty($_GET['ids'])){
        foreach ($_GET['ids'] as $key => $value){
            $id = intval($value);
            $picInfo = C::t('#tom_love#tom_love_pic')->fetch_by_id($id);
            C::t('#tom_love#tom_love_pic')->delete($id);
            DB::query("UPDATE ".DB::table('tom_love')." SET pic_num=pic_num-1 WHERE id='{$picInfo['user_id']}'", 'UNBUFFERED');
        }
    }
    
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
}else{
    
    set_list_url("tom_love_admin_picshenhe_list");
    $pagesize = 30;
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    $start = ($page-1)*$pagesize;
    $count = C::t('#tom_love#tom_love_pic')->fetch_all_count(" AND shenhe_status = 2 ");
    $shenheList = C::t('#tom_love#tom_love_pic')->fetch_all_list(" AND shenhe_status = 2 ","ORDER BY id DESC",$start,$pagesize);
    showtableheader();
    echo '<form name="cpform2" id="cpform2" method="post" autocomplete="off" action="'.ADMINSCRIPT.'?action='.$modFromUrl.'" onsubmit="return pic_form();">';
    echo '<input type="hidden" name="formhash" value="'.FORMHASH.'" />';
    echo '<tr><th colspan="15" class="partition">' . $Lang['picshenhe_list'] . '</th></tr>';
    echo '<tr class="header">';
    echo '<th> ID </th>';
    echo '<th>' . $Lang['nickname'] . '</th>';
    echo '<th>' . $Lang['picshenhe_pic'] . '</th>';
    echo '<th>' . $Lang['picshenhe_status'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    foreach ($shenheList as $key => $value){
        
        $userInfoTmp = C::t('#tom_love#tom_love')->fetch_by_id($value['user_id']);
        
        $shenhe_status = '--';
        if($value['shenhe_status'] == 2){
            $shenhe_status = $Lang['picshenhe_status_2'];
        }
        
        if(!preg_match('/^http/', $value['pic_url'])){
            if(strpos($value['pic_url'], 'source/plugin/tom_love') === false){
                $value['pic_url'] = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$value['pic_url'];
            }else{
                $value['pic_url'] = $value['pic_url'];
            }
        }else{
            $value['pic_url'] = $value['pic_url'];
        }
        
        echo '<tr>';
        echo '<td><input class="checkbox" type="checkbox" name="ids[]" value="' . $value['id'] . '" >'.$value['id'].'</td>';
        echo '<td><a target="_blank" href="'.$adminBaseUrl.'&tmod=user&act=show&id='.$value['user_id'].'&formhash='.FORMHASH.'">' . $userInfoTmp['nickname'] . '</a></td>';
        echo '<td><a target="_blank" href="'.$value['pic_url'].'"><img width="50" height="50" src="' . $value['pic_url'] . '"></a></td>';
        echo '<td>' . $shenhe_status . '</td>';
        echo '<td>';
        echo '<a href="'.$modBaseUrl.'&act=ok&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['picshenhe_ok'] . '</a>&nbsp;|&nbsp;';
        echo '<a href="'.$modBaseUrl.'&act=del&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['picshenhe_del'] . '</a>';
        echo '</td>';
        echo '</tr>';
    }
    $formstr = <<<EOF
        <tr>
            <td class="td25">
                <input type="checkbox" name="chkall" id="chkallFh9R" class="checkbox" onclick="checkAll('prefix', this.form, 'ids')" />
                <label for="chkallFh9R">{$Lang['checkall']}</label>
            </td>
            <td class="td25">
                <select name="act" >
                    <option value="batch_ok">{$Lang['picshenhe_batch_pic_ok']}</option>
                    <option value="batch_del">{$Lang['picshenhe_batch_pic_del']}</option>
                </select>
            </td>
            <td colspan="15">
                <div class="fixsel"><input type="submit" class="btn" id="submit_announcesubmit" name="announcesubmit" value="{$Lang['picshenhe_batch_btn']}" /></div>
            </td>
        </tr>
        <script type="text/javascript">
        function pic_form(){
          var r = confirm("{$Lang['picshenhe_batch_make_sure']}")
          if (r == true){
            return true;
          }else{
            return false;
          }
        }
        
        </script>
EOF;
    
    echo $formstr;
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBaseUrl);
    showsubmit('', '', '', '', $multi, false);
}