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

$__UserInfo = array();
$userStatus = false;

$ucenterfilenameExists = false;
$ucenterfilename = DISCUZ_ROOT.'./source/plugin/tom_ucenter/tom_ucenter.inc.php';
if(file_exists($ucenterfilename)){
    $ucenterfilenameExists = true;
}
if($jyConfig['open_ucenter'] == 1 && $ucenterfilenameExists){
    
    $__MemberInfo = array();
    $cookieUid = getcookie('tom_ucenter_member_uid');
    $cookieKey = getcookie('tom_ucenter_member_key');
    
    if(!empty($cookieUid) && !empty($cookieKey)){
        $__MemberInfoTmp = C::t('#tom_ucenter#tom_ucenter_member')->fetch_by_uid($cookieUid);
        if($__MemberInfoTmp && !empty($__MemberInfoTmp['mykey'])){
            if(md5($__MemberInfoTmp['uid'].'|||'.$__MemberInfoTmp['mykey']) == $cookieKey){
                $__MemberInfo = $__MemberInfoTmp;
                $userInfoTmp = C::t('#tom_love#tom_love')->fetch_by_member_id($__MemberInfo['uid']);
                if($userInfoTmp){
                    $__UserInfo = $userInfoTmp;
                    $userStatus = true;
                }
            }
        }
    }
    
}else{
    $cookieUserid = getcookie('tom_love_uid');
    if(!empty($cookieUserid)){
        $__UserInfo = C::t('#tom_love#tom_love')->fetch_by_id($cookieUserid);
        if($__UserInfo){
            $userStatus = true;
        }
    }   
}