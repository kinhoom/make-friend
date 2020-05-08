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

require_once libfile('function/plugin');

if(isset($_G['uid']) && $_G['uid'] > 0 && $_G['groupid'] == 1){
    
    $sql = '';
    
    $tom_xiangqin_field = C::t('#tom_xiangqin#tom_xiangqin')->fetch_all_field();
    if (!isset($tom_xiangqin_field['qianxians'])) {
        $sql .= "ALTER TABLE `pre_tom_xiangqin` ADD `qianxians` int(11) DEFAULT '0';\n";
    }
    if (!isset($tom_xiangqin_field['qianxian_status'])) {
        $sql .= "ALTER TABLE `pre_tom_xiangqin` ADD `qianxian_status` int(11) DEFAULT '1';\n";
    }
    
    $tom_xiangqin_vip_field = C::t('#tom_xiangqin#tom_xiangqin_vip')->fetch_all_field();
    if (!isset($tom_xiangqin_vip_field['qianxian_times'])) {
        $sql .= "ALTER TABLE `pre_tom_xiangqin_vip` ADD `qianxian_times` int(11) DEFAULT '0';\n";
    }
    if (!isset($tom_xiangqin_vip_field['chakan_times'])) {
        $sql .= "ALTER TABLE `pre_tom_xiangqin_vip` ADD `chakan_times` int(11) DEFAULT '0';\n";
    }
    
    $tom_xiangqin_common_field = C::t('#tom_xiangqin#tom_xiangqin_common')->fetch_all_field();
    if (!isset($tom_xiangqin_common_field['qianxian_txt'])) {
        $sql .= "ALTER TABLE `pre_tom_xiangqin_common` ADD `qianxian_txt` text;\n";
    }
    
    $tom_xiangqin_order_field = C::t('#tom_xiangqin#tom_xiangqin_order')->fetch_all_field();
    if (!isset($tom_xiangqin_order_field['qianxian_value'])) {
        $sql .= "ALTER TABLE `pre_tom_xiangqin_order` ADD `qianxian_value` int(11) DEFAULT '0';\n";
    }
    
    if (!empty($sql)) {
        runquery($sql);
    }
    
    $sql = <<<EOF
    CREATE TABLE IF NOT EXISTS `pre_tom_xiangqin_chakan` (
      `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `xiangqin_id` int(11) NOT NULL DEFAULT '0',
      `user_id` int(11) DEFAULT '0',
      `time_key` int(11) DEFAULT '0',
      `add_time` int(11) DEFAULT '0',
      `part1` varchar(255) DEFAULT NULL,
      `part2` varchar(255) DEFAULT NULL,
      `part3` int(11) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM;
    
    CREATE TABLE IF NOT EXISTS `pre_tom_xiangqin_qianxian` (
      `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `xiangqin_id` int(11) DEFAULT '0',
      `hongniang_id` int(11) DEFAULT '0',
      `qianxian_xiangqin_id` int(11) DEFAULT '0',
      `qianxian_beizu` text,
      `qianxian_time` int(11) DEFAULT '0',
      `part1` varchar(255) DEFAULT NULL,
      `part2` varchar(255) DEFAULT NULL,
      `part3` int(11) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM;
    
    CREATE TABLE IF NOT EXISTS `pre_tom_xiangqin_qianxians_log` (
      `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `xiangqin_id` int(11) DEFAULT '0',
      `log_type` int(11) DEFAULT '0',
      `change_num` int(11) DEFAULT '0',
      `old_num` int(11) DEFAULT '0',
      `txt` text,
      `log_time` int(11) DEFAULT '0',
      `part1` varchar(255) DEFAULT NULL,
      `part2` varchar(255) DEFAULT NULL,
      `part3` int(11) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM;
    
    CREATE TABLE IF NOT EXISTS `pre_tom_xiangqin_focuspic` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `title` varchar(255) DEFAULT NULL,
      `picurl` varchar(255) DEFAULT NULL,
      `link` varchar(255) DEFAULT NULL,
      `fsort` int(11) DEFAULT '10',
      `part1` varchar(255) DEFAULT NULL,
      `part2` varchar(255) DEFAULT NULL,
      `part3` int(11) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM;

EOF;

    runquery($sql);

    echo 'OK';exit;
    
}else{
    exit('Access Denied');
}