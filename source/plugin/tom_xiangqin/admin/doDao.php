<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')){
    exit('Access Denied');
}

$modBaseUrl = $adminBaseUrl.'&tmod=doDao';
$modListUrl = $adminListUrl.'&tmod=doDao';
$modFromUrl = $adminFromUrl.'&tmod=doDao';

$vip_id         = isset($_GET['vip_id'])? intval($_GET['vip_id']):0;
$top_status     = isset($_GET['top_status'])? intval($_GET['top_status']):0;
$sex            = isset($_GET['sex'])? intval($_GET['sex']):0;
$height         = isset($_GET['height_id'])? intval($_GET['height_id']):0;
$age            = isset($_GET['age'])? intval($_GET['age']):0;
$shouru         = isset($_GET['shouru'])? intval($_GET['shouru']):0;
$edu            = isset($_GET['edu_id'])? intval($_GET['edu_id']):0;
$is_ok          = isset($_GET['is_ok'])? intval($_GET['is_ok']):0;
$shenhe_status  = isset($_GET['shenhe_status'])? intval($_GET['shenhe_status']):0;

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
if(!empty($is_ok)){
    if($is_ok == 1){
        $where.= " AND is_ok=0 ";
    }
    if($is_ok == 2){
        $where.= " AND is_ok=1 ";
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
        $where.=" AND height > 181" ;
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

showformheader($modFromUrl.'&formhash='.FORMHASH);
showtableheader();

$vipStr = '<tr class="header"><th>'.$Lang['vip_id'].'</th><th></th></tr>';
$vipStr.= '<tr><td width="100"><select style="width: 130px;" name="vip_id" id="vip_id" onchange="refreshterm();">';
$vipStr.= '<option value="0">'.$Lang['quanbu'].'</option>';
$vipList = C::t('#tom_xiangqin#tom_xiangqin_vip')->fetch_all_list("");
if(is_array($vipList) && !empty($vipList)){
    foreach ($vipList as $key => $value){
        if($value['id'] == $vip_id){
            $vipStr.=  '<option value='.$value['id'].' selected>'.$value['name'].'</option>';
        }else{
            $vipStr.=  '<option value='.$value['id'].'>'.$value['name'].'</option>';
        }
    }
}
$vipStr.= '</select></td></tr>';
echo $vipStr;

$top_0 = $top_1 = $top_2 ="";
if($top_status == 0){ $top_0 = "selected";}
if($top_status == 1){ $top_1 = "selected";}
if($top_status == 2){ $top_2 = "selected";}
$topStr = '<tr class="header"><th>'.$Lang['top_status'].'</th><th></th></tr>';
$topStr.= '<tr><td width="100"><select style="width: 130px;" name="top_status" id="top_status" onchange="refreshterm();">';
$topStr.=  '<option value="0" '.$top_0.'>'.$Lang['quanbu'].'</option>';
$topStr.=  '<option value="1" '.$top_1.'>'.$Lang['edit_top_status_0'].'</option>';
$topStr.=  '<option value="2" '.$top_2.'>'.$Lang['edit_top_status_1'].'</option>';

$topStr.= '</select></td><td></td></tr>';
echo $topStr;

$is_ok_0 = $is_ok_1 = $is_ok_2 ="";
if($is_ok == 0){ $is_ok_0 = "selected";}
if($is_ok == 1){ $is_ok_1 = "selected";}
if($is_ok == 2){ $is_ok_2 = "selected";}
$isokStr  = '<tr class="header"><th>'.$Lang['is_ok'].'</th><th></th></tr>';
$isokStr.= '<tr><td width="100"><select style="width: 130px;" name="is_ok" id="is_ok" onchange="refreshterm();">';
$isokStr.=  '<option value="0" '.$top_0.'>'.$Lang['quanbu'].'</option>';
$isokStr.=  '<option value="1" '.$top_1.'>'.$Lang['is_ok_0'].'</option>';
$isokStr.=  '<option value="2" '.$top_2.'>'.$Lang['is_ok_1'].'</option>';

$isokStr.= '</select></td><td></td></tr>';
echo $isokStr;
    
$shenhe_status_0 = $shenhe_status_1 = $shenhe_status_2 ="";
if($shenhe_status == 0){ $shenhe_status_0 = "selected";}
if($shenhe_status == 1){ $shenhe_status_1 = "selected";}
if($shenhe_status == 2){ $shenhe_status_2 = "selected";}
$shenheStr = '<tr class="header"><th>'.$Lang['shenhe_status'].'</th><th></th></tr>';
$shenheStr.= '<tr><td width="100"><select style="width: 130px;" name="shenhe_status" id="shenhe_status" onchange="refreshterm();">';
$shenheStr.=  '<option value="0" '.$shenhe_status_0.'>'.$Lang['quanbu'].'</option>';
$shenheStr.=  '<option value="1" '.$shenhe_status_1.'>'.$Lang['shenhe_ok'].'</option>';
$shenheStr.=  '<option value="2" '.$shenhe_status_2.'>'.$Lang['shenhe_no'].'</option>';

$shenheStr.= '</select></td><td></td></tr>';
echo $shenheStr;

$sex_0 = $sex_1 = $sex_2 ="";
if($sex == 0){ $sex_0 = "selected";}
if($sex == 1){ $sex_1 = "selected";}
if($sex == 2){ $sex_2 = "selected";}
$sexStr = '<tr class="header"><th>'.$Lang['sex'].'</th><th></th></tr>';
$sexStr.= '<tr><td width="100"><select style="width: 130px;" name="sex" id="sex" onchange="refreshterm();">';
$sexStr.=  '<option value="0" '.$sex_0.'>'.$Lang['quanbu'].'</option>';
$sexStr.=  '<option value="1" '.$sex_1.'>'.$Lang['man'].'</option>';
$sexStr.=  '<option value="2" '.$sex_2.'>'.$Lang['woman'].'</option>';

$sexStr.= '</select></td><td></td></tr>';
echo $sexStr;

$heightStr = '<tr class="header"><th>'.$Lang['doDao_height'].'</th><th></th></tr>';
$heightStr.= '<tr><td width="100"><select style="width: 130px;" name="height_id" id="height_id" onchange="refreshterm();">';
$heightStr.=  '<option value="0">'.$Lang['quanbu'].'</option>';
if(is_array($heightSearchArray) && !empty($heightSearchArray)){
    foreach ($heightSearchArray as $key => $value){
        if($key == $height){
            $heightStr.=  '<option value='.$key.' selected>'.$value.'</option>';
        }else{
            $heightStr.=  '<option value='.$key.'>'.$value.'</option>';
        }
    }
}
$heightStr.= '</select></td><td></td></tr>';
echo $heightStr;

$ageStr = '<tr class="header"><th>'.$Lang['age'].'</th><th></th></tr>';
$ageStr.= '<tr><td width="100"><select style="width: 130px;" name="age" id="age" onchange="refreshterm();">';
$ageStr.=  '<option value="0">'.$Lang['quanbu'].'</option>';
if(is_array($ageSearchArray) && !empty($ageSearchArray)){
    foreach ($ageSearchArray as $key => $value){
        if($key == $age){
            $ageStr.=  '<option value='.$key.' selected>'.$value.'</option>';
        }else{
            $ageStr.=  '<option value='.$key.'>'.$value.'</option>';
        }
    }
}
$ageStr.= '</select></td><td></td></tr>';
echo $ageStr;

$shouruStr = '<tr class="header"><th>'.$Lang['shouru'].'</th><th></th></tr>';
$shouruStr.= '<tr><td width="100"><select style="width: 130px;" name="shouru" id="shouru" onchange="refreshterm();">';
$shouruStr.=  '<option value="0">'.$Lang['quanbu'].'</option>';
if(is_array($paySearchArray) && !empty($paySearchArray)){
    foreach ($paySearchArray as $key => $value){
        if($key == $shouru){
            $shouruStr.=  '<option value='.$key.' selected>'.$value.'</option>';
        }else{
            $shouruStr.=  '<option value='.$key.'>'.$value.'</option>';
        }
    }
}
$shouruStr.= '</select></td><td></td></tr>';
echo $shouruStr;

$eduStr = '<tr class="header"><th>'.$Lang['edu'].'</th><th></th></tr>';
$eduStr.= '<tr><td width="100"><select style="width: 130px;" name="edu_id" id="edu_id" onchange="refreshterm();">';
$eduStr.=  '<option value="0">'.$Lang['quanbu'].'</option>';
if(is_array($eduArray) && !empty($eduArray)){
    foreach ($eduArray as $key => $value){
        if($key == $edu){
            $eduStr.=  '<option value='.$key.' selected>'.$value.'</option>';
        }else{
            $eduStr.=  '<option value='.$key.'>'.$value.'</option>';
        }
    }
}
$eduStr.= '</select></td><td></td></tr>';
echo $eduStr;
showformfooter();

$count = C::t('#tom_xiangqin#tom_xiangqin')->fetch_all_count($where);
$num = ceil($count/1000);
$doDaoUrl = $_G['siteurl']."plugin.php?id=tom_xiangqin:doDao&vip_id={$vip_id}&top_status={$top_status}&sex={$sex}&height={$height}&edu={$edu}&shouru={$shouru}&age={$age}&shenhe_status={$shenhe_status}&is_ok={$is_ok}";
echo '<tr>';
for($i = 1; $i <= $num; $i++){
    $max_number = $i * 1000;
    $min_number = $max_number - 1000;
    if($i%6 == 0){
        echo '<td><a href="'.$doDaoUrl.'&page='.$i.'" target="_blank" style="color: #FA6A03; padding:2px 7px; font-weight:600; margin-left: 10px; border-radius: 5px; border: 1px solid #FA6A03;">'.$Lang['daochu'].$min_number.'-'.$max_number.'</a></td></tr><tr>';
    }else{
        echo '<td><a href="'.$doDaoUrl.'&page='.$i.'" target="_blank" style="color: #FA6A03; padding:2px 7px; font-weight:600; margin-left: 10px; border-radius: 5px; border: 1px solid #FA6A03;">'.$Lang['daochu'].$min_number.'-'.$max_number.'</a></td>';
    }
}
echo '</tr>';
showtablefooter();

$adminurl = $modBaseUrl.'&formhash='.FORMHASH;
echo <<<SCRIPT
<script type="text/javascript">
function refreshterm() {
    location.href = "$adminurl"+"&vip_id="+jq('#vip_id').val() +"&top_status="+jq('#top_status').val() +"&shenhe_status="+jq('#shenhe_status').val() + "&sex="+jq('#sex').val() +"&height_id="+jq('#height_id').val() +"&age="+jq('#age').val() +"&shouru="+jq('#shouru').val() +"&edu_id="+jq('#edu_id').val() +"&is_ok="+jq('#is_ok').val();
}
</script>
SCRIPT;
