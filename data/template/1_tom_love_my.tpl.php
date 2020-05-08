<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<!DOCTYPE html>
<html>
<head>
<?php if($isGbk) { ?>
<meta http-equiv="Content-Type" content="text/html; charset=GBK">
<?php } else { ?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php } ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0 , maximum-scale=1.0, user-scalable=0">
<title>基本资料-<?php echo $jyConfig['plugin_name'];?></title>
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link href="source/plugin/tom_love/images/style.css?v=<?php echo $cssJsVersion;?>" rel="stylesheet" type="text/css">
<script src="source/plugin/tom_love/images/jquery.js" type="text/javascript"></script>
<script src="source/plugin/tom_love/images/layer_mobile/layer.js?v=<?php echo $cssJsVersion;?>" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_love/images';
</script>
<script src="source/plugin/tom_love/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script>
<style>
    .layui-m-layer0 .layui-m-layerchild{width: 70%;}
    .layui-m-layercont{padding: 5px 3px;}
</style>
</head>
<body>
<?php if($myBox == 1) { ?>
<header class="header_style2 clearfix" style="display:none;">
<h1>基本资料</h1>
</header>
<section class="my_box clearfix">
<div class="my_top_box clearfix">
        <span class="avatar"><a href="plugin.php?id=tom_love&amp;mod=avatar">点击修改头像</a></span>
    	<figure><a href="plugin.php?id=tom_love&amp;mod=avatar"><img src="<?php echo $__UserInfo['avatar'];?>"/></a></figure>
        <article>
            <header>
                <h1 class="woman"></h1>
                <h2>
                    <?php if($__UserInfo['nickname'] == '') { ?>未填写昵称<?php } else { ?><?php echo $__UserInfo['nickname'];?><?php } ?>
                    <span class="userid">(ID:<?php echo $__UserInfo['id'];?>)</span>
                    <?php if($__UserInfo['subscribe'] == 0 && $jyConfig['open_subscribe'] == 1) { ?><span class="online_no">离线</span><?php } elseif(($__UserInfo['subscribe'] == 1) && ($jyConfig['open_subscribe'] == 1)) { ?><span class="online_ok">在线</span><?php } ?>
                </h2>
                <?php if($__UserInfo['renzheng'] == 1) { ?><img src="source/plugin/tom_love/images/info_rengzheng.png" width="auto" height="16"><?php } ?>
                <?php if($__UserInfo['vip_id'] == 1) { ?><img src="source/plugin/tom_love/images/info_vip.png" width="16" height="auto"><?php } ?>
                <?php if($jyConfig['open_tel_renzheng'] == 1 && $__UserInfo['phone_renzheng'] == 1) { ?><img src="source/plugin/tom_love/images/info_phone.png" width="16" height="auto"><?php } ?>
            </header>
            <section>
                <p>性别:<?php if($__UserInfo['sex'] == 1) { ?>男,<?php } if($__UserInfo['sex'] == 2) { ?>女,<?php } if($age) { ?> 年龄:<?php echo $age;?><?php } ?></p>
                <p><?php echo $__UserInfo['area'];?></p>
            </section>
            <footer>
                <span class="home"><a href="plugin.php?id=tom_love&amp;mod=info&amp;uid=<?php echo $__UserInfo['id'];?>">我的主页</a></span>
            	<span class="edit"><a href="plugin.php?id=tom_love&amp;mod=my&amp;act=info">点击修改资料</a></span>
            </footer>
        </article>
    </div>
    <?php if($showWanshanBtn == 1) { ?>
    <div class="wanshan_info_btn  clearfix">
    	<a href="plugin.php?id=tom_love&amp;mod=my&amp;act=info">完善资料奖励<?php echo $jyConfig['zl_reward_score'];?><?php echo $jyConfig['score_name'];?></a>
    </div>
    <?php } ?>
    <div class="box_both clearfix"></div>
    <div class="my_sign_box">
    	<div class="my_sign_box_left">本月累计签到<span><?php echo $signCount;?></span>天数</div>
        <div class="my_sign_box_right">
            <?php if($isTodaySignCount > 0 ) { ?>
            <div class="my_sign_box_btn2">今日已签到</div>
            <?php } else { ?>
            <div class="my_sign_box_btn1" onclick="signInfo();">+&nbsp;签 到</div>
            <?php } ?>
        </div>
    </div>
    <section class="my_tongji_box clearfix">
      <ul class="clearfix">
          <li>
              <a href="plugin.php?id=tom_love&amp;mod=guanxi&amp;act=meanlian">
              <p class="num"><font color="#FE4C6E"><?php echo $meanlianCount;?></font></p>
              <p class="title">我的暗恋</p>
              </a>
          </li>
          <li>
              <a href="plugin.php?id=tom_love&amp;mod=guanxi&amp;act=anlianme">
              <p class="num"><font color="#FE4C6E"><?php echo $anlianmeCount;?></font></p>
              <p class="title">暗恋我的</p>
              </a>
          </li>
          <li>
              <a href="plugin.php?id=tom_love&amp;mod=guanxi&amp;act=mechakan">
              <p class="num"><font color="#FE4C6E"><?php echo $meChakanCount;?></font></p>
        	  <p class="title">我看过谁</p>
              </a>
          </li>
          <li>
              <a href="plugin.php?id=tom_love&amp;mod=guanxi&amp;act=chakanme">
              <p class="num"><font color="#FE4C6E"><?php echo $chakanMeCount;?></font></p>
        	  <p class="title">谁看过我</p>
              </a>
          </li>
    </ul>
    </section>
    <div class="my_menu_box clearfix">
    	<ul>
            <?php if($jyConfig['open_tongcheng'] == 1 ) { ?>
            <li><a href="plugin.php?id=tom_love&amp;mod=sms">我的消息<span class="go"><?php if($noReadNum > 0) { ?><span class="smsnum"><?php echo $noReadNum;?></span><?php } ?></a></li>
            <?php } ?>
            <li><a href="plugin.php?id=tom_love&amp;mod=scorepay">我的<?php echo $jyConfig['score_name'];?><span class="msg">(<?php echo $__UserInfo['score'];?><?php echo $jyConfig['score_name'];?>)</span><span class="go">充值</span></a></li>
            <li><a href="plugin.php?id=tom_love&amp;mod=vippay">充值会员<span class="msg">(<?php if($__UserInfo['vip_id'] == 1) { ?>黄金会员<?php } else { ?>普通会员<?php } ?>)</span><span class="go">充值</span></a></li>
            <li><a href="plugin.php?id=tom_love&amp;mod=flowerslog">我的鲜花<span class="msg">(<?php echo $__UserInfo['flowers'];?>朵)</span><span class="go">查看</span></a></li>
        </ul>
    </div>
    
    <div class="my_menu_box clearfix">
    	<ul>
            <?php if($__UserInfo['subscribe'] == 0 && $jyConfig['open_subscribe'] == 1) { ?>
            <li>
                <a href="javascript:void(0);" onclick="online();"><font color="#0894fb">开启在线状态</font>
                    <span class="go">开启</span>
                </a>
            </li>
            <?php } ?>
            <li>
                <a href="plugin.php?id=tom_love&amp;mod=rec">我要上首页
                    <?php if($__UserInfo['recommend_time'] > 0 && $__UserInfo['recommend'] == 1) { ?>
                    <span class="msg">(<?php echo $recommendTime;?>)</span>
                    <?php } ?>
                    <span class="go">申请</span>
                </a>
            </li>
            <li>
                <a href="plugin.php?id=tom_love&amp;mod=photo">我的相册
                    <span class="msg">(<?php echo $__UserInfo['pic_num'];?>张)</span>
                    <span class="go">上传</span>
                </a>
            </li>
            <?php if($jyConfig['open_tel_renzheng'] == 1) { ?>
            <li><a href="plugin.php?id=tom_love&amp;mod=phone">手机认证<?php if($__UserInfo['phone_renzheng'] == 1) { ?><span class="msg">(已认证)</span><?php } ?><span class="go">申请</span></a></li>
            <?php } ?>
            <li>
                <a href="plugin.php?id=tom_love&amp;mod=renzheng">实名认证
                    <?php if($renzhengStatus == 0) { ?>
                    <?php } elseif($renzhengStatus == 1) { ?>
                    <span class="msg">(已认证)</span>
                    <?php } elseif($renzhengStatus == 2) { ?>
                    <span class="msg">(审核中)</span>
                    <?php } ?>
                    <span class="go">申请</span>
                </a>
            </li>
            <?php if($jyConfig['closed_tel_qq']==0 ) { ?>
            <?php if($__UserInfo['closed'] == 1) { ?>
            <li>
                <a href="javascript:void(0);" onclick="closeInfo(0);">联系方式
                    <span class="msg">(已关闭)</span><span class="go">公开</span>
                </a>
            </li>
            <?php } else { ?>
            <li><a href="javascript:void(0);" onclick="closeInfo(1);">联系方式
                    <span class="msg">(已开启)</span><span class="go">关闭</span>
                </a>
            </li>
            <?php } ?>
            <?php } ?>
            <?php if($__UserInfo['smstp_open'] == 1) { ?>
            <li>
                <a href="javascript:void(0);" onclick="closeSmstp(0);">消息通知
                    <span class="msg">(已开启)</span><span class="go">关闭</span>
                </a>
            </li>
            <?php } else { ?>
            <li>
                <a href="javascript:void(0);" onclick="closeSmstp(1);">消息通知
                    <span class="msg">(已关闭)</span><span class="go">开启</span>
                </a>
            </li>
            <?php } ?>
            <li><a href="plugin.php?id=tom_love&amp;mod=theme">修改主题<span class="go">上传</span></a></li>
        </ul>
    </div>
    
    <div class="my_menu_box clearfix">
    	<ul>
            <li><a href="plugin.php?id=tom_love&amp;mod=article&amp;aid=1">关于我们<span class="go"></span></a></li>
            <li><a href="plugin.php?id=tom_love&amp;mod=article&amp;aid=2">用户协议<span class="go"></span></a></li>
        </ul>
    </div>
    <?php if($jyConfig['open_ucenter'] == 1) { ?>
    <?php } else { ?>
    <div class="edit_form_btn  id_close_info clearfix">
    	<a href="plugin.php?id=tom_love:register&amp;act=loginOut">退出登录</a>
    </div>
    <?php } ?>
</section><?php include template('tom_love:footer'); } if($infoBox == 1) { ?>
<header class="header_style2 clearfix">
<a href="plugin.php?id=tom_love&amp;mod=my">返回</a>
<h1>完善资料</h1>
</header>
<section class="edit_box clearfix">
<div class="edit_form_box from_class clearfix">
    	<form id="info_base" method="post" action="" onsubmit="return false;">
            <table>
                <colgroup><col width="30%"><col><col width="70%"><col></colgroup>
                <tbody>
                <tr>
                    <td>昵　　称:<font color="#F60">*</font></td>
                    <td><input type="text" id="nickname" name="nickname" value="<?php echo $__UserInfo['nickname'];?>" placeholder="填写昵称" class="input_text"></td>
                </tr>
                <tr>
                    <td>交友类别:<font color="#F60">*</font></td>
                    <td>
                        <label class="input_checkbox"><input type="checkbox" name="friend" id="friend" value="1" <?php if($__UserInfo['friend'] == 1) { ?>checked<?php } ?>>交友</label>
                        <label class="input_checkbox"><input type="checkbox" name="marriage" id="marriage" value="1" <?php if($__UserInfo['marriage'] == 1) { ?>checked<?php } ?>>婚恋</label>
                    </td>
                </tr>
                <tr>
                    <td>性　　别:<font color="#F60">*</font></td>
                    <td>
                        <select id="sex" name="sex">
                            <option value="0">请选择</option>
                            <option value="1" <?php if($__UserInfo['sex'] == 1) { ?>selected<?php } ?>>男</option>
                            <option value="2" <?php if($__UserInfo['sex'] == 2) { ?>selected<?php } ?>>女</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>出生年份:<font color="#F60">*</font></td>
                    <td>
                        <select id="year" name="year">
                            <option value="0">请选择</option>
                            <?php if(is_array($yearArray)) foreach($yearArray as $key => $val) { ?>                            <option value="<?php echo $val;?>" <?php if($__UserInfo['year'] == $val) { ?>selected<?php } ?>><?php echo $val;?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>婚姻状况:<font color="#F60">*</font></td>
                    <td>
                        <select id="marital" name="marital">
                            <option value="0">请选择</option>
                            <?php if(is_array($maritalArray)) foreach($maritalArray as $key => $value) { ?>                            <option value="<?php echo $key;?>" <?php if($__UserInfo['marital_id'] == $key) { ?>selected<?php } ?>><?php echo $value;?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>身高(厘米):</td>
                    <td><input type="number" name="height" value="<?php echo $__UserInfo['height'];?>" placeholder="请填写身高" class="input_text"></td>
                </tr>
                <tr>
                    <td>体重(KG):</td>
                    <td><input type="number" name="weight" value="<?php echo $__UserInfo['weight'];?>" placeholder="请填写体重" class="input_text"></td>
                </tr>
                <tr>
                    <td>居住地区:<font color="#F60">*</font></td>
                    <td>
                        <select name="country" id="country" style="display: none;">
                            <option value="0">中国</option>
                        </select>
                        <select name="province" id="province" onchange="getCity();"  style="margin-top: 5px; display: inline-block;">
                            <option value="0">全部</option>
                            <?php if(is_array($provinceList)) foreach($provinceList as $key => $value) { ?>                            <option value="<?php echo $value['id'];?>" <?php if($__UserInfo['province_id'] == $value['id']) { ?>selected<?php } ?>><?php echo $value['name'];?></option>
                            <?php } ?>
                        </select>
                        <select name="city" id="city" onchange="getArea();" style="margin-top: 5px; display: inline-block; <?php if($__UserInfo['province_id'] == 0 ) { ?>display: none;<?php } ?>">
                            <option value="0">全部</option>
                            <?php if(is_array($cityList)) foreach($cityList as $key => $value) { ?>                            <option value="<?php echo $value['id'];?>" <?php if($__UserInfo['city_id'] == $value['id']) { ?>selected<?php } ?>><?php echo $value['name'];?></option>
                            <?php } ?>
                        </select>
                        <select name="area" id="area"  onchange="getTowns();" style="margin-top: 5px; display: inline-block; <?php if($__UserInfo['city_id'] == 0 ) { ?>display: none;<?php } ?> ">
                            <option value="0">全部</option>
                            <?php if(is_array($areaList)) foreach($areaList as $key => $value) { ?>                            <option value="<?php echo $value['id'];?>" <?php if($__UserInfo['area_id'] == $value['id']) { ?>selected<?php } ?>><?php echo $value['name'];?></option>
                            <?php } ?>
                        </select>
                        <?php if($jyConfig['open_four_district'] == 1) { ?>
<select name="towns" id="towns" style="margin-top: 5px; display: inline-block; <?php if($__UserInfo['area_id'] == 0 ) { ?>display: none;<?php } ?>" >
                            <option value="0">全部</option>
                            <?php if(is_array($townsList)) foreach($townsList as $key => $value) { ?>                            <option value="<?php echo $value['id'];?>" <?php if($__UserInfo['towns_id'] == $value['id']) { ?>selected<?php } ?>><?php echo $value['name'];?></option>
                            <?php } ?>
                        </select>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>户籍地区:</td>
                    <td>
                        <select name="hjcountry" id="hjcountry" style="display: none;">
                            <option value="0">中国</option>
                        </select>
                        <select name="hjprovince" id="hjprovince" onchange="gethjCity();"  style="margin-top: 5px; display: inline-block;">
                            <option value="0">全部</option>
                            <?php if(is_array($hjprovinceList)) foreach($hjprovinceList as $key => $value) { ?>                            <option value="<?php echo $value['id'];?>" <?php if($__UserInfo['hjprovince_id'] == $value['id']) { ?>selected<?php } ?>><?php echo $value['name'];?></option>
                            <?php } ?>
                        </select>
                        <select name="hjcity" id="hjcity" onchange="gethjArea();" style="margin-top: 5px; display: inline-block; <?php if($__UserInfo['hjprovince_id'] == 0 ) { ?>display: none;<?php } ?> ">
                            <option value="0">全部</option>
                            <?php if(is_array($hjcityList)) foreach($hjcityList as $key => $value) { ?>                            <option value="<?php echo $value['id'];?>" <?php if($__UserInfo['hjcity_id'] == $value['id']) { ?>selected<?php } ?>><?php echo $value['name'];?></option>
                            <?php } ?>
                        </select>
                        <select name="hjarea" id="hjarea" onchange="gethjTowns();"  style="margin-top: 5px; display: inline-block; <?php if($__UserInfo['hjcity_id'] == 0 ) { ?>display: none;<?php } ?> ">
                            <option value="0">全部</option>
                            <?php if(is_array($hjareaList)) foreach($hjareaList as $key => $value) { ?>                            <option value="<?php echo $value['id'];?>" <?php if($__UserInfo['hjarea_id'] == $value['id']) { ?>selected<?php } ?>><?php echo $value['name'];?></option>
                            <?php } ?>
                        </select>
                        <?php if($jyConfig['open_four_district'] == 1) { ?>
<select name="hjtowns" id="hjtowns" style="margin-top: 5px; display: inline-block; <?php if($__UserInfo['hjarea_id'] == 0 ) { ?>display: none;<?php } ?>" >
                            <option value="0">全部</option>
                            <?php if(is_array($hjtownsList)) foreach($hjtownsList as $key => $value) { ?>                            <option value="<?php echo $value['id'];?>" <?php if($__UserInfo['hjtowns_id'] == $value['id']) { ?>selected<?php } ?>><?php echo $value['name'];?></option>
                            <?php } ?>
                        </select>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>职　　业:</td>
                    <td>
                        <select name="job">
                            <option value="0">请选择</option>
                            <?php if(is_array($worksArray)) foreach($worksArray as $key => $value) { ?>                            <option value="<?php echo $key;?>" <?php if($__UserInfo['work_id'] == $key) { ?>selected<?php } ?>><?php echo $value;?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>学　　历:</td>
                    <td>
                        <select name="edu">
                            <option value="0">请选择</option>
                            <?php if(is_array($eduArray)) foreach($eduArray as $key => $value) { ?>                            <option value="<?php echo $key;?>" <?php if($__UserInfo['edu_id'] == $key) { ?>selected<?php } ?>><?php echo $value;?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>月收入:</td>
                    <td>
                        <select name="pay">
                            <option value="0">请选择</option>
                            <?php if(is_array($payArray)) foreach($payArray as $key => $value) { ?>                            <option value="<?php echo $key;?>" <?php if($__UserInfo['pay_id'] == $key) { ?>selected<?php } ?>><?php echo $value;?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>微 信 号:<font color="#F60">*</font></td>
                    <td><input type="text" name="wx" id="wx" value="<?php echo $__UserInfo['wx'];?>" class="input_text"></td>
                </tr>
                <tr>
                    <td>QQ号码:</td>
                    <td><input type="text" name="qq" id="qq" value="<?php echo $__UserInfo['qq'];?>" class="input_text"></td>
                </tr>
                <tr>
                    <td>手 机 号:</td>
                    <td><input type="text" name="tel" value="<?php echo $__UserInfo['tel'];?>" class="input_text" <?php if($__UserInfo['phone_renzheng'] == 1) { ?>readonly<?php } ?>></td>
                </tr>
                <tr>
                    <td>交友宣言:<font color="#F60">*</font></td>
                    <td>
                        <textarea name="describe" id="describe" rows="4" placeholder="不要超过100个字"><?php echo $__UserInfo['describe'];?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>择偶要求:</td>
                    <td>
                        <textarea name="mate_demands" id="mate_demands" rows="4" placeholder="不要超过100个字"><?php echo $__UserInfo['mate_demands'];?></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <input type="hidden" name="act" value="saveInfo">
                        <input type="hidden" name="formhash" value="<?php echo $formhash;?>">
                    </td>
                </tr>
            </tbody>
            </table>
        </form>
    </div>
    <div class="id_edit_form_btn edit_form_btn clearfix">
    	<a href="javascript:void(0);">保存资料</a>
    </div>
</section>
<!-- info end -->
<?php } ?>
<script>
function online(){
    layer.open({
        content: '<img src="<?php echo $jyConfig['fuwuhao_qrcode'];?>"><p>长按识别后，头像显示在线状态<p/>'
        ,btn: '知道了'
      });
}

function closeInfo(closeId){
    $.ajax({
        type: "GET",
        url: "<?php echo $closeUrl;?>",
        data: "close="+closeId,
        success: function(msg){
            if(closeId == 0){
                tusi("开启成功");
            }else{
                tusi("关闭成功");
            }
            setTimeout(function(){document.location.reload();},1888);
        }
    });
}
function closeSmstp(smstp_openId){
    $.ajax({
        type: "GET",
        url: "<?php echo $opensmstpUrl;?>",
        data: "smstp_open="+smstp_openId,
        success: function(msg){
            if(smstp_openId == 1){
                tusi("开启成功");
            }else{
                tusi("关闭成功");
            }
            setTimeout(function(){document.location.reload();},1888);
        }
    });
}

var signFlag = 0;
function signInfo(){
    if(signFlag == 1){
        return false;
    }
    signFlag = 1;
    $.ajax({
        type: "GET",
        url: "<?php echo $signUrl;?>",
        data: "xxxxx="+1,
        success: function(msg){
            tusi("签到成功，奖励<?php echo $jyConfig['sign_score'];?><?php echo $jyConfig['score_name'];?>");
            setTimeout(function(){window.location.href=window.location.href+"&p=1";},1888);
        }
    });
}

$(document).ready(function(){
    <?php if($__UserInfo['status'] == 2) { ?>
    tusi("你的账号已经被封禁");
    <?php } ?>
    <?php if($jyConfig['open_user_shenhe'] == 1 && $__UserInfo['shenhe_status'] == 1) { ?>
    tusi("账号审核中,请先完善资料");
    <?php } ?>
    <?php if($jyConfig['open_user_shenhe'] == 1 && $__UserInfo['shenhe_status'] == 3) { ?>
    tusi("账号审核未通过");
    <?php } ?>
    <?php if($_GET['mustinfo'] == 1) { ?>
    tusi("完善资料后才能继续访问");
    <?php } ?>
    $.get("<?php echo $ajaxClicksUrl;?>");
});

$(".id_edit_form_btn").click( function () { 
    var nickname    = $("#nickname").val();
    var sex         = $("#sex").val();
    var year        = $("#year").val();
    var marital     = $("#marital").val();
    var province    = $("#province").val();
    var city        = $("#city").val();
    var area        = $("#area").val();
    var hjprovince    = $("#hjprovince").val();
    var hjcity        = $("#hjcity").val();
    var hjarea        = $("#hjarea").val();
    var wx          = $("#wx").val();
    var qq          = $("#qq").val();
    var describe    = $("#describe").val();
    var mate_demands = $("#mate_demands").val();
    
    if($('#friend').is(':checked')){
    }else if($('#marriage').is(':checked')){
    }else{
        tusi("请选择交友类别!");
        return false;
    }

    if(nickname == ""){
        tusi("请填写昵称!");
        return false;
    }
    if(sex == 0){
        tusi("请选择性别!");
        return false;
    }
    if(year == 0){
        tusi("请选择出生年份!");
        return false;
    }
    if(marital == 0){
        tusi("请填写婚姻状况!");
        return false;
    }
    if(province == 0){
        tusi("请填写居住省份!");
        return false;
    }
    if(city == 0){
        tusi("请填写居住城市!");
        return false;
    }
    if(hjprovince == 0){
        //tusi("请填写户籍省份!");
        //return false;
    }
    if(hjcity == 0){
        //tusi("请填写户籍城市!");
        //return false;
    }
    <?php if($jyConfig['open_four_district'] == 1) { ?>
    if(area == 0){
        tusi("请填写居住州县!");
        return false;
    }
    if(hjarea == 0){
        //tusi("请填写户籍州县!");
        //return false;
    }
    <?php } ?>
    if(wx == ""){
        tusi("微信号必须填写!");
        return false;
    }
    if(qq == ""){
        //tusi("QQ号必须填写!");
        //return false;
    }
    if(describe == ""){
        tusi("请填写交友宣言!");
        return false;
    }
    $.ajax({
        type: "POST",
        url: "<?php echo $saveUrl;?>",
        data: $('#info_base').serialize(),
        success: function(msg){
            if(msg == '201'){
                tusi("昵称已存在，请重新填写");
            }else if(msg == '202'){
                tusi("昵称不能出现11位纯数字");
            }else{
                tusi("个人信息更新成功!");
                setTimeout(function(){window.location.href='<?php echo $backUrl;?>';},1888);
            }
        }
    });
});

function getCity(){
  var province = $("#province").val();
  $.ajax({
        type: "GET",
        url: "plugin.php?id=tom_love:ajax",
        data: "act=city&pid="+province,
        dataType : "jsonp",
        jsonpCallback:"jsonpCallback",
        cache : false,
        success: function(json){
            
            var cityHtml = '<option value="0">请选择城市</option>';
            $.each(json,function(k,v){
                cityHtml+= '<option value="'+v.id+'">'+v.name+'</option>';
            })
            $("#city").html(cityHtml);
            $("#city").show();
        }
    });
}   

function getArea(){
  var city = $("#city").val();
  $.ajax({
        type: "GET",
        url: "plugin.php?id=tom_love:ajax",
        data: "act=area&pid="+city,
        dataType : "jsonp",
        jsonpCallback:"jsonpCallback",
        cache : false,
        success: function(json){
            var areaHtml = '<option value="0">请选择区/县</option>';
            $.each(json,function(k,v){
                areaHtml+= '<option value="'+v.id+'">'+v.name+'</option>';
            })
            $("#area").html(areaHtml);
            $("#area").show();
        }
    });
}

function getTowns(){
  var area = $("#area").val();
  $.ajax({
        type: "GET",
        url: "plugin.php?id=tom_love:ajax",
        data: "act=towns&pid="+area,
        dataType : "jsonp",
        jsonpCallback:"jsonpCallback",
        cache : false,
        success: function(json){
            var areaHtml = '<option value="0">请选择镇/街道</option>';
            $.each(json,function(k,v){
                areaHtml+= '<option value="'+v.id+'">'+v.name+'</option>';
            })
            $("#towns").html(areaHtml);
            $("#towns").show();
        }
    });
}

function gethjCity(){
  var province = $("#hjprovince").val();
  $.ajax({
        type: "GET",
        url: "plugin.php?id=tom_love:ajax",
        data: "act=city&pid="+province,
        dataType : "jsonp",
        jsonpCallback:"jsonpCallback",
        cache : false,
        success: function(json){
            var cityHtml = '<option value="0">请选择城市</option>';
            $.each(json,function(k,v){
                cityHtml+= '<option value="'+v.id+'">'+v.name+'</option>';
            })
            $("#hjcity").html(cityHtml);
            $("#hjcity").show();
        }
    });
}   

function gethjArea(){
  var city = $("#hjcity").val();
  $.ajax({
        type: "GET",
        url: "plugin.php?id=tom_love:ajax",
        data: "act=area&pid="+city,
        dataType : "jsonp",
        jsonpCallback:"jsonpCallback",
        cache : false,
        success: function(json){
            var areaHtml = '<option value="0">请选择区/县</option>';
            $.each(json,function(k,v){
                areaHtml+= '<option value="'+v.id+'">'+v.name+'</option>';
            })
            $("#hjarea").html(areaHtml);
            $("#hjarea").show();
        }
    });
}

function gethjTowns(){
  var hjarea = $("#hjarea").val();
  $.ajax({
        type: "GET",
        url: "plugin.php?id=tom_love:ajax",
        data: "act=towns&pid="+hjarea,
        dataType : "jsonp",
        jsonpCallback:"jsonpCallback",
        cache : false,
        success: function(json){
            var areaHtml = '<option value="0">请选择镇/街道</option>';
            $.each(json,function(k,v){
                areaHtml+= '<option value="'+v.id+'">'+v.name+'</option>';
            })
            $("#hjtowns").html(areaHtml);
            $("#hjtowns").show();
        }
    });
}

</script>
<script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" type="text/javascript"></script>
<script>
wx.config({
    debug: false,
    appId: '<?php echo $wxJssdkConfig["appId"];?>',
    timestamp: <?php echo $wxJssdkConfig["timestamp"];?>,
    nonceStr: '<?php echo $wxJssdkConfig["nonceStr"];?>',
    signature: '<?php echo $wxJssdkConfig["signature"];?>',
    jsApiList: [
      'onMenuShareTimeline',
      'onMenuShareAppMessage'
    ]
});
wx.ready(function () {
    wx.onMenuShareTimeline({
        title: '<?php echo $shareTitle;?>',
        link: '<?php echo $shareUrl;?>', 
        imgUrl: '<?php echo $shareLogo;?>', 
        success: function () { 
            $.get("<?php echo $shareAjaxUrl;?>");
        },
        cancel: function () { 
        }
    });
    wx.onMenuShareAppMessage({
        title: '<?php echo $shareTitle;?>',
        desc: '<?php echo $shareDesc;?>',
        link: '<?php echo $shareUrl;?>',
        imgUrl: '<?php echo $shareLogo;?>',
        type: 'link',
        dataUrl: '',
        success: function () { 
            $.get("<?php echo $shareAjaxUrl;?>");
        },
        cancel: function () { 
        }
    });
});
</script>
</body>
</html>