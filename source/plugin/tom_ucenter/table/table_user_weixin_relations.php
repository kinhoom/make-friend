<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


class table_user_weixin_relations extends discuz_table {
	public function __construct() {
		$this->_table	= 'user_weixin_relations';
		$this->_pk		= 'id'; 
		parent::__construct();
	}
	
	public function fetch_by_uid($uid) {	
		return DB::fetch_first("SELECT * FROM %t WHERE userid = %d", array($this->_table, $uid));
	}
	
	public function fetch_by_openid($openid) {
		return DB::fetch_first("SELECT * FROM %t WHERE openid = %s", array($this->_table, $openid));
	}

	public function fetch_by_unionid($unionid) {
		return DB::fetch_first("SELECT * FROM %t WHERE unionid = %s", array($this->_table, $unionid));
	}
	
	public function delete_by_uid($uids) {
		return DB::delete($this->_table, DB::field('userid', $uids));
	}
	
	public function update_status($uid, $status) {
		return DB::update($this->_table, array('status' => $status), array('userid' => $uid), true);
	}
	
	public function fetch_all($start, $limit) {
		return DB::fetch_all("SELECT * FROM %t ORDER BY create_time DESC ".DB::limit($start, $limit), array($this->_table),'uid');
	}
	
	
}