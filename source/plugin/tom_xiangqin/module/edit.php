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

$act       = isset($_GET['act'])? trim($_GET['act']):'';

if($act == 'saveInfo' && $_GET['formhash'] == FORMHASH){
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
    
    if($__Xiangqin['is_ok'] != 1){
        $auto_id = 0;
        $autoidTmp  = C::t('#tom_xiangqin#tom_xiangqin_autoid')->fetch_all_list(""," ORDER BY id DESC ",0,1);
        if(is_array($autoidTmp) && !empty($autoidTmp) && !empty($autoidTmp[0]['id'])){
            if($autoidTmp[0]['id'] > 9990 && $autoidTmp[0]['id'] < 101010 ){
                $insertData = array();
                $insertData['id']               = 101011;
                $insertData['add_time']         = TIMESTAMP;
                if(C::t('#tom_xiangqin#tom_xiangqin_autoid')->insert($insertData)){
                    $auto_id = C::t('#tom_xiangqin#tom_xiangqin_autoid')->insert_id();
                }
            }else{
                $insertData = array();
                $insertData['add_time']         = TIMESTAMP;
                if(C::t('#tom_xiangqin#tom_xiangqin_autoid')->insert($insertData)){
                    $auto_id = C::t('#tom_xiangqin#tom_xiangqin_autoid')->insert_id();
                }
            }
        }else{
            $insertData = array();
            $insertData['id']               = 1011;
            $insertData['add_time']         = TIMESTAMP;
            if(C::t('#tom_xiangqin#tom_xiangqin_autoid')->insert($insertData)){
                $auto_id = C::t('#tom_xiangqin#tom_xiangqin_autoid')->insert_id();
            }
        }
        $user_no = '';
        $auto_id_str = strval($auto_id);
        if($auto_id > 101010){
            $rand_num1 = mt_rand(1, 9);
            $user_no.= $auto_id_str[0].$auto_id_str[1].$rand_num1;
            $rand_num2 = mt_rand(1, 9);
            $user_no.= $auto_id_str[2].$auto_id_str[3].$rand_num2;
            $rand_num3 = mt_rand(1, 9);
            $user_no.= $auto_id_str[4].$auto_id_str[5].$rand_num3;
        }else{
            $rand_num1 = mt_rand(1, 9);
            $user_no.= $auto_id_str[0].$auto_id_str[1].$rand_num1;
            $rand_num2 = mt_rand(1, 9);
            $user_no.= $auto_id_str[2].$auto_id_str[3].$rand_num2;
        }
        $updateData = array();
        $updateData['user_no']       = $user_no;
        C::t('#tom_xiangqin#tom_xiangqin')->update($__Xiangqin['id'],$updateData);
    }
    $birthday           = isset($_GET['birthday'])? daddslashes($_GET['birthday']):'';
    $ymdArr             = explode('-', $birthday);
    $birth_year         = $ymdArr[0];
    $birth_month        = $ymdArr[1];
    $birth_day          = $ymdArr[2];
    $xm                 = isset($_GET['xm'])? daddslashes($_GET['xm']):'';
    $sex                = isset($_GET['sex'])? intval($_GET['sex']):0;
    $height             = isset($_GET['height'])? intval($_GET['height']):0;
    $weight             = isset($_GET['weight'])? intval($_GET['weight']):0;
    $xingzuo_id         = isset($_GET['xingzuo_id'])? intval($_GET['xingzuo_id']):0;
    $shuxiang_id        = isset($_GET['shuxiang_id'])? intval($_GET['shuxiang_id']):0;
    $xuexing_id         = isset($_GET['xuexing_id'])? intval($_GET['xuexing_id']):0;
    $minzu_id           = isset($_GET['minzu_id'])? intval($_GET['minzu_id']):0;
    $job                = isset($_GET['job'])? daddslashes($_GET['job']):0;
    $tel                = isset($_GET['tel'])? daddslashes($_GET['tel']):'';
    $edu_id             = isset($_GET['edu_id'])? intval($_GET['edu_id']):0;
    $marital_id         = isset($_GET['marital_id'])? intval($_GET['marital_id']):0;
    $child_id           = isset($_GET['child_id'])? intval($_GET['child_id']):0;
    $wx                 = isset($_GET['wx'])? daddslashes($_GET['wx']):0;
    $qq                 = isset($_GET['qq'])? daddslashes($_GET['qq']):0;
    $shouru             = isset($_GET['shouru'])? daddslashes($_GET['shouru']):0;
    $house_id           = isset($_GET['house_id'])? intval($_GET['house_id']):0;
    $che_id             = isset($_GET['che_id'])? intval($_GET['che_id']):0;
    $zheou_min_age      = isset($_GET['zheou_min_age'])? intval($_GET['zheou_min_age']):0;
    $zheou_max_age      = isset($_GET['zheou_max_age'])? intval($_GET['zheou_max_age']):0;
    $zheou_min_height   = isset($_GET['zheou_min_height'])? intval($_GET['zheou_min_height']):0;
    $zheou_max_height   = isset($_GET['zheou_max_height'])? intval($_GET['zheou_max_height']):0;
    $zheou_marital_id   = isset($_GET['zheou_marital_id'])? intval($_GET['zheou_marital_id']):0;
    $zheou_minzu_id     = isset($_GET['zheou_minzu_id'])? intval($_GET['zheou_minzu_id']):0;
    $zheou_edu_id       = isset($_GET['zheou_edu_id'])? intval($_GET['zheou_edu_id']):0;
    $zheou_desc         = isset($_GET['zheou_desc'])? daddslashes($_GET['zheou_desc']):0;
    $describe           = isset($_GET['describe'])? daddslashes($_GET['describe']):0;
    $country_id         = isset($_GET['country_id'])? intval($_GET['country_id']):0;
    $province_id        = isset($_GET['province_id'])? intval($_GET['province_id']):0;
    $zheou_province_id  = isset($_GET['zheou_province_id'])? intval($_GET['zheou_province_id']):0;
    $city_id            = isset($_GET['city_id'])? intval($_GET['city_id']):0;
    $zheou_city_id      = isset($_GET['zheou_city_id'])? intval($_GET['zheou_city_id']):0;
    $area_id            = isset($_GET['area_id'])? intval($_GET['area_id']):0;
    $towns_id           = isset($_GET['towns_id'])? intval($_GET['towns_id']):0;
    $hjcountry_id       = isset($_GET['hjcountry_id'])? intval($_GET['hjcountry_id']):0;
    $hjprovince_id      = isset($_GET['hjprovince_id'])? intval($_GET['hjprovince_id']):0;
    $hjcity_id          = isset($_GET['hjcity_id'])? intval($_GET['hjcity_id']):0;
    $hjarea_id          = isset($_GET['hjarea_id'])? intval($_GET['hjarea_id']):0;
    $hjtowns_id         = isset($_GET['hjtowns_id'])? intval($_GET['hjtowns_id']):0;
    $is_open            = isset($_GET['is_open'])? intval($_GET['is_open']):0;
    
    $provinceStr = "";
    $cityStr = "";
    $areaStr = "";
    $townsStr = "";
    $provinceInfo = C::t('#tom_love#tom_love_district')->fetch_by_id($province_id);
    $cityInfo = C::t('#tom_love#tom_love_district')->fetch_by_id($city_id);
    $areaInfo = C::t('#tom_love#tom_love_district')->fetch_by_id($area_id);
    $townsInfo = C::t('#tom_love#tom_love_district')->fetch_by_id($towns_id);
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
    $hjprovinceInfo = C::t('#tom_love#tom_love_district')->fetch_by_id($hjprovince_id);
    $hjcityInfo = C::t('#tom_love#tom_love_district')->fetch_by_id($hjcity_id);
    $hjareaInfo = C::t('#tom_love#tom_love_district')->fetch_by_id($hjarea_id);
    $hjtownsInfo = C::t('#tom_love#tom_love_district')->fetch_by_id($hjtowns_id);
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
    $updateData['country_id']           = $country_id;
    $updateData['province_id']          = $province_id;
    //$updateData['zheou_province_id']    = $zheou_province_id;
    //$updateData['zheou_city_id']        = $zheou_city_id;
    $updateData['city_id']              = $city_id;
    $updateData['area_id']              = $area_id;
    $updateData['towns_id']             = $towns_id;
    $updateData['hjcountry_id']         = $hjcountry_id;
    $updateData['hjprovince_id']        = $hjprovince_id;
    $updateData['hjcity_id']            = $hjcity_id;
    $updateData['hjarea_id']            = $hjarea_id;
    $updateData['hjtowns_id']           = $hjtowns_id;
    $updateData['xm']                   = $xm;
    $updateData['wx']                   = $wx;
    $updateData['qq']                   = $qq;
    $updateData['tel']                  = $tel;
    $updateData['sex']                  = $sex;
    $updateData['height']               = $height;
    $updateData['weight']               = $weight;
    $updateData['xingzuo_id']           = $xingzuo_id;
    $updateData['shuxiang_id']          = $shuxiang_id;
    $updateData['xuexing_id']           = $xuexing_id;
    $updateData['minzu_id']             = $minzu_id;
    $updateData['job']                  = $job;
    $updateData['shouru']               = $shouru;
    $updateData['edu_id']               = $edu_id;
    $updateData['marital_id']           = $marital_id;
    $updateData['child_id']             = $child_id;
    $updateData['house_id']             = $house_id;
    $updateData['che_id']               = $che_id;
    $updateData['birth_year']           = $birth_year;
    $updateData['birth_month']          = $birth_month;
    $updateData['birth_day']            = $birth_day;
    $updateData['zheou_min_age']        = $zheou_min_age;
    $updateData['zheou_max_age']        = $zheou_max_age;
    $updateData['zheou_min_height']     = $zheou_min_height;
    $updateData['zheou_max_height']     = $zheou_max_height;
    $updateData['zheou_marital_id']     = $zheou_marital_id;
    $updateData['zheou_minzu_id']       = $zheou_minzu_id;
    $updateData['zheou_edu_id']         = $zheou_edu_id;
    $updateData['zheou_desc']           = $zheou_desc;
    $updateData['describe']             = $describe;
    $updateData['area']                 = $provinceStr." ".$cityStr." ".$areaStr." ".$townsStr;
    $updateData['hjarea']               = $hjprovinceStr." ".$hjcityStr." ".$hjareaStr." ".$hjtownsStr;
    $updateData['is_ok']                = 1;
    $updateData['is_open']              = $is_open;
    $updateData['ok_time']              = TIMESTAMP;
    if($xiangqinConfig['open_ok_shenhe'] == 1){
        $updateData['shenhe_status'] = 2;
    }else{
        $updateData['shenhe_status'] = 1;
    }
    C::t('#tom_xiangqin#tom_xiangqin')->update($__Xiangqin['id'],$updateData);
    echo '1';exit; 
   
}else if($act == 'del_photo' && $_GET['formhash'] == FORMHASH){
    $photoId      = isset($_GET['photoId'])? intval($_GET['photoId']):0;
     C::t('#tom_xiangqin#tom_xiangqin_photo')->delete($photoId);
     $outArr = array(
         'status'=> 200,
     );
    echo json_encode($outArr); exit;
}else if($act == 'avatar' && $_GET['formhash'] == FORMHASH){
    $xiangqin_id      = isset($_GET['xiangqin_id'])? intval($_GET['xiangqin_id']):0;
    $photoId          = isset($_GET['photoId'])? intval($_GET['photoId']):0;
    DB::query("UPDATE ".DB::table('tom_xiangqin_photo')." SET is_avatar=0 WHERE xiangqin_id='$xiangqin_id' ", 'UNBUFFERED');
    $updateData    = array();
    $updateData['is_avatar']  = 1;
    C::t('#tom_xiangqin#tom_xiangqin_photo')->update($photoId,$updateData);
    
    $outArr = array(
        'status'=> 200,
    );
    echo json_encode($outArr); exit;
}else{
    $avatar_i = 1;
    $i = 1;
    $photoData = C::t('#tom_xiangqin#tom_xiangqin_photo')->fetch_all_list(" AND xiangqin_id = {$__Xiangqin['id']} ", 'ORDER BY id DESC', 0, 10000);
    $photoList = array();
    if(is_array($photoData) && !empty($photoData)){
        foreach($photoData as $key => $value){
            if($value['is_avatar'] == 1){
                $avatar_i = $i;
            }
            
            $photoList[$key] = $value;
            if(!preg_match('/^http/', $value['pic_url'])){
                if(strpos($value['pic_url'], 'data/attachment/tomwx') !== false || strpos($value['pic_url'], 'uc_server/') !== false || strpos($value['pic_url'], 'source/plugin') !== false){
                    $photoList[$key]['pic_url'] = $_G['siteurl'].$value['pic_url'];
                }else{
                    $photoList[$key]['pic_url'] = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$value['pic_url'];
                }
            }else{
                $photoList[$key]['pic_url'] = $value['pic_url'];
            }
            $photoList[$key]['i'] = $i;
            $i++;
        }
    }
    
    $provinceList = $hjprovinceList = $zheouprovinceList = C::t('#tom_love#tom_love_district')->fetch_all_by_level(1);
    if($__Xiangqin['province_id'] > 0){
        $cityList = C::t('#tom_love#tom_love_district')->fetch_all_by_upid($__Xiangqin['province_id']);
    }
    if($__Xiangqin['city_id'] > 0){
        $areaList = C::t('#tom_love#tom_love_district')->fetch_all_by_upid($__Xiangqin['city_id']);
    }
    if($__Xiangqin['area_id'] > 0){
        $townsList = C::t('#tom_love#tom_love_district')->fetch_all_by_upid($__Xiangqin['area_id']);
    }
    if($__Xiangqin['hjprovince_id'] > 0){
        $hjcityList = C::t('#tom_love#tom_love_district')->fetch_all_by_upid($__Xiangqin['hjprovince_id']);
    }
    if($__Xiangqin['hjcity_id'] > 0){
        $hjareaList = C::t('#tom_love#tom_love_district')->fetch_all_by_upid($__Xiangqin['hjcity_id']);
    }
    if($__Xiangqin['hjarea_id'] > 0){
        $hjtownsList = C::t('#tom_love#tom_love_district')->fetch_all_by_upid($__Xiangqin['hjarea_id']);
    }
    if($__Xiangqin['zheou_province_id'] > 0){
        $zheoucityList = C::t('#tom_love#tom_love_district')->fetch_all_by_upid($__Xiangqin['zheou_province_id']);
    }
}

