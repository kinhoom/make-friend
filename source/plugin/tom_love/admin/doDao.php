<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')){
    exit('Access Denied');
}

$modBaseUrl = $adminBaseUrl.'&tmod=doDao';
$modListUrl = $adminListUrl.'&tmod=doDao';
$modFromUrl = $adminFromUrl.'&tmod=doDao';

$vip_id         = isset($_GET['vip_id'])? intval($_GET['vip_id']):0;
$renzheng       = isset($_GET['renzheng'])? intval($_GET['renzheng']):0;
$phone_renzheng = isset($_GET['phone_renzheng'])? intval($_GET['phone_renzheng']):0;
$recommend      = isset($_GET['recommend'])? intval($_GET['recommend']):0;
$status         = isset($_GET['status'])? intval($_GET['status']):0;
$all            = isset($_GET['all'])? intval($_GET['all']):1;

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
$fenhao = $Lang['fenhao'];
showformheader($modFromUrl.'&formhash='.FORMHASH);
showtableheader();

$vip_id_status_0 =  $hy_status_1 = $hy_status_2 = "";
if($vip_id == 1){
    $vip_id_status_1 = 'selected';
}else if($vip_id == 2){
    $vip_id_status_2 = 'selected';
}else{
    $vip_id_status_0 = 'selected';
}
$modelStr = '<tr class="header"><th>'.$Lang['edit_vip_id'].'</th><th></th></tr>';
$modelStr.= '<tr><td width="100"><select style="width: 130px;" name="vip_id" id="vip_id" onchange="refreshvip_id();">';
$modelStr.=  '<option value="0" '.$vip_id_status_0.'>'.$Lang['quanbu'].'</option>';
$modelStr.=  '<option value="1" '.$vip_id_status_1.'>'.$Lang['edit_vip_id_0'].'</option>';
$modelStr.=  '<option value="2" '.$vip_id_status_2.'>'.$Lang['edit_vip_id_1'].'</option>';

$modelStr.= '</select></td><td></td></tr>';
echo $modelStr;

$phone_renzheng_status_0 =  $phone_renzheng_status_1 = $phone_renzheng_status_2 = "";
if($phone_renzheng == 1){
    $phone_renzheng_status_1 = 'selected';
}else if($phone_renzheng == 2){
    $phone_renzheng_status_2 = 'selected';
}else{
    $phone_renzheng_status_0 = 'selected';
}
$modelStr = '<tr class="header"><th>'.$Lang['shouji_rz'].'</th><th></th></tr>';
$modelStr.= '<tr><td width="100"><select style="width: 130px;" name="phone_renzheng" id="phone_renzheng" onchange="refreshphone_renzheng();">';
$modelStr.=  '<option value="0" '.$phone_renzheng_status_0.'>'.$Lang['quanbu'].'</option>';
$modelStr.=  '<option value="1" '.$phone_renzheng_status_1.'>'.$Lang['rz_no'].'</option>';
$modelStr.=  '<option value="2" '.$phone_renzheng_status_2.'>'.$Lang['rz_yes'].'</option>';

$modelStr.= '</select></td><td></td></tr>';
echo $modelStr;

$renzheng_status_0 =  $renzheng_status_1 = $renzheng_status_2 = "";
if($renzheng == 1){
    $renzheng_status_1 = 'selected';
}else if($renzheng == 2){
    $renzheng_status_2 = 'selected';
}else{
    $renzheng_status_0 = 'selected';
}
$modelStr = '<tr class="header"><th>'.$Lang['renzheng'].'</th><th></th></tr>';
$modelStr.= '<tr><td width="100"><select style="width: 130px;" name="renzheng" id="renzheng" onchange="refreshrenzheng();">';
$modelStr.=  '<option value="0" '.$renzheng_status_0.'>'.$Lang['quanbu'].'</option>';
$modelStr.=  '<option value="1" '.$renzheng_status_1.'>'.$Lang['rz_no'].'</option>';
$modelStr.=  '<option value="2" '.$renzheng_status_2.'>'.$Lang['rz_yes'].'</option>';

$modelStr.= '</select></td><td></td></tr>';
echo $modelStr;

$recommend_status_0 =  $recommend_status_1 = $recommend_status_2 = "";
if($recommend == 1){
    $recommend_status_1 = 'selected';
}else if($recommend == 2){
    $recommend_status_2 = 'selected';
}else{
    $recommend_status_0 = 'selected';
}
$modelStr = '<tr class="header"><th>'.$Lang['recommend'].'</th><th></th></tr>';
$modelStr.= '<tr><td width="100"><select style="width: 130px;" name="recommend" id="recommend" onchange="refreshrecommend();">';
$modelStr.=  '<option value="0" '.$recommend_status_0.'>'.$Lang['quanbu'].'</option>';
$modelStr.=  '<option value="1" '.$recommend_status_1.'>'.$Lang['rec_no'].'</option>';
$modelStr.=  '<option value="2" '.$recommend_status_2.'>'.$Lang['rec_yes'].'</option>';

