<?php
/*
 * 源码出处：大-叔-来
 * 官方网址: www.dashulai.com
 * 备用网址: https://dwz.cn/q4scNR7Q(请收藏备用!)
 * 本资源来源于网络收集,仅供个人学习研究欣赏，请勿用于商业用途，并于下载24小时后删除!
 * 技术支持/更新维护：官网 https://www.dashulai.com
 * 
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$server_yasu_size = 640;
if($jyConfig['server_yasu_size'] > 0){
    $server_yasu_size = $jyConfig['server_yasu_size'];
}
include DISCUZ_ROOT.'./source/plugin/tom_love/class/tom.upload.php';
$upload = new tom_upload();

if($_GET['act'] == 'avatar' && $_GET['formhash'] == FORMHASH){
    $_FILES["Filedata"]['name'] = addslashes(diconv(urldecode($_FILES["Filedata"]['name']), 'UTF-8'));
    
    if($_FILES['Filedata']['size'] > $jyConfig['max_upload_size']*1024){
        echo 'SIZE|url';exit;
    }
    
    if(!getimagesize($_FILES['Filedata']['tmp_name']) || !$upload->init($_FILES['Filedata'], 'common', random(3, 1), random(8)) || !$upload->save()) {
        echo 'NO|url';exit;
    }
    
    require_once libfile('class/image');
    $image = new image();
    $image->Thumb($upload->attach['target'], '', $server_yasu_size, $server_yasu_size, 1, 1);
    
    $picurl = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$upload->attach['attachment'];
    $updateData = array();
    $updateData['avatar'] = $upload->attach['attachment'];
    C::t('#tom_love#tom_love')->update($__UserInfo['id'],$updateData);
    echo 'OK|'.$picurl;exit;
    
}else if($_GET['act'] == 'theme' && $_GET['formhash'] == FORMHASH){
    $_FILES["Filedata"]['name'] = addslashes(diconv(urldecode($_FILES["Filedata"]['name']), 'UTF-8'));
    
    if($_FILES['Filedata']['size'] > $jyConfig['max_upload_size']*1024){
        echo 'SIZE|url';exit;
    }
    
    if(!getimagesize($_FILES['Filedata']['tmp_name']) || !$upload->init($_FILES['Filedata'], 'common', random(3, 1), random(8)) || !$upload->save()) {
        echo 'NO|url';exit;
    }
    
    require_once libfile('class/image');
    $image = new image();
    $image->Thumb($upload->attach['target'], '', $server_yasu_size, $server_yasu_size, 1, 1);
    
    $picurl = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$upload->attach['attachment'];
    $updateData = array();
    $updateData['theme'] = $upload->attach['attachment'];
    C::t('#tom_love#tom_love')->update($__UserInfo['id'],$updateData);
    echo 'OK|'.$picurl;exit;
    
}else if($_GET['act'] == 'photo' && $_GET['formhash'] == FORMHASH){
    $pic_num = C::t('#tom_love#tom_love_pic')->fetch_all_count(" AND user_id ={$__UserInfo['id']} ");
    if($pic_num < $jyConfig['pic_num']){
    }else{
        echo 'OVER|url';exit;
    }
    
    $_FILES["Filedata"]['name'] = addslashes(diconv(urldecode($_FILES["Filedata"]['name']), 'UTF-8'));
    
    if($_FILES['Filedata']['size'] > $jyConfig['max_upload_size']*1024){
        echo 'SIZE|url';exit;
    }
    
    if(!getimagesize($_FILES['Filedata']['tmp_name']) || !$upload->init($_FILES['Filedata'], 'common', random(3, 1), random(8)) || !$upload->save()) {
        echo 'NO|url';exit;
    }
    
    require_once libfile('class/image');
    $image = new image();
    $image->Thumb($upload->attach['target'], '', $server_yasu_size, $server_yasu_size, 1, 1);
    
    $picurl = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$upload->attach['attachment'];
    
    if($jyConfig['open_pic_shenhe'] == 1){
        $shenhe_status = 2;
    }else{
        $shenhe_status = 1;
    }
    
    $insertData = array();
    $insertData['user_id']          = $__UserInfo['id'];
    $insertData['pic_url']          = $upload->attach['attachment'];
    $insertData['shenhe_status']    = $shenhe_status;
    $picid = C::t('#tom_love#tom_love_pic')->insert($insertData,true);

    $updateData = array();
    $updateData['pic_num'] = $pic_num + 1;
    C::t('#tom_love#tom_love')->update($__UserInfo['id'],$updateData);
    echo 'OK|'.$picurl.'|'.$picid;exit;
    
}else if($_GET['act'] == 'renzheng1' && $_GET['formhash'] == FORMHASH){

    $_FILES["Filedata1"]['name'] = addslashes(diconv(urldecode($_FILES["Filedata1"]['name']), 'UTF-8'));
    
    if($_FILES['Filedata']['size'] > $jyConfig['max_upload_size']*1024){
        echo 'SIZE|url';exit;
    }
    
    if(!getimagesize($_FILES['Filedata1']['tmp_name']) || !$upload->init($_FILES['Filedata1'], 'common', random(3, 1), random(8)) || !$upload->save()) {
        echo 'NO|url';exit;
    }
    $picurl = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$upload->attach['attachment'];
    echo 'OK|'.$picurl.'|'.$upload->attach['attachment'];exit;
    
}else if($_GET['act'] == 'renzheng2' && $_GET['formhash'] == FORMHASH){

    $_FILES["Filedata2"]['name'] = addslashes(diconv(urldecode($_FILES["Filedata2"]['name']), 'UTF-8'));
    
    if($_FILES['Filedata']['size'] > $jyConfig['max_upload_size']*1024){
        echo 'SIZE|url';exit;
    }
    
    if(!getimagesize($_FILES['Filedata2']['tmp_name']) || !$upload->init($_FILES['Filedata2'], 'common', random(3, 1), random(8)) || !$upload->save()) {
        echo 'NO|url';exit;
    }
    $picurl = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$upload->attach['attachment'];
    echo 'OK|'.$picurl.'|'.$upload->attach['attachment'];exit;
}else if($_GET['act'] == 'renzheng3' && $_GET['formhash'] == FORMHASH){

    $_FILES["Filedata3"]['name'] = addslashes(diconv(urldecode($_FILES["Filedata3"]['name']), 'UTF-8'));
    
    if($_FILES['Filedata']['size'] > $jyConfig['max_upload_size']*1024){
        echo 'SIZE|url';exit;
    }
    
    if(!getimagesize($_FILES['Filedata3']['tmp_name']) || !$upload->init($_FILES['Filedata3'], 'common', random(3, 1), random(8)) || !$upload->save()) {
        echo 'NO|url';exit;
    }
    $picurl = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$upload->attach['attachment'];
    echo 'OK|'.$picurl.'|'.$upload->attach['attachment'];exit;
}else if($_GET['act'] == 'shuoshuo' && $_GET['formhash'] == FORMHASH){

    $_FILES["Filedata"]['name'] = addslashes(diconv(urldecode($_FILES["Filedata"]['name']), 'UTF-8'));
    
    if($_FILES['Filedata']['size'] > $jyConfig['max_upload_size']*1024){
        echo 'SIZE|url';exit;
    }
    
    if(!getimagesize($_FILES['Filedata']['tmp_name']) || !$upload->init($_FILES['Filedata'], 'common', random(3, 1), random(8)) || !$upload->save()) {
        echo 'NO|url';exit;
    }
    
    require_once libfile('class/image');
    $image = new image();
    $image->Thumb($upload->attach['target'], '', $server_yasu_size, $server_yasu_size, 1, 1);
    
    $picurl = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$upload->attach['attachment'];
    echo 'OK|'.$picurl.'|'.$upload->attach['attachment'];exit;
}else if($_GET['act'] == 'report' && $_GET['formhash'] == FORMHASH){

    $_FILES["Filedata"]['name'] = addslashes(diconv(urldecode($_FILES["Filedata"]['name']), 'UTF-8'));
    
    if($_FILES['Filedata']['size'] > $jyConfig['max_upload_size']*1024){
        echo 'SIZE|url';exit;
    }
    
    if(!getimagesize($_FILES['Filedata']['tmp_name']) || !$upload->init($_FILES['Filedata'], 'common', random(3, 1), random(8)) || !$upload->save()) {
        echo 'NO|url';exit;
    }
    
    require_once libfile('class/image');
    $image = new image();
    $image->Thumb($upload->attach['target'], '', $server_yasu_size, $server_yasu_size, 1, 1);
    
    $picurl = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$upload->attach['attachment'];
    echo 'OK|'.$picurl.'|'.$upload->attach['attachment'];exit;
}