$hobby_listStr = str_replace("\r\n","{n}",$xiangqinConfig['hobby']); 
$hobby_listStr = str_replace("\n","{n}",$hobby_listStr);
$hobby_listStr = str_replace("\r","{n}",$hobby_listStr);
$hobby_listTmpArr = explode("{n}", $hobby_listStr);

$xieyi_txt = stripslashes($__CommonInfo['xieyi_txt']);

$showMustPhoneRz = 0;
if($__UserInfo['phone_renzheng'] == 0 && $jyConfig['open_tel_renzheng'] == 1 && $xiangqinConfig['must_tel_rz'] == 1){
    $showMustPhoneRz = 1;
}

$saveUrl        = "plugin.php?id=tom_xiangqin&mod=edit&uid={$__Xiangqin['id']}";
$backUrl        = "plugin.php?id=tom_xiangqin&mod=my";
$uploadUrl1     = "plugin.php?id=tom_xiangqin&mod=upload&uid={$__Xiangqin['id']}&act=pic&formhash=".FORMHASH;
$delPhotoUrl    = "plugin.php?id=tom_xiangqin&mod=edit";
$setAvatarUrl   = "plugin.php?id=tom_xiangqin&mod=edit&xiangqin_id={$__Xiangqin['id']}";
$wxUploadUrl    = "plugin.php?id=tom_xiangqin:wxMediaDownload&act=photo&xiangqin_id={$__Xiangqin['id']}&formhash=".FORMHASH;

$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
include template("tom_xiangqin:edit");