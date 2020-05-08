<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$sql = <<<EOF

DROP TABLE IF EXISTS `pre_tom_pay_order`;
CREATE TABLE `pre_tom_pay_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plugin_id` varchar(255) DEFAULT NULL,
  `order_no` varchar(255) DEFAULT NULL,
  `goods_id` int(11) DEFAULT '0',
  `goods_name` varchar(255) DEFAULT NULL,
  `goods_beizu` varchar(255) DEFAULT NULL,
  `goods_url` varchar(255) DEFAULT NULL,
  `succ_back_url` varchar(255) DEFAULT NULL,
  `fail_back_url` varchar(255) DEFAULT NULL,
  `allow_alipay` int(11) DEFAULT '1',
  `pay_price` decimal(10,2) DEFAULT '0.00',
  `payment` varchar(255) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `prepay_id` varchar(255) DEFAULT NULL,
  `code_url` varchar(255) DEFAULT NULL,
  `mweb_url` varchar(255) DEFAULT NULL,
  `qf_order_id` int(11) DEFAULT '0',
  `mag_order_id` varchar(255) DEFAULT NULL,
  `add_time` int(11) unsigned DEFAULT '0',
  `order_time` int(11) unsigned DEFAULT '0',
  `pay_time` int(11) unsigned DEFAULT '0',
  `order_status` int(11) DEFAULT '0',
  `expire_time` int(11) DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_no_idx` (`order_no`)
) ENGINE=MyISAM;
        
EOF;

runquery($sql);
@unlink(DISCUZ_ROOT . './source/plugin/tom_pay/discuz_plugin_tom_pay.xml');
@unlink(DISCUZ_ROOT . './source/plugin/tom_pay/discuz_plugin_tom_pay_SC_GBK.xml');
@unlink(DISCUZ_ROOT . './source/plugin/tom_pay/discuz_plugin_tom_pay_SC_UTF8.xml');
@unlink(DISCUZ_ROOT . './source/plugin/tom_pay/discuz_plugin_tom_pay_TC_BIG5.xml');
@unlink(DISCUZ_ROOT . './source/plugin/tom_pay/discuz_plugin_tom_pay_TC_UTF8.xml');

$finish = TRUE;

@unlink(DISCUZ_ROOT . './source/plugin/tom_pay/install.php');
