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
$jyConfig = $_G['cache']['plugin']['tom_love'];
$tomSysOffset = getglobal('setting/timeoffset');
require_once libfile('function/discuzcode');
$nowYear = dgmdate($_G['timestamp'], 'Y', $tomSysOffset);
$nowTime = gmmktime(0, 0, 0, dgmdate($_G['timestamp'], 'n', $tomSysOffset), dgmdate($_G['timestamp'], 'j', $tomSysOffset), dgmdate($_G['timestamp'], 'Y', $tomSysOffset)) - $tomSysOffset * 3600;
$nowMonth = gmmktime(0, 0, 0, dgmdate($_G['timestamp'], 'n', $tomSysOffset), 1, dgmdate($_G['timestamp'], 'Y', $tomSysOffset)) - $tomSysOffset * 3600;
$appid = trim($jyConfig['love_appid']);
$appsecret = trim($jyConfig['love_appsecret']);
$prand = rand(1, 1000);
$cssJsVersion = '20181006';
$wxJssdkConfig = array();
$wxJssdkConfig['appId'] = '';
$wxJssdkConfig['timestamp'] = time();
$wxJssdkConfig['nonceStr'] = '';
$wxJssdkConfig['signature'] = '';

include DISCUZ_ROOT . './source/plugin/tom_love/class/weixin.class.php';
$weixinClass = new weixinClass($appid, $appsecret);
$wxJssdkConfig = $weixinClass->get_jssdk_config();
$shareTitle = $jyConfig['share_title'];
$shareDesc = $jyConfig['share_desc'];
$shareLogo = $jyConfig['share_logo'];
$shareUrl = $_G['siteurl'] . 'plugin.php?id=tom_love&mod=index';
$phone_back_url = $weixinClass->get_url();
$phone_back_url = urlencode($phone_back_url);
$phoneUrl = 'plugin.php?id=tom_love&mod=phone&phone_back=' . $phone_back_url;
if (CHARSET == 'gbk') {
	include DISCUZ_ROOT . './source/plugin/tom_love/config/works.gbk.php';
} else {
	include DISCUZ_ROOT . './source/plugin/tom_love/config/works.utf.php';
}
include DISCUZ_ROOT . './source/plugin/tom_love/class/link.func.php';
include DISCUZ_ROOT . './source/plugin/tom_love/class/love.func.php';
include DISCUZ_ROOT . './source/plugin/tom_love/class/phb.func.php';
include DISCUZ_ROOT . './source/plugin/tom_love/login.php';
$shareAjaxUrl = $_G['siteurl'] . 'plugin.php?id=tom_love';
$ajaxClicksUrl = $_G['siteurl'] . 'plugin.php?id=tom_love:ajax&act=clicks&formhash=' . FORMHASH;
$ajaxLoadListUrl = 'plugin.php?id=tom_love:ajax&act=list&formhash=' . $formhash;
$subscribeUrl = 'plugin.php?id=tom_love:ajax&act=subscribe&formhash=' . $formhash;
$__ShowXiangqin = 0;
$xiangqinConfig = array();

