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

$modBaseUrl = $adminBaseUrl.'&tmod=user';
$modListUrl = $adminListUrl.'&tmod=user';
$modFromUrl = $adminFromUrl.'&tmod=user';

$get_list_url_value = get_list_url("tom_love_admin_user_list");
if($get_list_url_value){
    $modListUrl = $get_list_url_value;
}

$act = $_GET['act'];
$formhash =  $_GET['formhash']? $_GET['formhash']:'';
if($formhash == FORMHASH && $act == 'show'){
    $info = C::t('#tom_love#tom_love')->fetch_by_id($_GET['id']);
    
    $sexName = '';
    if($info['sex'] == 1){
        $sexName = $Lang['man'];
    }else if($info['sex'] == 2){
        $sexName = $Lang['woman'];
    }else{
        $sexName = '-';
    }
    $jyTypeOne = "";
    $jyTypeTwo = "";
    if($info['friend'] == 1){
        $jyTypeOne= $Lang['jy'];
    }
    if($info['marriage'] == 1){
        $jyTypeTwo= $Lang['hl'];
    }
    
    $countryStr = "";
    $provinceStr = "";
    $cityStr = "";
    if($info['country_id'] == 1){
        $countryStr = $Lang['china'];
    }
    
    if($info['year'] > 0){
        if($jyConfig['age_type_id'] == 1){
            $age = $nowYear - $info['year'];
        }else{
            $age = $nowYear - $info['year'] + 1;
        }
    }else{
        $age = '-';
    }
    if(!preg_match('/^http/', $info['avatar'])){
        if(strpos($info['avatar'], 'source/plugin/tom_love') === false){
            $info['avatar'] = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$info['avatar'];
        }else{
            $info['avatar'] = $info['avatar'];
        }
    }
    
    $score = $info['score'];
    
    $picList = C::t('#tom_love#tom_love_pic')->fetch_all_list(" AND user_id ={$info['id']} ","ORDER BY id DESC",0,100);
    
    $fenhao = $Lang['fenhao'];
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $Lang['user_info'] . '</th></tr>';
    echo '<tr><td width="150" align="right"><b>'.$Lang['avatar'].$fenhao.'</b></td><td><img src="'.$info['avatar'].'" width="40" height="40" />&nbsp;<a href="'.$modBaseUrl.'&act=delavatar&uid='.$info['id'].'&formhash='.FORMHASH.'"">('.$Lang['delete'].')</a></td></tr>';
    //echo '<tr><td align="right"><b>UID'.$fenhao.'</b></td><td>' . $info['bbs_uid'] . '</td></tr>';
    //echo '<tr><td align="right"><b>'.$Lang['bbs_username'].$fenhao.'</b></td><td><a href="home.php?mod=space&uid='.$info['bbs_uid'].'"target="_blank" >' . $info['bbs_username'] . '</a></td></tr>';
    echo '<tr><td align="right"><b>'.$Lang['nickname'].$fenhao.'</b></td><td>'.$info['nickname'].'</td></tr>';
    echo '<tr><td align="right"><b>'.$Lang['sex'].$fenhao.'</b></td><td>'.$sexName.'</td></tr>';
    echo '<tr><td align="right"><b>'.$Lang['age'].$fenhao.'</b></td><td>'.$age.'&nbsp;<a href="'.$modBaseUrl.'&act=edityear&id='.$info['id'].'&formhash='.FORMHASH.'">(' . $Lang['edit_year'] . ')</a></td></tr>';
    echo '<tr><td align="right"><b>'.$Lang['marital'].$fenhao.'</b></td><td>'.$maritalArray[$info['marital_id']].'</td></tr>';
    echo '<tr><td align="right"><b>'.$Lang['score'].$fenhao.'</b></td><td>'.$score.'</td></tr>';
    echo '<tr><td align="right"><b>'.$Lang['wx'].$fenhao.'</b></td><td>'.$info['wx'].'</td></tr>';
    echo '<tr><td align="right"><b>'.$Lang['qq'].$fenhao.'</b></td><td>'.$info['qq'].'</td></tr>';
    echo '<tr><td align="right"><b>'.$Lang['tel'].$fenhao.'</b></td><td>'.$info['tel'].'</td></tr>';
    echo '<tr><td align="right"><b>'.$Lang['jy_type'].$fenhao.'</b></td><td>'.$jyTypeOne.' '.$jyTypeTwo.'</td></tr>';
    echo '<tr><td align="right"><b>'.$Lang['work'].$fenhao.'</b></td><td>'.$worksArray[$info['work_id']].'</td></tr>';
    echo '<tr><td align="right"><b>'.$Lang['edu'].$fenhao.'</b></td><td>'.$eduArray[$info['edu_id']].'</td></tr>';
    echo '<tr><td align="right"><b>'.$Lang['pay'].$fenhao.'</b></td><td>'.$payArray[$info['pay_id']].'</td></tr>';
    echo '<tr><td align="right"><b>'.$Lang['height'].$fenhao.'</b></td><td>'.$info['height'].'</td></tr>';
    echo '<tr><td align="right"><b>'.$Lang['weight'].$fenhao.'</b></td><td>'.$info['weight'].'</td></tr>';
    echo '<tr><td align="right"><b>'.$Lang['area'].$fenhao.'</b></td><td>'.$info['area'].'</td></tr>';
    echo '<tr><td align="right"><b>'.$Lang['hjarea'].$fenhao.'</b></td><td>'.$info['hjarea'].'</td></tr>';
    echo '<tr><td align="right"><b>'.$Lang['describe'].$fenhao.'</b></td><td>'.$info['describe'].'</td></tr>';
    echo '<tr><td align="right"><b>'.$Lang['pic_list'].$fenhao.'</b></td><td>';
    if(is_array($picList) && !empty($picList)){
        
        $i = 1;
        foreach ($picList as $key => $value){
            if(!preg_match('/^http/', $value['pic_url'])){
                if(strpos($value['pic_url'], 'source/plugin/tom_love') === false){
                    $value['pic_url'] = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$value['pic_url'];
                }else{
                    $value['pic_url'] = $value['pic_url'];
                }
            }else{
                $value['pic_url'] = $value['pic_url'];
            }
            echo '<img src="'.$value['pic_url'].'" width="80" height="80" />&nbsp;<a href="'.$modBaseUrl.'&act=delpic&uid='.$info['id'].'&picid='.$value['id'].'&formhash='.FORMHASH.'">('.$Lang['delete'].')</a>&nbsp;&nbsp;&nbsp;';
            if($i%4 == 0){
                echo "<br/>";
            }
            $i++;
        }
    }
    echo '</td></tr>';
    showtablefooter();
}else if($formhash == FORMHASH && $act == 'editscore'){
    $info = C::t('#tom_love#tom_love')->fetch_by_id($_GET['id']);
    if(submitcheck('submit')){
        $score = intval($_GET['score']);
        $updateData = array();
        $updateData['score'] = $score;
        C::t('#tom_love#tom_love')->update($_GET['id'],$updateData);
        
        $insertData = array();
        $insertData['user_id']      = $info['id'];
        $insertData['score_value']  = $score;
        $insertData['log_type']     = 15;
        $insertData['log_time']     = TIMESTAMP;
        C::t('#tom_love#tom_love_scorelog')->insert($insertData);
        
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        $fenhao = $Lang['fenhao'];
        showformheader($modFromUrl.'&act=editscore&id='.$_GET['id'].'&formhash='.FORMHASH);
        showtableheader();
        echo '<tr><th colspan="15" class="partition">' . $Lang['edit_score'] . '</th></tr>';
        echo '<tr><td width="100" align="right"><b>'.$Lang['nickname'].$fenhao.'</b></td><td>'.$info['nickname'].'</td></tr>';
        echo '<tr><td align="right"><b>'.$Lang['edit_score'].$fenhao.'</b></td><td><input name="score" type="text" value="'.$info['score'].'" size="20" /> '.$Lang['edit_score_msg'].'</td></tr>';
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
}else if($formhash == FORMHASH && $act == 'edityear'){
    $info = C::t('#tom_love#tom_love')->fetch_by_id($_GET['id']);
    if(submitcheck('submit')){
        $year = intval($_GET['year']);
        $updateData = array();
        $updateData['year'] = $year;
        C::t('#tom_love#tom_love')->update($_GET['id'],$updateData);
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        $fenhao = $Lang['fenhao'];
        showformheader($modFromUrl.'&act=edityear&id='.$_GET['id'].'&formhash='.FORMHASH);
        showtableheader();
        echo '<tr><th colspan="15" class="partition">' . $Lang['edit_year'] . '</th></tr>';
        echo '<tr><td width="100" align="right"><b>'.$Lang['nickname'].$fenhao.'</b></td><td>'.$info['nickname'].'</td></tr>';
        echo '<tr><td align="right"><b>'.$Lang['edit_year'].$fenhao.'</b></td><td><input name="year" type="text" value="'.$info['year'].'" size="20" /> '.$Lang['edit_year_msg'].'</td></tr>';
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
}else if($formhash == FORMHASH && $act == 'editvip'){
    $info = C::t('#tom_love#tom_love')->fetch_by_id($_GET['id']);
    if(submitcheck('submit')){
        $vip_id = intval($_GET['vip_id']);
        $vip_time     = isset($_GET['vip_time'])? addslashes($_GET['vip_time']):'';
        $vip_time     = strtotime($vip_time);

        $updateData = array();
        $updateData['vip_id'] = $vip_id;
        $updateData['vip_time'] = $vip_time;
        C::t('#tom_love#tom_love')->update($_GET['id'],$updateData);

        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        tomloadcalendarjs();
        $fenhao = $Lang['fenhao'];
        showformheader($modFromUrl.'&act=editvip&id='.$_GET['id'].'&formhash='.FORMHASH);
        showtableheader();
        echo '<tr><th colspan="15" class="partition">' . $Lang['edit_vip_title'] .'('.$info['nickname']. ')</th></tr>';
        $vip_id_item = array(0=>$Lang['edit_vip_id_0'],1=>$Lang['edit_vip_id_1']);
        tomshowsetting(array('title'=>$Lang['edit_vip_id'],'name'=>'vip_id','value'=>$info['vip_id'],'msg'=>$Lang['edit_vip_id_msg'],'item'=>$vip_id_item),"radio");
        tomshowsetting(array('title'=>$Lang['edit_vip_time'],'name'=>'vip_time','value'=>$info['vip_time'],'msg'=>$Lang['edit_vip_time_msg']),"calendar");
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
}else if($formhash == FORMHASH && $act == 'addtz'){
    $info = C::t('#tom_love#tom_love')->fetch_by_id($_GET['id']);
    if(submitcheck('submit')){
        $content    = isset($_GET['content'])? addslashes($_GET['content']):'';
        
        $insertData = array();
        $insertData['user_id']     = $_GET['id'];
        $insertData['type']        = 1;
        $insertData['title']       = $Lang['sys_tz_title'];
        $insertData['content']     = $content;
        $insertData['tz_time']     = TIMESTAMP;
        $insertData['is_read']     = 0;
        C::t('#tom_love#tom_love_tz')->insert($insertData);
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        $fenhao = $Lang['fenhao'];
        showformheader($modFromUrl.'&act=addtz&id='.$_GET['id'].'&formhash='.FORMHASH);
        showtableheader();
        echo '<tr><th colspan="15" class="partition">' .$info['nickname'].$fenhao. $Lang['sys_tz_title'] . '</th></tr>';
        tomshowsetting(array('title'=>$Lang['sys_tz_title'],'name'=>'content','value'=>'','msg'=>''),"textarea");
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
}else if($formhash == FORMHASH && $act == 'addqunfa'){
    
    $renzheng       = isset($_GET['renzheng'])? intval($_GET['renzheng']):0;
    $recommend      = isset($_GET['recommend'])? intval($_GET['recommend']):0;
    $status         = isset($_GET['status'])? intval($_GET['status']):0;
    $all            = isset($_GET['all'])? intval($_GET['all']):1;
    
    if(submitcheck('submit')){
        $content    = isset($_GET['content'])? addslashes($_GET['content']):'';
        $content = urlencode($content);
        $modQunfaListUrl = $modListUrl.'&act=doqunfa&renzheng='.$renzheng.'&recommend='.$recommend.'&status='.$status.'&all='.$all.'&content='.$content.'&formhash='.FORMHASH;
        cpmsg($Lang['qunfa_add_msg'], $modQunfaListUrl, 'loadingform');
    }else{
        
        $where = "";
        if(!empty($renzheng)){
            if($renzheng == 1){
                $where.= " AND renzheng=0 ";
            }
            if($renzheng == 2){
                $where.= " AND renzheng=1 ";
            }
        }
        if(!empty($recommend)){
            if($recommend == 1){
                $where.= " AND recommend=0 ";
            }
            if($recommend == 2){
                $where.= " AND recommend=1 ";
            }
        }
        if(!empty($status)){
            $where.= " AND status=$status ";
        }
        if(!empty($all)){
            if($all == 1){
                $where.= " AND year>0 ";
            }
            if($all == 2){
                $where.= " AND year=0 ";
            }
        }
        $count = C::t('#tom_love#tom_love')->fetch_all_count($where,"","");
        
        $qunfa_tz_title2 = str_replace("{NUM}", $count, $Lang['qunfa_tz_title2']);
        
        $fenhao = $Lang['fenhao'];
        showformheader($modFromUrl.'&act=addqunfa&renzheng='.$renzheng.'&recommend='.$recommend.'&status='.$status.'&all='.$all.'&formhash='.FORMHASH);
        showtableheader();
        echo '<tr><th colspan="15" class="partition">' .$qunfa_tz_title2. '</th></tr>';
        tomshowsetting(array('title'=>$Lang['sys_tz_title'],'name'=>'content','value'=>'','msg'=>''),"textarea");
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
}else if($formhash == FORMHASH && $act == 'doqunfa'){
    
    $renzheng       = isset($_GET['renzheng'])? intval($_GET['renzheng']):0;
    $recommend      = isset($_GET['recommend'])? intval($_GET['recommend']):0;
    $status         = isset($_GET['status'])? intval($_GET['status']):0;
    $all            = isset($_GET['all'])? intval($_GET['all']):1;
    $page           = isset($_GET['page'])? intval($_GET['page']):1;
    $nextpage = $page + 1;
    
    $content    = isset($_GET['content'])? addslashes($_GET['content']):'';
    $content = urldecode($content);
    
    $pagesize = 100;
    $start = ($page-1)*$pagesize;	
    
    $where = "";
    if(!empty($renzheng)){
        if($renzheng == 1){
            $where.= " AND renzheng=0 ";
        }
        if($renzheng == 2){
            $where.= " AND renzheng=1 ";
        }
    }
    if(!empty($recommend)){
        if($recommend == 1){
            $where.= " AND recommend=0 ";
        }
        if($recommend == 2){
            $where.= " AND recommend=1 ";
        }
    }
    if(!empty($status)){
        $where.= " AND status=$status ";
    }
    if(!empty($all)){
        if($all == 1){
            $where.= " AND year>0 ";
        }
        if($all == 2){
            $where.= " AND year=0 ";
        }
    }
    $count = C::t('#tom_love#tom_love')->fetch_all_count($where,"","");
    $allPageNum = ceil($count/$pagesize);
    
    if($page <= $allPageNum){
        
        $userList = C::t('#tom_love#tom_love')->fetch_all_list($where,"ORDER BY add_time DESC",$start,$pagesize,"","");
        
        if(is_array($userList) && !empty($userList)){
            foreach ($userList as $key => $value){
                $insertData = array();
                $insertData['user_id']     = $value['id'];
                $insertData['type']        = 1;
                $insertData['title']       = $Lang['sys_tz_title'];
                $insertData['content']     = $content;
                $insertData['tz_time']     = TIMESTAMP;
                $insertData['is_read']     = 0;
                C::t('#tom_love#tom_love_tz')->insert($insertData);
            }
        }
        
        $qunfa_do_msg = str_replace("{PAGES}", $page, $Lang['qunfa_do_msg']);
        $qunfa_do_msg = str_replace("{COUNT}", $allPageNum, $qunfa_do_msg);
        
        $modQunfaListUrl = $modListUrl.'&act=doqunfa&renzheng='.$renzheng.'&recommend='.$recommend.'&status='.$status.'&all='.$all.'&content='.$_GET['content'].'&page='.$nextpage.'&formhash='.FORMHASH;
        cpmsg($qunfa_do_msg, $modQunfaListUrl, 'loadingform');
        
    }else{
        cpmsg($Lang['qunfa_do_success'], $modListUrl, 'succeed');
    }
}else if($formhash == FORMHASH && $act == 'addqfmbxx'){
    
    $renzheng       = isset($_GET['renzheng'])? intval($_GET['renzheng']):0;
    $recommend      = isset($_GET['recommend'])? intval($_GET['recommend']):0;
    $status         = isset($_GET['status'])? intval($_GET['status']):0;
    $all            = isset($_GET['all'])? intval($_GET['all']):1;
    
    if(submitcheck('submit')){
        $title    = isset($_GET['title'])? addslashes($_GET['title']):'';
        $content  = isset($_GET['content'])? addslashes($_GET['content']):'';
        $link     = isset($_GET['link'])? addslashes($_GET['link']):'';
        $title    = urlencode($title);
        $content  = urlencode($content);
        $link     = urlencode($link);
        $modQambxxListUrl = $modListUrl.'&act=doqfmbxx&renzheng='.$renzheng.'&recommend='.$recommend.'&status='.$status.'&all='.$all.'&title='.$title.'&content='.$content.'&link='.$link.'&formhash='.FORMHASH;
        cpmsg($Lang['qfmbxx_add_msg'], $modQambxxListUrl, 'loadingform');
    }else{
        
        $title      = isset($_GET['title'])? addslashes($_GET['title']):'';
        $content    = isset($_GET['content'])? addslashes($_GET['content']):'';
        $link       = isset($_GET['link'])? addslashes($_GET['link']):'http://';
        $title      = urldecode($title);
        $content    = urldecode($content);
        $link       = urldecode($link);
        
        $where = "";
        if(!empty($renzheng)){
            if($renzheng == 1){
                $where.= " AND renzheng=0 ";
            }
            if($renzheng == 2){
                $where.= " AND renzheng=1 ";
            }
        }
        if(!empty($recommend)){
            if($recommend == 1){
                $where.= " AND recommend=0 ";
            }
            if($recommend == 2){
                $where.= " AND recommend=1 ";
            }
        }
        if(!empty($status)){
            $where.= " AND status=$status ";
        }
        if(!empty($all)){
            if($all == 1){
                $where.= " AND year>0 ";
            }
            if($all == 2){
                $where.= " AND year=0 ";
            }
        }
        $count = C::t('#tom_love#tom_love')->fetch_all_count($where,"","");
        
        $qfmbxx_tz_title2 = str_replace("{NUM}", $count, $Lang['qfmbxx_tz_title2']);
        
        $fenhao = $Lang['fenhao'];
        showformheader($modFromUrl.'&act=addqfmbxx&renzheng='.$renzheng.'&recommend='.$recommend.'&status='.$status.'&all='.$all.'&formhash='.FORMHASH);
        showtableheader();
        echo '<tr><th colspan="15" class="partition">' .$qfmbxx_tz_title2. '</th></tr>';
        tomshowsetting(array('title'=>$Lang['qfmbxx_sms_title'],'name'=>'title','value'=>$title,'msg'=>$Lang['qfmbxx_sms_title_msg']),"input");
        tomshowsetting(array('title'=>$Lang['qfmbxx_sms_content'],'name'=>'content','value'=>$content,'msg'=>''),"textarea");
        tomshowsetting(array('title'=>$Lang['qfmbxx_sms_link'],'name'=>'link','value'=>$link,'msg'=>''),"input");
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
}else if($formhash == FORMHASH && $act == 'doqfmbxx'){
    
    $renzheng       = isset($_GET['renzheng'])? intval($_GET['renzheng']):0;
    $recommend      = isset($_GET['recommend'])? intval($_GET['recommend']):0;
    $status         = isset($_GET['status'])? intval($_GET['status']):0;
    $all            = isset($_GET['all'])? intval($_GET['all']):1;
    $page           = isset($_GET['page'])? intval($_GET['page']):1;
    $nextpage = $page + 1;
    
    $title      = isset($_GET['title'])? addslashes($_GET['title']):'';
    $content    = isset($_GET['content'])? addslashes($_GET['content']):'';
    $link       = isset($_GET['link'])? addslashes($_GET['link']):'';
    $title      = urldecode($title);
    $content    = urldecode($content);
    $link       = urldecode($link);
        
    $pagesize = 20;
    $start = ($page-1)*$pagesize;	
    
    $where = "";
    if(!empty($renzheng)){
        if($renzheng == 1){
            $where.= " AND renzheng=0 ";
        }
        if($renzheng == 2){
            $where.= " AND renzheng=1 ";
        }
    }
    if(!empty($recommend)){
        if($recommend == 1){
            $where.= " AND recommend=0 ";
        }
        if($recommend == 2){
            $where.= " AND recommend=1 ";
        }
    }
    if(!empty($status)){
        $where.= " AND status=$status ";
    }
    if(!empty($all)){
        if($all == 1){
            $where.= " AND year>0 ";
        }
        if($all == 2){
            $where.= " AND year=0 ";
        }
    }
    $count = C::t('#tom_love#tom_love')->fetch_all_count($where,"","");
    $allPageNum = ceil($count/$pagesize);
    
    if($page <= $allPageNum){
        
        $userList = C::t('#tom_love#tom_love')->fetch_all_list($where,"ORDER BY add_time DESC",$start,$pagesize,"","");
        
        $appid = trim($jyConfig['love_appid']); 
        $appsecret = trim($jyConfig['love_appsecret']); 
        include DISCUZ_ROOT.'./source/plugin/tom_love/class/weixin.class.php';
        include DISCUZ_ROOT.'./source/plugin/tom_love/class/templatesms.class.php';
        $weixinClass = new weixinClass($appid,$appsecret);
        $access_token = $weixinClass->get_access_token();
        $templateSmsClass = new templateSms($access_token, "");
        
        if(is_array($userList) && !empty($userList)){
            foreach ($userList as $key => $value){
                if($access_token && !empty($value['openid'])){
                    $smsData = array(
                        'first'         => $title,
                        'keyword1'      => '-',
                        'keyword2'      => dgmdate(TIMESTAMP,"Y-m-d H:i:s",$tomSysOffset),
                        'remark'        => $content
                    );
                    $r = $templateSmsClass->sendSmsTm20702951($value['openid'],$jyConfig['template_tm20702951'],$smsData,$link);
//                    if($r){}else{
//                        $modaddQambxxListUrl = $modListUrl.'&act=addqfmbxx&renzheng='.$renzheng.'&recommend='.$recommend.'&status='.$status.'&all='.$all.'&title='.$_GET['title'].'&content='.$_GET['content'].'&link='.$_GET['link'].'&formhash='.FORMHASH;
//                        cpmsg($Lang['qfmbxx_do_fail'], $modaddQambxxListUrl, 'succeed');
//                    }
                    
                }
            }
        }
        
        $qfmbxx_do_msg = str_replace("{PAGES}", $page, $Lang['qfmbxx_do_msg']);
        $qfmbxx_do_msg = str_replace("{COUNT}", $allPageNum, $qfmbxx_do_msg);
        
        $modQambxxListUrl = $modListUrl.'&act=doqfmbxx&renzheng='.$renzheng.'&recommend='.$recommend.'&status='.$status.'&all='.$all.'&title='.$_GET['title'].'&content='.$_GET['content'].'&link='.$_GET['link'].'&page='.$nextpage.'&formhash='.FORMHASH;
        cpmsg($qfmbxx_do_msg, $modQambxxListUrl, 'loadingform');
        
    }else{
        cpmsg($Lang['qfmbxx_do_success'], $modListUrl, 'succeed');
    }
}else if($formhash == FORMHASH && $act == 'rzdel'){
    $updateData = array();
    $updateData['renzheng'] = 0;
    C::t('#tom_love#tom_love')->update($_GET['id'],$updateData);
    C::t('#tom_love#tom_love_renzheng')->update_renzheng_status(0,$_GET['id']);
    cpmsg($Lang['act_success'],$modListUrl, 'succeed');
}else if($formhash == FORMHASH && $act == 'rzadd'){
    $updateData = array();
    $updateData['renzheng'] = 1;
    C::t('#tom_love#tom_love')->update($_GET['id'],$updateData);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
}else if($formhash == FORMHASH && $act == 'sjrzdel'){
    $updateData = array();
    $updateData['phone_renzheng'] = 0;
    C::t('#tom_love#tom_love')->update($_GET['id'],$updateData);
    cpmsg($Lang['act_success'],$modListUrl, 'succeed');
}else if($formhash == FORMHASH && $act == 'sjrzadd'){
    $updateData = array();
    $updateData['phone_renzheng'] = 1;
    C::t('#tom_love#tom_love')->update($_GET['id'],$updateData);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
}else if($formhash == FORMHASH && $act == 'recdel'){
    $updateData = array();
    $updateData['recommend'] = 0;
    C::t('#tom_love#tom_love')->update($_GET['id'],$updateData);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
}else if($formhash == FORMHASH && $act == 'recadd'){
    
    $info = C::t('#tom_love#tom_love')->fetch_by_id($_GET['id']);
    if(submitcheck('submit')){
        $recommend_time     = isset($_GET['recommend_time'])? addslashes($_GET['recommend_time']):'';
        $recommend_time     = strtotime($recommend_time);
        $updateData = array();
        $updateData['recommend'] = 1;
        $updateData['recommend_time'] = $recommend_time;
        $updateData['recommend_do_time'] = TIMESTAMP;
        C::t('#tom_love#tom_love')->update($_GET['id'],$updateData);
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        tomloadcalendarjs();
        $fenhao = $Lang['fenhao'];
        showformheader($modFromUrl.'&act=recadd&id='.$_GET['id'].'&formhash='.FORMHASH);
        showtableheader();
        echo '<tr><th colspan="15" class="partition">' . $Lang['add_recommend_time'] .'('.$info['nickname']. ')</th></tr>';
        tomshowsetting(array('title'=>$Lang['add_recommend_time'],'name'=>'recommend_time','value'=>$info['recommend_time'],'msg'=>$Lang['add_recommend_time_msg']),"calendar");
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
}else if($formhash == FORMHASH && $act == 'fenghao'){
    $updateData = array();
    $updateData['status'] = 2;
    C::t('#tom_love#tom_love')->update($_GET['id'],$updateData);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
}else if($formhash == FORMHASH && $act == 'normal'){
    $updateData = array();
    $updateData['status'] = 1;
    C::t('#tom_love#tom_love')->update($_GET['id'],$updateData);
    cpmsg($Lang['act_success'],$modListUrl, 'succeed');
}else if($formhash == FORMHASH && $act == 'del'){
    C::t('#tom_love#tom_love')->delete($_GET['id']);
    C::t('#tom_love#tom_love_shuoshuo')->delete_by_uid($_GET['id']);
    C::t('#tom_love#tom_love_guanxi')->delete_by_gid($_GET['id']);
    C::t('#tom_love#tom_love_pic')->delete_by_uid($_GET['id']);
    C::t('#tom_love#tom_love_share')->delete_by_uid($_GET['id']);
    C::t('#tom_love#tom_love_renzheng')->delete_by_uid($_GET['id']);
    C::t('#tom_love#tom_love_rec')->delete_by_uid($_GET['id']);
    C::t('#tom_love#tom_love_tz')->delete_by_uid($_GET['id']);
    C::t('#tom_love#tom_love_order')->delete_by_uid($_GET['id']);
    C::t('#tom_love#tom_love_report')->delete_by_uid($_GET['id']);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
}else if($formhash == FORMHASH && $act == 'delavatar'){
    $uid = intval($_GET['uid']);
    $updateData = array();
    $updateData['avatar'] = 'source/plugin/tom_love/images/avatar_default.jpg';
    C::t('#tom_love#tom_love')->update($uid,$updateData);
    cpmsg($Lang['act_success'], $modListUrl.'&act=show&id='.$uid.'&formhash='.FORMHASH, 'succeed');
}else if($formhash == FORMHASH && $act == 'delpic'){
    $uid = intval($_GET['uid']);
    $picid = intval($_GET['picid']);
    C::t('#tom_love#tom_love_pic')->delete($picid);
    $pic_num = C::t('#tom_love#tom_love_pic')->fetch_all_count(" AND user_id ={$uid} ");
    $updateData = array();
    $updateData['pic_num'] = $pic_num;
    C::t('#tom_love#tom_love')->update($uid,$updateData);
    cpmsg($Lang['act_success'], $modListUrl.'&act=show&id='.$uid.'&formhash='.FORMHASH, 'succeed');
}else if($act == 'goldChange' && $formhash == FORMHASH){
    $info = C::t('#tom_love#tom_love')->fetch_by_id($_GET['id']);
    $page     = isset($_GET['page'])? intval($_GET['page']):1;
    $pagesize = 50;
    $start = ($page-1)*$pagesize;

    $count = C::t('#tom_love#tom_love_scorelog')->fetch_all_count(" AND user_id={$_GET['id']} ");
    $scorelogData = C::t('#tom_love#tom_love_scorelog')->fetch_all_list(" AND user_id={$_GET['id']} ","ORDER BY id DESC",$start,$pagesize);
    $scorelogList = array();
    if(is_array($scorelogData) && !empty($scorelogData)){
        foreach ($scorelogData as $logkey => $logvalue){
            $scorelogList[$logkey] = $logvalue;
        }
    }
    showtableheader();
    echo '<tr><th colspan="15" class="partition">('.$info['nickname'].')'. $Lang['gold_change_title'] .'</th></tr>';
    echo '<tr class="header">';
    echo '<th>'. $Lang['gold_change_row'] .'</th>';
    echo '<th>'. $Lang['gold_change_record'] .'</th>';
    echo '<th>'. $Lang['gold_change_record_num']  .'</th>';
    echo '<th>'. $Lang['gold_change_record_time'] .'</th>';
    echo '</tr>';
    
    $i = 1;
    foreach($scorelogList as $key => $value){
        echo '<tr>';
        echo '<td>'. ($i+$start) .'</td>';
        echo '<td>';
        switch ($value['log_type']){
            case '1';
                echo $Lang['log_type_title1'];
                break;
            case '2';
                echo $Lang['log_type_title2'];
                break;
            case '3';
                echo $Lang['log_type_title3'];
                break;
            case '4';
                echo $Lang['log_type_title4'];
                break;
            case '5';
                echo $Lang['log_type_title5'];
                break;
            case '6';
                echo $Lang['log_type_title6'];
                break;
            case '7';
                echo $Lang['log_type_title7'];
                break;
            case '8';
                echo $Lang['log_type_title8'];
                break;
            case '9';
                echo $Lang['log_type_title9'];
                break;
            case '10';
                echo $Lang['log_type_title10'];
                break;
            case '11';
                echo $Lang['log_type_title11'];
                break;
            case '12';
                echo $Lang['log_type_title12'];
                break;
            case '13';
                echo $Lang['log_type_title13'];
                break;
            case '14';
                echo $Lang['log_type_title14'];
                break;
            case '15';
                echo $Lang['log_type_title15'];
                break;
            default :
                echo $Lang['log_type_title0'];
                break;
        }
        echo '</td>';
        echo '<td>'. $value['score_value'] .'</td>';
        echo '<td>'. dgmdate($value['log_time'], 'Y-m-d H:i:s',$tomSysOffset) .'</td>';
        echo '</tr>';
        $i++;
    }
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBaseUrl."&act=goldChange&id={$_GET['id']}&formhash=".FORMHASH);	
    showsubmit('', '', '', '', $multi, false);
    
    
}else if($act == 'flowerslog' && $formhash == FORMHASH){
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $pagesize = 50;
    $start = ($page - 1) * $pagesize;
    $count = C::t('#tom_love#tom_love_flowers_log')->fetch_all_count(" AND user_id = {$_GET['id']}");
    $flowerslogListTmp = C::t('#tom_love#tom_love_flowers_log')->fetch_all_list(" AND user_id = {$_GET['id']}", "ORDER BY id ASC", $start, $pagesize);
    $info = C::t('#tom_love#tom_love')->fetch_by_id($_GET['id']);
    $flowerslogList = array();
    if(is_array($flowerslogListTmp) && !empty($flowerslogListTmp)){
        foreach ($flowerslogListTmp as $key => $value){
            $flowerslogList[$key] = $value;
            $flowerslogList[$key]['txt'] = htmlspecialchars_decode($value['txt']);
            $flowerslogList[$key]['txt'] = str_replace('plugin.php?id=tom_love&mod=info&uid=', $adminBaseUrl.'&formhash='.FORMHASH.'&tmod=user&act=show&id=', $flowerslogList[$key]['txt']);
        }
    }
    showtableheader();
    echo '<tr><th colspan="15" class="partition">('.$info['nickname'].')'. $Lang['flowerslog_change_title'] .'</th></tr>';
    echo '<tr class="header">';
    echo '<th>'. $Lang['flowerslog_change_row'] .'</th>';
    echo '<th>'. $Lang['flowerslog_change_type'] .'</th>';
    echo '<th>'. $Lang['flowerslog_change_num'] .'</th>';
    echo '<th>'. $Lang['flowerslog_change_old_num'] .'</th>';
    echo '<th>'. $Lang['flowerslog_change_txt'] .'</th>';
    echo '<th>'. $Lang['flowerslog_change_log_time'] .'</th>';
    echo '</tr>';
    
    $i = 1;
    foreach($flowerslogList as $key => $value){
        $type = '';
        if($value['type_id'] == 1){
            $type = $Lang['flowerslog_change_type_1'];
        }else if($value['type_id'] == 2){
            $type = $Lang['flowerslog_change_type_2'];
        }
        
        echo '<tr>';
        echo '<td>'. ($i+$start) .'</td>';
        echo '<td>'. $type .'</td>';
        echo '<td>'. $value['change_num'] .'</td>';
        echo '<td>'. $value['old_num'] .'</td>';
        echo '<td>'. $value['txt'] .'</td>';
        echo '<td>'. dgmdate($value['log_time'], 'Y-m-d H:i:s',$tomSysOffset) .'</td>';
        echo '</tr>';
        $i++;
    }
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBaseUrl."&act=flowerslog&id={$_GET['id']}&formhash=".FORMHASH);	
    showsubmit('', '', '', '', $multi, false);
    
}else{
    
    set_list_url("tom_love_admin_user_list");
    
    $search         = intval($_GET['search'])>0? intval($_GET['search']):0;
    $user_id        = isset($_GET['user_id'])? intval($_GET['user_id']):''; 
    $nickname       = !empty($_GET['nickname'])? addslashes($_GET['nickname']):'';
    $vip_id         = isset($_GET['vip_id'])? intval($_GET['vip_id']):0;
    $phone_renzheng = isset($_GET['phone_renzheng'])? intval($_GET['phone_renzheng']):0;
    $renzheng       = isset($_GET['renzheng'])? intval($_GET['renzheng']):0;
    $recommend      = isset($_GET['recommend'])? intval($_GET['recommend']):0;
    $is_majia       = isset($_GET['is_majia'])? intval($_GET['is_majia']):0;
    $status         = isset($_GET['status'])? intval($_GET['status']):0;
    $all            = isset($_GET['all'])? intval($_GET['all']):1;
    
    $pagesize   = 10;
    $page       = intval($_GET['page'])>0? intval($_GET['page']):1;
    $start      = ($page-1)*$pagesize;	
    
    $where = "";
    if(!empty($user_id)){
        $where.= " AND id={$user_id} ";
    }
    if(!empty($vip_id)){
        if($vip_id == 1){
            $where.= " AND vip_id=1 ";
        }
    }
    if(!empty($phone_renzheng)){
        if($phone_renzheng == 1){
            $where.= " AND phone_renzheng=0 ";
        }
        if($phone_renzheng == 2){
            $where.= " AND phone_renzheng=1 ";
        }
    }
    if(!empty($renzheng)){
        if($renzheng == 1){
            $where.= " AND renzheng=0 ";
        }
        if($renzheng == 2){
            $where.= " AND renzheng=1 ";
        }
    }
    if(!empty($recommend)){
        if($recommend == 1){
            $where.= " AND recommend=0 ";
        }
        if($recommend == 2){
            $where.= " AND recommend=1 ";
        }
    }
    if(!empty($is_majia)){
        if($is_majia == 1){
            $where.= " AND is_majia=0 ";
        }
        if($is_majia == 2){
            $where.= " AND is_majia=1 ";
        }
    }
    if(!empty($status)){
        $where.= " AND status=$status ";
    }
    if(!empty($all)){
        if($all == 1){
            $where.= " AND year>0 ";
        }
        if($all == 2){
            $where.= " AND year=0 ";
        }
    }
    $count = C::t('#tom_love#tom_love')->fetch_all_count($where,'',$nickname);
    $userList = C::t('#tom_love#tom_love')->fetch_all_list($where,"ORDER BY add_time DESC",$start,$pagesize,'',$nickname);
    
    $modBasePageUrl = $modBaseUrl."&phone_renzheng={$phone_renzheng}&renzheng={$renzheng}&recommend={$recommend}&status={$status}&all={$all}&vip_id={$vip_id}";
    $uSiteUrl = urlencode($_G['siteurl']);
    showtableheader();
    $Lang['love_help_1']  = str_replace("{SITEURL}", $_G['siteurl'], $Lang['love_help_1']);
    $Lang['love_help_2']  = str_replace("{SITEURL}", $_G['siteurl'], $Lang['love_help_2']);
    $Lang['love_help_3']  = str_replace("{SITEURL}", $_G['siteurl'], $Lang['love_help_3']);
    echo '<tr><th colspan="15" class="partition">' . $Lang['love_help_title'] . '</th></tr>';
    echo '<tr><td  class="tipsblock" s="1"><ul id="tipslis">';
    echo '<li>' . $Lang['love_help_1'] . '</li>';
    //echo '<li>' . $Lang['love_help_3'] . '</li>';
    echo '<li>' . $Lang['love_help_2'] . '</li>';
    echo '</ul></td></tr>';
    showtablefooter();
    
    $fenhao = $Lang['fenhao'];
    showformheader($modFromUrl.'&formhash='.FORMHASH);
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $Lang['search_list'] . '(<a href="'.$modBaseUrl.'&search=1"><font color="#F90B0B">' . $Lang['search_gaoji_list'] . '</font></a>)</th></tr>';
    echo '<tr><td width="100" align="right"><b> ID </b></td><td><input name="user_id" type="text" value="'.$user_id.'" size="40" /></td></tr>';
    echo '<tr><td width="100" align="right"><b>'.$Lang['nickname'].$fenhao.'</b></td><td><input name="nickname" type="text" value="'.$nickname.'" size="40" /></td></tr>';
    
    if($search == 1){
        $vip_id_1 = "";
        if($vip_id == 1){ $vip_id_1 = "selected";}
        echo '<tr><td width="100" align="right"><b>' . $Lang['edit_vip_id'] . '</b></td><td><select name="vip_id" >';
        echo '<option value="0">'.$Lang['edit_vip_id'].'</option>';
        echo '<option value="1" '.$vip_id_1.'>'.$Lang['edit_vip_id_1'].'</option>';
        echo '</select></td></tr>';

        $sjrenzheng_1 = $sjrenzheng_2 = "";
        if($sjrenzheng == 1){ $sjrenzheng_1 = "selected";}
        if($sjrenzheng == 2){ $sjrenzheng_2 = "selected";}
        echo '<tr><td width="100" align="right"><b>' . $Lang['shouji_rz'] . '</b></td><td><select name="phone_renzheng" >';
        echo '<option value="0">'.$Lang['shouji_rz'].'</option>';
        echo '<option value="1" '.$sjrenzheng_1.'>'.$Lang['rz_no'].'</option>';
        echo '<option value="2" '.$sjrenzheng_2.'>'.$Lang['rz_yes'].'</option>';
        echo '</select></td></tr>';
        
        $renzheng_1 = $renzheng_2 = "";
        if($renzheng == 1){ $renzheng_1 = "selected";}
        if($renzheng == 2){ $renzheng_2 = "selected";}
        echo '<tr><td width="100" align="right"><b>' . $Lang['renzheng'] . '</b></td><td><select name="renzheng" >';
        echo '<option value="0">'.$Lang['renzheng'].'</option>';
        echo '<option value="1" '.$renzheng_1.'>'.$Lang['rz_no'].'</option>';
        echo '<option value="2" '.$renzheng_2.'>'.$Lang['rz_yes'].'</option>';
        echo '</select></td></tr>';

        $recommend_1 = $recommend_2 = "";
        if($recommend == 1){ $recommend_1 = "selected";}
        if($recommend == 2){ $recommend_2 = "selected";}
        echo '<tr><td width="100" align="right"><b>' . $Lang['recommend'] . '</b></td><td><select name="recommend" >';
        echo '<option value="0">'.$Lang['recommend'].'</option>';
        echo '<option value="1" '.$recommend_1.'>'.$Lang['rec_no'].'</option>';
        echo '<option value="2" '.$recommend_2.'>'.$Lang['rec_yes'].'</option>';
        echo '</select></td></tr>';
        
        $is_majia_1 = $is_majia_2 = "";
        if($is_majia == 1){ $is_majia_1 = "selected";}
        if($is_majia == 2){ $is_majia_2 = "selected";}
        echo '<tr><td width="100" align="right"><b>' . $Lang['is_majia'] . '</b></td><td><select name="is_majia" >';
        echo '<option value="0">'.$Lang['is_majia'].'</option>';
        echo '<option value="1" '.$is_majia_1.'>'.$Lang['is_majia_0'].'</option>';
        echo '<option value="2" '.$is_majia_2.'>'.$Lang['is_majia_1'].'</option>';
        echo '</select></td></tr>';

        $status_1 = $status_2 = "";
        if($status == 1){ $status_1 = "selected";}
        if($status == 2){ $status_2 = "selected";}
        echo '<tr><td width="100" align="right"><b>' . $Lang['status'] . '</b></td><td><select name="status" >';
        echo '<option value="0">'.$Lang['status'].'</option>';
        echo '<option value="1" '.$status_1.'>'.$Lang['normal'].'</option>';
        echo '<option value="2" '.$status_2.'>'.$Lang['fenghao'].'</option>';
        echo '</select></td></tr>';
    }
    
    $all_1 = $all_2 = "";
    if($all == 1){ $all_1 = "selected";}
    if($all == 2){ $all_2 = "selected";}
    echo '<tr><td width="100" align="right"><b>' . $Lang['info_all_user'] . '</b></td><td><select name="all" >';
    echo '<option value="0">'.$Lang['info_all_user'].'</option>';
    echo '<option value="1" '.$all_1.'>'.$Lang['info_ok_user'].'</option>';
    echo '<option value="2" '.$all_2.'>'.$Lang['info_no_user'].'</option>';
    echo '</select></td></tr>';
    
    showsubmit('submit', 'submit');
    showtablefooter();
    showformfooter();
    
    tomshownavheader();
    if($jyConfig['open_ucenter'] == 1){
        tomshownavli($Lang['add_user'],$manageUrl.'&mod=add2',false,true);
    }else{
        tomshownavli($Lang['add_user'],$manageUrl.'&mod=add',false,true);
    }
    tomshownavli($Lang['add_gift'],$adminBaseUrl.'&tmod=gift',false);
    tomshownavli($Lang['qunfa_tz_title'],$modBasePageUrl.'&act=addqunfa&formhash='.FORMHASH,false);
    //tomshownavli($Lang['qfmbxx_tz_title'],$modBasePageUrl.'&act=addqfmbxx&formhash='.FORMHASH,false);
    tomshownavli($Lang['report_list'],$adminBaseUrl.'&tmod=report',false);
    tomshownavli($Lang['shenhe_user_list'],$adminBaseUrl.'&tmod=usershenhe',false);
    tomshownavli($Lang['shenhe_pic_list'],$adminBaseUrl.'&tmod=picshenhe',false);
    tomshownavli($Lang['pm_message_list'],$adminBaseUrl.'&tmod=pmMessage',false);
    tomshownavli($Lang['daochu'],$adminBaseUrl.'&tmod=doDao',false);
    tomshownavfooter();
    
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $Lang['user_list'] . '</th></tr>';
    echo '<tr class="header">';
    echo '<th>ID</th>';
    echo '<th>' . $Lang['nickname'] . '</th>';
    echo '<th>' . $Lang['sex'] . '</th>';
    echo '<th>' . $Lang['age'] . '</th>';
    echo '<th>' . $Lang['score'] . '</th>';
    echo '<th>' . $Lang['jy_type'] . '</th>';
    echo '<th>' . $Lang['edit_vip_id'] . '</th>';
    echo '<th>' . $Lang['closed'] . '</th>';
    echo '<th>' . $Lang['shouji_rz'] . '</th>';
    echo '<th>' . $Lang['renzheng'] . '</th>';
    echo '<th>' . $Lang['recommend'] . '</th>';
    echo '<th>' . $Lang['is_majia'] . '</th>';
    echo '<th>' . $Lang['status'] . '</th>';
    echo '<th>' . $Lang['add_time'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    foreach ($userList as $key => $value){
        $addTime = dgmdate($value['add_time'], 'Y-m-d',$tomSysOffset);
        $edit_vip_idName = "";
        if($value['vip_id'] == 1){
            $edit_vip_idName = '<font color="#009933">'.$Lang['edit_vip_id_1'].'</font>';
        }else{
            $edit_vip_idName = $Lang['edit_vip_id_0'];
        }
        $closeName = "";
        if($value['closed'] == 1){
            $closeName = '<font color="#FF0000">'.$Lang['close'].'</font>';
        }else{
            $closeName = '<font color="#009933">'.$Lang['open'].'</font>';
        }
        $sexName = '';
        if($value['sex'] == 1){
            $sexName = $Lang['man'];
        }else if($value['sex'] == 2){
            $sexName = $Lang['woman'];
        }else{
            $sexName = '-';
        }
        
        $jyTypeOne = "";
        $jyTypeTwo = "";
        if($value['friend'] == 1){
            $jyTypeOne= $Lang['jy'];
        }
        if($value['marriage'] == 1){
            $jyTypeTwo= $Lang['hl'];
        }
        
        if($value['year'] > 0){
            if($jyConfig['age_type_id'] == 1){
                $age = $nowYear - $value['year'];
            }else{
                $age = $nowYear - $value['year'] + 1;
            }
        }else{
            $age = '-';
        }
        
        echo '<tr>';
        echo '<td>' . $value['id'] . '</td>';
        echo '<td>' . $value['nickname'] . '</td>'; 
        echo '<td>' . $sexName . '</td>';
        echo '<td>' . $age . '</td>';
        echo '<td>' . $value['score'] . '</td>';
        echo '<td>' . $jyTypeOne." ".$jyTypeTwo . '</td>';
        echo '<td>' . $edit_vip_idName . '</td>';
        echo '<td>' . $closeName . '</td>';
         if($value['phone_renzheng'] == 1){
            echo '<td><font color="#009933">' . $Lang['rz_yes'] . '</font>(<a href="'.$modBaseUrl.'&act=sjrzdel&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['rz_del'] . '</a>)</td>';
        }else{
            echo '<td><font color="#FF0000">' . $Lang['rz_no'] . '</font>(<a href="'.$modBaseUrl.'&act=sjrzadd&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['rz_add'] . '</a>)</td>';
        }
        if($value['renzheng'] == 1){
            echo '<td><font color="#009933">' . $Lang['rz_yes'] . '</font>(<a href="'.$modBaseUrl.'&act=rzdel&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['rz_del'] . '</a>)</td>';
        }else{
            echo '<td><font color="#FF0000">' . $Lang['rz_no'] . '</font>(<a href="'.$modBaseUrl.'&act=rzadd&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['rz_add'] . '</a>)</td>';
        }
        if($value['recommend'] == 1 && $value['recommend_time'] > TIMESTAMP){
            echo '<td><font color="#009933">' . $Lang['rec_yes'] . '</font>(<a href="'.$modBaseUrl.'&act=recadd&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['rec_add'] . '</a>)(<a href="'.$modBaseUrl.'&act=recdel&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['rec_del'] . '</a>)</td>';
        }else{
            echo '<td><font color="#FF0000">' . $Lang['rec_no'] . '</font>(<a href="'.$modBaseUrl.'&act=recadd&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['rec_add'] . '</a>)</td>';
        }
        if($value['is_majia'] == 1){
            echo '<td><font color="#009933">' . $Lang['is_majia_1'] . '</font></td>';
        }else{
            echo '<td><font color="#FF0000">' . $Lang['is_majia_0'] . '</font></td>';
        }
        if($value['status'] == 1){
            echo '<td><font color="#009933">' . $Lang['normal'] . '</font>(<a href="'.$modBaseUrl.'&act=fenghao&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['fenghao'] . '</a>)</td>';
        }else{
            echo '<td><font color="#FF0000">' . $Lang['fenghao'] . '</font>(<a href="'.$modBaseUrl.'&act=normal&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['normal'] . '</a>)</td>';
        }
        echo '<td>' . $addTime . '</td>';
        echo '<td style="line-height: 25px;">';
        echo '<a href="'.$modBaseUrl.'&act=show&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['show'] . '</a>&nbsp;&nbsp;|&nbsp;&nbsp;';
        echo '<a href="'.$modBaseUrl.'&act=editscore&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['edit_score'] . '</a><br/>';
        echo '<a href="'.$modBaseUrl.'&act=editvip&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['edit_vip_title'] . '</a>&nbsp;&nbsp;|&nbsp;&nbsp;';
        echo '<a href="'.$manageUrl.'&mod=edit&user_id='.$value['id'].'" target="_blank">' . $Lang['edit_user'] . '</a><br/>';
        echo '<a href="'.$modBaseUrl.'&act=goldChange&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['gold_change_title'] . '</a>&nbsp;&nbsp;|&nbsp;&nbsp;';
        echo '<a href="'.$modBaseUrl.'&act=flowerslog&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['flowerslog_title'] . '</a><br/>';
        echo '<a href="'.$modBaseUrl.'&act=addtz&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['sys_tz_title'] . '</a>&nbsp;&nbsp;|&nbsp;&nbsp;';
        echo '<a href="'.$adminBaseUrl.'&tmod=pmMessage&user_id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['pm_message_user_title'] . '</a><br/>';
        echo '<a href="javascript:void(0);" onclick="del_confirm(\''.$modBaseUrl.'&act=del&id='.$value['id'].'&formhash='.FORMHASH.'\');">' . $Lang['delete'] . '</a>';
        
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
