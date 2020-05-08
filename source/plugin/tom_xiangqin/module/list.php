<?php

/*
   [Dashulai!] (C)2009-2019 WWW.DASHULAI.COM.
   技术支持/更新维护：官网 https://www.dashulai.com
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$outStr = '';

$user_no            = isset($_GET['user_no'])? intval($_GET['user_no']):0;
$xm                 = isset($_GET['xm'])? daddslashes(urldecode($_GET['xm'])):'';
$edu                = isset($_GET['edu'])? daddslashes(urldecode($_GET['edu'])):'';
$shouru             = isset($_GET['shouru'])? intval($_GET['shouru']):0;
$sex                = isset($_GET['sex'])? intval($_GET['sex']):0;
$height             = isset($_GET['height'])? intval($_GET['height']):0;
$age                = isset($_GET['age'])? intval($_GET['age']):0;
$marital            = isset($_GET['marital'])? intval($_GET['marital']):0;
$job                = isset($_GET['job'])? intval($_GET['job']):0;
$page               = isset($_GET['page'])? intval($_GET['page']):1;
$city_id            = isset($_GET['city_id'])? intval($_GET['city_id']):0;
$hunyin             = isset($_GET['hunyin'])? intval($_GET['hunyin']):0;
$zheou_min_age      = isset($_GET['zheou_min_age'])? intval($_GET['zheou_min_age']):0;
$zheou_max_age      = isset($_GET['zheou_max_age'])? intval($_GET['zheou_max_age']):0;

$where = " AND is_ok = 1 AND shenhe_status = 1 AND status = 1 AND is_open = 1 ";

if($sex == 1){
    $where.=" AND sex = 1 ";
}else if($sex == 2){
    $where.=" AND sex = 2 ";
}
if(!empty($user_no)){
    $where.=" AND user_no = {$user_no}";
}
if($hunyin > 0 && $hunyin != 99){
    $where.=" AND marital_id = {$hunyin} ";
}
if($juzhuprovince > 0){
    $where.=" AND province_id = {$juzhuprovince} ";
}
if($juzhucity > 0){
    $where.=" AND city_id = {$juzhucity} ";
}
if($age > 0){
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
if($height > 0){
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
if($shouru > 0){
    if($shouru == 1){
       $where.=" AND shouru < 5000";
    }else if($shouru == 2){
        $where.=" AND shouru > 5000 AND shouru <= 10000 " ;
    }else if($shouru == 3){
        $where.=" AND shouru >10000 AND shouru <= 20000 " ;
    }else if($shouru == 4){
        $where.=" AND shouru > 20000 AND shouru <= 30000 " ;
    }else if($shouru == 5){
        $where.=" AND shouru > 30000 AND shouru <= 50000 " ;
    }else if($shouru == 6){
        $where.=" AND shouru > 50000 " ;
    }
}
if($edu > 0){
    if($edu == 1){
       $where.=" AND edu_id = 3";
    }else if($edu == 2){
        $where.=" AND edu_id = 4 " ;
    }else if($edu == 3){
        $where.=" AND edu_id = 5 " ;
    }else if($edu == 4){
        $where.=" AND edu_id = 6 " ;
    }else if($edu == 5){
        $where.=" AND edu_id = 7 " ;
    }else if($edu == 6){
        $where.=" AND edu_id = 8 " ;
    }
}
if($city_id > 0){
    $where.=" AND city_id = {$city_id} ";
}
if($zheou_min_age > 0 && $zheou_max_age > 0){
    if($jyConfig['age_type_id'] == 1){
        $startYear = $nowYear - $zheou_max_age;
        $endYear = $nowYear - $zheou_min_age;
    }else{
        $startYear = $nowYear - $zheou_max_age + 1;
        $endYear = $nowYear - $zheou_min_age + 1;
    }
    $where.=" AND birth_year >= {$startYear} AND birth_year <= {$endYear}";
}

$sort = " ORDER BY top_status DESC,top_time DESC, id DESC";
$pagesize = 8;
$start = ($page-1)*$pagesize;
$userData = C::t('#tom_xiangqin#tom_xiangqin')->fetch_all_list($where,$sort,$start,$pagesize,$xm);
$userList = array();
if(is_array($userData) && !empty($userData)){
    foreach ($userData as $key => $value){
        $userList[$key] = $value;
        $userList[$key]['describe'] = tom_num_replace(cutstr(dhtmlspecialchars($value['describe']),58,"..."));
        if($value['birth_year'] > 0){
            if($jyConfig['age_type_id'] == 1){
                $userList[$key]['age'] = $nowYear - $value['birth_year'];
            }else{
                $userList[$key]['age'] = $nowYear - $value['birth_year'] + 1;
            }
        }else{
            $userList[$key]['age'] = '';
        }

        $userList[$key]['user']['pic_url'] = tom_xiangqin_avatar($value['id']);
        $loveInfo = C::t('#tom_love#tom_love')->fetch_by_id($value['user_id']);
        if(is_array($loveInfo) && !empty($loveInfo)){
            $userList[$key]['user']['phone_renzheng'] = $loveInfo['phone_renzheng'];
            $userList[$key]['user']['renzheng'] = $loveInfo['renzheng'];
        }
    }
}

if(is_array($userList) && !empty($userList)){
    foreach ($userList as $key => $value){
        $outStr .= '<div class="item_big clearfix">';
        if($__Xiangqin['is_ok'] == 1){
            if($__Xiangqin['vip_id'] < 1){
                $outStr .= '<a href="plugin.php?id=tom_xiangqin&mod=card&uid='.$value['id'].'">';
            }else{
                $outStr .= '<a href="plugin.php?id=tom_xiangqin&mod=info&uid='.$value['id'].'">';
            }
        }else if($__Xiangqin['id'] > 0){
            $outStr .= '<a onclick="wanshan();" href="javascript:void;">';
        }else{
            $outStr .= '<a href="plugin.php?id=tom_xiangqin&mod=my">';
        }
                $outStr .= '<div class="pictop clearfix">';
                    $outStr .= '<img src="'.$value['user']['pic_url'].'"/>';
                $outStr .= '</div>';
            $outStr .= '</a>';
            $outStr .= '<div class="picmiddle clearfix">';
                $outStr .='<div class="left">'.$value['xm'].'</div>';
                if($value['sex'] == 1){
                    $outStr .= '<div class="right"><img src="source/plugin/tom_xiangqin/images/boy.png"></div>';
                }else if($value['sex'] == 2){
                    $outStr .= '<div class="right"><img src="source/plugin/tom_xiangqin/images/girl.png"></div>';
                }
                $outStr .= '<span class="sui">'.$value['age'].''.lang('plugin/tom_xiangqin','sui').'</span>';
            $outStr .= '</div>';
            $outStr .= '<div class="picbottom clearfix">';
                $outStr .= '<span class="left">'.$value['shouru'].'/'.lang('plugin/tom_xiangqin','yue').'</span>';
                $outStr .= '<span class="icon">';
                    if($value['top_status'] == 1){
                        $outStr .= '<img src="source/plugin/tom_xiangqin/images/topper.png" style="width:13px;">&nbsp;';
                    }
                    if($value['vip_id'] > 0){
                        $outStr .= '<img src="source/plugin/tom_xiangqin/images/vip.png" style="width:13px;">&nbsp;';
                    }
                    if($value['house_id'] == 3 || $value['house_id'] == 4){
                        $outStr .= '<img src="source/plugin/tom_xiangqin/images/house.png" style="width:13px;">&nbsp;';
                    }
                    if($value['che_id'] == 2 || $value['che_id'] == 3 || $value['che_id'] == 4 ){
                        $outStr .= '<img src="source/plugin/tom_xiangqin/images/car.png" style="width:13px;">&nbsp;';
                    }
                    if($value['user']['phone_renzheng'] == 1){
                        $outStr .= '<img src="source/plugin/tom_xiangqin/images/mobile.png" style="width:13px;">&nbsp;';
                    }
                    if($value['user']['renzheng'] == 1){
                        $outStr .= '<img src="source/plugin/tom_xiangqin/images/renzheng.png" style="width:13px;">&nbsp;';
                    }
                $outStr .= '</span>';
            $outStr .= '</div>';
            $outStr .= '<div class="shoucang clearfix">';
                $outStr .= "<div class='left' onClick='shoucang({$value['id']});'>";
                    $outStr .= '<img src="source/plugin/tom_xiangqin/images/like.png" style="width:16px;margin-top:-3px;">&nbsp;';
                    $isCollect = array();
                    if($__UserInfo['id'] > 0){
                        $isCollect = C::t('#tom_xiangqin#tom_xiangqin_collect')->fetch_all_list("AND user_id = {$__UserInfo['id']} AND xiangqin_id ={$value['id']}"," ORDER BY id DESC ",0,1);
                    }
                    if(is_array($isCollect) && !empty($isCollect) && $isCollect[0]['id'] > 0){
                        $outStr .= '<span class="qi">'.lang('plugin/tom_xiangqin','collect_yishoucang').'</span>';
                    }else{
                        $outStr .= '<span class="qi">'.lang('plugin/tom_xiangqin','shoucang').'</span>';
                    }
                $outStr .= '</div>';
                $outStr .= '<div class="right">';
                    if($__Xiangqin['vip_id'] > 0){
                        $outStr .= '<a href="plugin.php?id=tom_xiangqin&mod=info&uid='.$value['id'].'">';
                    }else{
                        $outStr .= '<a href="plugin.php?id=tom_xiangqin&mod=card&uid='.$value['id'].'">';
                    }
                        $outStr .= '<img src="source/plugin/tom_xiangqin/images/love.png" style="width:16px;margin-top:-2px;">&nbsp;';
                        $outStr .= "<span style='color:#A19F9F'>".lang('plugin/tom_xiangqin','index_xiangqin').'</span>';
                    $outStr .= '</a>';
                $outStr .= '</div>';
            $outStr .= '</div>';
        $outStr .= '</div>';
    }
}else{
    $outStr = '205';
}
$outStr = tom_link_replace($outStr);
$outStr = diconv($outStr,CHARSET,'utf-8');
echo json_encode($outStr); exit;