if (file_exists(DISCUZ_ROOT . './source/plugin/tom_xiangqin/tom_xiangqin.inc.php')) {
	$xiangqinConfig = $_G['cache']['plugin']['tom_xiangqin'];
	if ($xiangqinConfig['open_xiangqin'] == 1) {
		$__ShowXiangqin = 1;
	}
}
$show_guanzu_box = 0;
if ($__UserInfo['subscribe'] == 0) {
	if ($_SESSION['subscribe_notice'] == 1) {
		$show_guanzu_box = 0;
	} else {
		$show_guanzu_box = 1;
	}
}
$commonInfo = C::t('#tom_love#tom_love_common')->fetch_by_id(1);
if (!is_array($commonInfo) || empty($commonInfo)) {
	$insertData = array();
	$insertData['clicks'] = 0;
	C::t('#tom_love#tom_love_common')->insert($insertData);
	$commonInfo = C::t('#tom_love#tom_love_common')->fetch_by_id(1);
}
$jyConfig['age_type_id'] = intval($jyConfig['age_type_id']);
if ($_GET['mod'] == 'index') {
	$userNum = C::t('#tom_love#tom_love')->fetch_all_count(' AND status = 1 ');
	$userNum = $userNum + $jyConfig['virtual_users'];
	$userNumTxt = $userNum;
	if ($userNum > 1000000) {
		$userNumTmp = $userNum / 10000;
		$userNumTxt = number_format($userNumTmp, 0);
	} else {
		if ($userNum > 10000) {
			$userNumTmp = $userNum / 10000;
			$userNumTxt = number_format($userNumTmp, 2);
		}
	}
	
	$clicksNum = $commonInfo['clicks'] + $jyConfig['virtual_clicks'];
	$clicksNumTxt = $clicksNum;
	if ($clicksNum > 1000000) {
		$clicksNumTmp = $clicksNum / 10000;
		$clicksNumTxt = number_format($clicksNumTmp, 0);
	} else {
		if ($clicksNum > 10000) {
			$clicksNumTmp = $clicksNum / 10000;
			$clicksNumTxt = number_format($clicksNumTmp, 2);
		}
	}
	$slideData = C::t('#tom_love#tom_love_focuspic')->fetch_all_list('', 'ORDER BY fsort ASC,id DESC', 0, 10);
	$slideList = array();
	if (is_array($slideData) && !empty($slideData)) {
		foreach ($slideData as $key => $value) {
			$slideList[$key] = $value;
			$slideList[$key]['title'] = dhtmlspecialchars($value['title']);
			if (!preg_match('/^http/', $value['picurl'])) {
				$slideList[$key]['picurl'] = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']) . $_G['setting']['attachurl'] . 'common/' . $value['picurl'];
			} else {
				$slideList[$key]['picurl'] = $value['picurl'];
			}
		}
	}
	
	$ssData = C::t('#tom_love#tom_love_shuoshuo')->fetch_all_list('', 'ORDER BY ss_time DESC', 0, 2);
	$ssList = array();
	if (is_array($ssData) && !empty($ssData)) {
		foreach ($ssData as $key => $value) {
			$ssList[$key] = $value;
			$ssList[$key]['content'] = tom_num_replace(cutstr(dhtmlspecialchars($value['content']), 58, '...'));
			$userTmp = C::t('#tom_love#tom_love')->fetch_by_id($value['user_id']);
			$ssList[$key]['userinfo'] = $userTmp;
			$ssList[$key]['userinfo']['avatar'] = tom_avatar($userTmp['avatar']);
		}
	}
	$vipUpdateUrl = $_G['siteurl'] . 'plugin.php?id=tom_love:ajax&act=vipUpdate&formhash=' . FORMHASH;
	$recUpdateUrl = $_G['siteurl'] . 'plugin.php?id=tom_love:ajax&act=recUpdate&formhash=' . FORMHASH;
	if (empty($jyConfig['dingyue_qrcode'])) {
		$jyConfig['dingyue_qrcode'] = $jyConfig['fuwuhao_qrcode'];
	}
	$indexJsFile = DISCUZ_ROOT . './source/plugin/tom_love/images/index.js';
    
	$isGbk = false;
	if (CHARSET == 'gbk') {
		$isGbk = true;
	}
	include template('tom_love:index');
	echo '<script src="source/plugin/tom_love/images/index.js"></script>';
} else {
	if ($_GET['mod'] == 'list') {
		$nickname = isset($_GET['nickname']) ? daddslashes(diconv(urldecode($_GET['nickname']), 'utf-8')) : '';
		$renzheng = isset($_GET['renzheng']) ? intval($_GET['renzheng']) : 0;
		$phone_renzheng = isset($_GET['phone_renzheng']) ? intval($_GET['phone_renzheng']) : 0;
		$hjcity_id = isset($_GET['hjcity_id']) ? intval($_GET['hjcity_id']) : 0;
		$province_id = isset($_GET['province_id']) ? intval($_GET['province_id']) : 0;
		$city_id = isset($_GET['city_id']) ? intval($_GET['city_id']) : 0;
		$area_id = isset($_GET['area_id']) ? intval($_GET['area_id']) : 0;
		$towns_id = isset($_GET['towns_id']) ? intval($_GET['towns_id']) : 0;
		$district_id = isset($_GET['district_id']) ? intval($_GET['district_id']) : 0;
		$sex = isset($_GET['sex']) ? intval($_GET['sex']) : 0;
		$age = isset($_GET['age']) ? intval($_GET['age']) : 0;
		$type = isset($_GET['type']) ? intval($_GET['type']) : 0;
		$marital = isset($_GET['marital']) ? intval($_GET['marital']) : 0;
		$job = isset($_GET['job']) ? intval($_GET['job']) : 0;
		$nearby_type = 0;
		$nearby_name = lang('plugin/tom_love', 'nav_nearby');
		if ($hjcity_id > 0) {
			$nearby_type = 1;
			$hjcityInfo = C::t('#tom_love#tom_love_district')->fetch_by_id($hjcity_id);
			$nearby_name = $hjcityInfo['name'];
		}
		
		if ($city_id > 0) {
			$nearby_type = 2;
			$cityInfo = C::t('#tom_love#tom_love_district')->fetch_by_id($city_id);
			$nearby_name = $cityInfo['name'];
		}
		if ($area_id > 0) {
			$nearby_type = 2;
			$areaInfo = C::t('#tom_love#tom_love_district')->fetch_by_id($area_id);
			$nearby_name = $areaInfo['name'];
		}
		if ($towns_id > 0) {
			$nearby_type = 2;
			$townsInfo = C::t('#tom_love#tom_love_district')->fetch_by_id($towns_id);
			$nearby_name = $townsInfo['name'];
		}
		$listUrl = 'plugin.php?id=tom_love&mod=list';
		$districtUrlParam = '&nickname=' . $_GET['nickname'] . ('&phone_renzheng=' . $phone_renzheng . '&sex=' . $sex . '&type=' . $type . '&marital=' . $marital . '&job=' . $job . '&age=' . $age);
		$sexUrlParam = '&nickname=' . $_GET['nickname'] . ('&phone_renzheng=' . $phone_renzheng . '&city_id=' . $city_id . '&hjcity_id=' . $hjcity_id . '&type=' . $type . '&marital=' . $marital . '&job=' . $job . '&age=' . $age . '&area_id=' . $area_id . '&towns_id=' . $towns_id);
		$ageUrlParam = '&nickname=' . $_GET['nickname'] . ('&phone_renzheng=' . $phone_renzheng . '&city_id=' . $city_id . '&hjcity_id=' . $hjcity_id . '&sex=' . $sex . '&type=' . $type . '&marital=' . $marital . '&job=' . $job . '&area_id=' . $area_id . '&towns_id=' . $towns_id);
		$filterUrlParam = '&city_id=' . $city_id . '&hjcity_id=' . $hjcity_id . '&sex=' . $sex . '&age=' . $age . '&area_id=' . $area_id . '&towns_id=' . $towns_id;
		$ajaxLoadListUrl = $ajaxLoadListUrl . '&nickname=' . urlencode($nickname) . ('&renzheng=' . $renzheng . '&phone_renzheng=' . $phone_renzheng . '&city_id=' . $city_id . '&hjcity_id=' . $hjcity_id . '&sex=' . $sex . '&type=' . $type . '&marital=' . $marital . '&job=' . $job . '&age=' . $age . '&area_id=' . $area_id . '&towns_id=' . $towns_id . '&province_id=' . $province_id);
		$hjcityList = array();
		if ($__UserInfo['id'] > 0) {
			$hjcityListTmp = C::t('#tom_love#tom_love_district')->fetch_all_by_upid($__UserInfo['hjprovince_id']);
			if (is_array($hjcityListTmp) && !empty($hjcityListTmp)) {
				foreach ($hjcityListTmp as $key => $value) {
					$hjcityList[$key] = $value;
					$hjcityList[$key]['link_url'] = $districtUrlParam . '&hjcity_id=' . $value['id'];
				}
			}
		}
		
		$districtList = array();
		if ($__UserInfo['id'] > 0) {
			$cityListTmp = C::t('#tom_love#tom_love_district')->fetch_all_by_upid($__UserInfo['province_id']);
			if (is_array($cityListTmp) && !empty($cityListTmp)) {
				foreach ($cityListTmp as $key => $value) {
					$districtList[$key] = $value;
					$districtList[$key]['link_url'] = $districtUrlParam . '&city_id=' . $value['id'];
				}
			}
		} else {
			if (isset($jyConfig['search_district']) && !empty($jyConfig['search_district'])) {
				$setDistrict = C::t('#tom_love#tom_love_district')->fetch_by_level_name($jyConfig['search_district']);
				if ($setDistrict) {
					if ($setDistrict['level'] == 1) {
						$provinceId = $setDistrict['id'];
						$districtListTmp = C::t('#tom_love#tom_love_district')->fetch_all_by_upid($provinceId);
						if (is_array($districtListTmp) && !empty($districtListTmp)) {
							foreach ($districtListTmp as $key => $value) {
								$districtList[$key] = $value;
								$districtList[$key]['link_url'] = $districtUrlParam . '&city_id=' . $value['id'];
							}
						}
					} else {
						if ($setDistrict['level'] == 2) {
							$cityId = $setDistrict['id'];
							$districtListTmp = C::t('#tom_love#tom_love_district')->fetch_all_by_upid($cityId);
							if (is_array($districtListTmp) && !empty($districtListTmp)) {
								foreach ($districtListTmp as $key => $value) {
									$districtList[$key] = $value;
									$districtList[$key]['link_url'] = $districtUrlParam . '&area_id=' . $value['id'];
								}
							}
						} else {
							if ($setDistrict['level'] == 3) {
								$areaId = $setDistrict['id'];
								$districtListTmp = C::t('#tom_love#tom_love_district')->fetch_all_by_upid($areaId);
								if (is_array($districtListTmp) && !empty($districtListTmp)) {
									foreach ($districtListTmp as $key => $value) {
										$districtList[$key] = $value;
										$districtList[$key]['link_url'] = $districtUrlParam . '&towns_id=' . $value['id'];
									}
								}
							}
						}
					}
				}
			}
		}
		$provinceList = C::t('#tom_love#tom_love_district')->fetch_all_by_level(1);
		$cityList = array();
		if ($province_id > 0) {
			$cityList = C::t('#tom_love#tom_love_district')->fetch_all_by_upid($province_id);
		}
		$isGbk = false;
		if (CHARSET == 'gbk') {
			$isGbk = true;
		}
		include template('tom_love:list');
	} else {
		if ($_GET['mod'] == 'info') {
			$uid = isset($_GET['uid']) ? trim($_GET['uid']) : 0;
			$info = C::t('#tom_love#tom_love')->fetch_by_id($uid);
			if ($info['status'] != 1 && $info['shenhe_status'] != 2) {
				dheader('location:' . $_G['siteurl'] . 'plugin.php?id=tom_love&mod=index');
				exit(0);
			}
			if ($info['year'] > 0) {
				if ($jyConfig['age_type_id'] == 1) {
					$age = $nowYear - $info['year'];
				} else {
					$age = $nowYear - $info['year'] + 1;
				}
			} else {
				$age = '';
			}
			
			$ssCount = C::t('#tom_love#tom_love_shuoshuo')->fetch_all_count('AND user_id = ' . $uid);
			$describe = tom_num_replace(dhtmlspecialchars($info['describe']));
			$mate_demands = tom_num_replace(dhtmlspecialchars($info['mate_demands']));
			$themeSrc = 'source/plugin/tom_love/images/Zhuytait1.png';
			if (!empty($info['theme'])) {
				if (!preg_match('/^http/', $info['theme'])) {
					if (strpos($info['theme'], 'source/plugin/tom_love') === false) {
						$themeSrc = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']) . $_G['setting']['attachurl'] . 'common/' . $info['theme'];
					} else {
						$themeSrc = $info['theme'];
					}
				} else {
					$themeSrc = $info['theme'];
				}
			}
			$info['avatar'] = tom_avatar($info['avatar']);
			$picListTmp = C::t('#tom_love#tom_love_pic')->fetch_all_list(' AND user_id =' . $uid . ' AND shenhe_status=1 ', 'ORDER BY id DESC', 0, 100);
			$picList = array();
			$picListAll = array();
			$picListStr = '';
			$i = 1;
			if (is_array($picListTmp) && !empty($picListTmp)) {
				foreach ($picListTmp as $key => $value) {
					if (!preg_match('/^http/', $value['pic_url'])) {
						if (strpos($value['pic_url'], 'source/plugin/tom_love') === false) {
							$value['pic_url'] = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']) . $_G['setting']['attachurl'] . 'common/' . $value['pic_url'];
						} else {
							$value['pic_url'] = $_G['siteurl'] . $value['pic_url'];
						}
					} else {
						$value['pic_url'] = $value['pic_url'];
					}
					if ($i < 5) {
						$picList[$key] = $value;
						$picList[$key]['i'] = $i;
					}
					$picListAll[] = $value['pic_url'];
					$i = $i + 1;
				}
				$picListStr = implode('|', $picListAll);
			}
			$show_pic_prompt_box = 0;
			if ($jyConfig['open_photo_album'] == 1 && $__UserInfo['id'] > 0) {
				if ($uid != $__UserInfo['id']) {
					if ($__UserInfo['pic_num'] <= 0) {
						$show_pic_prompt_box = 1;
					}
				}
			}
			
			$giftListTmp = C::t('#tom_love#tom_love_gift')->fetch_all_list(' AND is_show = 1', 'ORDER BY id DESC', 0, 1000);
			$giftList = array();
			if (is_array($giftListTmp) && !empty($giftListTmp)) {
				foreach ($giftListTmp as $key => $value) {
					$giftList[$key] = $value;
					if (!preg_match('/^http/', $value['gift_picurl'])) {
						if (strpos($value['gift_picurl'], 'source/plugin/tom_love') === false) {
							$giftList[$key]['gift_picurl'] = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']) . $_G['setting']['attachurl'] . 'common/' . $value['gift_picurl'];
						} else {
							$giftList[$key]['gift_picurl'] = $value['gift_picurl'];
						}
					} else {
						$giftList[$key]['gift_picurl'] = $value['gift_picurl'];
					}
				}
			}
			$giftCount = C::t('#tom_love#tom_love_gift_count')->fetch_gift_count(' AND user_id = ' . $uid);
			$giftCountListTmp = C::t('#tom_love#tom_love_gift_count')->fetch_all_list(' AND user_id = ' . $uid . ' ', 'ORDER BY id DESC', 0, 10000);
			$giftCountList = array();
			if (is_array($giftCountListTmp) && !empty($giftCountListTmp)) {
				foreach ($giftCountListTmp as $key => $value) {
					$giftCountList[$key] = $value;
					if (!preg_match('/^http/', $value['gift_picurl'])) {
						if (strpos($value['gift_picurl'], 'source/plugin/tom_love') === false) {
							$giftCountList[$key]['gift_picurl'] = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']) . $_G['setting']['attachurl'] . 'common/' . $value['gift_picurl'];
						} else {
							$giftCountList[$key]['gift_picurl'] = $value['gift_picurl'];
						}
					} else {
						$giftCountList[$key]['gift_picurl'] = $value['gift_picurl'];
					}
				}
			}
			
			$contactTag = 0;
			if ($__UserInfo['id'] > 0) {
				$contactUser = C::t('#tom_love#tom_love_guanxi')->fetch_by_contact($__UserInfo['id'], $info['id']);
				if ($contactUser || $info['id'] == $__UserInfo['id']) {
					$contactTag = 1;
				}
			}
			$anlianTag = 0;
			if ($__UserInfo['id'] > 0) {
				$anlianUser = C::t('#tom_love#tom_love_guanxi')->fetch_by_anlian($__UserInfo['id'], $info['id']);
				if ($anlianUser || $info['id'] == $__UserInfo['id']) {
					$anlianTag = 1;
				}
			}
			$shareTitle = $jyConfig['share_info_title'];
			$shareTitle = str_replace('{NICKNAME}', $info['nickname'], $shareTitle);
			if ($info['sex'] == 1) {
				$shareTitle = str_replace('{SEX}', lang('plugin/tom_love', 'man'), $shareTitle);
			} else {
				if ($info['sex'] == 2) {
					$shareTitle = str_replace('{SEX}', lang('plugin/tom_love', 'woman'), $shareTitle);
				}
			}
			$shareTitle = str_replace('{AGE}', $age, $shareTitle);
			$shareTitle = str_replace('{MARITAL}', $maritalArray[$info['marital_id']], $shareTitle);
			$shareTitle = str_replace('{HEIGHT}', $info['height'] . 'cm', $shareTitle);
			$shareTitle = str_replace('{WEIGHT}', $info['weight'] . 'kg', $shareTitle);
			$shareTitle = str_replace('{JOB}', $worksArray[$info['work_id']], $shareTitle);
			$shareTitle = str_replace('{EDU}', $eduArray[$info['edu_id']], $shareTitle);
			$shareTitle = str_replace('{PAY}', $payArray[$info['pay_id']], $shareTitle);
			$shareTitle = str_replace('{DESCRIBE}', $describe, $shareTitle);
			$shareTitle = str_replace('{MATE_DEMANDS}', $mate_demands, $shareTitle);
			$shareTitle = str_replace("\n", '', $shareTitle);
			$shareTitle = str_replace("\r", '', $shareTitle);
			$shareTitle = str_replace("\r\n", '', $shareTitle);
			$shareDesc = $jyConfig['share_info_desc'];
			$shareDesc = str_replace('{NICKNAME}', $info['nickname'], $shareDesc);
			if ($info['sex'] == 1) {
				$shareDesc = str_replace('{SEX}', lang('plugin/tom_love', 'man'), $shareDesc);
			} else {
				if ($info['sex'] == 2) {
					$shareDesc = str_replace('{SEX}', lang('plugin/tom_love', 'woman'), $shareDesc);
				}
			}
			$shareDesc = str_replace('{AGE}', $age, $shareDesc);
			$shareDesc = str_replace('{MARITAL}', $maritalArray[$info['marital_id']], $shareDesc);
			$shareDesc = str_replace('{HEIGHT}', $info['height'] . 'cm', $shareDesc);
			$shareDesc = str_replace('{WEIGHT}', $info['weight'] . 'kg', $shareDesc);
			$shareDesc = str_replace('{JOB}', $worksArray[$info['work_id']], $shareDesc);
			$shareDesc = str_replace('{EDU}', $eduArray[$info['edu_id']], $shareDesc);
			$shareDesc = str_replace('{PAY}', $payArray[$info['pay_id']], $shareDesc);
			$shareDesc = str_replace('{DESCRIBE}', $describe, $shareDesc);
			$shareDesc = str_replace('{MATE_DEMANDS}', $mate_demands, $shareDesc);
			$shareDesc = str_replace("\n", '', $shareDesc);
			$shareDesc = str_replace("\r", '', $shareDesc);
			$shareDesc = str_replace("\r\n", '', $shareDesc);
			$shareLogo = $info['avatar'];
			$shareUrl = $_G['siteurl'] . ('plugin.php?id=tom_love&mod=info&uid=' . $info['id']);
			$contactUrl = 'plugin.php?id=tom_love:ajax&act=contact&uid=' . $__UserInfo['id'] . '&gid=' . $info['id'] . '&formhash=' . FORMHASH;
			$anlianUrl = 'plugin.php?id=tom_love:ajax&act=anlian&uid=' . $__UserInfo['id'] . '&gid=' . $info['id'] . '&formhash=' . FORMHASH;
			$helloUrl = 'plugin.php?id=tom_love:ajax&act=hello&uid=' . $__UserInfo['id'] . '&tid=' . $info['id'] . '&formhash=' . FORMHASH;
			$detailsUrl = 'plugin.php?id=tom_love:ajax&tid=' . $info['id'] . '&formhash=' . FORMHASH;
			$scoreUrl = 'plugin.php?id=tom_love:ajax&uid=' . $__UserInfo['id'] . '&tid=' . $info['id'] . '&formhash=' . FORMHASH;
			$ajaxInfoClicksUrl = 'plugin.php?id=tom_love:ajax&act=infoClicks&formhash=' . FORMHASH . ('&uid=' . $info['id']);
			$shuoshuoUrl = 'plugin.php?id=tom_love&mod=shuoshuo';
			$isGbk = false;
			if (CHARSET == 'gbk') {
				$isGbk = true;
			}
			if ($_GET['miniprogram_get_title'] == 1) {
				echo '<title>' . $shareTitle . '</title>';
				exit(0);
			} else {
				include template('tom_love:info');
			}
		} else {
			if ($_GET['mod'] == 'phb') {
				$phb_type = isset($_GET['phb_type']) ? intval($_GET['phb_type']) : 1;
				$type = isset($_GET['type']) ? intval($_GET['type']) : 1;
				$phb_num = 20;
				if ($jyConfig['phb_num'] > 0) {
					$phb_num = $jyConfig['phb_num'];
				}
				if ($phb_type == 1) {
					$month_id = dgmdate($_G['timestamp'], 'Ym', $tomSysOffset);
				} else {
					if ($phb_type == 2) {
						$month_id = dgmdate($_G['timestamp'], 'YW', $tomSysOffset);
					}
				}
				$where = 'AND month_id = ' . $month_id . ' AND phb_type = ' . $phb_type . ' ';
				$order = 'ORDER BY id DESC';
				if ($type == 1) {
					$where .= ' AND flowers > 0';
					$order = 'ORDER BY flowers DESC,id DESC';
				} else {
					if ($type == 2) {
						$where .= ' AND anlians > 0';
						$order = 'ORDER BY anlians DESC,id DESC';
					} else {
						if ($type == 3) {
							$where .= ' AND clicks > 0';
							$order = 'ORDER BY clicks DESC,id DESC';
						} else {
							if ($type == 4) {
								$where .= ' AND signdays > 0';
								$order = 'ORDER BY signdays DESC,id DESC';
							} else {
								if ($type == 5) {
									$where .= ' AND shuoshuo > 0';
									$order = 'ORDER BY shuoshuo DESC,id DESC';
								} else {
									if ($type == 6) {
										$where .= ' AND sharetime > 0';
										$order = 'ORDER BY sharetime DESC,id DESC';
									}
								}
							}
						}
					}
				}
				//by www-dashulai-com
				$userData = C::t('#tom_love#tom_love_phb')->fetch_all_list($where, $order, 0, $phb_num);
				$userList = array();
				if (is_array($userData) && !empty($userData)) {
					foreach ($userData as $key => $value) {
						$userInfo = C::t('#tom_love#tom_love')->fetch_by_id($value['user_id']);
						if (is_array($userInfo) && !empty($userInfo) && $userInfo['status'] == 1) {
							$userList[$key] = $value;
							$userList[$key]['user_id'] = $userInfo;
							$userList[$key]['user_id']['describe'] = dhtmlspecialchars($userInfo['describe']);
							if ($userInfo['year'] > 0) {
								if ($jyConfig['age_type_id'] == 1) {
									$userList[$key]['user_id']['age'] = $nowYear - $userInfo['year'];
								} else {
									$userList[$key]['user_id']['age'] = $nowYear - $userInfo['year'] + 1;
								}
							} else {
								$userList[$key]['user_id']['age'] = '';
							}
							$userList[$key]['user_id']['avatar'] = tom_avatar($userInfo['avatar']);
						}
					}
				}
				$isGbk = false;
				if (CHARSET == 'gbk') {
					$isGbk = true;
				}
                
				include template('tom_love:phb');
			} else {
				if ($_GET['mod'] == 'report') {
					$act = isset($_GET['act']) ? trim($_GET['act']) : '';
					$report_from = isset($_GET['report_from']) ? daddslashes($_GET['report_from']) : '';
					if ($act == 'save' && $_GET['formhash'] == FORMHASH) {
						$outArr = array('status' => 200);
						$report_user_id = isset($_GET['report_user_id']) ? intval($_GET['report_user_id']) : 0;
						$report_content = isset($_GET['report_content']) ? daddslashes(diconv(urldecode($_GET['report_content']), 'utf-8')) : '';
						$bmpicliArr = array();
						if (is_array($_GET['bmpicli']) && !empty($_GET['bmpicli'])) {
							foreach ($_GET['bmpicli'] as $key => $value) {
								$bmpicliArr[] = daddslashes($value);
							}
						}
						$insertData = array();
						$insertData['user_id'] = $__UserInfo['id'];
						$insertData['report_user_id'] = $report_user_id;
						$insertData['report_content'] = $report_content;
						$insertData['report_pic_1'] = $bmpicliArr[0];
						$insertData['report_pic_2'] = $bmpicliArr[1];
						$insertData['report_time'] = TIMESTAMP;
						C::t('#tom_love#tom_love_report')->insert($insertData);
						echo json_encode($outArr);
						exit(0);
					}
					$report_user_id = isset($_GET['report_user_id']) ? intval($_GET['report_user_id']) : 0;
					$reportUserInfo = C::t('#tom_love#tom_love')->fetch_by_id($report_user_id);
					$uploadUrl = 'plugin.php?id=tom_love&mod=upload&act=report&formhash=' . FORMHASH;
					$reportUrl = 'plugin.php?id=tom_love&mod=report';
					$isGbk = false;
					if (CHARSET == 'gbk') {
						$isGbk = true;
					}
					
					include template('tom_love:report');
				} else {
					if ($_GET['mod'] == 'guanxi') {
						$act = isset($_GET['act']) ? trim($_GET['act']) : '';
						$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
						$where = '';
						$pageType = '';
						if ($act == 'meanlian') {
							$pageType = 'anlian';
							$where = ' AND type_id=2 AND user_id=' . $__UserInfo['id'] . ' ';
						} else {
							if ($act == 'anlianme') {
								$pageType = 'anlian';
								$where = ' AND type_id=2 AND gx_user_id=' . $__UserInfo['id'] . ' ';
							} else {
								if ($act == 'mechakan') {
									$pageType = 'chakan';
									$where = ' AND type_id=1 AND user_id=' . $__UserInfo['id'] . ' ';
								} else {
									if ($act == 'chakanme') {
										$pageType = 'chakan';
										$where = ' AND type_id=1 AND gx_user_id=' . $__UserInfo['id'] . ' ';
									}
								}
							}
						}
						$pagesize = 8;
						$start = ($page - 1) * $pagesize;
						$guanxiData = C::t('#tom_love#tom_love_guanxi')->fetch_all_list($where, 'ORDER BY id DESC', $start, $pagesize);
						$guanxiDataCount = C::t('#tom_love#tom_love_guanxi')->fetch_all_count($where);
						$guanxiList = array();
						if (is_array($guanxiData) && !empty($guanxiData)) {
							foreach ($guanxiData as $key => $value) {
								if ($act == 'meanlian' || $act == 'mechakan') {
									$user = C::t('#tom_love#tom_love')->fetch_by_id($value['gx_user_id']);
								} else {
									if ($act == 'anlianme' || $act == 'chakanme') {
										$user = C::t('#tom_love#tom_love')->fetch_by_id($value['user_id']);
									}
								}
								$guanxiList[$key] = $value;
								$guanxiList[$key]['user'] = $user;
								$guanxiList[$key]['describe'] = tom_num_replace(cutstr(dhtmlspecialchars($user['describe']), 28, '...'));
								$guanxiList[$key]['age'] = $nowYear - $user['year'] + 1;
								$guanxiList[$key]['user']['avatar'] = tom_avatar($user['avatar']);
							}
						}
						
						$showNextPage = 1;
						if ($start + $pagesize >= $guanxiDataCount) {
							$showNextPage = 0;
						}
						$prePage = $page - 1;
						$nextPage = $page + 1;
						$prePageUrl = 'plugin.php?id=tom_love&mod=guanxi&act=' . $act . '&page=' . $prePage;
						$nextPageUrl = 'plugin.php?id=tom_love&mod=guanxi&act=' . $act . '&page=' . $nextPage;
						$deleteUrl = 'plugin.php?id=tom_love:ajax&act=delanlian&formhash=' . FORMHASH;
						$isGbk = false;
						if (CHARSET == 'gbk') {
							$isGbk = true;
						}
						include template('tom_love:guanxi');
					} else {
						if ($_GET['mod'] == 'article') {
							$title = '';
							$content = '';
							if ($_GET['aid'] == 1) {
								$title = lang('plugin/tom_love', 'aboutus_title');
								$content = discuzcode($jyConfig['love_aboutus'], 0, 0, 0, 1, 1, 1, 0, 0, 0, 0);
							} else {
								if ($_GET['aid'] == 2) {
									$title = lang('plugin/tom_love', 'xieyi_title');
									$content = discuzcode($jyConfig['love_xieyi'], 0, 0, 0, 1, 1, 1, 0, 0, 0, 0);
								} else {
									if ($_GET['aid'] == 3) {
										$title = lang('plugin/tom_love', 'gonggao_title');
										$content = discuzcode($jyConfig['index_gonggao_msg'], 0, 0, 0, 1, 1, 1, 0, 0, 0, 0);
									}
								}
							}
							$isGbk = false;
							if (CHARSET == 'gbk') {
								$isGbk = true;
							}
							include template('tom_love:article');
						} else {
							if ($_GET['mod'] == 'flowerslog') {
								$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
								$pagesize = 15;
								$start = ($page - 1) * $pagesize;
								$flowerslogListTmp = C::t('#tom_love#tom_love_flowers_log')->fetch_all_list(' AND user_id = ' . $__UserInfo['id'], ' ORDER BY id DESC', $start, $pagesize);
								$flowerslogCount = C::t('#tom_love#tom_love_flowers_log')->fetch_all_count('AND user_id = ' . $__UserInfo['id']);
								$flowerslogList = array();
								if (is_array($flowerslogListTmp) && !empty($flowerslogListTmp)) {
									foreach ($flowerslogListTmp as $key => $value) {
										$flowerslogList[$key] = $value;
										$flowerslogList[$key]['txt'] = htmlspecialchars_decode($value['txt']);
									}
								}
								$showNextPage = 1;
								if ($start + $pagesize >= $flowerslogCount) {
									$showNextPage = 0;
								}
								$total = ceil($shopGoodsCount / $pagesize);
								$prePage = $page - 1;
								$nextPage = $page + 1;
								$prePageUrl = 'plugin.php?id=tom_love&mod=flowerslog&page=' . $prePage;
								$nextPageUrl = 'plugin.php?id=tom_love&mod=flowerslog&page=' . $nextPage;
								$isGbk = false;
								if (CHARSET == 'gbk') {
									$isGbk = true;
								}
								//www-dashulai-com
								include template('tom_love:flowerslog');
							} else {
								if ($_GET['mod'] == 'avatar') {
									$act = isset($_GET['act']) ? trim($_GET['act']) : '';
									$uploadUrl = 'plugin.php?id=tom_love&mod=upload&act=avatar&formhash=' . FORMHASH;
									$backUrl = 'plugin.php?id=tom_love&mod=my';
									$isGbk = false;
									if (CHARSET == 'gbk') {
										$isGbk = true;
									}
									include template('tom_love:avatar');
								} else {
									if ($_GET['mod'] == 'theme') {
										$act = isset($_GET['act']) ? trim($_GET['act']) : '';
										$userThemePic = '';
										if (!empty($__UserInfo['theme'])) {
											if (!preg_match('/^http/', $__UserInfo['theme'])) {
												if (strpos($__UserInfo['theme'], 'source/plugin/tom_love') === false) {
													$userThemePic = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']) . $_G['setting']['attachurl'] . 'common/' . $__UserInfo['theme'];
												} else {
													$userThemePic = $__UserInfo['theme'];
												}
											} else {
												$userThemePic = $__UserInfo['theme'];
											}
										}
										$uploadUrl = 'plugin.php?id=tom_love&mod=upload&act=theme&formhash=' . FORMHASH;
										$isGbk = false;
										if (CHARSET == 'gbk') {
											$isGbk = true;
										}
										include template('tom_love:theme');
									} else {
										if ($_GET['mod'] == 'photo') {
											$act = isset($_GET['act']) ? trim($_GET['act']) : '';
											if ($act == 'del' && $_GET['formhash'] == FORMHASH) {
												$picid = intval($_GET['picid']);
												C::t('#tom_love#tom_love_pic')->delete($picid);
												$pic_num = C::t('#tom_love#tom_love_pic')->fetch_all_count(' AND user_id =' . $__UserInfo['id'] . ' ');
												$updateData = array();
												$updateData['pic_num'] = $pic_num;
												C::t('#tom_love#tom_love')->update($__UserInfo['id'], $updateData);
												$__UserInfo['pic_num'] = $pic_num;
											}
											$picListTmp = C::t('#tom_love#tom_love_pic')->fetch_all_list(' AND user_id =' . $__UserInfo['id'] . ' ', 'ORDER BY id DESC', 0, 100);
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
											$delUrl = 'plugin.php?id=tom_love&mod=photo&act=del&formhash=' . FORMHASH . '&picid=';
											$uploadUrl = 'plugin.php?id=tom_love&mod=upload&act=photo&formhash=' . FORMHASH;
											$allow_upload_num = $jyConfig['pic_num'] - $__UserInfo['pic_num'];
											if ($allow_upload_num < 1) {
												$allow_upload_num = 0;
											}
											$isGbk = false;
											if (CHARSET == 'gbk') {
												$isGbk = true;
											}
											//www-dashulai-com
											include template('tom_love:photo');
										} else {
											if ($_GET['mod'] == 'renzheng') {
												$renzheng_from = isset($_GET['renzheng_from']) ? daddslashes($_GET['renzheng_from']) : '';
												$renzheng_back = isset($_GET['renzheng_back']) ? daddslashes($_GET['renzheng_back']) : '';
												$act = isset($_GET['act']) ? trim($_GET['act']) : '';
												if ($act == 'save' && $_GET['formhash'] == FORMHASH) {
													$outArr = array('status' => 200);
													$id = isset($_GET['rid']) ? intval($_GET['rid']) : '';
													$xm = isset($_GET['xm']) ? daddslashes(diconv(urldecode($_GET['xm']), 'utf-8')) : '';
													$sfzh = isset($_GET['sfzh']) ? daddslashes($_GET['sfzh']) : '';
													$content = isset($_GET['content']) ? daddslashes(diconv(urldecode($_GET['content']), 'utf-8')) : '';
													$pic_z = isset($_GET['pic_z']) ? daddslashes($_GET['pic_z']) : '';
													$pic_f = isset($_GET['pic_f']) ? daddslashes($_GET['pic_f']) : '';
													$pic_s = isset($_GET['pic_s']) ? daddslashes($_GET['pic_s']) : '';
													$updateData = array();
													$updateData['xm'] = $xm;
													$updateData['sfzh'] = $sfzh;
													$updateData['content'] = $content;
													$updateData['pic_z'] = $pic_z;
													$updateData['pic_f'] = $pic_f;
													$updateData['pic_s'] = $pic_s;
													$updateData['renzheng_time'] = TIMESTAMP;
													$updateData['renzheng_status'] = 1;
													C::t('#tom_love#tom_love_renzheng')->update($id, $updateData);
													echo json_encode($outArr);
													exit(0);
												}
												$renzhengInfo = C::t('#tom_love#tom_love_renzheng')->fetch_by_uid($__UserInfo['id']);
												if (!$renzhengInfo) {
													$insertData = array();
													$insertData['user_id'] = $__UserInfo['id'];
													$insertData['pic_z'] = 'source/plugin/tom_love/images/pic_z.png';
													$insertData['pic_f'] = 'source/plugin/tom_love/images/pic_f.png';
													$insertData['pic_s'] = 'source/plugin/tom_love/images/pic_s.png';
													C::t('#tom_love#tom_love_renzheng')->insert($insertData);
													$renzhengInfo = C::t('#tom_love#tom_love_renzheng')->fetch_by_uid($__UserInfo['id']);
												}
												if (!preg_match('/^http/', $renzhengInfo['pic_z'])) {
													if (strpos($renzhengInfo['pic_z'], 'source/plugin/tom_love') === false) {
														$pic_z = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']) . $_G['setting']['attachurl'] . 'common/' . $renzhengInfo['pic_z'];
													} else {
														$pic_z = $renzhengInfo['pic_z'];
													}
												} else {
													$pic_z = $renzhengInfo['pic_z'];
												}
												if (!preg_match('/^http/', $renzhengInfo['pic_f'])) {
													if (strpos($renzhengInfo['pic_f'], 'source/plugin/tom_love') === false) {
														$pic_f = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']) . $_G['setting']['attachurl'] . 'common/' . $renzhengInfo['pic_f'];
													} else {
														$pic_f = $renzhengInfo['pic_f'];
													}
												} else {
													$pic_f = $renzhengInfo['pic_f'];
												}
												if (!preg_match('/^http/', $renzhengInfo['pic_s'])) {
													if (strpos($renzhengInfo['pic_s'], 'source/plugin/tom_love') === false) {
														$pic_s = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']) . $_G['setting']['attachurl'] . 'common/' . $renzhengInfo['pic_s'];
													} else {
														$pic_s = $renzhengInfo['pic_s'];
													}
												} else {
													$pic_s = $renzhengInfo['pic_s'];
												}
												//WWW.DASHULAI.COM
												$renzhengString = discuzcode($jyConfig['renzheng'], 0, 0, 0, 1, 1, 1, 0, 0, 0, 0);
												$uploadUrl1 = 'plugin.php?id=tom_love&mod=upload&act=renzheng1&formhash=' . FORMHASH;
												$uploadUrl2 = 'plugin.php?id=tom_love&mod=upload&act=renzheng2&formhash=' . FORMHASH;
												$uploadUrl3 = 'plugin.php?id=tom_love&mod=upload&act=renzheng3&formhash=' . FORMHASH;
												$renzhengUrl = 'plugin.php?id=tom_love&mod=renzheng&formhash=' . FORMHASH;
												$isGbk = false;
												if (CHARSET == 'gbk') {
													$isGbk = true;
												}
												include template('tom_love:renzheng');
											} else {
												if ($_GET['mod'] == 'score') {
													$scoretype = 'extcredits1';
													$scorename = $_G['setting']['extcredits'][1]['title'];
													if (intval($jyConfig['bbs_score_type']) >= 1) {
														$scoretype = 'extcredits' . $jyConfig['bbs_score_type'];
														$scorename = $_G['setting']['extcredits'][$jyConfig['bbs_score_type']]['title'];
													}
													$userBbsScore = C::t('#tom_love#tom_common_member_count')->result_by_uid($__UserInfo['bbs_uid'], $scoretype);
													$scoreArr = array('1' => $jyConfig['bbs_score_scale'] * 1, '2' => $jyConfig['bbs_score_scale'] * 2, '5' => $jyConfig['bbs_score_scale'] * 5, '10' => $jyConfig['bbs_score_scale'] * 10, '20' => $jyConfig['bbs_score_scale'] * 20);
													if ($_GET['act'] == 'recharge' && $_GET['formhash'] == FORMHASH) {
														$outArr = array('status' => 0);
														$bbs_score = isset($_GET['bbs_score']) ? intval($_GET['bbs_score']) : '';
														if ($bbs_score > $userBbsScore) {
															$outArr['status'] = 201;
														} else {
															$updateData = array();
															$updateData['score'] = $__UserInfo['score'] + $bbs_score * $jyConfig['bbs_score_scale'];
															C::t('#tom_love#tom_love')->update($__UserInfo['id'], $updateData);
															$deductScore = (0 - 1) * $bbs_score;
															updatemembercount($__UserInfo['bbs_uid'], array($scoretype => $deductScore));
															$outArr['status'] = 200;
															$insertData = array();
															$insertData['user_id'] = $__UserInfo['id'];
															$insertData['score_value'] = $bbs_score * $jyConfig['bbs_score_scale'];
															$insertData['log_type'] = 1;
															$insertData['log_time'] = TIMESTAMP;
															C::t('#tom_love#tom_love_scorelog')->insert($insertData);
														}
														echo json_encode($outArr);
														exit(0);
													}
													$scoreString = discuzcode($jyConfig['score_page'], 0, 0, 0, 1, 1, 1, 0, 0, 0, 0);
													$rechargeUrl = 'plugin.php?id=tom_love&mod=score';
													$scorelogData = C::t('#tom_love#tom_love_scorelog')->fetch_all_list(' AND user_id=' . $__UserInfo['id'] . ' AND log_type=1 ', 'ORDER BY log_time DESC', 0, 50);
													$scorelogList = array();
													if (is_array($scorelogData) && !empty($scorelogData)) {
														foreach ($scorelogData as $logkey => $logvalue) {
															$scorelogList[$logkey] = $logvalue;
														}
													}
													$isGbk = false;
													if (CHARSET == 'gbk') {
														$isGbk = true;
													}
													include template('tom_love:score');
												} else {
													if ($_GET['mod'] == 'scorepay') {
														$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
														$yuan_score_listStr = str_replace("\r\n", '{n}', $jyConfig['yuan_score_list']);
														$yuan_score_listStr = str_replace("\n", '{n}', $yuan_score_listStr);
														$yuan_score_listTmpArr = explode('{n}', $yuan_score_listStr);
														$yuan_scoreArr = array();
														if (is_array($yuan_score_listTmpArr) && !empty($yuan_score_listTmpArr)) {
															foreach ($yuan_score_listTmpArr as $key => $value) {
																if (!empty($value)) {
																	list($yuan, $score) = explode('|', $value);
																	$yuan = intval($yuan);
																	$score = intval($score);
																	if (!empty($yuan) && !empty($score)) {
																		$yuan_scoreArr[$yuan] = $score;
																	}
																}
															}
														}
														$scoreString = discuzcode($jyConfig['score_page'], 0, 0, 0, 1, 1, 1, 0, 0, 0, 0);
														$pagesize = 50;
														$start = ($page - 1) * $pagesize;
														$count = C::t('#tom_love#tom_love_guanxi')->fetch_all_count(' AND user_id=' . $__UserInfo['id'] . ' ');
														$scorelogData = C::t('#tom_love#tom_love_scorelog')->fetch_all_list(' AND user_id=' . $__UserInfo['id'] . ' ', 'ORDER BY log_time DESC', $start, $pagesize);
														$scorelogList = array();
														if (is_array($scorelogData) && !empty($scorelogData)) {
															foreach ($scorelogData as $logkey => $logvalue) {
																$scorelogList[$logkey] = $logvalue;
															}
														}
														$showNextPage = 1;
														if ($start + $pagesize >= $count) {
															$showNextPage = 0;
														}
														
														$prePage = $page - 1;
														$nextPage = $page + 1;
														$prePageUrl = 'plugin.php?id=tom_love&mod=scorelog&page=' . $prePage;
														$nextPageUrl = 'plugin.php?id=tom_love&mod=scorelog&page=' . $nextPage;
														$payUrl = 'plugin.php?id=tom_love:pay';
														$isGbk = false;
														if (CHARSET == 'gbk') {
															$isGbk = true;
														}
														include template('tom_love:scorepay');
													} else {
														if ($_GET['mod'] == 'vippay') {
															$girlTequan = 0;
															if ($__UserInfo['sex'] == 2 && $jyConfig['open_girl_tequan'] == 1) {
																$girlTequan = 1;
															}
															$yuan_vip1_listStr = str_replace("\r\n", '{n}', $jyConfig['yuan_vip1_list']);
															$yuan_vip1_listStr = str_replace("\n", '{n}', $yuan_vip1_listStr);
															$yuan_vip1_listTmpArr = explode('{n}', $yuan_vip1_listStr);
															$yuan_vip1Arr = array();
															if (is_array($yuan_vip1_listTmpArr) && !empty($yuan_vip1_listTmpArr)) {
																foreach ($yuan_vip1_listTmpArr as $key => $value) {
																	if (!empty($value)) {
																		list($month, $price) = explode('|', $value);
																		$month = intval($month);
																		$price = intval($price);
																		if (!empty($month) && !empty($price)) {
																			$yuan_vip1Arr[$month] = $price;
																		}
																	}
																}
															}
															$vipTime = dgmdate($__UserInfo['vip_time'], 'Y-m-d', $tomSysOffset);
															$vip_payString = discuzcode($jyConfig['vip_pay_msg'], 0, 0, 0, 1, 1, 1, 0, 0, 0, 0);
															$payUrl = 'plugin.php?id=tom_love:pay';
															$isGbk = false;
															if (CHARSET == 'gbk') {
																$isGbk = true;
															}
															include template('tom_love:vippay');
														} else {
															if ($_GET['mod'] == 'rec') {
																$act = isset($_GET['act']) ? trim($_GET['act']) : '';
																$rec_score_listStr = str_replace("\r\n", '{n}', $jyConfig['rec_score_list']);
																$rec_score_listStr = str_replace("\n", '{n}', $rec_score_listStr);
																$rec_score_listTmpArr = explode('{n}', $rec_score_listStr);
																$rec_scoreArr = array();
																if (is_array($rec_score_listTmpArr) && !empty($rec_score_listTmpArr)) {
																	foreach ($rec_score_listTmpArr as $key => $value) {
																		if (!empty($value)) {
																			list($month, $score) = explode('|', $value);
																			$month = intval($month);
																			$score = intval($score);
																			if (!empty($month) && !empty($score)) {
																				$rec_scoreArr[$month] = $score;
																			}
																		}
																	}
																}
																if ($act == 'addrec' && $_GET['formhash'] == FORMHASH) {
																	$day_id = intval($_GET['day_id']) > 0 ? intval($_GET['day_id']) : 0;
																	$outArr = array('status' => 200);
																	if ($__UserInfo['vip_id'] == 0) {
																		if (!isset($rec_scoreArr[$day_id])) {
																			$outArr['status'] = 301;
																			echo json_encode($outArr);
																			exit(0);
																		}
																	}
																	if ($__UserInfo['vip_id'] == 0) {
																		if (!empty($rec_scoreArr) && $rec_scoreArr[$day_id] > $__UserInfo['score']) {
																			$outArr = array('status' => 101, 'have' => $__UserInfo['score'], 'need' => $rec_scoreArr[$day_id]);
																			echo json_encode($outArr);
																			exit(0);
																		}
																	}
																	$recommend_time = TIMESTAMP;
																	if ($__UserInfo['recommend_time'] > TIMESTAMP) {
																		$recommend_time = $__UserInfo['recommend_time'] + $day_id * 86400;
																	} else {
																		$recommend_time = TIMESTAMP + $day_id * 86400;
																	}
																	if ($__UserInfo['vip_id'] == 1) {
																		$recommend_time = $__UserInfo['vip_time'];
																	}
																	if ($__UserInfo['vip_id'] == 0) {
																		$updateData = array();
																		$updateData['recommend_time'] = $recommend_time;
																		$updateData['recommend_do_time'] = TIMESTAMP;
																		$updateData['score'] = $__UserInfo['score'] - $rec_scoreArr[$day_id];
																		C::t('#tom_love#tom_love')->update($__UserInfo['id'], $updateData);
																		$insertData = array();
																		$insertData['user_id'] = $__UserInfo['id'];
																		$insertData['score_value'] = $rec_scoreArr[$day_id];
																		$insertData['log_type'] = 7;
																		$insertData['log_time'] = TIMESTAMP;
																		C::t('#tom_love#tom_love_scorelog')->insert($insertData);
																	} else {
																		$updateData = array();
																		$updateData['recommend_time'] = $recommend_time;
																		$updateData['recommend_do_time'] = TIMESTAMP;
																		C::t('#tom_love#tom_love')->update($__UserInfo['id'], $updateData);
																	}
																	$updateData = array();
																	$updateData['recommend'] = 1;
																	C::t('#tom_love#tom_love')->update($__UserInfo['id'], $updateData);
																	echo json_encode($outArr);
																	exit(0);
																}
																if ($__UserInfo['recommend_time'] > 0) {
																	$recommendTime = dgmdate($__UserInfo['recommend_time'], 'Y-m-d', $tomSysOffset);
																} else {
																	$recommendTime = ' - - ';
																}
																$recUrl = 'plugin.php?id=tom_love&mod=rec&act=addrec';
																$isGbk = false;
																if (CHARSET == 'gbk') {
																	$isGbk = true;
																}
																include template('tom_love:rec');
															} else {
																if ($_GET['mod'] == 'noxiao') {
																	$isGbk = false;
																	if (CHARSET == 'gbk') {
																		$isGbk = true;
																	}
																	include template('tom_love:noxiao');
																} else {
																	if ($_GET['mod'] == 'shop') {
																		include DISCUZ_ROOT . './source/plugin/tom_love/module/shop.php';
																	} else {
																		if ($_GET['mod'] == 'shuoshuo') {
																			include DISCUZ_ROOT . './source/plugin/tom_love/module/shuoshuo.php';
																		} else {
																			if ($_GET['mod'] == 'sms') {
																				include DISCUZ_ROOT . './source/plugin/tom_love/module/sms.php';
																			} else {
																				if ($_GET['mod'] == 'my') {
																					include DISCUZ_ROOT . './source/plugin/tom_love/module/my.php';
																				} else {
																					if ($_GET['mod'] == 'phone') {
																						include DISCUZ_ROOT . './source/plugin/tom_love/module/phone.php';
																					} else {
																						if ($_GET['mod'] == 'upload') {
																							include DISCUZ_ROOT . './source/plugin/tom_love/module/upload.php';
																						} else {
																							if ($_GET['mod'] == 'sms_old') {
																								include DISCUZ_ROOT . './source/plugin/tom_love/module/sms_old.php';
																							} else {
																								if ($_GET['mod'] == 'shuoshuoinfo') {
																									include DISCUZ_ROOT . './source/plugin/tom_love/module/shuoshuoinfo.php';
																								} else {
																									dheader('location:' . $_G['siteurl'] . 'plugin.php?id=tom_love&mod=index');
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
					}
				}
			}
		}
	}
}
tomoutput();
