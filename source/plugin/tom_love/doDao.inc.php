<?php
/**
 * 
 * www.huaidanwangluo.com/»µµ° (ÇëÊÕ²Ø±¸ÓÃ!)
 * 
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$tomSysOffset = getglobal('setting/timeoffset');
if (CHARSET == 'gbk') {
    include DISCUZ_ROOT.'./source/plugin/tom_love/config/works.gbk.php';
}else{
    include DISCUZ_ROOT.'./source/plugin/tom_love/config/works.utf.php';
}

$vip_id         = isset($_GET['vip_id'])? intval($_GET['vip_id']):0;
$phone_renzheng = isset($_GET['phone_renzheng'])? intval($_GET['phone_renzheng']):0;
$renzheng       = isset($_GET['renzheng'])? intval($_GET['renzheng']):0;
$recommend      = isset($_GET['recommend'])? intval($_GET['recommend']):0;
$status         = isset($_GET['status'])? intval($_GET['status']):0;
$all            = isset($_GET['all'])? intval($_GET['all']):1;

$pagesize   = 1000;
$page       = intval($_GET['page'])>0? intval($_GET['page']):1;
$start      = ($page-1)*$pagesize;	
$where = "";

if(!empty($vip_id)){
    if($vip_id == 2){
        $where.= " AND vip_id=1 ";
    }else{
        $where.= " AND vip_id=0 ";
    }
}
if(!empty($phone_renzheng)){
      if($phone_renzheng == 1){
          $where.= " AND phone_renzheng=0 ";
      }
      if($phone_renzheng == 2){
          $where.= " AND phone_renzheng=1 ";
      }
  }
if(!empty($renzheng)){
    if($renzheng == 1){
        $where.= " AND renzheng=0 ";
    }
    if($renzheng == 2){
        $where.= " AND renzheng=1 ";
    }
}
if(!empty($recommend)){
    if($recommend == 1){
        $where.= " AND recommend=0 ";
    }
    if($recommend == 2){
        $where.= " AND recommend=1 ";
    }
}

if(!empty($status)){
    $where.= " AND status=$status ";
}
if(!empty($all)){
    if($all == 1){
        $where.= " AND year>0 ";
    }
    if($all == 2){
        $where.= " AND year=0 ";
    }
}
if(isset($_G['uid']) && $_G['uid'] > 0 && $_G['groupid'] == 1){
    $infoListTmp = C::t('#tom_love#tom_love')->fetch_all_list($where,"ORDER BY add_time DESC",$start,$pagesize,'');
    $infoList = array();
    foreach ($infoListTmp as $key => $value) {
        $infoList[$key] = $value;
        
        $item_sex = '';
        if($value['sex'] == 1){
            $item_sex = lang('plugin/tom_love','man');
        }else if($value['sex'] == 2){
            $item_sex = lang('plugin/tom_love','woman');
        }else{
            $item_sex = '-';
        }
        $item_vip_id = '';
        if($value['vip_id'] == 0){
            $item_vip_id = lang('plugin/tom_love','edit_vip_id_0');
        }else if($value['vip_id'] == 1){
            $item_vip_id = lang('plugin/tom_love','edit_vip_id_1');
        }else{
            $item_vip_id = '-';
        }
        $item_renzhneg = '';
        if($value['renzheng'] == 1){
            $item_renzhneg = lang('plugin/tom_love','rz_yes');
        }else{
            $item_renzhneg = lang('plugin/tom_love','rz_no');
        }
        $item_phone_renzhneg = '';
        if($value['phone_renzheng'] == 1){
            $item_phone_renzhneg = lang('plugin/tom_love','rz_yes');
        }else{
            $item_phone_renzhneg = lang('plugin/tom_love','rz_no');
        }
        $infoList[$key]['renzheng']       = $item_renzhneg;
        $infoList[$key]['phone_renzheng'] = $item_phone_renzhneg;
        $infoList[$key]['sex'] = $item_sex;
        $infoList[$key]['marital_id'] = $maritalArray[$value['marital_id']];
        $infoList[$key]['vip_id'] = $item_vip_id;
        $infoList[$key]['work_id'] = $worksArray[$value['work_id']];
        $infoList[$key]['edu_id'] = $eduArray[$value['edu_id']];
        $infoList[$key]['pay_id'] = $payArray[$value['pay_id']];
        
        $item_jy_type = "";
        if($infoList[$key]['marriage'] == 1 && $infoList[$key]['friend'] == 1){
            $item_jy_type= lang('plugin/tom_love','marriage').' '.lang('plugin/tom_love','friend');
        }else if($infoList[$key]['marriage'] == 1){
            $item_jy_type= lang('plugin/tom_love','marriage');
        }else if($infoList[$key]['friend'] == 1){
            $item_jy_type= lang('plugin/tom_love','friend');
        }else{
            $item_jy_type = '-';
        }
         $infoList[$key]['marriage'] = $item_jy_type;
         $infoList[$key]['friend']   = $item_jy_type;
     }
   
    $item_nickname            = lang('plugin/tom_love','nickname');
    $item_sex                 = lang('plugin/tom_love','sex');
    $item_year                = lang('plugin/tom_love','year');
    $item_marital_id          = lang('plugin/tom_love','marital');
    $item_vip_id              = lang('plugin/tom_love','edit_vip_id');
    $item_score               = lang('plugin/tom_love','score');
    $item_wx                  = lang('plugin/tom_love','wx');
    $item_qq                  = lang('plugin/tom_love','qq');
    $item_tel                 = lang('plugin/tom_love','tel');
    $item_jy_type             = lang('plugin/tom_love','jy_type');
    $item_work                = lang('plugin/tom_love','work');
    $item_edu                 = lang('plugin/tom_love','edu');
    $item_pay                 = lang('plugin/tom_love','pay');
    $item_height              = lang('plugin/tom_love','height');
    $item_weight              = lang('plugin/tom_love','weight');
    $item_area                = lang('plugin/tom_love','area');
    $item_hjarea              = lang('plugin/tom_love','hjarea');
    $item_describe            = lang('plugin/tom_love','describe');
    $item_renzheng            = lang('plugin/tom_love','renzheng');
    $item_phone_renzheng      = lang('plugin/tom_love','shouji_rz');

    $listData[] = array($item_nickname,$item_sex,$item_year,$item_marital_id,$item_vip_id,$item_renzheng,$item_phone_renzheng,$item_score,$item_wx,$item_qq,$item_tel,$item_jy_type,$item_work,$item_edu,$item_pay,$item_height,$item_weight,$item_area,$item_hjarea,$item_describe); 
    foreach ($infoList as $v){
        $lineData = array();
        $lineData[] = $v['nickname'];
        $lineData[] = $v['sex'];
        $lineData[] = $v['year'];
        $lineData[] = $v['marital_id'];
        $lineData[] = $v['vip_id'];
        $lineData[] = $v['renzheng'];
        $lineData[] = $v['phone_renzheng'];
        $lineData[] = $v['score'];
        $lineData[] = '\''.$v['wx'];
        $lineData[] = '\''.$v['qq'];
        $lineData[] = '\''.$v['tel'];
        $lineData[] = $v['friend'];
        $lineData[] = $v['work_id'];
        $lineData[] = $v['edu_id'];
        $lineData[] = $v['pay_id'];
        $lineData[] = $v['height'];
        $lineData[] = $v['weight'];
        $lineData[] = $v['area'];
        $lineData[] = $v['hjarea'];
        $lineData[] = $v['describe'];
        $listData[] = $lineData;
    }
  
  header("Content-Type: application/vnd.ms-excel");
  header("Content-Disposition:filename=exportLove.xls");

    foreach ($listData as $fields){
        foreach ($fields as $k=> $v){
            $str = @diconv("$v",CHARSET,"GB2312");
            echo $str ."\t";
        }
        echo "\n";
    }
    exit;
}else{
    exit('Access Denied');
}