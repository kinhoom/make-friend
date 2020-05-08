<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：大叔来 www.dasuhlai.com
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
} 

class table_tom_ucenter_member extends discuz_table{
	public function __construct() {
        parent::__construct();
		$this->_table = 'tom_ucenter_member';
		$this->_pk    = 'uid';
	}

    public function fetch_by_uid($uid,$field='*') {
		return DB::fetch_first("SELECT $field FROM %t WHERE uid=%d", array($this->_table, $uid));
	}
    
    public function fetch_by_openid($openid) {
		return DB::fetch_first("SELECT * FROM %t WHERE  openid=%s ", array($this->_table,$openid));
	}
    
    public function fetch_by_unionid($unionid,$field='*') {
		return DB::fetch_first("SELECT $field FROM %t WHERE unionid=%s", array($this->_table, $unionid));
	}
    
    public function fetch_by_bbs_uid($bbs_uid) {
		return DB::fetch_first("SELECT * FROM %t WHERE  bbs_uid=%d ", array($this->_table,$bbs_uid));
	}
    
    public function fetch_by_tel($tel) {
		return DB::fetch_first("SELECT * FROM %t WHERE  tel=%s ", array($this->_table,$tel));
	}
    
    public function fetch_all_like_list($condition,$orders = '',$start = 0,$limit = 10,$nickname='') {
        if(!empty($nickname)){
            $data = DB::fetch_all("SELECT * FROM %t WHERE 1 %i AND nickname LIKE %s $orders LIMIT $start,$limit",array($this->_table,$condition,'%'.$nickname.'%'));
        }else{
            $data = DB::fetch_all("SELECT * FROM %t WHERE 1 %i $orders LIMIT $start,$limit",array($this->_table,$condition));
        }
		
		return $data;
	}
    
    public function fetch_all_like_count($condition,$nickname='') {
        if(!empty($nickname)){
            $return = DB::fetch_first("SELECT count(*) AS num FROM %t WHERE 1 %i AND nickname LIKE %s ",array($this->_table,$condition,'%'.$nickname.'%'));
        }else{
            $return = DB::fetch_first("SELECT count(*) AS num FROM %t WHERE 1 %i ",array($this->_table,$condition));
        }
		return $return['num'];
	}
	
    public function fetch_all_list($condition,$orders = '',$start = 0,$limit = 10) {
		$data = DB::fetch_all("SELECT * FROM %t WHERE 1 %i $orders LIMIT $start,$limit",array($this->_table,$condition));
		return $data;
	}
    
    public function insert_id() {
		return DB::insert_id();
	}
    
    public function fetch_all_count($condition) {
        $return = DB::fetch_first("SELECT count(*) AS num FROM ".DB::table($this->_table)." WHERE 1 $condition ");
		return $return['num'];
	}
	
	public function delete_by_id($uid) {
		return DB::query("DELETE FROM %t WHERE uid=%d", array($this->_table, $uid));
	}

}


