<?php

/*
   [Dashulai!] (C)2009-2019 WWW.DASHULAI.COM.
   技术支持/更新维护：官网 https://www.dashulai.com
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

session_start();
loaducenter();
$formhash = FORMHASH;
$jyConfig = $_G['cache']['plugin']['tom_love'];
$tomSysOffset = getglobal('setting/timeoffset');
$appid = trim($jyConfig['love_appid']);  
$appsecret = trim($jyConfig['love_appsecret']);

include DISCUZ_ROOT.'./source/plugin/tom_love/class/weixin.class.php';
$weixinClass = new weixinClass($appid,$appsecret);

if($_GET['act'] == "photo" && $_GET['formhash'] == $formhash){
    $outAtr = array(
        'status' => 1,
    );
    
    $media_id    = isset($_GET['serverId'])? daddslashes($_GET['serverId']): 0;
    $xiangqin_id = isset($_GET['xiangqin_id'])? daddslashes($_GET['xiangqin_id']): 0;
    
    $access_token = $weixinClass->get_access_token();
    $url = "https://api.weixin.qq.com/cgi-bin/media/get?access_token={$access_token}&media_id={$media_id}";
    $return = curl_request($url);
    $types = array('image/bmp'=>'.bmp', 'image/gif'=>'.gif', 'image/jpeg'=>'.jpg', 'image/png'=>'.png');
    if(isset($types[$return['info']['content_type']])){
        
        $imageDir = "/source/plugin/tom_xiangqin/data/photo/".date("Ym")."/".date("d")."/";
        $imageName = "source/plugin/tom_xiangqin/data/photo/".date("Ym")."/".date("d")."/".md5($media_id).$types[$return['info']['content_type']];
        $tomDir = DISCUZ_ROOT.'.'.$imageDir;
        if(!is_dir($tomDir)){
            mkdir($tomDir, 0777,true);
        }else{
            chmod($tomDir, 0777);
        }
        if(false !== file_put_contents(DISCUZ_ROOT.'./'.$imageName, $return['content'])){
            
            require_once libfile('class/image');
            $image = new image();
            $image->Thumb(DISCUZ_ROOT.'./'.$imageName,'', 720, 720, 1, 1);
            
            $insertData = array();
            $insertData['xiangqin_id']      = $xiangqin_id;
            $insertData['pic_url']          = $imageName;
            C::t('#tom_xiangqin#tom_xiangqin_photo')->insert($insertData,true);
            $photo_id = C::t('#tom_xiangqin#tom_xiangqin_photo')->insert_id();
            $outAtr = array(
                'status' => 200,
                'picurl' => $imageName,
                'photo_id' => $photo_id,
            );
        }else{
            $outAtr = array(
                'status' => 302,
                'picurl' => $imageName,
            );
        }
        
    }else{
        $outAtr = array(
            'status' => 301,
            'content' => $return['content'],
        );
    }
    
    echo json_encode($outAtr); exit;
}else{
    echo 1; exit;
}

function curl_request($url){
    if(function_exists('curl_init')){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $package = curl_exec($ch);
        $httpInfo = curl_getinfo($ch);
        curl_close($ch); 
        $return = array_merge(array('content' => $package), array('info' => $httpInfo));
        return $return;
    }
    return false;
}