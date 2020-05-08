<?php
// +----------------------------------------------------------------------
// | Copyright:    (c) 2009-2019 https://www.dashulai.com All rights reserved.
// +----------------------------------------------------------------------
// | Developer:    大叔来 (https://dwz.cn/q4scNR7Q请收藏备用!)
// +----------------------------------------------------------------------
// | Author:       by Dashulai.com. 技术支持/更新维护：官网 https://www.dashulai.com
// +----------------------------------------------------------------------
if(!defined('IN_DISCUZ')){
	exit('Access Denied');
}

include DISCUZ_ROOT.'./source/plugin/tom_love/class/tom.upload.php';
if($_GET['act'] == 'pic' && $_GET['formhash'] == FORMHASH){
    $xiangqin_id = isset($_GET['uid'])? daddslashes($_GET['uid']): 0;
    $pic_num = C::t('#tom_xiangqin#tom_xiangqin_photo')->fetch_all_count(" AND xiangqin_id = {$__Xiangqin['id']}");
    if($pic_num < $xiangqinConfig['pic_num']){
    }else{
        echo 'OVER|url';exit;
    }
    
    $upload = new discuz_upload();
    $_FILES["uploaderInput"]['name'] = addslashes(diconv(urldecode($_FILES["uploaderInput"]['name']), 'UTF-8'));
    
    if(!getimagesize($_FILES['uploaderInput']['tmp_name']) || !$upload->init($_FILES['uploaderInput'], 'common', random(3, 1), random(8)) || !$upload->save()) {
        echo 'NO|url';exit;
    }
    
    require_once libfile('class/image');
    $image = new image();
    $image->Thumb($upload->attach['target'], '', 720, 720, 1, 1);
    
    $picurl = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$upload->attach['attachment'];
    
    $insertData = array();
    $insertData['xiangqin_id']      = $xiangqin_id;
    $insertData['pic_url']          = $upload->attach['attachment'];
    C::t('#tom_xiangqin#tom_xiangqin_photo')->insert($insertData,true);
    $picid = C::t('#tom_xiangqin#tom_xiangqin_photo')->insert_id();
    
    $updateData = array();
    echo 'OK|'.$picurl.'|'.$picid;exit;
    
}