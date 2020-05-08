<?php
/**
 * 
 * 大叔来提醒：为保证大叔来资源的更新维护保障，防止大叔来首发资源被恶意泛滥，
 *             希望所有下载大叔来资源的会员不要随意把大叔来首发资源提供给其他人;
 *             如被发现，将取消大叔来会员免费更新资格，停止一切后期更新支持以及所有补丁BUG等修正服务；
 *          
 * 大叔来出品 必属精品
 * 大叔来社区 全网首发 https://dwz.cn/bEeiwujz
 * 官方网址：www.dashulai.com (请收藏备用!)
 * 本资源来源于网络收集,仅供个人学习研究欣赏，请勿用于商业用途，并于下载24小时后删除!
 * 技术支持/更新维护：官网 https://www.dashulai.com
 * 谢谢支持，感谢你对大叔来的关注和信赖！！！   
 * 
 */
if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
session_start();
loaducenter();
$jyConfig = $_G['cache']['plugin']['tom_love'];
$xiangqinConfig = $_G['cache']['plugin']['tom_xiangqin'];
$tomSysOffset = getglobal('setting/timeoffset');
$nowDayTime = gmmktime(0, 0, 0, dgmdate($_G['timestamp'], 'n', $tomSysOffset), dgmdate($_G['timestamp'], 'j', $tomSysOffset), dgmdate($_G['timestamp'], 'Y', $tomSysOffset)) - $tomSysOffset * 3600;
$nowYear = dgmdate($_G['timestamp'], 'Y', $tomSysOffset);
$appid = trim($jyConfig['love_appid']);
$appsecret = trim($jyConfig['love_appsecret']);
include DISCUZ_ROOT . './source/plugin/tom_xiangqin/class/xiangqin.func.php';
include DISCUZ_ROOT . './source/plugin/tom_love/class/love.func.php';
include DISCUZ_ROOT . './source/plugin/tom_love/class/link.func.php';
include DISCUZ_ROOT . './source/plugin/tom_love/login_ajax.php';

