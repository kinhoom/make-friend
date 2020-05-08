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
define('TPL_DEFAULT', true);
$formhash = FORMHASH;
$nowYear = dgmdate($_G['timestamp'], 'Y', $tomSysOffset);
$jyConfig = $_G['cache']['plugin']['tom_love'];
$xiangqinConfig = $_G['cache']['plugin']['tom_xiangqin'];
$tomSysOffset = getglobal('setting/timeoffset');
$nowDayTime = gmmktime(0, 0, 0, dgmdate($_G['timestamp'], 'n', $tomSysOffset), dgmdate($_G['timestamp'], 'j', $tomSysOffset), dgmdate($_G['timestamp'], 'Y', $tomSysOffset)) - $tomSysOffset * 3600;
require_once libfile('function/discuzcode');
$appid = trim($jyConfig['love_appid']);
$appsecret = trim($jyConfig['love_appsecret']);
$prand = rand(1, 1000);
$cssJsVersion = '201812221221';
include DISCUZ_ROOT . './source/plugin/tom_love/class/weixin.class.php';
$weixinClass = new weixinClass($appid, $appsecret);

$wxJssdkConfig = array();
$wxJssdkConfig['appId'] = '';
$wxJssdkConfig['timestamp'] = time();
$wxJssdkConfig['nonceStr'] = '';
$wxJssdkConfig['signature'] = '';
$wxJssdkConfig = $weixinClass->get_jssdk_config();
$shareTitle = $xiangqinConfig['share_title'];
$shareDesc = $xiangqinConfig['share_desc'];
$shareLogo = $xiangqinConfig['share_logo'];
$shareUrl = $_G['siteurl'] . 'plugin.php?id=tom_xiangqin&mod=index';
if (CHARSET == 'gbk') {
	include DISCUZ_ROOT . './source/plugin/tom_xiangqin/config/works.gbk.php';
} else {
	include DISCUZ_ROOT . './source/plugin/tom_xiangqin/config/works.utf.php';
}

include DISCUZ_ROOT . './source/plugin/tom_xiangqin/class/xiangqin.func.php';
include DISCUZ_ROOT . './source/plugin/tom_love/class/love.func.php';
include DISCUZ_ROOT . './source/plugin/tom_love/class/link.func.php';
include DISCUZ_ROOT . './source/plugin/tom_love/login.php';
$__Xiangqin = array();
if ($__UserInfo['id'] > 0) {
	$__XiangqinTmp = C::t('#tom_xiangqin#tom_xiangqin')->fetch_by_user_id($__UserInfo['id']);
	if ($__XiangqinTmp['id'] > 0) {
		$__Xiangqin = $__XiangqinTmp;
	} else {
		$insertData = array();
		$insertData['user_id'] = $__UserInfo['id'];
		$insertData['sex'] = $__UserInfo['sex'];
		$insertData['tel'] = $__UserInfo['tel'];
		$insertData['wx'] = $__UserInfo['wx'];
		$insertData['qq'] = $__UserInfo['qq'];
		if ($xiangqinConfig['closed_tel'] == 1) {
			$insertData['closed'] = 1;
		}
		$insertData['add_time'] = TIMESTAMP;
		C::t('#tom_xiangqin#tom_xiangqin')->insert($insertData);
		$__Xiangqin = C::t('#tom_xiangqin#tom_xiangqin')->fetch_by_user_id($__UserInfo['id']);
		if (!empty($__UserInfo['avatar'])) {
		}
	}
}
//by www-dashulai-com
$ajaxClicksUrl = $_G['siteurl'] . 'plugin.php?id=tom_love:ajax&act=clicks&formhash=' . FORMHASH;
$ajaxLoadListUrl = 'plugin.php?id=tom_xiangqin:ajax&act=list&formhash=' . $formhash;
$phone_back_url = $weixinClass->get_url();
$phone_back_url = urlencode($phone_back_url);
$phoneUrl = 'plugin.php?id=tom_love&mod=phone&phone_from=xiangqin&phone_back=' . $phone_back_url;
$sfzUrl = 'plugin.php?id=tom_love&mod=renzheng&renzheng_from=xiangqin&renzheng_back=' . $phone_back_url;
$searchUrl = 'plugin.php?id=tom_xiangqin:ajax&act=get_search_url';
$ajaxAddShoucangUrl = 'plugin.php?id=tom_xiangqin:ajax&act=addshoucang';
$ajaxDelShoucangUrl = 'plugin.php?id=tom_xiangqin:ajax&act=delshoucang';
$__CommonInfo = C::t('#tom_xiangqin#tom_xiangqin_common')->fetch_by_id(1);
if (!$__CommonInfo) {
	$insertData = array();
	$insertData['id'] = 1;
	C::t('#tom_xiangqin#tom_xiangqin_common')->insert($insertData);
}

