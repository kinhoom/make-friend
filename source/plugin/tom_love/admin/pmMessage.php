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

$modBaseUrl = $adminBaseUrl.'&tmod=pmMessage'; 
$modListUrl = $adminListUrl.'&tmod=pmMessage';
$modFromUrl = $adminFromUrl.'&tmod=pmMessage';

$get_list_url_value = get_list_url("tom_love_admin_pm_message_list");
if($get_list_url_value){
    $modListUrl = $get_list_url_value;
}

if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'del'){
    
    C::t('#tom_love#tom_love_pm_message')->delete($_GET['id']);
    
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'batch_del'){
    
    if(is_array($_GET['ids']) && !empty($_GET['ids'])){
        foreach ($_GET['ids'] as $key => $value){
            C::t('#tom_love#tom_love_pm_message')->delete($value);
        }
    }
    
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
}else{
    
    set_list_url("tom_love_admin_pm_message_list");
    
    $user_id  = intval($_GET['user_id'])>0? intval($_GET['user_id']):0;
    
    $whereStr = '';
    if(!empty($user_id)){
        $whereStr.= " AND user_id={$user_id} ";
    }
    
    $pagesize = 100;
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    $start = ($page-1)*$pagesize;	
    $count = C::t('#tom_love#tom_love_pm_message')->fetch_all_count($whereStr);
    $messageList = C::t('#tom_love#tom_love_pm_message')->fetch_all_list($whereStr,"ORDER BY add_time DESC",$start,$pagesize);
    
    $modBasePageUrl = $modBaseUrl."&user_id={$user_id}";
    
    echo '<form name="cpform2" id="cpform2" method="post" autocomplete="off" action="'.ADMINSCRIPT.'?action='.$modFromUrl.'&formhash='.FORMHASH.'" onsubmit="return batch_del();">'.
		'<input type="hidden" name="formhash" value="'.FORMHASH.'" />';
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $Lang['pm_message_list'] . '</th></tr>';
    echo '<tr class="header">';
    echo '<th> - </th>';
    echo '<th>ID</th>';
    echo '<th>' . $Lang['nickname'] . '</th>';
    echo '<th>' . $Lang['pm_message_content'] . '</th>';
    echo '<th>' . $Lang['pm_message_time'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    foreach ($messageList as $key => $value){
        
        $modelUrl = $adminBaseUrl.'&tmod=index';
        $userInfo = C::t('#tom_love#tom_love')->fetch_by_id($value['user_id']);

        echo '<tr style="background-color: #FCFAFA;">';
        echo '<td><input class="checkbox" type="checkbox" name="ids[]" value="' . $value['id'] . '" ></td>';
        echo '<td>'.$userInfo['id'].'</td>';
        echo '<td>'.$userInfo['nickname'].'</td>';
        echo '<td>' . $value['content'] . '</td>';
        echo '<td>' . dgmdate($value['add_time'], 'Y-m-d H:i:s',$tomSysOffset) . '</td>';
        echo '<td>';
        echo '<a href="'.$modBaseUrl.'&act=del&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['del'] . '</a>';
        echo '</td>';
        echo '</tr>';
        
    }
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBasePageUrl);
    showsubmit('', '', '', '', $multi, false);
    
        $formstr = <<<EOF
        <tr>
            <td class="td25">
                <input type="checkbox" name="chkall" id="chkallFh9R" class="checkbox" onclick="checkAll('prefix', this.form, 'ids')" />
                <label for="chkallFh9R">{$Lang['checkall']}</label>
            </td>
            <td class="td25">
                <select name="act" >
                    <option value="batch_del">{$Lang['batch_del']}</option>
                </select>
            </td>
            <td colspan="15">
                <div class="fixsel"><input type="submit" class="btn" id="submit_announcesubmit" name="announcesubmit" value="{$Lang['batch_btn']}" /></div>
            </td>
        </tr>
        <script type="text/javascript">
        function batch_del(){
          var r = confirm("{$Lang['makesure_del_msg']}")
          if (r == true){
            return true;
          }else{
            return false;
          }
        }
        </script>
EOF;
    echo $formstr;
    showformfooter();
}