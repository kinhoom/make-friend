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

if($_GET['act'] == 'add' && $_GET['formhash'] == FORMHASH){
    
    $outArr = array(
        'status'=> 0,
    );
    
    $nickname = isset($_GET['nickname'])? daddslashes(diconv(urldecode($_GET['nickname']),'utf-8')):'';
    
    $insertData = array();
    $insertData['nickname'] = $nickname;
    $insertData['score']    = $jyConfig['score_num'];
    $insertData['avatar']   = "source/plugin/tom_love/images/avatar_default.jpg";
    $insertData['sex']      = 0;
    $insertData['is_majia'] = 1;
    $insertData['add_time'] = TIMESTAMP;
    C::t('#tom_love#tom_love')->insert($insertData);

    $userId = C::t('#tom_love#tom_love')->insert_id();
    
    $outArr = array(
        'status'=> 200,
        'id' => $userId,
    );
    echo json_encode($outArr); exit;
}

$manageUrl = "plugin.php?id=tom_love:manage&mod=add2";
$editUrl = "plugin.php?id=tom_love:manage&mod=edit&act=add&user_id=";

$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
include template("tom_love:admin/add2user");