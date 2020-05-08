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

$user_id = isset($_GET['user_id'])? intval($_GET['user_id']):0;
$userInfo = C::t('#tom_love#tom_love')->fetch_by_id($user_id);
$server_yasu_size = 640;
if($jyConfig['server_yasu_size'] > 0){
    $server_yasu_size = $jyConfig['server_yasu_size'];
}

if($_GET['act']=='photo' && $_GET['formhash'] == FORMHASH){
    
    $pic_num = C::t('#tom_love#tom_love_pic')->fetch_all_count(" AND user_id ={$userInfo['id']} ");
    if($pic_num < $jyConfig['pic_num']){
    }else{
        echo 'OVER|url';exit;
    }
    
    $upload = new discuz_upload();
    $_FILES["filedata1"]['name'] = addslashes(diconv(urldecode($_FILES["filedata1"]['name']), 'UTF-8'));
    
    if($_FILES['filedata1']['size'] > $jyConfig['max_upload_size']*1024){
        echo 'SIZE|url';exit;
    }

    if(!getimagesize($_FILES['filedata1']['tmp_name']) || !$upload->init($_FILES['filedata1'], 'common', random(3, 1), random(8)) || !$upload->save()) {
        echo 'NO|url';exit;
    }
    
    require_once libfile('class/image');
    $image = new image();
    $image->Thumb($upload->attach['target'], '', $server_yasu_size, $server_yasu_size, 1, 1);
    
    $picurl = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$upload->attach['attachment'];
    $insertData = array();
    $insertData['user_id'] = $userInfo['id'];
    $insertData['pic_url'] = $upload->attach['attachment'];
    $picid = C::t('#tom_love#tom_love_pic')->insert($insertData,true);

    $updateData = array();
    $updateData['pic_num'] = $pic_num + 1;
    C::t('#tom_love#tom_love')->update($userInfo['id'],$updateData);
    echo 'OK|'.$picurl.'|'.$picid;exit;
    
}else if($_GET['act'] == 'avatar' && $_GET['formhash'] == FORMHASH){
    $upload = new discuz_upload();
    $_FILES["filedata"]['name'] = addslashes(diconv(urldecode($_FILES["filedata"]['name']), 'UTF-8'));
    
    if($_FILES['filedata']['size'] > $jyConfig['max_upload_size']*1024){
        echo 'SIZE|url';exit;
    }

    if(!getimagesize($_FILES['filedata']['tmp_name']) || !$upload->init($_FILES['filedata'], 'common', random(3, 1), random(8)) || !$upload->save()) {
        echo 'NO|url';exit;
    }
    
    require_once libfile('class/image');
    $image = new image();
    $image->Thumb($upload->attach['target'], '', $server_yasu_size, $server_yasu_size, 1, 1);
    
    $picurl = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$upload->attach['attachment'];
    $updateData = array();
    $updateData['avatar'] = $upload->attach['attachment'];
    C::t('#tom_love#tom_love')->update($userInfo['id'],$updateData);
    echo 'OK|'.$picurl;exit;
}else if($_GET['act'] == 'del' && $_GET['formhash'] == FORMHASH){
    $outArr = array(
        'status'=> 0,
    );
    $picid = intval($_GET['picid']);
    C::t('#tom_love#tom_love_pic')->delete($picid);
    
    $pic_num = C::t('#tom_love#tom_love_pic')->fetch_all_count(" AND user_id ={$userInfo['id']} ");
    $updateData = array();
    $updateData['pic_num'] = $pic_num;
    C::t('#tom_love#tom_love')->update($userInfo['id'],$updateData);
    $outArr = array(
        'status'=> 200,
    );
    echo json_encode($outArr); exit;
}else if($_GET['act'] == 'my' && $_GET['formhash'] == FORMHASH){

    $friend = isset($_GET['friend'])? intval($_GET['friend']):0;
    $marriage = isset($_GET['marriage'])? intval($_GET['marriage']):0;
    $nickname = isset($_GET['nickname'])? daddslashes(diconv(urldecode($_GET['nickname']),'utf-8')):"";
    $sex = isset($_GET['sex'])? intval($_GET['sex']):0;
    $year = isset($_GET['year'])? intval($_GET['year']):0;
    $marital = isset($_GET['marital'])? intval($_GET['marital']):0;
    $weight = isset($_GET['weight'])? intval($_GET['weight']):0;
    $height = isset($_GET['height'])? intval($_GET['height']):0;
    $country = isset($_GET['country'])? intval($_GET['country']):0;
    $province = isset($_GET['province'])? intval($_GET['province']):0;
    $city = isset($_GET['city'])? intval($_GET['city']):0;
    $area = isset($_GET['area'])? intval($_GET['area']):0;
    $towns = isset($_GET['towns'])? intval($_GET['towns']):0;
    
    $hjcountry = isset($_GET['hjcountry'])? intval($_GET['hjcountry']):0;
    $hjprovince = isset($_GET['hjprovince'])? intval($_GET['hjprovince']):0;
    $hjcity = isset($_GET['hjcity'])? intval($_GET['hjcity']):0;
    $hjarea = isset($_GET['hjarea'])? intval($_GET['hjarea']):0;
    $hjtowns = isset($_GET['hjtowns'])? intval($_GET['hjtowns']):0;
    
    $job = isset($_GET['job'])? intval($_GET['job']):0;
    $edu = isset($_GET['edu'])? intval($_GET['edu']):0;
    $pay = isset($_GET['pay'])? intval($_GET['pay']):0;
    $wx = isset($_GET['wx'])? daddslashes(diconv(urldecode($_GET['wx']),'utf-8')):"";
    $qq = isset($_GET['qq'])? daddslashes(diconv(urldecode($_GET['qq']),'utf-8')):"";
    $tel = isset($_GET['tel'])? daddslashes(diconv(urldecode($_GET['tel']),'utf-8')):"";
    $describe = isset($_GET['describe'])? daddslashes(diconv(urldecode($_GET['describe']),'utf-8')):"";
    $mate_demands = isset($_GET['mate_demands'])? daddslashes(diconv(urldecode($_GET['mate_demands']),'utf-8')):"";

    if(C::t('#tom_love#tom_love')->check_nickname($userInfo['id'],$nickname)){
        echo '201';exit;
    }
    
    $provinceStr = "";
    $cityStr = "";
    $areaStr = "";
    $townsStr = "";
    $provinceInfo = C::t('#tom_love#tom_love_district')->fetch_by_id($province);
    $cityInfo = C::t('#tom_love#tom_love_district')->fetch_by_id($city);
    $areaInfo = C::t('#tom_love#tom_love_district')->fetch_by_id($area);
    $townsInfo = C::t('#tom_love#tom_love_district')->fetch_by_id($towns);
    if($provinceInfo){
        $provinceStr = $provinceInfo['name'];
    }
    if($cityInfo){
        $cityStr = $cityInfo['name'];
    }
    if($areaInfo){
        $areaStr = $areaInfo['name'];
    }
    if($townsInfo){
        $townsStr = $townsInfo['name'];
    }
    
    $hjprovinceStr = "";
    $hjcityStr = "";
    $hjareaStr = "";
    $hjtownsStr = "";
    $hjprovinceInfo = C::t('#tom_love#tom_love_district')->fetch_by_id($hjprovince);
    $hjcityInfo = C::t('#tom_love#tom_love_district')->fetch_by_id($hjcity);
    $hjareaInfo = C::t('#tom_love#tom_love_district')->fetch_by_id($hjarea);
    $hjtownsInfo = C::t('#tom_love#tom_love_district')->fetch_by_id($hjtowns);
    if($hjprovinceInfo){
        $hjprovinceStr = $hjprovinceInfo['name'];
    }
    if($hjcityInfo){
        $hjcityStr = $hjcityInfo['name'];
    }
    if($hjareaInfo){
        $hjareaStr = $hjareaInfo['name'];
    }
    if($hjtownsInfo){
        $hjtownsStr = $hjtownsInfo['name'];
    }
    
    $updateData = array();
    
    if(empty($userInfo['describe']) && $jyConfig['zl_reward_score'] > 0){
        $updateData['score'] = $userInfo['score'] + $jyConfig['zl_reward_score'];
        
        $insertData = array();
        $insertData['user_id'] = $userInfo['id'];
        $insertData['score_value'] = $jyConfig['zl_reward_score'];
        $insertData['log_type'] = 4;
        $insertData['log_time'] = TIMESTAMP;
        C::t('#tom_love#tom_love_scorelog')->insert($insertData);
        
    }
    
    $updateData['friend'] = $friend;
    $updateData['marriage'] = $marriage;
    $updateData['nickname'] = $nickname;
    $updateData['sex'] = $sex;
    $updateData['year'] = $year;
    $updateData['country_id'] = $country;
    $updateData['province_id'] = $province;
    $updateData['city_id'] = $city;
    $updateData['area_id'] = $area;
    $updateData['towns_id'] = $towns;
    $updateData['hjcountry_id'] = $hjcountry;
    $updateData['hjprovince_id'] = $hjprovince;
    $updateData['hjcity_id'] = $hjcity;
    $updateData['hjarea_id'] = $hjarea;
    $updateData['hjtowns_id'] = $hjtowns;
    $updateData['work_id'] = $job;
    $updateData['height'] = $height;
    $updateData['weight'] = $weight;
    $updateData['edu_id'] = $edu;
    $updateData['pay_id'] = $pay;
    $updateData['marital_id'] = $marital;
    $updateData['describe'] = $describe;
    $updateData['mate_demands'] = $mate_demands;
    $updateData['wx'] = $wx;
    $updateData['qq'] = $qq;
    $updateData['tel'] = $tel;
    $updateData['area'] = $provinceStr." ".$cityStr." ".$areaStr." ".$townsStr;
    $updateData['hjarea'] = $hjprovinceStr." ".$hjcityStr." ".$hjareaStr." ".$hjtownsStr;
    C::t('#tom_love#tom_love')->update($userInfo['id'],$updateData);
    echo '1';exit;
    
    
}


