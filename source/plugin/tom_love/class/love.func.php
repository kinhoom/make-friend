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

function check_subscribe($access_token,$openid){
    $subscribeFlag = 0;
    $get_user_info_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$openid}&lang=zh_CN";
    $return = get_html($get_user_info_url);
    if(!empty($return)){
        $content = json_decode($return,true);
        if(is_array($content) && !empty($content) && isset($content['subscribe'])){
            if($content['subscribe'] == 1){
                $subscribeFlag = 1;
            }else if($content['subscribe'] == 0){
                $subscribeFlag = 2;
            }
        }
    }
    return $subscribeFlag;
}

function tom_num_replace($string){
    $match = "/\d{5}/";
	if(!empty($string)){
		$string = preg_replace($match, '*****', $string);
	}
    return $string;
}


function tom_avatar($picurl = ''){
    global $_G;
    
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

function wx_iconv_recurrence($value) {
	if(is_array($value)) {
		foreach($value AS $key => $val) {
			$value[$key] = wx_iconv_recurrence($val);
		}
	} else {
		$value = diconv($value, 'utf-8', CHARSET);
	}
	return $value;
}