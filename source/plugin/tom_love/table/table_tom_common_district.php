<?php
/**
 * 
 * 大叔来出品 必属精品
 * 大叔来  全网首发 https://dwz.cn/bEeiwujz
 * 本资源来源于网络收集,仅供个人学习研究欣赏，请勿用于商业用途，并于下载24小时后删除!
 * 感谢支持！您的支持是我们最大的动力！为站长提供最适合的运营资源！
 * 欢迎大家来访获得最新更新的优秀资源！更多VIP特色资源不容错过！！
 * [大叔来]站长交流群: ①群 205670720
 * 永久域名：https://www.dashulai.com/ (请收藏备用!)
 * 
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_tom_common_district extends discuz_table
{
	public function __construct() {

		$this->_table = 'common_district';
		$this->_pk    = 'id';

		parent::__construct();
	}
    
    public function fetch_by_id($id,$field='*') {
		return DB::fetch_first("SELECT $field FROM %t WHERE id=%d ", array($this->_table, $id));
	}
    
    public function fetch_by_name($name,$field='*') {
		return DB::fetch_first("SELECT $field FROM %t WHERE name LIKE %s ", array($this->_table,'%'.$name.'%'));
	}
    
    public function fetch_by_level_name($name,$field='*') {
		return DB::fetch_first("SELECT $field FROM %t WHERE name LIKE %s AND (level=1 OR level=2 OR level=3) ", array($this->_table,'%'.$name.'%'));
	}
    
    public function fetch_all_by_level($level,$field='*') {
		return DB::fetch_all("SELECT $field FROM %t WHERE level=%d ", array($this->_table, $level));
	}
    
	public function fetch_all_by_upid($upid, $order = null, $sort = 'DESC') {
		$upid = is_array($upid) ? array_map('intval', (array)$upid) : dintval($upid);
		if($upid !== null) {
			$ordersql = $order !== null && !empty($order) ? ' ORDER BY '.DB::order($order, $sort) : '';
			return DB::fetch_all('SELECT * FROM %t WHERE '.DB::field('upid', $upid)." $ordersql", array($this->_table), $this->_pk);
		}
		return array();
	}

	public function fetch_all_by_name($name) {
		if(!empty($name)) {
			return DB::fetch_all('SELECT * FROM %t WHERE '.DB::field('name', $name), array($this->_table));
		}
		return array();
	}

}