$footer_nav_content_name = $footer_nav_content_link = '';
if ($xiangqinConfig['footer_nav_mod'] == 1) {
	if (!empty($xiangqinConfig['footer_nav_content'])) {
		$footer_nav_content = explode('|', $xiangqinConfig['footer_nav_content']);
		$footer_nav_content_name = $footer_nav_content[0];
		$footer_nav_content_link = $footer_nav_content[1];
	}
}
$focuspicData = C::t('#tom_xiangqin#tom_xiangqin_focuspic')->fetch_all_list('', 'ORDER BY fsort ASC,id DESC', 0, 10);
$focuspicList = array();
if (is_array($focuspicData) && !empty($focuspicData)) {
	foreach ($focuspicData as $key => $value) {
		$focuspicList[$key] = $value;
		$focuspicList[$key]['title'] = dhtmlspecialchars($value['title']);
		if (!preg_match('/^http/', $value['picurl'])) {
			$focuspicList[$key]['picurl'] = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']) . $_G['setting']['attachurl'] . 'common/' . $value['picurl'];
		} else {
			$focuspicList[$key]['picurl'] = $value['picurl'];
		}
	}
}
//by www.dashulai.com
if ($_GET['mod'] == 'index') {
	$sex = isset($_GET['sex']) ? intval($_GET['sex']) : 0;
	$agree_safe_msg = dhtmlspecialchars($xiangqinConfig['agree_safe_msg']);
	$agree_safe_msg = discuzcode($agree_safe_msg, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0);
	$wanshanUrl = 'plugin.php?id=tom_xiangqin:ajax&act=wanshan&formhash=' . FORMHASH;
	$vipUpdateUrl = 'plugin.php?id=tom_xiangqin:ajax&act=vipUpdate&formhash=' . FORMHASH;
	$topUpdateUrl = 'plugin.php?id=tom_xiangqin:ajax&act=topUpdate&formhash=' . FORMHASH;
	$ajaxAgreeUrl = 'plugin.php?id=tom_xiangqin:ajax&act=agree';
	$indexJsFile = DISCUZ_ROOT . './source/plugin/tom_xiangqin/images/index.js';
	$isGbk = false;
	if (CHARSET == 'gbk') {
		$isGbk = true;
	}
	include template('tom_xiangqin:index');
	echo '<script src="source/plugin/tom_xiangqin/images/index.js"></script>';
} else {
	if ($_GET['mod'] == 'info') {
		$uid = isset($_GET['uid']) ? intval($_GET['uid']) : 0;
		$info = C::t('#tom_xiangqin#tom_xiangqin')->fetch_by_id($uid);
		if ($info['is_open'] != 1) {
			dheader('location:' . $_G['siteurl'] . ('plugin.php?id=tom_xiangqin&mod=close&uid=' . $info['id']));
			exit(0);
		}
		if ($info['shenhe_status'] != 1 || $info['status'] != 1) {
			dheader('location:' . $_G['siteurl'] . 'plugin.php?id=tom_xiangqin&mod=index');
			exit(0);
		}
		//by www·dashulai·con
		$loveInfo = C::t('#tom_love#tom_love')->fetch_by_id($info['user_id']);
		$zheouProvinceInfo = C::t('#tom_love#tom_love_district')->fetch_by_id($info['zheou_province_id']);
		$zheouCityInfo = C::t('#tom_love#tom_love_district')->fetch_by_id($info['zheou_city_id']);
		$juzhuProvinceInfo = C::t('#tom_love#tom_love_district')->fetch_by_id($info['province_id']);
		$juzhuCityInfo = C::t('#tom_love#tom_love_district')->fetch_by_id($info['city_id']);
		$juzhuAreaInfo = C::t('#tom_love#tom_love_district')->fetch_by_id($info['area_id']);
		$hujiProvinceInfo = C::t('#tom_love#tom_love_district')->fetch_by_id($info['hjprovince_id']);
		$hujiCityInfo = C::t('#tom_love#tom_love_district')->fetch_by_id($info['hjcity_id']);
		$hujiAreaInfo = C::t('#tom_love#tom_love_district')->fetch_by_id($info['hjarea_id']);
		if ($info['birth_year'] > 0) {
			if ($jyConfig['age_type_id'] == 1) {
				$age = $nowYear - $info['birth_year'];
			} else {
				$age = $nowYear - $info['birth_year'] + 1;
			}
		} else {
			$age = '';
		}
		$pic_url = '';
		$photoData = C::t('#tom_xiangqin#tom_xiangqin_photo')->fetch_all_list(' AND xiangqin_id = ' . $uid . ' ', 'ORDER BY id DESC', 0, 100);
		$photoCount = C::t('#tom_xiangqin#tom_xiangqin_photo')->fetch_all_count(' AND xiangqin_id = ' . $uid);
		$photoList = array();
		$i = 1;
		if (is_array($photoData) && !empty($photoData)) {
			foreach ($photoData as $key => $value) {
				$photoList[$key] = $value;
				if (!preg_match('/^http/', $value['pic_url'])) {
					if (strpos($value['pic_url'], 'data/attachment/tomwx') !== false || strpos($value['pic_url'], 'uc_server/') !== false || strpos($value['pic_url'], 'source/plugin') !== false) {
						$photoList[$key]['pic_url'] = $_G['siteurl'] . $value['pic_url'];
					} else {
						$photoList[$key]['pic_url'] = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']) . $_G['setting']['attachurl'] . 'common/' . $value['pic_url'];
					}
				}
				if ($value['is_avatar'] == 1 || $i == 1) {
					$pic_url = $photoList[$key]['pic_url'];
				}
				$i = $i + 1;
			}
		}
		
		$picList = array();
		$picListAll = array();
		$picListStr = '';
		if (is_array($photoData) && !empty($photoData)) {
			foreach ($photoData as $key => $value) {
				if (!preg_match('/^http/', $value['pic_url'])) {
					if (strpos($value['pic_url'], 'source/plugin/') === false) {
						$value['pic_url'] = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']) . $_G['setting']['attachurl'] . 'common/' . $value['pic_url'];
					} else {
						$value['pic_url'] = $_G['siteurl'] . $value['pic_url'];
					}
				} else {
					$value['pic_url'] = $value['pic_url'];
				}
				$picListAll[] = $value['pic_url'];
			}
			$picListStr = implode('|', $picListAll);
		}
		if ($__UserInfo['id'] > 0) {
			$isCollect = C::t('#tom_xiangqin#tom_xiangqin_collect')->fetch_all_list('AND user_id = ' . $__UserInfo['id'] . ' AND xiangqin_id =' . $info['id'], ' ORDER BY id DESC ', 0, 1);
		}
		
		$hongniangInfo = C::t('#tom_xiangqin#tom_xiangqin_hongniang')->fetch_all_list('', ' ORDER BY paixu ASC,id DESC ', 0, 1);
		$hongniangQrcode = '';
		if (is_array($hongniangInfo) && !empty($hongniangInfo[0]['qrcode'])) {
			if (!preg_match('/^http/', $hongniangInfo[0]['qrcode'])) {
				if (strpos($hongniangInfo[0]['qrcode'], 'source/plugin/') === false) {
					$hongniangQrcode = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']) . $_G['setting']['attachurl'] . 'common/' . $hongniangInfo[0]['qrcode'];
				} else {
					$hongniangQrcode = $_G['siteurl'] . $hongniangInfo[0]['qrcode'];
				}
			} else {
				$hongniangQrcode = $hongniangInfo[0]['qrcode'];
			}
		}
		$hongniangPicurl = '';
		if (is_array($hongniangInfo) && !empty($hongniangInfo[0]['picurl'])) {
			if (!preg_match('/^http/', $hongniangInfo[0]['picurl'])) {
				if (strpos($hongniangInfo[0]['picurl'], 'source/plugin/') === false) {
					$hongniangPicurl = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']) . $_G['setting']['attachurl'] . 'common/' . $hongniangInfo[0]['picurl'];
				} else {
					$hongniangPicurl = $_G['siteurl'] . $hongniangInfo[0]['picurl'];
				}
			} else {
				$hongniangPicurl = $hongniangInfo[0]['picurl'];
			}
		}
		$chakanTag = $showChakanXz = $overChakanNum = $shengyuChakanNum = 0;
		if ($__UserInfo['id'] > 0) {
			$chakanData = C::t('#tom_xiangqin#tom_xiangqin_chakan')->fetch_by_user_xiangqin_id($__UserInfo['id'], $info['id']);
			if ($chakanData['id'] > 0 || $info['user_id'] == $__UserInfo['id']) {
				$chakanTag = 1;
			}
			$vipInfo = C::t('#tom_xiangqin#tom_xiangqin_vip')->fetch_by_id($__Xiangqin['vip_id']);
			if ($vipInfo['chakan_times'] > 0) {
				$showChakanXz = 1;
			}
			if ($showChakanXz == 1) {
				$chakanCount = C::t('#tom_xiangqin#tom_xiangqin_chakan')->fetch_all_count(' AND user_id=' . $__UserInfo['id'] . ' AND time_key=' . $nowDayTime . ' ');
				if ($chakanCount >= $vipInfo['chakan_times']) {
					$overChakanNum = 1;
				} else {
					$shengyuChakanNum = $vipInfo['chakan_times'] - $chakanCount;
				}
			}
		}
		$shareTitle = $xiangqinConfig['info_share_title'];
		$shareTitle = str_replace('{NAME}', $info['xm'], $shareTitle);
		if ($info['sex'] == 1) {
			$shareTitle = str_replace('{SEX}', lang('plugin/tom_love', 'man'), $shareTitle);
		} else {
			if ($info['sex'] == 2) {
				$shareTitle = str_replace('{SEX}', lang('plugin/tom_love', 'woman'), $shareTitle);
			}
		}
		$shareTitle = str_replace('{AGE}', $age, $shareTitle);
		$shareLogo = $pic_url;
		$shareDesc = $info['describe'];
		$shareDesc = str_replace("\n", '', $shareDesc);
		$shareDesc = str_replace("\r", '', $shareDesc);
		$shareDesc = str_replace("\r\n", '', $shareDesc);
		$shareUrl = $_G['siteurl'] . ('plugin.php?id=tom_xiangqin&mod=info&uid=' . $info['id']);
		$chakanUrl = 'plugin.php?id=tom_xiangqin:ajax&act=chakan&user_id=' . $__UserInfo['id'] . '&xiangqin_id=' . $info['id'] . '&formhash=' . FORMHASH;
		$isGbk = false;
		if (CHARSET == 'gbk') {
			$isGbk = true;
		}
		
		include template('tom_xiangqin:info');
	} else {
		if ($_GET['mod'] == 'list') {
			$sex = isset($_GET['sex']) ? intval($_GET['sex']) : 0;
			$xm = isset($_GET['xm']) ? daddslashes(urldecode($_GET['xm'])) : '';
			$shouru = isset($_GET['shouru']) ? intval($_GET['shouru']) : 0;
			$age = isset($_GET['age']) ? intval($_GET['age']) : 0;
			$height = isset($_GET['height']) ? intval($_GET['height']) : 0;
			$edu = isset($_GET['edu']) ? daddslashes(urldecode($_GET['edu'])) : '';
			$city_id = isset($_GET['city_id']) ? intval($_GET['city_id']) : 0;
			$keyword = isset($_GET['keyword']) ? addslashes(urldecode($_GET['keyword'])) : '';
			$user_no = isset($_GET['user_no']) ? intval($_GET['user_no']) : 0;
			if (!is_numeric($keyword)) {
				$xm = $keyword;
			} else {
				$user_no = $keyword;
			}
			$ajaxLoadListUrl = $ajaxLoadListUrl . '&xm=' . urlencode($xm) . ('&sex=' . $sex . '&age=' . $age . '&height=' . $height . '&shouru=' . $shouru . '&edu=' . $edu . '&city_id=' . $city_id . '&user_no=' . $user_no);
			$shareUrl = $_G['siteurl'] . 'plugin.php?id=tom_xiangqin&mod=list';
			$isGbk = false;
			if (CHARSET == 'gbk') {
				$isGbk = true;
			}
			include template('tom_xiangqin:list');
		} else {
			if ($_GET['mod'] == 'search') {
				$sex = isset($_GET['sex']) ? intval($_GET['sex']) : 0;
				$age = isset($_GET['age']) ? intval($_GET['age']) : 0;
				$height = isset($_GET['height']) ? intval($_GET['height']) : 0;
				$shouru = isset($_GET['shouru']) ? intval($_GET['shouru']) : 0;
				$edu = isset($_GET['edu']) ? intval($_GET['edu']) : 0;
				$province_id = isset($_GET['province_id']) ? intval($_GET['province_id']) : 0;
				$city_id = isset($_GET['city_id']) ? intval($_GET['city_id']) : 0;
				$provinceList = $hjprovinceList = $zheouprovinceList = C::t('#tom_love#tom_love_district')->fetch_all_by_level(1);
				$cityList = C::t('#tom_love#tom_love_district')->fetch_all_by_upid($info['province_id']);
				$areaList = C::t('#tom_love#tom_love_district')->fetch_all_by_upid($info['city_id']);
				$townsList = C::t('#tom_love#tom_love_district')->fetch_all_by_upid($info['area_id']);
				$hjcityList = C::t('#tom_love#tom_love_district')->fetch_all_by_upid($info['hjprovince_id']);
				$hjareaList = C::t('#tom_love#tom_love_district')->fetch_all_by_upid($info['hjcity_id']);
				$hjtownsList = C::t('#tom_love#tom_love_district')->fetch_all_by_upid($info['hjarea_id']);
				$zheoucityList = C::t('#tom_love#tom_love_district')->fetch_all_by_upid($info['zheou_province_id']);
				$listUrl = 'plugin.php?id=tom_xiangqin&mod=list';
				$shareUrl = $_G['siteurl'] . 'plugin.php?id=tom_xiangqin&mod=search';
				$isGbk = false;
				if (CHARSET == 'gbk') {
					$isGbk = true;
				}
				include template('tom_xiangqin:search');
			} else {
				if ($_GET['mod'] == 'match') {
					if ($__Xiangqin['sex'] == 1) {
						$ajaxLoadListUrl = $ajaxLoadListUrl . ('&sex=2&hunyin=' . $__Xiangqin['zheou_marital_id'] . '&zheou_min_age=' . $__Xiangqin['zheou_min_age'] . '&zheou_max_age=' . $__Xiangqin['zheou_max_age']);
					} else {
						$ajaxLoadListUrl = $ajaxLoadListUrl . ('&sex=1&hunyin=' . $__Xiangqin['zheou_marital_id'] . '&zheou_min_age=' . $__Xiangqin['zheou_min_age'] . '&zheou_max_age=' . $__Xiangqin['zheou_max_age']);
					}
					$shareUrl = $_G['siteurl'] . 'plugin.php?id=tom_xiangqin&mod=match';
					$isGbk = false;
					if (CHARSET == 'gbk') {
						$isGbk = true;
					}
					include template('tom_xiangqin:match');
				} else {
					if ($_GET['mod'] == 'card') {
						$uid = isset($_GET['uid']) ? intval($_GET['uid']) : 0;
						$info = C::t('#tom_xiangqin#tom_xiangqin')->fetch_by_id($uid);
						$juzhuCityInfo = C::t('#tom_love#tom_love_district')->fetch_by_id($info['city_id']);
						$picurl = tom_xiangqin_avatar($uid);
						if ($info['birth_year'] > 0) {
							if ($jyConfig['age_type_id'] == 1) {
								$age = $nowYear - $info['birth_year'];
							} else {
								$age = $nowYear - $info['birth_year'] + 1;
							}
						} else {
							$age = '';
						}
						$xiangqincard_man_listStr = str_replace("\r\n", '{n}', $xiangqinConfig['xiangqin_card_man']);
						$xiangqincard_man_listStr = str_replace("\n", '{n}', $xiangqincard_man_listStr);
						$xiangqincard_man_listStr = str_replace("\r", '{n}', $xiangqincard_man_listStr);
						$xiangqincard_man_listTmpArr = explode('{n}', $xiangqincard_man_listStr);
						$xiangqincard_man_listArr = array();
						if (is_array($xiangqincard_man_listTmpArr) && !empty($xiangqincard_man_listTmpArr)) {
							foreach ($xiangqincard_man_listTmpArr as $key => $value) {
								if (!empty($value)) {
									$xiangqincard_man_listArr[] = $value;
								}
							}
						}
						$xiangqincard_woman_listStr = str_replace("\r\n", '{n}', $xiangqinConfig['xiangqin_card_woman']);
						$xiangqincard_woman_listStr = str_replace("\n", '{n}', $xiangqincard_woman_listStr);
						$xiangqincard_woman_listStr = str_replace("\r", '{n}', $xiangqincard_woman_listStr);
						$xiangqincard_woman_listTmpArr = explode('{n}', $xiangqincard_woman_listStr);
						$xiangqincard_woman_listArr = array();
						if (is_array($xiangqincard_woman_listTmpArr) && !empty($xiangqincard_woman_listTmpArr)) {
							foreach ($xiangqincard_woman_listTmpArr as $key => $value) {
								if (!empty($value)) {
									$xiangqincard_woman_listArr[] = $value;
								}
							}
						}
						$hongniangInfo = C::t('#tom_xiangqin#tom_xiangqin_hongniang')->fetch_all_list('', ' ORDER BY paixu ASC,id DESC ', 0, 1);
						$hongniangQrcode = '';
						if (is_array($hongniangInfo) && !empty($hongniangInfo[0]['qrcode'])) {
							if (!preg_match('/^http/', $hongniangInfo[0]['qrcode'])) {
								if (strpos($hongniangInfo[0]['qrcode'], 'source/plugin/') === false) {
									$hongniangQrcode = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']) . $_G['setting']['attachurl'] . 'common/' . $hongniangInfo[0]['qrcode'];
								} else {
									$hongniangQrcode = $_G['siteurl'] . $hongniangInfo[0]['qrcode'];
								}
							} else {
								$hongniangQrcode = $hongniangInfo[0]['qrcode'];
							}
						}
						$shareTitle = $xiangqinConfig['info_share_title'];
						$shareTitle = str_replace('{NAME}', $info['xm'], $shareTitle);
						if ($info['sex'] == 1) {
							$shareTitle = str_replace('{SEX}', lang('plugin/tom_love', 'man'), $shareTitle);
						} else {
							if ($info['sex'] == 2) {
								$shareTitle = str_replace('{SEX}', lang('plugin/tom_love', 'woman'), $shareTitle);
							}
						}
						$shareTitle = str_replace('{AGE}', $age, $shareTitle);
						$shareLogo = $picurl;
						$shareDesc = $info['describe'];
						$shareDesc = str_replace("\n", '', $shareDesc);
						$shareDesc = str_replace("\r", '', $shareDesc);
						$shareDesc = str_replace("\r\n", '', $shareDesc);
						$shareUrl = $_G['siteurl'] . 'plugin.php?id=tom_xiangqin&mod=card&uid=' . $uid;
						$isGbk = false;
						if (CHARSET == 'gbk') {
							$isGbk = true;
						}
						include template('tom_xiangqin:card');
					} else {
						if ($_GET['mod'] == 'collect') {
							$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
							$pagesize = 8;
							$start = ($page - 1) * $pagesize;
							$collectData = C::t('#tom_xiangqin#tom_xiangqin_collect')->fetch_all_list(' AND user_id = ' . $__UserInfo['id'] . ' ', ' ORDER BY id DESC ', $start, $pagesize);
							$collectList = array();
							if (is_array($collectData) && !empty($collectData)) {
								foreach ($collectData as $key => $value) {
									$userTmp = C::t('#tom_xiangqin#tom_xiangqin')->fetch_by_id($value['xiangqin_id']);
									$collectList[$key] = $value;
									$collectList[$key]['user'] = $userTmp;
									if ($jyConfig['age_type_id'] == 1) {
										$collectList[$key]['age'] = $nowYear - $userTmp['birth_year'];
									} else {
										$collectList[$key]['age'] = $nowYear - $userTmp['birth_year'] + 1;
									}
									$collectList[$key]['user']['pic_url'] = tom_xiangqin_avatar($value['xiangqin_id']);
								}
							}
							$collectDataCount = C::t('#tom_xiangqin#tom_xiangqin_collect')->fetch_all_count(' AND user_id = ' . $__UserInfo['id'] . ' ');
							$showNextPage = 1;
							if ($start + $pagesize >= $collectDataCount) {
								$showNextPage = 0;
							}
							$prePage = $page - 1;
							$nextPage = $page + 1;
							$prePageUrl = 'plugin.php?id=tom_xiangqin&mod=collect&page=' . $prePage;
							$nextPageUrl = 'plugin.php?id=tom_xiangqin&mod=collect&page=' . $nextPage;
							$shoucangUrl = 'plugin.php?id=tom_xiangqin&mod=collect';
							$isGbk = false;
							if (CHARSET == 'gbk') {
								$isGbk = true;
							}
							
							include template('tom_xiangqin:collect');
						} else {
							if ($_GET['mod'] == 'hongniang') {
								$hongniangListTmp = C::t('#tom_xiangqin#tom_xiangqin_hongniang')->fetch_all_list('', 'ORDER BY paixu ASC,id DESC', 0, 100);
								$hongniangList = array();
								if (is_array($hongniangListTmp) && !empty($hongniangListTmp)) {
									foreach ($hongniangListTmp as $key => $value) {
										$hongniangList[$key] = $value;
										if (!preg_match('/^http/', $value['picurl'])) {
											if (strpos($value['picurl'], 'source/plugin/') === false) {
												$hongniangList[$key]['picurl'] = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']) . $_G['setting']['attachurl'] . 'common/' . $value['picurl'];
											} else {
												$hongniangList[$key]['picurl'] = $_G['siteurl'] . $value['picurl'];
											}
										} else {
											$hongniangList[$key]['picurl'] = $value['picurl'];
										}
										if (!preg_match('/^http/', $value['qrcode'])) {
											if (strpos($value['qrcode'], 'source/plugin/') === false) {
												$hongniangList[$key]['qrcode'] = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']) . $_G['setting']['attachurl'] . 'common/' . $value['qrcode'];
											} else {
												$hongniangList[$key]['qrcode'] = $_G['siteurl'] . $value['qrcode'];
											}
										} else {
											$hongniangList[$key]['qrcode'] = $value['qrcode'];
										}
									}
								}
								$successList = C::t('#tom_xiangqin#tom_xiangqin_success')->fetch_all_list('', 'ORDER BY id DESC', 0, 100);
								$isGbk = false;
								if (CHARSET == 'gbk') {
									$isGbk = true;
								}
								include template('tom_xiangqin:hongniang');
							} else {
								if ($_GET['mod'] == 'close') {
									$uid = isset($_GET['uid']) ? intval($_GET['uid']) : 0;
									$info = C::t('#tom_xiangqin#tom_xiangqin')->fetch_by_id($uid);
									$hongniangInfo = C::t('#tom_xiangqin#tom_xiangqin_hongniang')->fetch_all_list('', ' ORDER BY paixu ASC,id DESC ', 0, 1);
									$isGbk = false;
									if (CHARSET == 'gbk') {
										$isGbk = true;
									}
									include template('tom_xiangqin:close');
								} else {
									if ($_GET['mod'] == 'vip') {
										$vipList = C::t('#tom_xiangqin#tom_xiangqin_vip')->fetch_all_list('', ' ORDER BY vsort ASC,id DESC ');
										if (is_array($vipList) && !empty($vipList)) {
											foreach ($vipList as $key => $value) {
												$vipList[$key] = $value;
											}
										}
										$vipInfo = C::t('#tom_xiangqin#tom_xiangqin_vip')->fetch_by_id($__Xiangqin['vip_id']);
										$vip_time = dgmdate($__Xiangqin['vip_time'], 'Y-m-d', $tomSysOffset);
										$vip_txt = stripslashes($__CommonInfo['vip_txt']);
										$payUrl = 'plugin.php?id=tom_xiangqin:pay';
										$isGbk = false;
										if (CHARSET == 'gbk') {
											$isGbk = true;
										}
										//大·叔·来 Dashulai.com
										include template('tom_xiangqin:vip');
									} else {
										if ($_GET['mod'] == 'top') {
											$top_money_listStr = str_replace("\r\n", '{n}', $xiangqinConfig['top_money_list']);
											$top_money_listStr = str_replace("\n", '{n}', $top_money_listStr);
											$top_money_listStr = str_replace("\r", '{n}', $top_money_listStr);
											$top_money_listTmpArr = explode('{n}', $top_money_listStr);
											$top_moneyArr = array();
											if (is_array($top_money_listTmpArr) && !empty($top_money_listTmpArr)) {
												foreach ($top_money_listTmpArr as $key => $value) {
													if (!empty($value)) {
														list($month, $price) = explode('|', $value);
														$month = intval($month);
														if (!empty($month) && !empty($price)) {
															$top_moneyArr[$month]['price'] = $price;
															$day_money = $price / $month;
															$top_moneyArr[$month]['day_money'] = number_format($day_money, 2, '.', '');
														}
													}
												}
											}
											$top_time = dgmdate($__Xiangqin['top_time'], 'Y-m-d', $tomSysOffset);
											$top_txt = stripslashes($__CommonInfo['top_txt']);
											$payUrl = 'plugin.php?id=tom_xiangqin:pay';
											$isGbk = false;
											if (CHARSET == 'gbk') {
												$isGbk = true;
											}
											include template('tom_xiangqin:top');
										} else {
											if ($_GET['mod'] == 'qianxian') {
												$qianxian_money_listStr = str_replace("\r\n", '{n}', $xiangqinConfig['qianxian_money_list']);
												$qianxian_money_listStr = str_replace("\n", '{n}', $qianxian_money_listStr);
												$qianxian_money_listStr = str_replace("\r", '{n}', $qianxian_money_listStr);
												$qianxian_money_listTmpArr = explode('{n}', $qianxian_money_listStr);
												$qianxian_moneyArr = array();
												if (is_array($qianxian_money_listTmpArr) && !empty($qianxian_money_listTmpArr)) {
													foreach ($qianxian_money_listTmpArr as $key => $value) {
														if (!empty($value)) {
															list($time, $price) = explode('|', $value);
															$time = intval($time);
															if (!empty($time) && !empty($price)) {
																$qianxian_moneyArr[$time]['price'] = $price;
															}
														}
													}
												}
												$qianxian_txt = stripslashes($__CommonInfo['qianxian_txt']);
												$payUrl = 'plugin.php?id=tom_xiangqin:pay';
												$isGbk = false;
												if (CHARSET == 'gbk') {
													$isGbk = true;
												}
												include template('tom_xiangqin:qianxian');
											} else {
												if ($_GET['mod'] == 'my') {
													include DISCUZ_ROOT . './source/plugin/tom_xiangqin/module/my.php';
												} else {
													if ($_GET['mod'] == 'edit') {
														include DISCUZ_ROOT . './source/plugin/tom_xiangqin/module/edit.php';
													} else {
														if ($_GET['mod'] == 'mycard') {
															include DISCUZ_ROOT . './source/plugin/tom_xiangqin/module/mycard.php';
														} else {
															if ($_GET['mod'] == 'upload') {
																include DISCUZ_ROOT . './source/plugin/tom_xiangqin/module/upload.php';
															} else {
																dheader('location:' . $_G['siteurl'] . 'plugin.php?id=tom_xiangqin&mod=index');
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
tomoutput();