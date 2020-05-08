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

$nowYear = dgmdate($_G['timestamp'], 'Y',$tomSysOffset);
$tomSysOffset = getglobal('setting/timeoffset');
if (CHARSET == 'gbk') {
    include DISCUZ_ROOT.'./source/plugin/tom_xiangqin/config/works.gbk.php';
}else{
    include DISCUZ_ROOT.'./source/plugin/tom_xiangqin/config/works.utf.php';
}

$vip_id         = isset($_GET['vip_id'])? intval($_GET['vip_id']):0;
$top_status     = isset($_GET['top_status'])? intval($_GET['top_status']):0;
$sex            = isset($_GET['sex'])? intval($_GET['sex']):0;
$height         = isset($_GET['height'])? intval($_GET['height']):0;
$age            = isset($_GET['age'])? intval($_GET['age']):0;
$shouru         = isset($_GET['shouru'])? intval($_GET['shouru']):0;
$edu            = isset($_GET['edu'])? intval($_GET['edu']):0;
$shenhe_status  = isset($_GET['shenhe_status'])? intval($_GET['shenhe_status']):0;
$is_ok          = isset($_GET['is_ok'])? intval($_GET['is_ok']):0;

$pagesize   = 1000;
$page       = intval($_GET['page'])>0? intval($_GET['page']):1;
$start      = ($page-1)*$pagesize;	
$where = "";

