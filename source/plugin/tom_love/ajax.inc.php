<?php
/**
 * 
 * »µµ°ÍøÂçbbs.huaidanwangluo.com£¡£¡£¡   
 * 
 */
if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
session_start();
loaducenter();
$jyConfig = $_G['cache']['plugin']['tom_love'];
$tomSysOffset = getglobal('setting/timeoffset');
$nowYear = dgmdate($_G['timestamp'], 'Y', $tomSysOffset);
$nowTime = gmmktime(0, 0, 0, dgmdate($_G['timestamp'], 'n', $tomSysOffset), dgmdate($_G['timestamp'], 'j', $tomSysOffset), dgmdate($_G['timestamp'], 'Y', $tomSysOffset)) - $tomSysOffset * 3600;
$appid = trim($jyConfig['love_appid']);
$appsecret = trim($jyConfig['love_appsecret']);
include DISCUZ_ROOT . './source/plugin/tom_love/class/link.func.php';
include DISCUZ_ROOT . './source/plugin/tom_love/class/phb.func.php';
include DISCUZ_ROOT . './source/plugin/tom_love/class/love.func.php';
include DISCUZ_ROOT . './source/plugin/tom_love/login_ajax.php';

if (CHARSET == 'gbk') {
	include DISCUZ_ROOT . './source/plugin/tom_love/config/works.gbk.php';
} else {
	include DISCUZ_ROOT . './source/plugin/tom_love/config/works.utf.php';
}
if ($_GET['act'] == 'list' && $_GET['formhash'] == FORMHASH) {
	$outStr = '';
	$nickname = isset($_GET['nickname']) ? daddslashes(urldecode($_GET['nickname'])) : '';
	$renzheng = isset($_GET['renzheng']) ? intval($_GET['renzheng']) : 0;
	$phone_renzheng = isset($_GET['phone_renzheng']) ? intval($_GET['phone_renzheng']) : 0;
	$province_id = isset($_GET['province_id']) ? intval($_GET['province_id']) : 0;
	$hjcity_id = isset($_GET['hjcity_id']) ? intval($_GET['hjcity_id']) : 0;
	$city_id = isset($_GET['city_id']) ? intval($_GET['city_id']) : 0;
	$area_id = isset($_GET['area_id']) ? intval($_GET['area_id']) : 0;
	$towns_id = isset($_GET['towns_id']) ? intval($_GET['towns_id']) : 0;
	$district_id = isset($_GET['district_id']) ? intval($_GET['district_id']) : 0;
	$sex = isset($_GET['sex']) ? intval($_GET['sex']) : 0;
	$age = isset($_GET['age']) ? intval($_GET['age']) : 0;
	$type = isset($_GET['type']) ? intval($_GET['type']) : 0;
	$marital = isset($_GET['marital']) ? intval($_GET['marital']) : 0;
	$job = isset($_GET['job']) ? intval($_GET['job']) : 0;
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$index_type = isset($_GET['index_type']) ? intval($_GET['index_type']) : 0;
	$where = ' AND nickname !=\'\' AND year > 0 AND status = 1 AND shenhe_status = 2 AND avatar != \'source/plugin/tom_love/images/avatar_default.jpg\' ';
	if ($phone_renzheng == 1) {
		$where .= ' AND phone_renzheng = 1 ';
	} else {
		if ($phone_renzheng == 2) {
			$where .= ' AND phone_renzheng = 0 ';
		}
	}
	if ($renzheng > 0) {
		$where .= ' AND renzheng = 1 ';
	}
	if ($province_id > 0) {
		$where .= ' AND province_id = ' . $province_id . ' ';
	}
	if ($hjcity_id > 0) {
		$where .= ' AND hjcity_id = ' . $hjcity_id . ' ';
	}
	if ($city_id > 0) {
		$where .= ' AND city_id = ' . $city_id . ' ';
	}
	if ($area_id > 0) {
		$where .= ' AND area_id = ' . $area_id . ' ';
	}
	if ($towns_id > 0) {
		$where .= ' AND towns_id = ' . $towns_id . ' ';
	}
	if ($sex == 1) {
		$where .= ' AND sex = 1 ';
	} else {
		if ($sex == 2) {
			$where .= ' AND sex = 2 ';
		}
	}
	if ($type == 1) {
		$where .= ' AND friend = 1 ';
	} else {
		if ($type == 2) {
			$where .= ' AND marriage = 1 ';
		}
	}
	if ($marital >= 1) {
		$where .= ' AND marital_id = ' . $marital . ' ';
	}
	if (!empty($job)) {
		$where .= ' AND work_id = ' . $job . ' ';
	}
	if ($index_type == 1) {
		$where .= ' AND recommend = 1 ';
	}
	if (!empty($age)) {
		if ($age == 1) {
			if ($jyConfig['age_type_id'] == 1) {
				$startYear = $nowYear - 23;
				$endYear = $nowYear - 18;
			} else {
				$startYear = $nowYear - 23 + 1;
				$endYear = $nowYear - 18 + 1;
			}
			$where .= ' AND year >= ' . $startYear . ' AND year <= ' . $endYear;
		} else {
			if ($age == 2) {
				if ($jyConfig['age_type_id'] == 1) {
					$startYear = $nowYear - 27;
					$endYear = $nowYear - 24;
				} else {
					$startYear = $nowYear - 27 + 1;
					$endYear = $nowYear - 24 + 1;
				}
				$where .= ' AND year >= ' . $startYear . ' AND year <= ' . $endYear;
			} else {
				if ($age == 3) {
					if ($jyConfig['age_type_id'] == 1) {
						$startYear = $nowYear - 30;
						$endYear = $nowYear - 28;
					} else {
						$startYear = $nowYear - 30 + 1;
						$endYear = $nowYear - 28 + 1;
					}
					$where .= ' AND year >= ' . $startYear . ' AND year <= ' . $endYear;
				} else {
					if ($age == 4) {
						if ($jyConfig['age_type_id'] == 1) {
							$startYear = $nowYear - 34;
							$endYear = $nowYear - 31;
						} else {
							$startYear = $nowYear - 34 + 1;
							$endYear = $nowYear - 31 + 1;
						}
						$where .= ' AND year >= ' . $startYear . ' AND year <= ' . $endYear;
					} else {
						if ($age == 5) {
							if ($jyConfig['age_type_id'] == 1) {
								$startYear = $nowYear - 39;
								$endYear = $nowYear - 35;
							} else {
								$startYear = $nowYear - 39 + 1;
								$endYear = $nowYear - 35 + 1;
							}
							$where .= ' AND year >= ' . $startYear . ' AND year <= ' . $endYear;
						} else {
							if ($age == 6) {
								if ($jyConfig['age_type_id'] == 1) {
									$startYear = $nowYear - 45;
									$endYear = $nowYear - 40;
								} else {
									$startYear = $nowYear - 45 + 1;
									$endYear = $nowYear - 40 + 1;
								}
								$where .= ' AND year >= ' . $startYear . ' AND year <= ' . $endYear;
							} else {
								if ($age == 7) {
									if ($jyConfig['age_type_id'] == 1) {
										$startYear = $nowYear - 55;
										$endYear = $nowYear - 45;
									} else {
										$startYear = $nowYear - 55 + 1;
										$endYear = $nowYear - 45 + 1;
									}
									$where .= ' AND year >= ' . $startYear . ' AND year <= ' . $endYear;
								} else {
									if ($age == 8) {
										if ($jyConfig['age_type_id'] == 1) {
											$endYear = $nowYear - 55;
										} else {
											$endYear = $nowYear - 55 + 1;
										}
										$where .= ' AND year <= ' . $endYear . ' ';
									} else {
										if ($age == 9) {
											if ($jyConfig['age_type_id'] == 1) {
												$startYear = $nowYear - 18;
											} else {
												$startYear = $nowYear - 18 + 1;
											}
											$where .= ' AND year >= ' . $startYear . ' ';
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
	//www_dashulai_com
	$sort = ' ORDER BY id DESC ';
	if ($index_type == 1) {
		$sort = ' ORDER BY recommend_do_time DESC,id DESC ';
	} else {
		if ($index_type == 2) {
			$sort = ' ORDER BY id DESC ';
		} else {
			if ($index_type == 3) {
				$sort = ' ORDER BY flowers DESC,id DESC ';
			} else {
				if ($index_type == 4) {
					$sort = ' ORDER BY anlians DESC,id DESC ';
				} else {
					if ($index_type == 5) {
						$sort = ' ORDER BY score DESC,id DESC ';
					} else {
						if ($index_type == 6) {
							$sort = ' ORDER BY clicks DESC,id DESC ';
						}
					}
				}
			}
		}
	}
	//by WWW.DASHULAI.COM
	$pagesize = 8;
	$start = ($page - 1) * $pagesize;
	$userData = C::t('#tom_love#tom_love')->fetch_all_list($where, $sort, $start, $pagesize, '', $nickname);
	$userList = array();
	if (is_array($userData) && !empty($userData)) {
		foreach ($userData as $key => $value) {
			$userList[$key] = $value;
			$userList[$key]['describe'] = tom_num_replace(cutstr(dhtmlspecialchars($value['describe']), 58, '...'));
			if ($value['year'] > 0) {
				if ($jyConfig['age_type_id'] == 1) {
					$userList[$key]['age'] = $nowYear - $value['year'];
				} else {
					$userList[$key]['age'] = $nowYear - $value['year'] + 1;
				}
			} else {
				$userList[$key]['age'] = '';
			}
			$userList[$key]['avatar'] = tom_avatar($value['avatar']);
			$provinceInfo = C::t('#tom_love#tom_love_district')->fetch_by_id($value['province_id']);
			$cityInfo = C::t('#tom_love#tom_love_district')->fetch_by_id($value['city_id']);
			$areaInfo = C::t('#tom_love#tom_love_district')->fetch_by_id($value['area_id']);
			$townsInfo = C::t('#tom_love#tom_love_district')->fetch_by_id($value['towns_id']);
			$userList[$key]['provinceInfo'] = $provinceInfo;
			$userList[$key]['cityInfo'] = $cityInfo;
			$userList[$key]['areaInfo'] = $areaInfo;
			$userList[$key]['townsInfo'] = $townsInfo;
		}
	}
	//www-dashulai-com
	if (is_array($userList) && !empty($userList)) {
		foreach ($userList as $key => $value) {
			if ($jyConfig['open_index_biglist'] == 1 && $index_type > 0) {
				$outStr .= '<div class="item_big clearfix">';
				$outStr .= '<a href="plugin.php?id=tom_love&mod=info&uid=' . $value['id'] . '">';
				$outStr .= '<div class="pictop clearfix">';
				$outStr .= '<img src="' . $value['avatar'] . '"/>';
				$outStr .= '</div>';
				$outStr .= '<div class="picmiddle clearfix">';
				$outStr .= '<div class="left">' . $value['nickname'] . '</div>';
				if ($value['sex'] == 1) {
					$outStr .= '<div class="right"><img src="source/plugin/tom_love/images/new-list/boy.png"></div>';
				} else {
					if ($value['sex'] == 2) {
						$outStr .= '<div class="right"><img src="source/plugin/tom_love/images/new-list/girl.png"></div>';
					}
				}
				$outStr .= '<span class="sui">' . $value['age'] . '' . lang('plugin/tom_love', 'ajax_list_sui') . '</span>';
				$outStr .= '</div>';
				$outStr .= '<div class="picbottom clearfix">';
				if ($index_type == 3) {
					$outStr .= '<span class="left" style="padding-left: 0px;">' . '<span style="color: #ff6c87;">' . $value['flowers'] . '</span>' . lang('plugin/tom_love', 'ajax_list_flowers_2') . '</span>';
				} else {
					if ($index_type == 4) {
						$outStr .= '<span class="left" style="padding-left: 0px;">' . '<span style="color: #ff6c87;">' . $value['anlians'] . '</span>' . lang('plugin/tom_love', 'ajax_list_anlians_2') . '</span>';
					} else {
						if ($index_type == 5) {
							$outStr .= '<span class="left" style="padding-left: 0px;">' . '<span style="color: #ff6c87;">' . $value['score'] . '</span>' . $jyConfig['score_name'] . '</span>';
						} else {
							$outStr .= '<span class="left">';
							if ($value['marriage'] == 1) {
								$outStr .= lang('plugin/tom_love', 'ajax_list_marriage');
							}
							if ($value['marriage'] == 1 && $value['friend'] == 1) {
								$outStr .= '' . lang('plugin/tom_love', 'ajax_list_dian') . '';
							}
							if ($value['friend'] == 1) {
								$outStr .= lang('plugin/tom_love', 'ajax_list_friend');
							}
							$outStr .= '</span>';
						}
					}
				}
				$outStr .= '<span class="icon">';
				if ($value['renzheng'] == 1) {
					$outStr .= '<img src="source/plugin/tom_love/images/new-list/rz.png" style="width:18px;">&nbsp;';
				}
				if ($value['phone_renzheng'] == 1) {
					$outStr .= '<img src="source/plugin/tom_love/images/new-list/mobile.png" style="width:18px;">&nbsp;';
				}
				if ($value['pic_num'] > 0) {
					$outStr .= '<img src="source/plugin/tom_love/images/new-list/photo.png" style="width:18px;">&nbsp;';
				}
				$outStr .= '</span>';
				$outStr .= '</div>';
				$outStr .= '</a>';
				$outStr .= '</div>';
			} else {
				$outStr .= '<div class="item clearfix">';
				$outStr .= '<a href="plugin.php?id=tom_love&mod=info&uid=' . $value['id'] . '">';
				$outStr .= '<div class="cell clearfix">';
				$outStr .= '<div class="left">';
				$outStr .= '<img src="' . $value['avatar'] . '"/>';
				$outStr .= '</div>';
				$outStr .= '<div class="right">';
				$outStr .= '<div class="topInfo">';
				$outStr .= '<div class="name"><p style="font-size:14px">' . $value['nickname'];
				if ($value['sex'] == 1) {
					$outStr .= '<img src="source/plugin/tom_love/images/new-list/boy.png">';
				} else {
					if ($value['sex'] == 2) {
						$outStr .= '<img src="source/plugin/tom_love/images/new-list/girl.png">';
					}
				}
				$outStr .= '</p></div>';
				if ($jyConfig['open_subscribe'] == 1) {
					if ($value['subscribe'] == 1) {
						$outStr .= '<div class="state"><p style="font-size:12px;"><img src="source/plugin/tom_love/images/new-list/online.png">' . lang('plugin/tom_love', 'ajax_list_online') . '</p></div>';
					} else {
						$outStr .= '<div class="state"><p style="font-size:12px;"><img src="source/plugin/tom_love/images/new-list/offline.png">' . lang('plugin/tom_love', 'ajax_list_offline') . '</p></div>';
					}
				}
				$outStr .= '</div>';
				$outStr .= '<div class="baseInfo">';
				if ($value['renzheng'] == 1) {
					$outStr .= '<img src="source/plugin/tom_love/images/new-list/rz.png" style="width:18px;">&nbsp;';
				}
				if ($value['phone_renzheng'] == 1) {
					$outStr .= '<img src="source/plugin/tom_love/images/new-list/mobile.png" style="width:18px;">&nbsp;';
				}
				if ($value['pic_num'] > 0) {
					$outStr .= '<img src="source/plugin/tom_love/images/new-list/photo.png" style="width:18px;">&nbsp;';
				}
				$outStr .= '<span>' . $value['age'] . '' . lang('plugin/tom_love', 'ajax_list_sui') . '</span>|';
				if ($jyConfig['list_address_type'] == 1) {
					$outStr .= '<span>' . $value['provinceInfo']['name'] . '' . lang('plugin/tom_love', 'ajax_list_dian') . '' . $value['cityInfo']['name'] . '</span>|';
				} else {
					if ($jyConfig['list_address_type'] == 2) {
						$outStr .= '<span>' . $value['cityInfo']['name'] . '' . lang('plugin/tom_love', 'ajax_list_dian') . '' . $value['areaInfo']['name'] . '</span>|';
					} else {
						if ($jyConfig['list_address_type'] == 3) {
							$outStr .= '<span>' . $value['areaInfo']['name'] . '' . lang('plugin/tom_love', 'ajax_list_dian') . '' . $value['townsInfo']['name'] . '</span>|';
						}
					}
				}
				$outStr .= '<span>';
				if ($value['marriage'] == 1) {
					$outStr .= lang('plugin/tom_love', 'ajax_list_marriage');
				}
				if ($value['marriage'] == 1 && $value['friend'] == 1) {
					$outStr .= '' . lang('plugin/tom_love', 'ajax_list_dian') . '';
				}
				if ($value['friend'] == 1) {
					$outStr .= lang('plugin/tom_love', 'ajax_list_friend');
				}
				$outStr .= '</span>';
				$outStr .= '</div>';
				$outStr .= '<div class="subInfo">';
				if (isset($worksArray[$value['work_id']])) {
					$outStr .= '<span>' . $worksArray[$value['work_id']] . '</span>';
				}
				if (isset($payArray[$value['pay_id']])) {
					$outStr .= '<span>' . $payArray[$value['pay_id']] . '/' . lang('plugin/tom_love', 'ajax_list_yue') . '</span>';
				}
				$outStr .= '</div>';
				if ($index_type == 3) {
					$outStr .= '<p style="padding-left: 0px;">' . lang('plugin/tom_love', 'ajax_list_flowers_1') . '<span>' . $value['flowers'] . '</span>' . lang('plugin/tom_love', 'ajax_list_flowers_2') . '</p>';
				} else {
					if ($index_type == 4) {
						$outStr .= '<p style="padding-left: 0px;">' . lang('plugin/tom_love', 'ajax_list_anlians_1') . '<span>' . $value['anlians'] . '</span>' . lang('plugin/tom_love', 'ajax_list_anlians_2') . '</p>';
					} else {
						if ($index_type == 5) {
							$outStr .= '<p style="padding-left: 0px;">' . lang('plugin/tom_love', 'ajax_list_score_1') . '<span>' . $value['score'] . '</span>' . $jyConfig['score_name'] . '' . lang('plugin/tom_love', 'ajax_list_score_2') . '</p>';
						} else {
							$outStr .= '<p><img src="source/plugin/tom_love/images/new-list/love.png">' . $value['describe'] . '</p>';
						}
					}
				}
				$outStr .= '</div>';
				$outStr .= '</div>';
				$outStr .= '</a>';
				$outStr .= '</div>';
			}
		}
	} else {
		$outStr = '205';
	}
	//By www.dashulai.com
	$outStr = tom_link_replace($outStr);
	$outStr = diconv($outStr, CHARSET, 'utf-8');
	echo json_encode($outStr);
	exit(0);
} else {
	if ($_GET['act'] == 'pic') {
		$callback = $_GET['callback'];
		$uid = isset($_GET['uid']) ? intval($_GET['uid']) : 0;
		$outArr = array();
		$picListTmp = C::t('#tom_love#tom_love_pic')->fetch_all_list(' AND user_id =' . $uid . ' AND shenhe_status=1 ', 'ORDER BY id DESC', 0, 100);
		$picList = array();
		if (is_array($picListTmp) && !empty($picListTmp)) {
			foreach ($picListTmp as $key => $value) {
				$picList[$key] = $value;
				if (!preg_match('/^http/', $value['pic_url'])) {
					if (strpos($value['pic_url'], 'source/plugin/tom_love') === false) {
						$picList[$key]['pic_url'] = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']) . $_G['setting']['attachurl'] . 'common/' . $value['pic_url'];
					} else {
						$picList[$key]['pic_url'] = $value['pic_url'];
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
		if ($_GET['act'] == 'city') {
			$callback = $_GET['callback'];
			$pid = isset($_GET['pid']) ? intval($_GET['pid']) : 0;
			$outArr = array();
			$cityList = C::t('#tom_love#tom_love_district')->fetch_all_by_upid($pid);
			if (is_array($cityList) && !empty($cityList)) {
				foreach ($cityList as $key => $value) {
					$outArr[$key]['id'] = $value['id'];
					$outArr[$key]['name'] = diconv($value['name'], CHARSET, 'utf-8');
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
			if ($_GET['act'] == 'area') {
				$callback = $_GET['callback'];
				$pid = isset($_GET['pid']) ? intval($_GET['pid']) : 0;
				$outArr = array();
				$areaList = C::t('#tom_love#tom_love_district')->fetch_all_by_upid($pid);
				if (is_array($areaList) && !empty($areaList)) {
					foreach ($areaList as $key => $value) {
						$outArr[$key]['id'] = $value['id'];
						$outArr[$key]['name'] = diconv($value['name'], CHARSET, 'utf-8');
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
				if ($_GET['act'] == 'towns') {
					$callback = $_GET['callback'];
					$pid = isset($_GET['pid']) ? intval($_GET['pid']) : 0;
					$outArr = array();
					$areaList = C::t('#tom_love#tom_love_district')->fetch_all_by_upid($pid);
					if (is_array($areaList) && !empty($areaList)) {
						foreach ($areaList as $key => $value) {
							$outArr[$key]['id'] = $value['id'];
							$outArr[$key]['name'] = diconv($value['name'], CHARSET, 'utf-8');
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
					if ($_GET['act'] == 'contact' && $_GET['formhash'] == FORMHASH && $userStatus) {
						$outArr = array('status' => 200);
						$gid = isset($_GET['gid']) ? intval($_GET['gid']) : 0;
						if ($__UserInfo['vip_id'] == 0) {
							if (!empty($jyConfig['contact_score']) && $jyConfig['contact_score'] > $__UserInfo['score']) {
								$outArr = array('status' => 101, 'have' => $__UserInfo['score'], 'need' => $jyConfig['contact_score']);
								echo json_encode($outArr);
								exit(0);
							}
						}
						$contactCount = C::t('#tom_love#tom_love_guanxi')->fetch_all_count(' AND type_id=1 AND user_id=' . $__UserInfo['id'] . ' AND time_key=' . $nowTime . ' ');
						if ($__UserInfo['vip_id'] == 1) {
							if ($contactCount >= $jyConfig['vip_show_contact_num']) {
								$outArr = array('status' => 301);
								echo json_encode($outArr);
								exit(0);
							}
						} else {
							if ($contactCount >= $jyConfig['show_contact_num']) {
								$outArr = array('status' => 302);
								echo json_encode($outArr);
								exit(0);
							}
						}
						$insertData = array();
						$insertData['user_id'] = $__UserInfo['id'];
						$insertData['gx_user_id'] = $gid;
						$insertData['type_id'] = 1;
						$insertData['time_key'] = $nowTime;
						C::t('#tom_love#tom_love_guanxi')->insert($insertData);
						if ($__UserInfo['vip_id'] == 0) {
							$updateData = array();
							$updateData['score'] = $__UserInfo['score'] - $jyConfig['contact_score'];
							C::t('#tom_love#tom_love')->update($__UserInfo['id'], $updateData);
							$insertData = array();
							$insertData['user_id'] = $__UserInfo['id'];
							$insertData['score_value'] = $jyConfig['contact_score'];
							$insertData['log_type'] = 9;
							$insertData['log_time'] = TIMESTAMP;
							C::t('#tom_love#tom_love_scorelog')->insert($insertData);
						}
						include DISCUZ_ROOT . './source/plugin/tom_love/class/weixin.class.php';
						include DISCUZ_ROOT . './source/plugin/tom_love/class/templatesms.class.php';
						$toUser = C::t('#tom_love#tom_love')->fetch_by_id($gid);
						$weixinClass = new weixinClass($appid, $appsecret);
						$access_token = $weixinClass->get_access_token();
						$nextSmsTime = $toUser['last_smstp_time'] + 1;
						if ($access_token && !empty($toUser['openid']) && $toUser['smstp_open'] == 1 && TIMESTAMP > $nextSmsTime) {
							$templateSmsClass = new templateSms($access_token, $_G['siteurl'] . ('plugin.php?id=tom_love&mod=info&uid=' . $__UserInfo['id']));
							$contact_template_first = str_replace('{NICKNAME}', $__UserInfo['nickname'], lang('plugin/tom_love', 'contact_template_first'));
							$flowersData = array('first' => $contact_template_first, 'keyword1' => '-', 'keyword2' => dgmdate(TIMESTAMP, 'Y-m-d H:i:s', $tomSysOffset), 'remark' => '');
							$r = $templateSmsClass->sendSmsTm20702951($toUser['openid'], $jyConfig['template_tm20702951'], $flowersData);
							$updateData = array();
							$updateData['last_smstp_time'] = TIMESTAMP;
							C::t('#tom_love#tom_love')->update($toUser['id'], $updateData);
						}
						echo json_encode($outArr);
						exit(0);
					} else {
						if ($_GET['act'] == 'anlian' && $_GET['formhash'] == FORMHASH && $userStatus) {
							$outArr = array('status' => 200);
							$gid = isset($_GET['gid']) ? intval($_GET['gid']) : 0;
							$girlTequan = 0;
							if ($__UserInfo['sex'] == 2 && $jyConfig['open_girl_tequan'] == 1) {
								$girlTequan = 1;
							}
							if ($__UserInfo['vip_id'] == 0 && $girlTequan == 0) {
								if (!empty($jyConfig['anlian_score']) && $jyConfig['anlian_score'] > $__UserInfo['score']) {
									$outArr = array('status' => 101, 'have' => $__UserInfo['score'], 'need' => $jyConfig['anlian_score']);
									echo json_encode($outArr);
									exit(0);
								}
							}
							$insertData = array();
							$insertData['user_id'] = $__UserInfo['id'];
							$insertData['gx_user_id'] = $gid;
							$insertData['type_id'] = 2;
							C::t('#tom_love#tom_love_guanxi')->insert($insertData);
							DB::query('UPDATE ' . DB::table('tom_love') . (' SET anlians=anlians+1 WHERE id=\'' . $gid . '\''), 'UNBUFFERED');
							if ($__UserInfo['vip_id'] == 0 && $girlTequan == 0) {
								$updateData = array();
								$updateData['score'] = $__UserInfo['score'] - $jyConfig['anlian_score'];
								C::t('#tom_love#tom_love')->update($__UserInfo['id'], $updateData);
								$insertData = array();
								$insertData['user_id'] = $__UserInfo['id'];
								$insertData['score_value'] = $jyConfig['anlian_score'];
								$insertData['log_type'] = 8;
								$insertData['log_time'] = TIMESTAMP;
								C::t('#tom_love#tom_love_scorelog')->insert($insertData);
							}
							include DISCUZ_ROOT . './source/plugin/tom_love/class/weixin.class.php';
							include DISCUZ_ROOT . './source/plugin/tom_love/class/templatesms.class.php';
							$toUser = C::t('#tom_love#tom_love')->fetch_by_id($gid);
							$weixinClass = new weixinClass($appid, $appsecret);
							$access_token = $weixinClass->get_access_token();
							$nextSmsTime = $toUser['last_smstp_time'] + 1;
							if ($access_token && !empty($toUser['openid']) && $toUser['smstp_open'] == 1 && TIMESTAMP > $nextSmsTime) {
								$templateSmsClass = new templateSms($access_token, $_G['siteurl'] . ('plugin.php?id=tom_love&mod=info&uid=' . $__UserInfo['id']));
								$anlian_template_first = str_replace('{NICKNAME}', $__UserInfo['nickname'], lang('plugin/tom_love', 'anlian_template_first'));
								$flowersData = array('first' => $anlian_template_first, 'keyword1' => '-', 'keyword2' => dgmdate(TIMESTAMP, 'Y-m-d H:i:s', $tomSysOffset), 'remark' => '');
								$r = $templateSmsClass->sendSmsTm20702951($toUser['openid'], $jyConfig['template_tm20702951'], $flowersData);
								$updateData = array();
								$updateData['last_smstp_time'] = TIMESTAMP;
								C::t('#tom_love#tom_love')->update($toUser['id'], $updateData);
							}
							update_phb($gid, 'anlians');
							echo json_encode($outArr);
							exit(0);
						} else {
							if ($_GET['act'] == 'hello' && $_GET['formhash'] == FORMHASH && $userStatus) {
								$outArr = array('status' => 200);
								$to_user_id = isset($_GET['tid']) ? intval($_GET['tid']) : 0;
								$toUser = C::t('#tom_love#tom_love')->fetch_by_id($to_user_id);
								$girlTequan = 0;
								if ($__UserInfo['sex'] == 2 && $jyConfig['open_girl_tequan'] == 1) {
									$girlTequan = 1;
								}
								if ($__UserInfo['vip_id'] == 0 && $girlTequan == 0) {
									if (!empty($jyConfig['hello_score']) && $jyConfig['hello_score'] > $__UserInfo['score']) {
										$outArr = array('status' => 101, 'have' => $__UserInfo['score'], 'need' => $jyConfig['hello_score']);
										echo json_encode($outArr);
										exit(0);
									}
								}
								$helloTmpArr = explode("\n", $jyConfig['hello_txt']);
								$helloArr = array();
								if (is_array($helloTmpArr) && !empty($helloTmpArr)) {
									foreach ($helloTmpArr as $key => $value) {
										$value = trim($value);
										if (!empty($value)) {
											$helloArr[] = $value;
										}
									}
								}
								$randKey = array_rand($helloArr, 1);
								$sms_object = lang('plugin/tom_love', 'sms_object');
								$max_use_id = $min_use_id = 0;
								if ($to_user_id == $__UserInfo['id']) {
									$outArr = array('status' => 100);
									echo json_encode($outArr);
									exit(0);
								} else {
									if ($to_user_id > $__UserInfo['id']) {
										$max_use_id = $to_user_id;
										$min_use_id = $__UserInfo['id'];
									} else {
										if ($to_user_id < $__UserInfo['id']) {
											$max_use_id = $__UserInfo['id'];
											$min_use_id = $to_user_id;
										}
									}
								}
								//by www¡¤dashulai¡¤com
								$pmListTmp = C::t('#tom_love#tom_love_pm_lists')->fetch_all_list(' AND min_use_id=' . $min_use_id . ' AND max_use_id=' . $max_use_id . ' ', ' ORDER BY id DESC ', 0, 1);
								if (is_array($pmListTmp) && !empty($pmListTmp[0]['id'])) {
									$pm_lists_id = $pmListTmp[0]['id'];
								} else {
									$insertData = array();
									$insertData['user_id'] = $__UserInfo['id'];
									$insertData['min_use_id'] = $min_use_id;
									$insertData['max_use_id'] = $max_use_id;
									$insertData['last_content'] = 'NULL-NULL-NULL-NULL-NULL-NULL';
									$insertData['last_time'] = TIMESTAMP;
									C::t('#tom_love#tom_love_pm_lists')->insert($insertData);
									$pm_lists_id = C::t('#tom_love#tom_love_pm_lists')->insert_id();
									$insertData = array();
									$insertData['user_id'] = $__UserInfo['id'];
									$insertData['pm_lists_id'] = $pm_lists_id;
									$insertData['new_num'] = 0;
									$insertData['last_time'] = TIMESTAMP;
									C::t('#tom_love#tom_love_pm')->insert($insertData);
									$insertData = array();
									$insertData['user_id'] = $to_user_id;
									$insertData['pm_lists_id'] = $pm_lists_id;
									$insertData['new_num'] = 0;
									$insertData['last_time'] = TIMESTAMP;
									C::t('#tom_love#tom_love_pm')->insert($insertData);
								}
								$insertData = array();
								$insertData['user_id'] = $__UserInfo['id'];
								$insertData['pm_lists_id'] = $pm_lists_id;
								$insertData['content'] = $helloArr[$randKey];
								$insertData['add_time'] = TIMESTAMP;
								C::t('#tom_love#tom_love_pm_message')->insert($insertData);
								DB::query('UPDATE ' . DB::table('tom_love_pm') . ' SET new_num=new_num+1,last_time=\'' . TIMESTAMP . '\' WHERE user_id=\'' . $to_user_id . ('\' AND pm_lists_id=\'' . $pm_lists_id . '\' '), 'UNBUFFERED');
								$updateData = array();
								$updateData['last_content'] = $helloArr[$randKey];
								$updateData['last_time'] = TIMESTAMP;
								C::t('#tom_love#tom_love_pm_lists')->update($pm_lists_id, $updateData);
								include DISCUZ_ROOT . './source/plugin/tom_love/class/weixin.class.php';
								include DISCUZ_ROOT . './source/plugin/tom_love/class/templatesms.class.php';
								$toUserInfo = C::t('#tom_love#tom_love')->fetch_by_id($to_user_id);
								$weixinClass = new weixinClass($appid, $appsecret);
								$access_token = $weixinClass->get_access_token();
								$nextSmsTime = $toUserInfo['last_smstp_time'] + 1;
								if ($access_token && !empty($toUserInfo['openid']) && $toUserInfo['smstp_open'] == 1 && TIMESTAMP > $nextSmsTime) {
									$templateSmsClass = new templateSms($access_token, $_G['siteurl'] . 'plugin.php?id=tom_love&mod=sms');
									$sms_template_first = str_replace('{NICKNAME}', $__UserInfo['nickname'], lang('plugin/tom_love', 'sms_template_first'));
									$smsData = array('first' => $sms_template_first, 'keyword1' => $helloArr[$randKey], 'keyword2' => dgmdate(TIMESTAMP, 'Y-m-d H:i:s', $tomSysOffset), 'remark' => '');
									$r = $templateSmsClass->sendSmsTm20702951($toUserInfo['openid'], $jyConfig['template_tm20702951'], $smsData);
									$updateData = array();
									$updateData['last_smstp_time'] = TIMESTAMP;
									C::t('#tom_love#tom_love')->update($toUserInfo['id'], $updateData);
								}
								if ($__UserInfo['vip_id'] == 0 && $girlTequan == 0) {
									$updateData = array();
									$updateData['score'] = $__UserInfo['score'] - $jyConfig['hello_score'];
									C::t('#tom_love#tom_love')->update($__UserInfo['id'], $updateData);
									$insertData = array();
									$insertData['user_id'] = $__UserInfo['id'];
									$insertData['score_value'] = $jyConfig['hello_score'];
									$insertData['log_type'] = 10;
									$insertData['log_time'] = TIMESTAMP;
									C::t('#tom_love#tom_love_scorelog')->insert($insertData);
								}
								echo json_encode($outArr);
								exit(0);
							} else {
								if ($_GET['act'] == 'delanlian' && $_GET['formhash'] == FORMHASH && $userStatus) {
									$outArr = array('status' => 200);
									$id = isset($_GET['aid']) ? intval($_GET['aid']) : 0;
									$guanxi = C::t('#tom_love#tom_love_guanxi')->fetch_by_id($id);
									if ($guanxi) {
										DB::query('UPDATE ' . DB::table('tom_love') . (' SET anlians=anlians-1 WHERE id=\'' . $guanxi['gx_user_id'] . '\''), 'UNBUFFERED');
									}
									C::t('#tom_love#tom_love_guanxi')->delete($id);
									echo json_encode($outArr);
									exit(0);
								} else {
									if ($_GET['act'] == 'share' && $_GET['formhash'] == FORMHASH && $userStatus) {
										if ($jyConfig['share_score_s'] == 0) {
											echo '1';
											exit(0);
										}
										$todayShareTimes = C::t('#tom_love#tom_love_share')->fetch_all_count(' AND user_id = ' . $__UserInfo['id'] . '  AND share_time > ' . $nowTime . ' ');
										if ($__UserInfo && $todayShareTimes < $jyConfig['share_time']) {
											$updateData = array();
											$updateData['score'] = $__UserInfo['score'] + $jyConfig['share_score_num'];
											C::t('#tom_love#tom_love')->update($__UserInfo['id'], $updateData);
											$insertData = array();
											$insertData['user_id'] = $__UserInfo['id'];
											$insertData['share_time'] = TIMESTAMP;
											C::t('#tom_love#tom_love_share')->insert($insertData);
											$insertData = array();
											$insertData['user_id'] = $__UserInfo['id'];
											$insertData['score_value'] = $jyConfig['share_score_num'];
											$insertData['log_type'] = 3;
											$insertData['log_time'] = TIMESTAMP;
											C::t('#tom_love#tom_love_scorelog')->insert($insertData);
										}
										update_phb($__UserInfo['id'], 'sharetime');
										echo '1';
										exit(0);
									} else {
										if ($_GET['act'] == 'clicks' && $_GET['formhash'] == FORMHASH) {
											$commonInfo = C::t('#tom_love#tom_love_common')->fetch_by_id(1);
											$updateData = array();
											$updateData['clicks'] = $commonInfo['clicks'] + 1;
											C::t('#tom_love#tom_love_common')->update(1, $updateData);
											echo 1;
											exit(0);
										} else {
											if ($_GET['act'] == 'infoClicks' && $_GET['formhash'] == FORMHASH) {
												$uid = isset($_GET['uid']) ? intval($_GET['uid']) : 0;
												C::t('#tom_love#tom_love')->update_num_clicks($uid);
												update_phb($uid, 'clicks');
												exit(0);
											} else {
												if ($_GET['act'] == 'giftDetails' && $_GET['formhash'] == FORMHASH) {
													$outStr = '';
													$tid = isset($_GET['tid']) ? intval($_GET['tid']) : 0;
													$gift_id = isset($_GET['gift_id']) ? intval($_GET['gift_id']) : 0;
													$toUserInfo = C::t('#tom_love#tom_love')->fetch_by_id($tid);
													$giftInfo = C::t('#tom_love#tom_love_gift')->fetch_by_id($gift_id);
													if (!is_array($toUserInfo) || !is_array($giftInfo) || empty($giftInfo) || empty($toUserInfo)) {
														$outStr = 201;
														$outStr = diconv($outStr, CHARSET, 'utf-8');
														echo json_encode($outStr);
														exit(0);
													}
													if (!preg_match('/^http/', $giftInfo['gift_picurl'])) {
														if (strpos($giftInfo['gift_picurl'], 'source/plugin/tom_love') === false) {
															$giftInfo['gift_picurl'] = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']) . $_G['setting']['attachurl'] . 'common/' . $giftInfo['gift_picurl'];
														}
													}
													$outStr .= '<div class="pic"><img src="' . $giftInfo['gift_picurl'] . '"></div>';
													$outStr .= '<div class="title">';
													$outStr .= '<div class="area">' . lang('plugin/tom_love', 'ajax_details_song_1') . '<span class="weak">&nbsp;' . $toUserInfo['nickname'] . '&nbsp;</span>' . lang('plugin/tom_love', 'ajax_details_song_2') . '<span class="weak">' . $giftInfo['flowers_num'] . '</span>' . lang('plugin/tom_love', 'ajax_details_song_3') . '</div>';
													$outStr .= '<div class="buttom" onClick="giftPay(' . $giftInfo['id'] . ');">' . lang('plugin/tom_love', 'ajax_details_pay_1') . $giftInfo['score_num'] . $jyConfig['score_name'] . '</div>';
													$outStr .= '<div class="close a_details_btn" onClick=\'$(".giftDetails").hide();\'>' . lang('plugin/tom_love', 'ajax_details_close') . '</div>';
													$outStr = diconv($outStr, CHARSET, 'utf-8');
													echo json_encode($outStr);
													exit(0);
												} else {
													if ($_GET['act'] == 'giftPay' && $_GET['formhash'] == FORMHASH) {
														$outArr = array('status' => 200);
														$tid = isset($_GET['tid']) ? intval($_GET['tid']) : 0;
														$uid = isset($_GET['uid']) ? intval($_GET['uid']) : 0;
														$gift_id = isset($_GET['gift_id']) ? intval($_GET['gift_id']) : 0;
														$giftInfo = C::t('#tom_love#tom_love_gift')->fetch_by_id($gift_id);
														$toUserInfo = C::t('#tom_love#tom_love')->fetch_by_id($tid);
														$userInfo = C::t('#tom_love#tom_love')->fetch_by_id($uid);
														if ($tid == $uid) {
															$outArr = array('status' => 202);
															echo json_encode($outArr);
															exit(0);
														}
														if ($userInfo['score'] < $giftInfo['score_num']) {
															$outArr = array('status' => 203, 'have' => $userInfo['score'], 'need' => $giftInfo['score_num']);
															echo json_encode($outArr);
															exit(0);
														}
														if (is_array($giftInfo) && !empty($giftInfo) && is_array($toUserInfo) && !empty($toUserInfo) && is_array($userInfo) && !empty($userInfo)) {
															$giftCountInfo = C::t('#tom_love#tom_love_gift_count')->fetch_all_list(' AND user_id = ' . $tid . ' AND gift_id = ' . $gift_id, ' ORDER BY id DESC', 0, 1);
															if (is_array($giftCountInfo) && !empty($giftCountInfo)) {
																DB::query('UPDATE ' . DB::table('tom_love_gift_count') . (' SET gift_num=gift_num+1 WHERE id=\'' . $giftCountInfo[0]['id'] . '\''), 'UNBUFFERED');
															} else {
																$insertData = array();
																$insertData['user_id'] = $tid;
																$insertData['gift_id'] = $gift_id;
																$insertData['gift_name'] = $giftInfo['gift_name'];
																$insertData['gift_picurl'] = $giftInfo['gift_picurl'];
																$insertData['gift_num'] = 1;
																C::t('#tom_love#tom_love_gift_count')->insert($insertData);
															}
															$content = lang('plugin/tom_love', 'tz_gift_content');
															$content = str_replace('{UID}', $userInfo['id'], $content);
															$content = str_replace('{NAME}', $userInfo['nickname'], $content);
															$content = str_replace('{GIFT}', $giftInfo['gift_name'], $content);
															$content = str_replace('{FLOWERS}', $giftInfo['flowers_num'], $content);
															$insertData = array();
															$insertData['user_id'] = $tid;
															$insertData['toUser_id'] = $uid;
															$insertData['gift_id'] = $gift_id;
															$insertData['type_id'] = 1;
															$insertData['change_num'] = $giftInfo['flowers_num'];
															$insertData['old_num'] = $toUserInfo['flowers'];
															$insertData['txt'] = $content;
															$insertData['log_time'] = TIMESTAMP;
															C::t('#tom_love#tom_love_flowers_log')->insert($insertData);
															DB::query('UPDATE ' . DB::table('tom_love') . (' SET flowers=flowers+' . $giftInfo['flowers_num'] . ' WHERE id=\'' . $tid . '\''), 'UNBUFFERED');
															DB::query('UPDATE ' . DB::table('tom_love') . (' SET score=score-' . $giftInfo['score_num'] . ' WHERE id=\'' . $uid . '\''), 'UNBUFFERED');
															update_phb($tid, 'flowers', $giftInfo['flowers_num']);
															$insertData = array();
															$insertData['user_id'] = $uid;
															$insertData['score_value'] = $giftInfo['score_num'];
															$insertData['log_type'] = 14;
															$insertData['log_time'] = TIMESTAMP;
															C::t('#tom_love#tom_love_scorelog')->insert($insertData);
															include DISCUZ_ROOT . './source/plugin/tom_love/class/weixin.class.php';
															include DISCUZ_ROOT . './source/plugin/tom_love/class/templatesms.class.php';
															$weixinClass = new weixinClass($appid, $appsecret);
															$access_token = $weixinClass->get_access_token();
															$nextSmsTime = $toUserInfo['last_smstp_time'] + 1;
															if ($access_token && !empty($toUserInfo['openid']) && $toUserInfo['smstp_open'] == 1 && TIMESTAMP > $nextSmsTime) {
																$templateSmsClass = new templateSms($access_token, $_G['siteurl'] . 'plugin.php?id=tom_love&mod=flowerslog');
																$flowers_template_first = str_replace('{NICKNAME}', $userInfo['nickname'], lang('plugin/tom_love', 'flowers_template_first'));
																$flowers_template_first = str_replace('{GIFT}', $giftInfo['gift_name'], $flowers_template_first);
																$flowers_template_first = str_replace('{NUM}', $giftInfo['flowers_num'], $flowers_template_first);
																$flowersData = array('first' => $flowers_template_first, 'keyword1' => '-', 'keyword2' => dgmdate(TIMESTAMP, 'Y-m-d H:i:s', $tomSysOffset), 'remark' => '');
																$r = $templateSmsClass->sendSmsTm20702951($toUserInfo['openid'], $jyConfig['template_tm20702951'], $flowersData);
																$updateData = array();
																$updateData['last_smstp_time'] = TIMESTAMP;
																C::t('#tom_love#tom_love')->update($toUserInfo['id'], $updateData);
															}
															$outArr = array('status' => 200);
														} else {
															$outArr = array('status' => 201);
														}
														echo json_encode($outArr);
														exit(0);
													} else {
														if ($_GET['act'] == 'subscribe' && $_GET['formhash'] == FORMHASH) {
															$_SESSION['subscribe_notice'] = 1;
															echo 200;
															exit(0);
														} else {
															if ($_GET['act'] == 'vipUpdate' && $_GET['formhash'] == FORMHASH) {
																$userList = C::t('#tom_love#tom_love')->fetch_vip_list(' AND vip_id = 1 AND vip_time <= ' . TIMESTAMP . ' ');
																if (is_array($userList) && !empty($userList)) {
																	foreach ($userList as $key => $value) {
																		$updateData = array();
																		$updateData['vip_id'] = 0;
																		C::t('#tom_love#tom_love')->update($value['id'], $updateData);
																	}
																}
																echo 200;
																exit(0);
															} else {
																if ($_GET['act'] == 'recUpdate' && $_GET['formhash'] == FORMHASH) {
																	$userList = C::t('#tom_love#tom_love')->fetch_vip_list(' AND recommend = 1 AND recommend_time <= ' . TIMESTAMP . ' ');
																	if (is_array($userList) && !empty($userList)) {
																		foreach ($userList as $key => $value) {
																			$updateData = array();
																			$updateData['recommend'] = 0;
																			$updateData['recommend_time'] = 0;
																			C::t('#tom_love#tom_love')->update($value['id'], $updateData);
																		}
																	}
																	echo 200;
																	exit(0);
																} else {
																	if ($_GET['act'] == 'loadPmlist' && $_GET['formhash'] == FORMHASH && $userStatus) {
																		$outStr = '';
																		$page = intval($_GET['page']) > 0 ? intval($_GET['page']) : 1;
																		$pagesize = 8;
																		$start = ($page - 1) * $pagesize;
																		$pmListTmp = C::t('#tom_love#tom_love_pm')->fetch_all_list(' AND user_id=' . $__UserInfo['id'] . ' ', ' ORDER BY last_time DESC,id DESC ', $start, $pagesize);
																		$pmList = array();
																		if (is_array($pmListTmp) && !empty($pmListTmp)) {
																			foreach ($pmListTmp as $key => $value) {
																				$pmListsTmp = C::t('#tom_love#tom_love_pm_lists')->fetch_by_id($value['pm_lists_id']);
																				if ($pmListsTmp['min_use_id'] == $__UserInfo['id']) {
																					$toUserInfoTmp = C::t('#tom_love#tom_love')->fetch_by_id($pmListsTmp['max_use_id']);
																				} else {
																					$toUserInfoTmp = C::t('#tom_love#tom_love')->fetch_by_id($pmListsTmp['min_use_id']);
																				}
																				$toUserInfoTmp['avatar'] = tom_avatar($toUserInfoTmp['avatar']);
																				if ('NULL-NULL-NULL-NULL-NULL-NULL' != $pmListsTmp['last_content']) {
																					$pmList[$key] = $value;
																					$pmList[$key]['last_content'] = tom_num_replace(dhtmlspecialchars($pmListsTmp['last_content']));
																					$pmList[$key]['toUserInfo'] = $toUserInfoTmp;
																				} else {
																					if ($value['new_num'] > 0) {
																						DB::query('UPDATE ' . DB::table('tom_love_pm') . (' SET new_num=0 WHERE user_id=\'' . $__UserInfo['id'] . '\' AND pm_lists_id=\'' . $value['pm_lists_id'] . '\' '), 'UNBUFFERED');
																					}
																				}
																			}
																		}
																		if (is_array($pmList) && !empty($pmList)) {
																			foreach ($pmList as $key => $val) {
																				$outStr .= '<section class="msg-list">';
																				$outStr .= '<a href="plugin.php?id=tom_love&mod=info&uid=' . $val['toUserInfo']['id'] . '">';
																				$outStr .= '<section class="msg-list-pic">';
																				$outStr .= '<img src="' . $val['toUserInfo']['avatar'] . '" />';
																				$outStr .= '</section>';
																				$outStr .= '</a>';
																				$outStr .= '<a href="plugin.php?id=tom_love&mod=sms&act=view&pm_lists_id=' . $val['pm_lists_id'] . '">';
																				$outStr .= '<section class="msg-list-web">';
																				$outStr .= '<h3><span>' . dgmdate($val['last_time'], 'u', '9999', 'm-d H:i') . '</span>' . $val['toUserInfo']['nickname'] . '&nbsp;</h3>';
																				$outStr .= '<p>';
																				if ($val['new_num'] > 0) {
																					$outStr .= '<i>' . $val['new_num'] . '</i>';
																				}
																				$outStr .= '' . $val['last_content'];
																				$outStr .= '</p>';
																				$outStr .= '</section>';
																				$outStr .= '</a>';
																				$outStr .= '<section class="clear"></section>';
																				$outStr .= '</section>';
																			}
																		} else {
																			$outStr = '205';
																		}
																		$outStr = tom_link_replace($outStr);
																		$outStr = diconv($outStr, CHARSET, 'utf-8');
																		echo json_encode($outStr);
																		exit(0);
																	} else {
																		if ($_GET['act'] == 'miniprogram') {
																			if ($_GET['ok'] == 1) {
																				$lifeTime = 300;
																				dsetcookie('tom_miniprogram', 1, $lifeTime);
																			} else {
																				$lifeTime = 1;
																				dsetcookie('tom_miniprogram', 0, $lifeTime);
																			}
																			echo '200';
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
							}
						}
					}
				}
			}
		}
	}
}