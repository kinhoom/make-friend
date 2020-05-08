<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


class table_appbyme_connection extends discuz_table {
	public function __construct() {
		$this->_table	= 'appbyme_connection';
		$this->_pk		= 'id'; 
		parent::__construct();
	}
	
	public function fetch_by_uid($uid) {	
		return DB::fetch_first("SELECT * FROM %t WHERE uid = %d", array($this->_table, $uid));
	}
	
	public function fetch_by_openid($openid) {
		return DB::fetch_first("SELECT * FROM %t WHERE openid = %s", array($this->_table, $openid));
	}

	public function fetch_by_unionid($unionid) {
		return DB::fetch_first("SELECT * FROM %t WHERE param = %s", array($this->_table, $unionid));
	}
	
}