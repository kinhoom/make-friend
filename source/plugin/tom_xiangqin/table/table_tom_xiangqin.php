<?php

/*
   [Dashulai!] (C)2009-2019 WWW.DASHULAI.COM.
   技术支持/更新维护：官网 https://www.dashulai.com
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
} 

class table_tom_xiangqin extends discuz_table{
	public function __construct() {
        parent::__construct();
		$this->_table = 'tom_xiangqin';
		$this->_pk    = 'id';
	}

    public function fetch_by_id($id,$field='*') {
		return DB::fetch_first("SELECT $field FROM %t WHERE id=%d", array($this->_table, $id));
	}
    
    public function fetch_by_user_no($user_no,$field='*') {
		return DB::fetch_first("SELECT $field FROM %t WHERE user_no=%d", array($this->_table, $user_no));
	}
    
    public function fetch_by_user_id($user_id,$field='*') {
		return DB::fetch_first("SELECT $field FROM %t WHERE user_id=%d", array($this->_table, $user_id));
	}
	
    public function fetch_all_list($condition,$orders = '',$start = 0,$limit = 10,$xm='') {
		if(!empty($xm)){
            $data = DB::fetch_all("SELECT * FROM %t WHERE 1 %i AND xm LIKE %s $orders LIMIT $start,$limit",array($this->_table,$condition,'%'.$xm.'%'));
        }else{
            $data = DB::fetch_all("SELECT * FROM %t WHERE 1 %i $orders LIMIT $start,$limit",array($this->_table,$condition));
        }
		return $data;
	}
    
    public function insert_id() {
		return DB::insert_id();
	}
    
    public function fetch_vip_list($condition,$start = 0,$limit = 10) {
        $data = DB::fetch_all("SELECT * FROM %t WHERE 1 %i LIMIT $start,$limit",array($this->_table,$condition));
		return $data;
	}
    
    public function fetch_all_count($condition,$xm='') {
        if(!empty($xm)){
            $return = DB::fetch_first("SELECT count(*) AS num FROM %t WHERE 1 %i AND xm LIKE %s ",array($this->_table,$condition,'%'.$xm.'%'));
        }else{
            $return = DB::fetch_first("SELECT count(*) AS num FROM %t WHERE 1 %i ",array($this->_table,$condition));
        }
		return $return['num'];
	}
	
	public function delete_by_id($id) {
		return DB::query("DELETE FROM %t WHERE id=%d", array($this->_table, $id));
	}

}