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

if($__Xiangqin['birth_year'] > 0){
    if($jyConfig['age_type_id'] == 1){
        $age = $nowYear - $__Xiangqin['birth_year'];
    }else{
        $age = $nowYear - $__Xiangqin['birth_year'] + 1;
    }
}else{
    $age = '';
}

$xiangqincard_man_listStr = str_replace("\r\n","{n}",$xiangqinConfig['xiangqin_card_man']); 
$xiangqincard_man_listStr = str_replace("\n","{n}",$xiangqincard_man_listStr);
$xiangqincard_man_listStr = str_replace("\r","{n}",$xiangqincard_man_listStr);
$xiangqincard_man_listTmpArr = explode("{n}", $xiangqincard_man_listStr);
$xiangqincard_man_listArr = array();
if(is_array($xiangqincard_man_listTmpArr) && !empty($xiangqincard_man_listTmpArr)){
    foreach($xiangqincard_man_listTmpArr as $key => $value){
        if(!empty($value)){
            $xiangqincard_man_listArr[] = $value;
        }
    }
}

$xiangqincard_woman_listStr = str_replace("\r\n","{n}",$xiangqinConfig['xiangqin_card_woman']); 
$xiangqincard_woman_listStr = str_replace("\n","{n}",$xiangqincard_woman_listStr);
$xiangqincard_woman_listStr = str_replace("\r","{n}",$xiangqincard_woman_listStr);
$xiangqincard_woman_listTmpArr = explode("{n}", $xiangqincard_woman_listStr);
$xiangqincard_woman_listArr = array();
if(is_array($xiangqincard_woman_listTmpArr) && !empty($xiangqincard_woman_listTmpArr)){
    foreach($xiangqincard_woman_listTmpArr as $key => $value){
        if(!empty($value)){
            $xiangqincard_woman_listArr[] = $value;
        }
    }
}

$juzhuCityInfo  = C::t('#tom_love#tom_love_district')->fetch_by_id($__Xiangqin['city_id']);
$juzhuAreaInfo  = C::t('#tom_love#tom_love_district')->fetch_by_id($__Xiangqin['area_id']);

$picurl = tom_xiangqin_avatar($__Xiangqin['id']);
$picData = file_get_contents($picurl);

$avatarDir = "/source/plugin/tom_xiangqin/data/avatar/".date("Ym")."/".date("d")."/";
$avatarName = "source/plugin/tom_xiangqin/data/avatar/".date("Ym")."/".date("d")."/".md5($picurl).'.png';
$tomDir = DISCUZ_ROOT.'.'.$avatarDir;
if(!is_dir($tomDir)){
    mkdir($tomDir, 0777,true);
}else{
    chmod($tomDir, 0777);
}
if(false !== file_put_contents(DISCUZ_ROOT.'./'.$avatarName, $picData)){
    require_once libfile('class/image');
    $image = new image();
    $image->Thumb(DISCUZ_ROOT.'./'.$avatarName,'', 500, 350, 2, 1);
    $picurl = $avatarName;
}

$hongniangInfo = C::t('#tom_xiangqin#tom_xiangqin_hongniang')->fetch_all_list(""," ORDER BY paixu ASC ",0,1);
$hongniangQrcode = '';
if(is_array($hongniangInfo) && !empty($hongniangInfo[0]['qrcode'])){
    if(!preg_match('/^http/', $hongniangInfo[0]['qrcode'])){
        if(strpos($hongniangInfo[0]['qrcode'], 'source/plugin/') === false){
            $hongniangQrcode = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$hongniangInfo[0]['qrcode'];
        }else{
            $hongniangQrcode = $_G['siteurl'].$hongniangInfo[0]['qrcode'];
        }
    }else{
        $hongniangQrcode = $hongniangInfo[0]['qrcode'];
    }
}

$qrcodeImg = $_G['siteurl']."plugin.php?id=tom_qrcode&data=".urlencode($_G['siteurl']."plugin.php?id=tom_xiangqin&mod=info&uid={$__Xiangqin['id']}");

$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
include template("tom_xiangqin:mycard");