if(!empty($vip_id)){
    $where.= " AND vip_id= {$vip_id}";
}
if(!empty($top_status)){
    if($top_status == 1){
        $where.= " AND top_status=0 ";
    }
    if($top_status == 2){
        $where.= " AND top_status=1 ";
    }
}
if(!empty($sex)){
    if($sex == 1){
        $where.= " AND sex=1 ";
    }
    if($sex == 2){
        $where.= " AND sex=2 ";
    }
}
if(!empty($height)){
    if($height == 1){
       $where.=" AND height < 155";
    }else if($height == 2){
        $where.=" AND height >= 156 AND height <= 160" ;
    }else if($height == 3){
        $where.=" AND height >=161 AND height <= 165" ;
    }else if($height == 4){
        $where.=" AND height >= 166 AND height <= 170" ;
    }else if($height == 5){
        $where.=" AND height >= 171 AND height <= 175" ;
    }else if($height == 6){
        $where.=" AND height >= 176 AND height <= 180" ;
    }else if($height == 7){
        $where.=" AND height > 180" ;
    }
}
if(!empty($age)){
    if($age == 1){
        if($jyConfig['age_type_id'] == 1){
            $startYear = $nowYear - 22;
            $endYear = $nowYear - 18;
        }else{
            $startYear = $nowYear - 22 + 1;
            $endYear = $nowYear - 18 + 1;
        }
        $where.=" AND birth_year >= {$startYear} AND birth_year <= {$endYear}";
    }else if($age == 2){
        if($jyConfig['age_type_id'] == 1){
            $startYear = $nowYear - 25;
            $endYear = $nowYear - 23;
        }else{
            $startYear = $nowYear - 25 + 1;
            $endYear = $nowYear - 23 + 1;
        }
        $where.=" AND birth_year >= {$startYear} AND birth_year <= {$endYear}";
    }else if($age == 3){
        if($jyConfig['age_type_id'] == 1){
            $startYear = $nowYear - 30;
            $endYear = $nowYear - 26;
        }else{
            $startYear = $nowYear - 30 + 1;
            $endYear = $nowYear - 26 + 1;
        }
        $where.=" AND birth_year >= {$startYear} AND birth_year <= {$endYear}";
    }else if($age == 4){
        if($jyConfig['age_type_id'] == 1){
            $startYear = $nowYear - 35;
            $endYear = $nowYear - 31;
        }else{
            $startYear = $nowYear - 35 + 1;
            $endYear = $nowYear - 31 + 1;
        }
        $where.=" AND birth_year >= {$startYear} AND birth_year <= {$endYear}";
    }else if($age == 5){
        if($jyConfig['age_type_id'] == 1){
            $startYear = $nowYear - 36;
        }else{
            $startYear = $nowYear - 36 + 1;
        }
        $where.=" AND birth_year <= {$startYear} ";
    }
}
if(!empty($shouru)){
    if($shouru == 1){
       $where.=" AND shouru < 5000";
    }else if($shouru == 2){
        $where.=" AND shouru > 5000 AND shouru <= 10000 " ;
    }else if($shouru == 3){
        $where.=" AND shouru >10000 AND shouru <= 20000 " ;
    }else if($shouru == 4){
        $where.=" AND shouru >20000 AND shouru <= 30000 " ;
    }else if($shouru == 5){
        $where.=" AND shouru > 30000 AND shouru <= 50000 " ;
    }else if($shouru == 6){
        $where.=" AND shouru > 50000 " ;
    }
}
if(!empty($edu)){
    $where.= " AND edu_id= {$edu}";
}
if(!empty($shenhe_status)){
    if($shenhe_status == 1){
        $where.= " AND shenhe_status=1 ";
    }
    if($shenhe_status == 2){
        $where.= " AND shenhe_status=3 ";
    }
}
if(!empty($is_ok)){
    if($is_ok == 1){
        $where.= " AND is_ok=0 ";
    }
    if($is_ok == 2){
        $where.= " AND is_ok=1 ";
    }
}
if(isset($_G['uid']) && $_G['uid'] > 0 && $_G['groupid'] == 1){
    $infoListTmp = C::t('#tom_xiangqin#tom_xiangqin')->fetch_all_list($where,"ORDER BY add_time DESC",$start,$pagesize,'');
    $vipList = C::t('#tom_xiangqin#tom_xiangqin_vip')->fetch_all_list("");
    $infoList = array();
    foreach ($infoListTmp as $key => $value) {
        $infoList[$key] = $value;
        
        $item_sex = '';
        if($value['sex'] == 1){
            $item_sex = lang('plugin/tom_xiangqin','man');
        }else if($value['sex'] == 2){
            $item_sex = lang('plugin/tom_xiangqin','woman');
        }else{
            $item_sex = '-';
        }
        $vipInfo = C::t('#tom_xiangqin#tom_xiangqin_vip')->fetch_by_id($value['vip_id']);
        if($value['vip_id'] < 1){
            $item_vip_id = lang('plugin/tom_xiangqin','edit_vip_id_0');
        }else{
            $item_vip_id = $vipInfo['name'];
        }
        $item_top_status = '';
        if($value['top_status'] == 0){
            $item_top_status = lang('plugin/tom_xiangqin','edit_top_status_0');
        }else{
            $item_top_status = lang('plugin/tom_xiangqin','edit_top_status_1');
        }
        $item_shenhe_status = '';
        if($value['shenhe_status'] == 1){
            $item_shenhe_status = lang('plugin/tom_xiangqin','shenhe_ok');
        }else{
            $item_shenhe_status = lang('plugin/tom_xiangqin','shenhe_no');
        }
        $loveInfo  = C::t('#tom_love#tom_love')->fetch_by_id($value['user_id']);
        $item_is_renzheng = '';
        if($loveInfo['renzheng'] == 1){
            $item_is_renzheng = lang('plugin/tom_xiangqin','is_renzheng_1');
        }else{
            $item_is_renzheng = lang('plugin/tom_xiangqin','is_renzheng_0');
        }
        $item_is_ok = '';
        if($value['is_ok'] == 1){
            $item_is_ok = lang('plugin/tom_xiangqin','is_ok_1');
        }else{
            $item_is_ok = lang('plugin/tom_xiangqin','is_ok_0');
        }
        $item_closed = '';
        if($value['closed'] == 0){
            $item_closed = lang('plugin/tom_xiangqin','open');
        }else{
            $item_closed = lang('plugin/tom_xiangqin','close');
        }
   
        $infoList[$key]['sex']               = $item_sex;
        $infoList[$key]['vip_id']            = $item_vip_id;
        $infoList[$key]['closed']            = $item_closed;
        $infoList[$key]['top_status']        = $item_top_status;
        $infoList[$key]['shenhe_status']     = $item_shenhe_status;
        $infoList[$key]['is_renzheng']       = $item_is_renzheng;
        $infoList[$key]['is_ok']             = $item_is_ok;
        $infoList[$key]['edu_id']            = $eduArray[$value['edu_id']];
        $infoList[$key]['height']            = $value['height'];
        $infoList[$key]['weight']            = $value['weight'];
        $infoList[$key]['xingzuo_id']        = $xingzuoArray[$value['xingzuo_id']];
        $infoList[$key]['shuxiang_id']       = $shuxiangArray[$value['shuxiang_id']];
        $infoList[$key]['xuexing_id']        = $xuexingArray[$value['xuexing_id']];
        $infoList[$key]['minzu_id']          = $minzuArray[$value['minzu_id']];
        $infoList[$key]['marital_id']        = $maritalArray[$value['marital_id']];
        $infoList[$key]['child_id']          = $childArray[$value['child_id']];
        $infoList[$key]['house_id']          = $houseArray[$value['house_id']];
        $infoList[$key]['che_id']            = $carArray[$value['che_id']];
        $infoList[$key]['zheou_edu_id']      = $eduArray[$value['zheou_edu_id']];
        $infoList[$key]['zheou_minzu_id']    = $minzuArray[$value['zheou_minzu_id']];
        $infoList[$key]['zheou_min_age']     = $value['zheou_min_age'];
        $infoList[$key]['zheou_max_age']     = $value['zheou_max_age'];
        $infoList[$key]['zheou_min_height']  = $value['zheou_min_height'];
        $infoList[$key]['zheou_max_height']  = $value['zheou_max_height'];
        $infoList[$key]['zheou_marital_id']  = $maritalArray[$value['zheou_marital_id']];
    }
     
    $item_xm                  = lang('plugin/tom_xiangqin','xm');
    $item_vip_id              = lang('plugin/tom_xiangqin','vip_id');
    $item_sex                 = lang('plugin/tom_xiangqin','sex');
    $item_age                 = lang('plugin/tom_xiangqin','birth_year_month_day');
    $item_tel                 = lang('plugin/tom_xiangqin','tel');
    $item_wx                  = lang('plugin/tom_xiangqin','wx');
    $item_qq                  = lang('plugin/tom_xiangqin','qq');
    $item_edu                 = lang('plugin/tom_xiangqin','edu');
    $item_xingzuo             = lang('plugin/tom_xiangqin','xingzuo');
    $item_shuxiang            = lang('plugin/tom_xiangqin','shuxiang');
    $item_xuexing             = lang('plugin/tom_xiangqin','xuexing');
    $item_minzu               = lang('plugin/tom_xiangqin','minzu');
    $item_job                 = lang('plugin/tom_xiangqin','work');
    $item_marital             = lang('plugin/tom_xiangqin','marital');
    $item_child               = lang('plugin/tom_xiangqin','child');
    $item_house               = lang('plugin/tom_xiangqin','house');
    $item_car                 = lang('plugin/tom_xiangqin','car');
    $item_height              = lang('plugin/tom_xiangqin','height');
    $item_weight              = lang('plugin/tom_xiangqin','weight');
    $item_area                = lang('plugin/tom_xiangqin','area');
    $item_hjarea              = lang('plugin/tom_xiangqin','hjarea');
    $item_closed              = lang('plugin/tom_xiangqin','closed');
    $item_describe            = lang('plugin/tom_xiangqin','describe');
    $item_top_status          = lang('plugin/tom_xiangqin','top_status');
    $item_zheou_martial       = lang('plugin/tom_xiangqin','zheou_marital');
    $item_zheou_age           = lang('plugin/tom_xiangqin','zheou_age');
    $item_zheou_height        = lang('plugin/tom_xiangqin','zheou_height');
    $item_zheou_edu           = lang('plugin/tom_xiangqin','zheou_edu');
    $item_zheou_minzu         = lang('plugin/tom_xiangqin','zheou_minzu');
    $item_zheou_desc          = lang('plugin/tom_xiangqin','zheou_desc');
    $item_shenhe_status       = lang('plugin/tom_xiangqin','shenhe_status');
    $item_is_renzheng         = lang('plugin/tom_xiangqin','is_renzheng');
    $item_is_ok               = lang('plugin/tom_xiangqin','is_ok');

    $listData[] = array($item_xm,$item_vip_id,$item_sex,$item_age,$item_wx,$item_qq,$item_tel,$item_edu,$item_xingzuo,$item_shuxiang,$item_xuexing,$item_minzu,$item_job,$item_marital,$item_child,$item_house,$item_car,$item_height,$item_weight,$item_area,$item_hjarea,$item_closed,$item_describe,$item_top_status,$item_zheou_martial,$item_zheou_age,$item_zheou_height,$item_zheou_edu,$item_zheou_minzu,$item_zheou_desc,$item_shenhe_status,$item_is_renzheng,$item_is_ok); 
    foreach ($infoList as $v){
        $lineData = array();
        $lineData[] = $v['xm'];
        $lineData[] = $v['vip_id'];
        $lineData[] = $v['sex'];
        $lineData[] = $v['birth_year'];
        $lineData[] = '\''.$v['wx'];
        $lineData[] = '\''.$v['qq'];
        $lineData[] = '\''.$v['tel'];
        $lineData[] = $v['edu_id'];
        $lineData[] = $v['xingzuo_id'];
        $lineData[] = $v['shuxiang_id'];
        $lineData[] = $v['xuexing_id'];
        $lineData[] = $v['minzu_id'];
        $lineData[] = $v['job'];
        $lineData[] = $v['marital_id'];
        $lineData[] = $v['child_id'];
        $lineData[] = $v['house_id'];
        $lineData[] = $v['che_id'];
        $lineData[] = $v['height'];
        $lineData[] = $v['weight'];
        $lineData[] = $v['area'];
        $lineData[] = $v['hjarea'];
        $lineData[] = $v['closed'];
        $lineData[] = $v['describe'];
        $lineData[] = $v['top_status'];
        $lineData[] = $v['zheou_marital_id'];
        $lineData[] = $v['zheou_min_age'].'--'.$v['zheou_max_age'];
        $lineData[] = $v['zheou_min_height'].'--'.$v['zheou_max_height'];
        $lineData[] = $v['zheou_edu_id'];
        $lineData[] = $v['zheou_minzu_id'];
        $lineData[] = $v['zheou_desc'];
        $lineData[] = $v['shenhe_status'];
        $lineData[] = $v['is_renzheng'];
        $lineData[] = $v['is_ok'];
        $listData[] = $lineData;
    }
  
  header("Content-Type: application/vnd.ms-excel");
  header("Content-Disposition:filename=exportXiangqin.xls");

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