if (CHARSET == 'gbk') {
	include DISCUZ_ROOT . './source/plugin/tom_xiangqin/config/works.gbk.php';
} else {
	include DISCUZ_ROOT . './source/plugin/tom_xiangqin/config/works.utf.php';
}
$__Xiangqin = array();
if ($__UserInfo['id'] > 0) {
	$__XiangqinTmp = C::t('#tom_xiangqin#tom_xiangqin')->fetch_by_user_id($__UserInfo['id']);
	if ($__XiangqinTmp['id'] > 0) {
		$__Xiangqin = $__XiangqinTmp;
	}
}
if ($_GET['act'] == 'list' && $_GET['formhash'] == FORMHASH) {
	include DISCUZ_ROOT . './source/plugin/tom_xiangqin/module/list.php';
} else {
	if ($_GET['act'] == 'vipUpdate' && $_GET['formhash'] == FORMHASH) {
		$userList = C::t('#tom_xiangqin#tom_xiangqin')->fetch_vip_list(' AND vip_id > 0 AND vip_time <= ' . TIMESTAMP . ' ');
		if (is_array($userList) && !empty($userList)) {
			foreach ($userList as $key => $value) {
				$updateData = array();
				$updateData['vip_id'] = 0;
				$updateData['vip_time'] = 0;
				C::t('#tom_xiangqin#tom_xiangqin')->update($value['id'], $updateData);
			}
		}
		echo 200;
		exit(0);
	} else {
		if ($_GET['act'] == 'topUpdate' && $_GET['formhash'] == FORMHASH) {
			$userList = C::t('#tom_xiangqin#tom_xiangqin')->fetch_vip_list(' AND top_status = 1 AND top_time <= ' . TIMESTAMP . ' ');
			if (is_array($userList) && !empty($userList)) {
				foreach ($userList as $key => $value) {
					$updateData = array();
					$updateData['top_status'] = 0;
					$updateData['top_time'] = 0;
					C::t('#tom_xiangqin#tom_xiangqin')->update($value['id'], $updateData);
				}
			}
			echo 200;
			exit(0);
		} else {
			if ($_GET['act'] == 'get_search_url' && $_GET['formhash'] == FORMHASH) {
				$keyword = isset($_GET['keyword']) ? daddslashes(diconv(urldecode($_GET['keyword']), 'utf-8')) : '';
				$url = 'plugin.php?id=tom_xiangqin&mod=list&keyword=' . urlencode(trim($keyword));
				$url = tom_link_replace($url);
				echo $url;
				exit(0);
			} else {
				if ($_GET['act'] == 'addshoucang' && $_GET['formhash'] == FORMHASH) {
					$xiangqin_id = isset($_GET['xiangqin_id']) ? intval($_GET['xiangqin_id']) : 0;
					$info = C::t('#tom_xiangqin#tom_xiangqin')->fetch_by_id($xiangqin_id);
					if (empty($__UserInfo['id'])) {
						$outArr = array('status' => 404);
						echo json_encode($outArr);
						exit(0);
					}
					$isCollect = C::t('#tom_xiangqin#tom_xiangqin_collect')->fetch_all_list('AND user_id = ' . $__UserInfo['id'] . ' AND xiangqin_id =' . $info['id'], ' ORDER BY id DESC ', 0, 1);
					if (is_array($isCollect) && !empty($isCollect)) {
						$outArr = array('status' => 101);
						echo json_encode($outArr);
						exit(0);
					}
					$insertData = array();
					$insertData['user_id'] = $__UserInfo['id'];
					$insertData['xiangqin_id'] = $info['id'];
					C::t('#tom_xiangqin#tom_xiangqin_collect')->insert($insertData);
					$outArr = array('status' => 200);
					
					echo json_encode($outArr);
					exit(0);
				} else {
					if ($_GET['act'] == 'delshoucang' && $_GET['formhash'] == FORMHASH) {
						$xiangqin_id = isset($_GET['xiangqin_id']) ? intval($_GET['xiangqin_id']) : 0;
						C::t('#tom_xiangqin#tom_xiangqin_collect')->delete_by_id($xiangqin_id);
						$outArr = array('status' => 200);
						echo json_encode($outArr);
						exit(0);
					} else {
						if ($_GET['act'] == 'opend' && $_GET['formhash'] == FORMHASH) {
							$xiangqin_id = isset($_GET['xiangqin_id']) ? intval($_GET['xiangqin_id']) : 0;
							$updateData = array();
							$updateData['closed'] = 0;
							C::t('#tom_xiangqin#tom_xiangqin')->update($xiangqin_id, $updateData);
							$outArr = array('status' => 200);
							echo json_encode($outArr);
							exit(0);
						} else {
							if ($_GET['act'] == 'closed' && $_GET['formhash'] == FORMHASH) {
								$xiangqin_id = isset($_GET['xiangqin_id']) ? intval($_GET['xiangqin_id']) : 0;
								$updateData = array();
								$updateData['closed'] = 1;
								C::t('#tom_xiangqin#tom_xiangqin')->update($xiangqin_id, $updateData);
								$outArr = array('status' => 200);
								//by www-dashulai-com
								echo json_encode($outArr);
								exit(0);
							} else {
								if ($_GET['act'] == 'agree' && $_GET['formhash'] == FORMHASH) {
									$xiangqin_id = isset($_GET['xiangqin_id']) ? intval($_GET['xiangqin_id']) : 0;
									$updateData = array();
									$updateData['agree_safe'] = 1;
									C::t('#tom_xiangqin#tom_xiangqin')->update($xiangqin_id, $updateData);
								} else {
									if ($_GET['act'] == 'chakan' && $_GET['formhash'] == FORMHASH && $userStatus) {
										$outArr = array('status' => 1);
										$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
										$xiangqin_id = isset($_GET['xiangqin_id']) ? intval($_GET['xiangqin_id']) : 0;
										$vipInfo = C::t('#tom_xiangqin#tom_xiangqin_vip')->fetch_by_id($__Xiangqin['vip_id']);
										$chakanCount = C::t('#tom_xiangqin#tom_xiangqin_chakan')->fetch_all_count(' AND user_id=' . $__UserInfo['id'] . ' AND time_key=' . $nowDayTime . ' ');
										if ($vipInfo['chakan_times'] > 0 && $chakanCount >= $vipInfo['chakan_times']) {
											$outArr = array('status' => 301);
											echo json_encode($outArr);
											exit(0);
										}
										$insertData = array();
										$insertData['xiangqin_id'] = $xiangqin_id;
										$insertData['user_id'] = $__UserInfo['id'];
										$insertData['time_key'] = $nowDayTime;
										C::t('#tom_xiangqin#tom_xiangqin_chakan')->insert($insertData);
										$outArr = array('status' => 200);
										//by www-dashulai-com
										echo json_encode($outArr);
										exit(0);
									} else {
										if ($_GET['act'] == 'pic') {
											$callback = $_GET['callback'];
											$uid = isset($_GET['uid']) ? intval($_GET['uid']) : 0;
											$outArr = array();
											$picListTmp = C::t('#tom_xiangqin#tom_xiangqin_photo')->fetch_all_list(' AND xiangqin_id = ' . $uid . ' ', 'ORDER BY id DESC', 0, 100);
											$picList = array();
											if (is_array($picListTmp) && !empty($picListTmp)) {
												foreach ($picListTmp as $key => $value) {
													$picList[$key] = $value;
													//WWW.DASHULAI.COM
													if (!preg_match('/^http/', $value['pic_url'])) {
														if (strpos($value['pic_url'], 'data/attachment/tomwx') !== false || strpos($value['pic_url'], 'uc_server/') !== false || strpos($value['pic_url'], 'source/plugin') !== false) {
															$picList[$key]['pic_url'] = $_G['siteurl'] . $value['pic_url'];
														} else {
															$picList[$key]['pic_url'] = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']) . $_G['setting']['attachurl'] . 'common/' . $value['pic_url'];
														}
													} else {
														$picList[$key]['pic_url'] = $value['pic_url'];
													}
												}
											}
											$i = 1;
											if (is_array($picList) && !empty($picList)) {
												foreach ($picList as $key => $value) {
													$outArr[$i] = $value['pic_url'];
													$i = $i + 1;
												}
											}
											$outStr = '';
											$outStr = json_encode($outArr);
											if ($callback) {
												$outStr = $callback . '(' . $outStr . ')';
											}
											echo $outStr;
											exit(0);
										} else {
											echo 'error';
											exit(0);
										}
									}
								}
							}
						}
					}
				}
			}
		}
	}
}