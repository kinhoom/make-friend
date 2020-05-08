<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


class table_thirdbind extends discuz_table {
	public function __construct() {
		$this->_table	= 'thirdbind';
		$this->_pk		= 'id'; 
		parent::__construct();
	}
	
	public function fetch_by_uid($uid) {
		return DB::fetch_first("SELECT * FROM %t WHERE uid = %d and weibotype = %s", array($this->_table, $uid,"wechat"));
	}
	
	public function fetch_by_openid($openid) {
		return DB::fetch_first("SELECT * FROM %t WHERE openid = %s and weibotype = %s", array($this->_table, $openid,"wechat"));
	}

	public function fetch_by_unionid($unionid) {
		return DB::fetch_first("SELECT * FROM %t WHERE unionid = %s and weibotype = %s", array($this->_table, $unionid,"wechat"));
	}
	
}