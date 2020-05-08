<?php
/**
 * 
 * ��������Ʒ ������Ʒ
 * ������  ȫ���׷� https://dwz.cn/bEeiwujz
 * ����Դ��Դ�������ռ�,��������ѧϰ�о����ͣ�����������ҵ��;����������24Сʱ��ɾ��!
 * ��л֧�֣�����֧�����������Ķ�����Ϊվ���ṩ���ʺϵ���Ӫ��Դ��
 * ��ӭ������û�����¸��µ�������Դ������VIP��ɫ��Դ���ݴ������
 * [������]վ������Ⱥ: ��Ⱥ 205670720
 * ����������https://www.dashulai.com/ (���ղر���!)
 * 
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
} 

class table_tom_love extends discuz_table{
	public function __construct() {
        parent::__construct();
		$this->_table = 'tom_love';
		$this->_pk    = 'id';
	}

    public function fetch_by_id($id,$field='*') {
		return DB::fetch_first("SELECT $field FROM %t WHERE id=%d ", array($this->_table, $id));
	}
    
    public function fetch_by_member_id($member_id,$field='*') {
		return DB::fetch_first("SELECT $field FROM %t WHERE member_id=%d ", array($this->_table, $member_id));
	}
    
    public function fetch_by_bbs_uid($bbsUid,$field='*') {
		return DB::fetch_first("SELECT $field FROM %t WHERE bbs_uid=%d ", array($this->_table, $bbsUid));
	}
    
    public function update_num_clicks($id) {
        return DB::query("UPDATE ".DB::table($this->_table)." SET clicks=clicks+1 WHERE id={$id}", 'UNBUFFERED');
	}
    
    public function check_nickname($id,$nickname) {
		 $check = DB::fetch_first("SELECT * FROM %t WHERE id!=%d AND nickname=%s ", array($this->_table, $id,$nickname));
         if($check){
             return true;
         }else{
             return false;
         }
	}
    
    public function fetch_by_tel($tel) {
		return DB::fetch_first("SELECT * FROM %t WHERE tel=%s ", array($this->_table, $tel));
	}
    
    public function fetch_by_openid($openid) {
		return DB::fetch_first("SELECT * FROM %t WHERE openid=%s ", array($this->_table, $openid));
	}
    
    public function fetch_by_unionid($unionid) {
		return DB::fetch_first("SELECT * FROM %t WHERE unionid=%s ", array($this->_table, $unionid));
	}
    
    public function fetch_all_list($condition,$orders = '',$start = 0,$limit = 10,$bbs_username='',$nickname='') {
        if(!empty($bbs_username)){
            $data = DB::fetch_all("SELECT * FROM %t WHERE 1 %i AND bbs_username LIKE %s $orders LIMIT $start,$limit",array($this->_table,$condition,'%'.$bbs_username.'%'));
        }else if(!empty($nickname)){
            $data = DB::fetch_all("SELECT * FROM %t WHERE 1 %i AND nickname LIKE %s $orders LIMIT $start,$limit",array($this->_table,$condition,'%'.$nickname.'%'));
        }else{
            $data = DB::fetch_all("SELECT * FROM %t WHERE 1 %i $orders LIMIT $start,$limit",array($this->_table,$condition));
        }
		
		return $data;
	}
    
    public function fetch_vip_list($condition) {
        $data = DB::fetch_all("SELECT * FROM %t WHERE 1 %i",array($this->_table,$condition));
		return $data;
	}
    
    public function fetch_all_count($condition,$bbs_username='',$nickname='') {
        if(!empty($bbs_username)){
            $return = DB::fetch_first("SELECT count(*) AS num FROM %t WHERE 1 %i AND bbs_username LIKE %s ",array($this->_table,$condition,'%'.$bbs_username.'%'));
        }else if(!empty($nickname)){
            $return = DB::fetch_first("SELECT count(*) AS num FROM %t WHERE 1 %i AND nickname LIKE %s ",array($this->_table,$condition,'%'.$nickname.'%'));
        }else{
            $return = DB::fetch_first("SELECT count(*) AS num FROM %t WHERE 1 %i ",array($this->_table,$condition));
        }
		return $return['num'];
	}
    
    public function insert_id() {
		return DB::insert_id();
	}

}

