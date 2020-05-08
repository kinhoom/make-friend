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
<title><?php echo $jyConfig['plugin_name'];?></title>
<meta name="description" content=""/>
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link href="source/plugin/tom_love/images/style.css?v=<?php echo $cssJsVersion;?>" rel="stylesheet" type="text/css">
<script src="source/plugin/tom_love/images/jquery.js" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_love/images';
</script>
<script src="source/plugin/tom_love/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script>
<base target="_self">
</head>
<body>
<header class="header_style2 clearfix">
<a href="plugin.php?id=tom_love&amp;mod=my">返回</a>
<h1><?php echo $jyConfig['score_name'];?>充值</h1>
</header>
<?php if($jyConfig['score_recharge'] == 1 && $__UserInfo['bbs_uid'] > 0 ) { ?>
<div class="score-menu">
    <div class="item"><a class="on" href="plugin.php?id=tom_love&amp;mod=scorepay">在线支付充值</a></div>
    <div class="item"><a  href="plugin.php?id=tom_love&amp;mod=score">论坛积分充值</a></div>
</div>
<?php } ?>
<header class="score_box clearfix">
<div class="score_top_box clearfix">
    	<figure><img src="source/plugin/tom_love/images/jinbi_ico.png"></figure>
        <article>
        	<header>我的<?php echo $jyConfig['score_name'];?>:</header>
            <footer><?php echo $__UserInfo['score'];?> <?php echo $jyConfig['score_name'];?></footer>
        </article>
    </div>
    <div class="box_both clearfix"></div>

    <div class="score_recharge_box from_class clearfix">
    <form id="payForm">
        <table>
          <colgroup><col width="25%"><col><col width="75%"><col></colgroup>
          <tbody>
          <tr>
              <td>充值<?php echo $jyConfig['score_name'];?>:</td>
              <td>
                    <select name="pay_price">
                        <?php if(is_array($yuan_scoreArr)) foreach($yuan_scoreArr as $key => $val) { ?>                        <option value="<?php echo $key;?>"><?php echo $val;?><?php echo $jyConfig['score_name'];?>，<?php echo $key;?>元</option>
                        <?php } ?>
                    </select>
                  <input type="hidden" name="openid" value="<?php echo $openid;?>">
                  <input type="hidden" name="user_id" value="<?php echo $__UserInfo['id'];?>">
                  <input type="hidden" name="formhash" value="<?php echo $formhash;?>">
              </td>
          </tr>
          </tbody>
      </table>
      </form>
    </div>
    <div class="score_recharge_btn clearfix">
    	<a href="javascript:void(0);" class="id_pay_btn">立刻充值</a>
    </div>
    <div class="box_both clearfix"></div>
    <div class="score_more_box clearfix"><?php echo $scoreString;?></div>
    <div class="score_log clearfix">
        <header><?php echo $jyConfig['score_name'];?>变更记录</header>
        <section>
            <ul class="clearfix">
                <?php if(is_array($scorelogList)) foreach($scorelogList as $key => $value) { ?>            	<li>
                    
                    <?php if($value['log_type'] == 1) { ?>论坛积分充值<?php } ?>
                    <?php if($value['log_type'] == 2) { ?>在线支付充值<?php } ?>
                    <?php if($value['log_type'] == 3) { ?>分享获得<?php } ?>
                    <?php if($value['log_type'] == 4) { ?>完善资料奖励<?php } ?>
                    <?php if($value['log_type'] == 5) { ?>每天签到奖励<?php } ?>
                    <?php if($value['log_type'] == 6) { ?>申请认证消耗<?php } ?>
                    <?php if($value['log_type'] == 7) { ?>申请首页推荐消耗<?php } ?>
                    <?php if($value['log_type'] == 8) { ?>暗恋消耗<?php } ?>
                    <?php if($value['log_type'] == 9) { ?>查看联系方式消耗<?php } ?>
                    <?php if($value['log_type'] == 10) { ?>打招呼消耗<?php } ?>
                    <?php if($value['log_type'] == 11) { ?>送鲜花消耗<?php } ?>
                    <?php if($value['log_type'] == 12) { ?>发布话题消耗<?php } ?>
                    <?php if($value['log_type'] == 13) { ?>发送消息消耗<?php } ?>
                    <?php if($value['log_type'] == 14) { ?>送礼物消耗<?php } ?>
                    <?php if($value['log_type'] == 15) { ?>后台变更<?php } ?>
                    <font color="#fd0d0d"><?php echo $value['score_value'];?><?php echo $jyConfig['score_name'];?></font><span><?php echo dgmdate($value[log_time], 'u');?></span></li>
                <?php } ?>
            </ul>
        </section>
    </div>
    <div class="pages clearfix">
    	<ul class="clearfix">
          <li><?php if($page > 1) { ?><a href="<?php echo $prePageUrl;?>">上一页</a><?php } else { ?><span>上一页</span><?php } ?></li>
          <li><?php if($showNextPage == 1) { ?><a href="<?php echo $nextPageUrl;?>">下一页</a><?php } else { ?><span>下一页</span><?php } ?></li>
      </ul>
    </div>
</header>
<script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" type="text/javascript"></script>
<script>
var submintPayStatus = 0;
$(".id_pay_btn").click( function () { 
    if(submintPayStatus == 1){
        return false;
    }
    loading('下单中...');
    submintPayStatus = 1;
    $.ajax({
        type: "GET",
        url: "<?php echo $payUrl;?>",
        dataType : "json",
        data: $('#payForm').serialize(),
        success: function(data){
            loading(false);
            if(data.status == 200) {
                if(data.pay_status == 1) {
                    tusi("下单成功，立即支付");
                    setTimeout(function(){window.location.href=data.payurl+"&prand=<?php echo $prand;?>";},500);
                }else{
                    submintPayStatus = 0;
                    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                }
            }else if(data.status == 301){
                tusi("用户不存在");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 302){
                tusi("订单金额不正确");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 303){
                tusi("没有安装[点微]支付中心插件");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 304){
                tusi("订单写入失败");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else{
                tusi("生成订单异常");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }
        }
    });
});
$(document).ready(function(){
  $.get("<?php echo $ajaxClicksUrl;?>");
});

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