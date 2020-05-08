<?php

/*
   [Dashulai!] (C)2009-2019 WWW.DASHULAI.COM.
   技术支持/更新维护：官网 https://www.dashulai.com
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_tom_love_district extends discuz_table{
	public function __construct() {
        parent::__construct();
		$this->_table = 'tom_love_district';
		$this->_pk    = 'id';
	}

    public function fetch_by_id($id,$field='*') {
		return DB::fetch_first("SELECT $field FROM %t WHERE id=%d", array($this->_table, $id));
	}
    
    public function fetch_by_name($name,$field='*') {
		return DB::fetch_first("SELECT $field FROM %t WHERE name LIKE %s ", array($this->_table,'%'.$name.'%'));
	}
    
    public function fetch_by_level_name($name,$field='*') {
		return DB::fetch_first("SELECT $field FROM %t WHERE name LIKE %s AND (level=1 OR level=2 OR level=3) ", array($this->_table,'%'.$name.'%'));
	}
    
    public function fetch_all_by_level($level,$field='*') {
		return DB::fetch_all("SELECT $field FROM %t WHERE level=%d ORDER BY displayorder ASC,id ASC ", array($this->_table, $level));
	}
    
    
    public function fetch_all_by_upid($upid, $order = null, $sort = 'DESC') {
		$upid = is_array($upid) ? array_map('intval', (array)$upid) : dintval($upid);
		if($upid !== null) {
			$ordersql = $order !== null && !empty($order) ? ' ORDER BY '.DB::order($order, $sort) : ' ORDER BY displayorder ASC,id ASC ';
			return DB::fetch_all('SELECT * FROM %t WHERE '.DB::field('upid', $upid)." ORDER BY displayorder ASC,id ASC ", array($this->_table), $this->_pk);
		}
		return array();
	}

	public function fetch_all_by_name($name) {
		if(!empty($name)) {
			return DB::fetch_all('SELECT * FROM %t WHERE '.DB::field('name', $name), array($this->_table));
		}
		return array();
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
	
	public function delete_by_id($id) {
		return DB::query("DELETE FROM %t WHERE id=%d", array($this->_table, $id));
	}

}
