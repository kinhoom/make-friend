<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：大叔来 www.dasuhlai.com
*/

if(!defined('IN_DISCUZ')){
	exit('Access Denied');
}

class table_tom_pay_order extends discuz_table{
	public function __construct() {
        parent::__construct();
		$this->_table = 'tom_pay_order';
		$this->_pk    = 'id';
	}

    public function fetch_by_id($id,$field='*') {
		return DB::fetch_first("SELECT $field FROM %t WHERE id=%d", array($this->_table, $id));
	}
    
    public function fetch_by_order_no($order_no,$field='*') {
		return DB::fetch_first("SELECT $field FROM %t WHERE order_no=%s", array($this->_table, $order_no));
	}
    
    public function fetch_by_qf_order_id($qf_order_id,$field='*') {
		return DB::fetch_first("SELECT $field FROM %t WHERE qf_order_id=%d", array($this->_table, $qf_order_id));
	}
    
    public function fetch_by_mag_order_id($mag_order_id,$field='*') {
		return DB::fetch_first("SELECT $field FROM %t WHERE mag_order_id=%s", array($this->_table, $mag_order_id));
	}
    
    public function fetch_all_sun_pay_price($condition) {
        $return = DB::fetch_first("SELECT SUM(pay_price) AS sun_pay_price FROM ".DB::table($this->_table)." WHERE 1 $condition ");
        if($return['sun_pay_price'] > 0){
            return $return['sun_pay_price'];
        }else{
            return 0;
        }
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