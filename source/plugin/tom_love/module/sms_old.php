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

$act = isset($_GET['act'])? trim($_GET['act']):'';

if($act == 'view'){
    $pageType = 'view';
    $pmList = array();
    $page     = isset($_GET['page'])? intval($_GET['page']):0;
    $toBbsUid = isset($_GET['tobbsuid'])? intval($_GET['tobbsuid']):0;

    $pagesize = 5;
    $toUserPic = '';
    $toUserInfo = C::t('#tom_love#tom_love')->fetch_by_bbs_uid($toBbsUid);
    if(!empty($toUserInfo['avatar']) && is_array($toUserInfo)){    
        if(!empty($toUserInfo['avatar'])){
            $toUserPic = tom_avatar($toUserInfo['avatar']);
        }
    }
        
    $smsDataCount = uc_pm_view_num($__UserInfo['bbs_uid'], $toBbsUid, 0);
    if(!$page) {
        $page = ceil($smsDataCount/$pagesize);
    }
    uc_pm_readstatus($__UserInfo['bbs_uid'], array($toBbsUid));
    
    $pmList = uc_pm_view($__UserInfo['bbs_uid'], 0, $toBbsUid, 5, ceil($smsDataCount/$pagesize)-$page+1, $pagesize, 0, 0);
    foreach($pmList as $key => $value){
        $pmList[$key] = $value;
        $pmList[$key]['message'] = tom_num_replace($value['message']);
    }
    $showNextPage = 1;
    $start = ($page-1)*$pagesize;
    if(($start + $pagesize) >= $smsDataCount){
        $showNextPage = 0;
    }
    $showPageBox = 0;
    if($smsDataCount > $pagesize){
        $showPageBox = 1;
    }
    $prePage = $page - 1;
    $nextPage = $page + 1;
    $prePageUrl = "plugin.php?id=tom_love&mod=sms_old&act=view&tobbsuid=$toBbsUid&page={$prePage}";
    $nextPageUrl = "plugin.php?id=tom_love&mod=sms_old&act=view&tobbsuid=$toBbsUid&page={$nextPage}";
    
}else{
    $pageType = 'list';
    $smsList = array();
    $page     = isset($_GET['page'])? intval($_GET['page']):1;
    $pagesize = 15;
    $result = uc_pm_list($__UserInfo['bbs_uid'], $page, $pagesize, 'inbox', "privatepm", 100);
    $smsDataCount = $result['count'];
    $listTmp = $result['data'];
    
    if(is_array($listTmp) && !empty($listTmp)){
        $today = $_G['timestamp'] - ($_G['timestamp'] + $_G['setting']['timeoffset'] * 3600) % 86400;
        foreach ($listTmp as $key => $value){
            if($value['pmtype'] = 1){
                $toUserInfo = C::t('#tom_love#tom_love')->fetch_by_bbs_uid($value['touid']);
                if($toUserInfo){
                    $smsList[$key] = $value;
                    $smsList[$key]['message'] = tom_num_replace($value['message']);
                    $smsList[$key]['__tonickname'] = $toUserInfo['nickname'];
                    $smsList[$key]['__toid'] = $toUserInfo['id'];
                    $smsList[$key]['__toavatar'] = tom_avatar($toUserInfo['avatar']);
                }
            }
        }
    }
    $showNextPage = 1;
    $start = ($page-1)*$pagesize;
    if(($start + $pagesize) >= $smsDataCount){
        $showNextPage = 0;
    }
    $prePage = $page - 1;
    $nextPage = $page + 1;
    $prePageUrl = "plugin.php?id=tom_love&mod=sms_old&page={$prePage}";
    $nextPageUrl = "plugin.php?id=tom_love&mod=sms_old&page={$nextPage}";
}

$smsUrl = "plugin.php?id=tom_love&mod=sms_old";

$isgbk = false;
if (CHARSET == 'gbk') $isgbk = true;
include template("tom_love:sms_old");
