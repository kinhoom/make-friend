<?php
/**
 * 
 * 大叔来出品 必属精品
 * 大叔来  全网首发 https://dwz.cn/bEeiwujz
 * 本资源来源于网络收集,仅供个人学习研究欣赏，请勿用于商业用途，并于下载24小时后删除!
 * 感谢支持！您的支持是我们最大的动力！为站长提供最适合的运营资源！
 * 欢迎大家来访获得最新更新的优秀资源！更多VIP特色资源不容错过！！
 * [大叔来]站长交流群: ①群 205670720
 * 永久域名：https://www.dashulai.com/ (请收藏备用!)
 * 
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function tom_xiangqin_avatar($xiangqin_id){
    global $_G;
    $photoData = array();
    $photoDataTmp = C::t('#tom_xiangqin#tom_xiangqin_photo')->fetch_all_list(" AND xiangqin_id = {$xiangqin_id} AND is_avatar =1 ", 'ORDER BY id DESC', 0, 1);
    if(is_array($photoDataTmp) && !empty($photoDataTmp[0]['pic_url'])){
        $photoData = $photoDataTmp;
    }else{
        $photoData = C::t('#tom_xiangqin#tom_xiangqin_photo')->fetch_all_list(" AND xiangqin_id = {$xiangqin_id}", 'ORDER BY id DESC', 0, 1);
    }
    $picurl = $photoData[0]['pic_url'];
    
    if(!preg_match('/^http/', $picurl)){
        if(strpos($picurl, 'data/attachment/tomwx') !== false){
            $picurl  = $_G['siteurl'].$picurl;
        }else if(strpos($picurl, 'uc_server/') !== false){
            $picurl  = $_G['siteurl'].$picurl;
        }else if(strpos($picurl, 'source/plugin') !== false){
            $picurl  = $_G['siteurl'].$picurl;
        }else{
            $picurl = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$picurl;
        }
    }
    return $picurl;
}