<?php
	
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function get_phb_id($user_id) {
    global $_G;
    static $_use_phb_ids = array();
    $tomSysOffset = getglobal('setting/timeoffset');
    
    if(isset($_use_phb_ids[$user_id])){
        return $_use_phb_ids[$user_id];
    }
    
    $month_id = dgmdate($_G['timestamp'], 'Ym',$tomSysOffset);
    $phbInfo = C::t('#tom_love#tom_love_phb')->fetch_all_list(" AND user_id = {$user_id} AND phb_type = 1 AND month_id = {$month_id}", " ORDER BY id DESC", 0, 1);
    if (is_array($phbInfo) && !empty($phbInfo)){
        $_use_phb_ids[$user_id] = $phbInfo[0]['id'];
		return $phbInfo[0]['id'];
    }else{
        $insertData = array();
        $insertData['user_id']   = $user_id;
        $insertData['phb_type']   = 1;
        $insertData['month_id']  = $month_id;
        C::t('#tom_love#tom_love_phb')->insert($insertData);
        $phb_id = C::t('#tom_love#tom_love_phb')->insert_id();
        $_use_phb_ids[$user_id] = $phb_id;
        return $phb_id;
    }
}

function get_week_phb_id($user_id) {
    global $_G;
    static $_use_week_phb_ids = array();
    $tomSysOffset = getglobal('setting/timeoffset');
    
    if(isset($_use_week_phb_ids[$user_id])){
        return $_use_week_phb_ids[$user_id];
    }
    
    $month_id = dgmdate($_G['timestamp'], 'YW',$tomSysOffset);
    $phbInfo = C::t('#tom_love#tom_love_phb')->fetch_all_list(" AND user_id = {$user_id} AND phb_type = 2 AND month_id = {$month_id}", " ORDER BY id DESC", 0, 1);
    if (is_array($phbInfo) && !empty($phbInfo)){
        $_use_week_phb_ids[$user_id] = $phbInfo[0]['id'];
		return $phbInfo[0]['id'];
    }else{
        $insertData = array();
        $insertData['user_id']   = $user_id;
        $insertData['phb_type']   = 2;
        $insertData['month_id']  = $month_id;
        C::t('#tom_love#tom_love_phb')->insert($insertData);
        $phb_id = C::t('#tom_love#tom_love_phb')->insert_id();
        $_use_week_phb_ids[$user_id] = $phb_id;
        return $phb_id;
    }
}

function update_phb($user_id, $type, $num=1){
    if($type == 'paymoney'){
        $num = isset($num)? floatval($num): 0;
        if($num == 0){
            return false;
        }
    }else{
        $num = isset($num)? intval($num): 1;
    }
    
    $phb_id = get_phb_id($user_id);
    $week_phb_id = get_week_phb_id($user_id);
    if(!$phb_id || !$week_phb_id){
        return false;
    }
    
    if($type == 'flowers'){
        DB::query("UPDATE ".DB::table('tom_love_phb')." SET flowers=flowers+{$num} WHERE id='{$phb_id}'", 'UNBUFFERED');
        DB::query("UPDATE ".DB::table('tom_love_phb')." SET flowers=flowers+{$num} WHERE id='{$week_phb_id}'", 'UNBUFFERED');
    }else if($type == 'anlians'){
        DB::query("UPDATE ".DB::table('tom_love_phb')." SET anlians=anlians+1 WHERE id='{$phb_id}'", 'UNBUFFERED');
        DB::query("UPDATE ".DB::table('tom_love_phb')." SET anlians=anlians+1 WHERE id='{$week_phb_id}'", 'UNBUFFERED');
    }else if($type == 'clicks'){
        DB::query("UPDATE ".DB::table('tom_love_phb')." SET clicks=clicks+1 WHERE id='{$phb_id}'", 'UNBUFFERED');
        DB::query("UPDATE ".DB::table('tom_love_phb')." SET clicks=clicks+1 WHERE id='{$week_phb_id}'", 'UNBUFFERED');
    }else if($type == 'paymoney'){
        DB::query("UPDATE ".DB::table('tom_love_phb')." SET paymoney=paymoney+{$num} WHERE id='{$phb_id}'", 'UNBUFFERED');
        DB::query("UPDATE ".DB::table('tom_love_phb')." SET paymoney=paymoney+{$num} WHERE id='{$week_phb_id}'", 'UNBUFFERED');
    }else if($type == 'signdays'){
        DB::query("UPDATE ".DB::table('tom_love_phb')." SET signdays=signdays+1 WHERE id='{$phb_id}'", 'UNBUFFERED');
        DB::query("UPDATE ".DB::table('tom_love_phb')." SET signdays=signdays+1 WHERE id='{$week_phb_id}'", 'UNBUFFERED');
    }else if($type == 'shuoshuo'){
        DB::query("UPDATE ".DB::table('tom_love_phb')." SET shuoshuo=shuoshuo+1 WHERE id='{$phb_id}'", 'UNBUFFERED');
        DB::query("UPDATE ".DB::table('tom_love_phb')." SET shuoshuo=shuoshuo+1 WHERE id='{$week_phb_id}'", 'UNBUFFERED');
    }else if($type == 'sharetime'){
        DB::query("UPDATE ".DB::table('tom_love_phb')." SET sharetime=sharetime+1 WHERE id='{$phb_id}'", 'UNBUFFERED');
        DB::query("UPDATE ".DB::table('tom_love_phb')." SET sharetime=sharetime+1 WHERE id='{$week_phb_id}'", 'UNBUFFERED');
    }else{
        return false;
    }
	return true;
}