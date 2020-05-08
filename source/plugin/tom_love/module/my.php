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

$act = isset($_GET['act'])? trim($_GET['act']):'';

if($__UserInfo['year'] > 0){    
    if($jyConfig['age_type_id'] == 1){
        $age = $nowYear - $__UserInfo['year'];
    }else{
        $age = $nowYear - $__UserInfo['year'] + 1;
    }
}else{
    $age = '';
}

$__UserInfo['province_id']  = isset($__UserInfo['province_id']) ? intval($__UserInfo['province_id']) :0;
$__UserInfo['city_id']      = isset($__UserInfo['city_id']) ? intval($__UserInfo['city_id']) :0;
$__UserInfo['area_id']      = isset($__UserInfo['area_id']) ? intval($__UserInfo['area_id']) :0;
$__UserInfo['hjprovince_id'] = isset($__UserInfo['hjprovince_id']) ? intval($__UserInfo['hjprovince_id']) :0;
$__UserInfo['hjcity_id']    = isset($__UserInfo['hjcity_id']) ? intval($__UserInfo['hjcity_id']) :0;
$__UserInfo['hjarea_id']    = isset($__UserInfo['hjarea_id']) ? intval($__UserInfo['hjarea_id']) :0;

$infoBox = 0;
$myBox = 0;
if($act == 'info'){
    $infoBox = 1;
    
    if($__UserInfo['phone_renzheng'] == 0 && $jyConfig['open_must_tel_renzheng'] == 1){
        dheader('location:'.$_G['siteurl'].$phoneUrl);exit;
    }
    
    $provinceList = $hjprovinceList = C::t('#tom_love#tom_love_district')->fetch_all_by_level(1);
    $cityList = C::t('#tom_love#tom_love_district')->fetch_all_by_upid($__UserInfo['province_id']);
    $areaList = C::t('#tom_love#tom_love_district')->fetch_all_by_upid($__UserInfo['city_id']);
    $townsList = C::t('#tom_love#tom_love_district')->fetch_all_by_upid($__UserInfo['area_id']);
    $hjcityList = C::t('#tom_love#tom_love_district')->fetch_all_by_upid($__UserInfo['hjprovince_id']);
    $hjareaList = C::t('#tom_love#tom_love_district')->fetch_all_by_upid($__UserInfo['hjcity_id']);
    $hjtownsList = C::t('#tom_love#tom_love_district')->fetch_all_by_upid($__UserInfo['hjarea_id']);
    $yearArray = array();
    $startYear = $nowYear - 60;
    $endYear = $nowYear - 15;
    for($i=$startYear;$i<=$endYear;$i++){
        $yearArray[] = $i;
    }
    
}else if($act == 'saveInfo' && $_GET['formhash'] == FORMHASH){
    
    if('utf-8' != CHARSET) {
        if(defined('IN_MOBILE')){
        }else{
            foreach($_POST AS $pk => $pv) {
                if(!is_numeric($pv)) {
                    $_GET[$pk] = $_POST[$pk] = wx_iconv_recurrence($pv);	
                }
            }
        }
    }
    
    $friend = isset($_GET['friend'])? intval($_GET['friend']):0;
    $marriage = isset($_GET['marriage'])? intval($_GET['marriage']):0;
    $nickname = isset($_GET['nickname'])? daddslashes($_GET['nickname']):'';
    $sex = isset($_GET['sex'])? intval($_GET['sex']):0;
    $year = isset($_GET['year'])? intval($_GET['year']):0;
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
    $height = isset($_GET['height'])? intval($_GET['height']):0;
    $weight = isset($_GET['weight'])? intval($_GET['weight']):0;
    $edu = isset($_GET['edu'])? intval($_GET['edu']):0;
    $pay = isset($_GET['pay'])? intval($_GET['pay']):0;
    $marital = isset($_GET['marital'])? intval($_GET['marital']):0;
    $wx = isset($_GET['wx'])? daddslashes($_GET['wx']):0;
    $qq = isset($_GET['qq'])? daddslashes($_GET['qq']):0;
    $tel = isset($_GET['tel'])? daddslashes($_GET['tel']):'';
    $describe = isset($_GET['describe'])? daddslashes($_GET['describe']):'';
    $mate_demands = isset($_GET['mate_demands'])? daddslashes($_GET['mate_demands']):'';
    
    if(C::t('#tom_love#tom_love')->check_nickname($__UserInfo['id'],$nickname)){
        echo '201';exit;
    }
    
    $match = "/\d{11}/";
	$string = preg_replace($match, '*****', $nickname);
    if($string != $nickname){
        echo '202';exit;
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
    
    if($__UserInfo['year'] == 0 && $jyConfig['zl_reward_score'] > 0){
        
        $updateData['score'] = $__UserInfo['score'] + $jyConfig['zl_reward_score'];
        
        $insertData = array();
        $insertData['user_id'] = $__UserInfo['id'];
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
    if($__UserInfo['phone_renzheng'] != 1){
        $updateData['tel'] = $tel;
    }
    $updateData['area'] = $provinceStr." ".$cityStr." ".$areaStr." ".$townsStr;
    $updateData['hjarea'] = $hjprovinceStr." ".$hjcityStr." ".$hjareaStr." ".$hjtownsStr;
    C::t('#tom_love#tom_love')->update($__UserInfo['id'],$updateData);
    echo '1';exit;
}else if($act == 'close' && $_GET['formhash'] == FORMHASH){
    $close = isset($_GET['close'])? intval($_GET['close']):0;
    $updateData = array();
    $updateData['closed'] = $close;
    C::t('#tom_love#tom_love')->update($__UserInfo['id'],$updateData);
    echo '1';exit;
}else if($act == 'smstp_open' && $_GET['formhash'] == FORMHASH){
    $smstp_open = isset($_GET['smstp_open'])? intval($_GET['smstp_open']):0;
    $updateData = array();
    $updateData['smstp_open'] = $smstp_open;
    C::t('#tom_love#tom_love')->update($__UserInfo['id'],$updateData);
    echo '1';exit;
}else if($act == 'sign' && $_GET['formhash'] == FORMHASH){
    
    $isTodaySignCount = C::t('#tom_love#tom_love_sign')->fetch_all_count(" AND user_id={$__UserInfo['id']} AND time_key = {$nowTime} ");
    if($isTodaySignCount > 0 ){}else{
        $updateData = array();
        $updateData['score'] = $__UserInfo['score'] + $jyConfig['sign_score'];
        $updateData['sign_time'] = TIMESTAMP;
        C::t('#tom_love#tom_love')->update($__UserInfo['id'],$updateData);

        $insertData = array();
        $insertData['user_id'] = $__UserInfo['id'];
        $insertData['time_key'] = $nowTime;
        $insertData['sign_time'] = TIMESTAMP;
        C::t('#tom_love#tom_love_sign')->insert($insertData);

        $insertData = array();
        $insertData['user_id'] = $__UserInfo['id'];
        $insertData['score_value'] = $jyConfig['sign_score'];
        $insertData['log_type'] = 5;
        $insertData['log_time'] = TIMESTAMP;
        C::t('#tom_love#tom_love_scorelog')->insert($insertData);
        update_phb($__UserInfo['id'], 'signdays');
    }
    
    echo '1';exit;
}else{
    $myBox = 1;
    
    if($__UserInfo['recommend_time'] > 0){
        $recommendTime = dgmdate($__UserInfo['recommend_time'], 'Y-m-d',$tomSysOffset);
    }
    
    $renzhengStatus = 0;
    $renzhengInfo = C::t('#tom_love#tom_love_renzheng')->fetch_by_uid($__UserInfo['id']);
    if($__UserInfo['renzheng'] == 1){
        $renzhengStatus = 1;
    }else if($renzhengInfo && $renzhengInfo['renzheng_status'] == 1 && $__UserInfo['renzheng'] == 0){
        $renzhengStatus = 2;
    }
    
    $meanlianCount = C::t('#tom_love#tom_love_guanxi')->fetch_all_count(" AND type_id=2 AND user_id={$__UserInfo['id']} ");
    $anlianmeCount = C::t('#tom_love#tom_love_guanxi')->fetch_all_count(" AND type_id=2 AND gx_user_id={$__UserInfo['id']} ");
    
    $meChakanCount = C::t('#tom_love#tom_love_guanxi')->fetch_all_count(" AND type_id=1 AND user_id={$__UserInfo['id']} ");
    $chakanMeCount = C::t('#tom_love#tom_love_guanxi')->fetch_all_count(" AND type_id=1 AND gx_user_id={$__UserInfo['id']} ");
    
    $signCount = C::t('#tom_love#tom_love_sign')->fetch_all_count(" AND user_id={$__UserInfo['id']} AND sign_time > {$nowMonth} ");
    
    $isTodaySignCount = C::t('#tom_love#tom_love_sign')->fetch_all_count(" AND user_id={$__UserInfo['id']} AND time_key = {$nowTime} ");
    
    
    $showWanshanBtn = 0;
    if($__UserInfo['year'] == 0 && $jyConfig['zl_reward_score'] > 0){
        $showWanshanBtn = 1;
    }
    
}

$recUrl = "plugin.php?id=tom_love&mod=my&uid={$__UserInfo['id']}&act=rec&formhash=".FORMHASH;
$opensmstpUrl = "plugin.php?id=tom_love&mod=my&uid={$__UserInfo['id']}&act=smstp_open&formhash=".FORMHASH;
$closeUrl = "plugin.php?id=tom_love&mod=my&uid={$__UserInfo['id']}&act=close&formhash=".FORMHASH;
$signUrl = "plugin.php?id=tom_love&mod=my&uid={$__UserInfo['id']}&act=sign&formhash=".FORMHASH;
$saveUrl = "plugin.php?id=tom_love&mod=my";
$backUrl = "plugin.php?id=tom_love&mod=my";

$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
include template("tom_love:my");