$userPicList = C::t('#tom_love#tom_love_pic')->fetch_all_list("AND user_id = {$user_id}", "ORDER BY id DESC", 0, 100);
foreach($userPicList as $key => $value){
    if(!preg_match('/^http/', $value['pic_url'])){
        if(strpos($value['pic_url'], 'source/plugin/tom_love') === false){
            $userPicList[$key]['pic_url_1'] = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$value['pic_url'];
        }else{
            $userPicList[$key]['pic_url_1'] = $value['pic_url'];
        }
    }else{
        $userPicList[$key]['pic_url_1'] = $value['pic_url'];
    }
}

if($userInfo['avatar']){
    $userInfo['avatar'] = tom_avatar($userInfo['avatar']);
}

$provinceList = $hjprovinceList = C::t('#tom_love#tom_love_district')->fetch_all_by_level(1);
$cityList = C::t('#tom_love#tom_love_district')->fetch_all_by_upid($userInfo['province_id']);
$areaList = C::t('#tom_love#tom_love_district')->fetch_all_by_upid($userInfo['city_id']);
$townsList = C::t('#tom_love#tom_love_district')->fetch_all_by_upid($userInfo['area_id']);
$hjcityList = C::t('#tom_love#tom_love_district')->fetch_all_by_upid($userInfo['hjprovince_id']);
$hjareaList = C::t('#tom_love#tom_love_district')->fetch_all_by_upid($userInfo['hjcity_id']);
$hjtownsList = C::t('#tom_love#tom_love_district')->fetch_all_by_upid($userInfo['hjarea_id']);

$allow_upload_num = $jyConfig['pic_num'] - $userInfo['pic_num'];
if($allow_upload_num < 1){
    $allow_upload_num = 0;
}

$yearArray = array();
$startYear = $nowYear - 60;
$endYear = $nowYear - 15;
for($i=$startYear;$i<=$endYear;$i++){
    $yearArray[] = $i;
}

$delUrl = "plugin.php?id=tom_love:manage&mod=edit&act=del&user_id={$userInfo['id']}&formhash=".FORMHASH;
$uploadUrl1 = "plugin.php?id=tom_love:manage&mod=edit&user_id={$userInfo['id']}&act=photo&formhash=".FORMHASH;
$uploadUrl = "plugin.php?id=tom_love:manage&mod=edit&act=avatar&user_id={$userInfo['id']}&formhash=".FORMHASH;
$saveUrl = "plugin.php?id=tom_love:manage&mod=edit&act=my&user_id={$userInfo['id']}&formhash=".FORMHASH;

$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
include template("tom_love:admin/edituser");