$modelStr.= '</select></td><td></td></tr>';
echo $modelStr;

$status_status_0 =  $status_status_1 = $status_status_2 = "";
if($status == 1){
    $status_status_1 = 'selected';
}else if($status == 2){
    $status_status_2 = 'selected';
}else{
    $status_status_0 = 'selected';
}
$modelStr = '<tr class="header"><th>'.$Lang['status'].'</th><th></th></tr>';
$modelStr.= '<tr><td width="100"><select style="width: 130px;" name="status" id="status" onchange="refreshstatus();">';
$modelStr.=  '<option value="0" '.$status_status_0.'>'.$Lang['quanbu'].'</option>';
$modelStr.=  '<option value="1" '.$status_status_1.'>'.$Lang['normal'].'</option>';
$modelStr.=  '<option value="2" '.$status_status_2.'>'.$Lang['fenghao'].'</option>';

$modelStr.= '</select></td><td></td></tr>';
echo $modelStr;

$year_status_1 =  $year_status_2 = "";
if($all == 1){
    $year_status_1 = 'selected';
}else{
    $year_status_2 = 'selected';
}
$modelStr = '<tr class="header"><th>'.$Lang['info_all_user'].'</th><th></th></tr>';
$modelStr.= '<tr><td width="100"><select style="width: 130px;" name="year" id="year" onchange="refreshyear();">';
$modelStr.=  '<option value="1" '.$year_status_1.'>'.$Lang['info_ok_user'].'</option>';
$modelStr.=  '<option value="2" '.$year_status_2.'>'.$Lang['info_no_user'].'</option>';

$modelStr.= '</select></td><td></td></tr>';
echo $modelStr;
showformfooter();

$count = C::t('#tom_love#tom_love')->fetch_all_count($where);
$num = ceil($count/1000);
$doDaoUrl = $_G['siteurl']."plugin.php?id=tom_love:doDao&renzheng={$renzheng}&recommend={$recommend}&status={$status}&all={$all}&vip_id={$vip_id}&phone_renzheng={$phone_renzheng}";
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

function refreshrecommend() {
	location.href = "$adminurl"+"&renzheng="+jq('#renzheng').val() +"&recommend="+jq('#recommend').val() + "&status="+jq('#status').val() + "&vip_id="+jq('#vip_id').val() + "&all="+jq('#year').val() + "&phone_renzheng="+jq('#phone_renzheng').val();
}          
function refreshyear() {
	location.href = "$adminurl"+"&renzheng="+jq('#renzheng').val() +"&recommend="+jq('#recommend').val() + "&status="+jq('#status').val() + "&vip_id="+jq('#vip_id').val() + "&all="+jq('#year').val() + "&phone_renzheng="+jq('#phone_renzheng').val();
}
function refreshvip_id() {
    location.href = "$adminurl"+"&renzheng="+jq('#renzheng').val() +"&recommend="+jq('#recommend').val() + "&status="+jq('#status').val() + "&vip_id="+jq('#vip_id').val() + "&all="+jq('#year').val() + "&phone_renzheng="+jq('#phone_renzheng').val();
}
function refreshrenzheng() {
	location.href = "$adminurl"+"&renzheng="+jq('#renzheng').val() +"&recommend="+jq('#recommend').val() + "&status="+jq('#status').val() + "&vip_id="+jq('#vip_id').val() + "&all="+jq('#year').val() + "&phone_renzheng="+jq('#phone_renzheng').val();
}
function refreshstatus() {
	location.href = "$adminurl"+"&renzheng="+jq('#renzheng').val() +"&recommend="+jq('#recommend').val() + "&status="+jq('#status').val() + "&vip_id="+jq('#vip_id').val() + "&all="+jq('#year').val() + "&phone_renzheng="+jq('#phone_renzheng').val();
}function refreshphone_renzheng() {
	location.href = "$adminurl"+"&renzheng="+jq('#renzheng').val() +"&recommend="+jq('#recommend').val() + "&status="+jq('#status').val() + "&vip_id="+jq('#vip_id').val() + "&all="+jq('#year').val() + "&phone_renzheng="+jq('#phone_renzheng').val();
}
</script>
SCRIPT;
