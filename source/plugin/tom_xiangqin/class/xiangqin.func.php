<?php
/**
 * 
 * ��������Ʒ ������Ʒ
 * ������  ȫ���׷� https://dwz.cn/bEeiwujz
 * ����Դ��Դ�������ռ�,��������ѧϰ�о����ͣ�����������ҵ��;����������24Сʱ��ɾ��!
 * ��л֧�֣�����֧�����������Ķ�����Ϊվ���ṩ���ʺϵ���Ӫ��Դ��
 * ��ӭ������û�����¸��µ�������Դ������VIP��ɫ��Դ���ݴ������
 * [������]վ������Ⱥ: ��Ⱥ 205670720
 * ����������https://www.dashulai.com/ (���ղر���!)
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