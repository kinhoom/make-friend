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

class table_tom_common_member_profile extends discuz_table
{
	public function __construct() {

		$this->_table = 'common_member_profile';
		$this->_pk    = 'uid';

		parent::__construct();
	}
    
    public function fetch_by_uid($uid,$field='*') {
		return DB::fetch_first("SELECT $field FROM %t WHERE uid=%d ", array($this->_table, $uid));
	}

}
