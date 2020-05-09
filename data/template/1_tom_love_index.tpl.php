<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<!DOCTYPE html><html>
<head>
<?php if($isGbk) { ?>
<meta http-equiv="Content-Type" content="text/html; charset=GBK">
<?php } else { ?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php } ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0 , maximum-scale=1.0, user-scalable=0">
<title><?php echo $jyConfig['plugin_name'];?></title>
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link href="source/plugin/tom_love/images/style.css?v=<?php echo $cssJsVersion;?>" rel="stylesheet" type="text/css">
<link href="source/plugin/tom_love/images/newstyle.css?v=<?php echo $cssJsVersion;?>" rel="stylesheet" type="text/css">
<link href="source/plugin/tom_love/images/swiper.min.css?v=<?php echo $cssJsVersion;?>" rel="stylesheet" />
<script src="source/plugin/tom_love/images/swiper.min.js" type="text/javascript"></script>
<script src="source/plugin/tom_love/images/jquery.js" type="text/javascript"></script>
<script src="source/plugin/tom_love/images/layer_mobile/layer.js?v=<?php echo $cssJsVersion;?>" type="text/javascript"></script>
<script type="text/javascript">var commonjspath = 'source/plugin/tom_love/images';</script>
<script src="source/plugin/tom_love/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript"></script>
<script src="source/plugin/tom_love/images/global.js?v=<?php echo $cssJsVersion;?>" type="text/javascript"></script>
<style>
.layui-m-layer0 .layui-m-layerchild{width: 70%;}
.layui-m-layercont{padding: 5px 3px;}
<?php if($__Android == 1) { ?>
.new-list .item .right .topInfo .name p{padding-top: 2px;}
<?php } ?>
</style>
</head>
<body id="index_body">
<section id="header">
    <?php if($slideList) { ?>
<div class="slide-box swiper-container">
<div class="slide-list swiper-wrapper clearfix">
            <?php if(is_array($slideList)) foreach($slideList as $key => $value) { ?><div class="item-area swiper-slide">
                <a href="<?php echo $value['link'];?>">
                	<img src="<?php echo $value['picurl'];?>" title="<?php echo $value['title'];?>">
                </a>
            </div>
            <?php } ?>
</div>
        <div class="swiper-pagination"></div>
</div>
    <?php } ?>
</section>
<div class="information">
    <img src="source/plugin/tom_love/images/data.gif">
    <span class="mingchen">用户:<span class="number"><?php echo $userNumTxt;?><?php if($userNum > 10000) { ?>万<?php } ?></span></span>
    <span class="mingchen">浏览:<span class="number"><?php echo $clicksNumTxt;?><?php if($clicksNum > 10000) { ?>万<?php } ?></span></span>
</div>
<section id="nav">
<div class="nav-list clearfix">
        <?php if($__ShowXiangqin == 1) { ?>
        <a href="plugin.php?id=tom_xiangqin&amp;mod=index">
<img src="source/plugin/tom_love/images/nav_xiangqin.png">
<h6>我要相亲</h6>
</a>
        <a href="plugin.php?id=tom_love&amp;mod=list&amp;sex=2">
<img src="source/plugin/tom_love/images/nav_s13_nv.png">
<h6>找女友</h6>
</a>
        <?php } else { ?>
        <a href="plugin.php?id=tom_love&amp;mod=list&amp;sex=2">
<img src="source/plugin/tom_love/images/nav_s13_nv.png">
<h6>找女友</h6>
</a>
<a href="plugin.php?id=tom_love&amp;mod=list&amp;sex=1">
<img src="source/plugin/tom_love/images/nav_s13_nan.png">
<h6>找男友</h6>
</a>
        <?php } ?>
<a href="plugin.php?id=tom_love&amp;mod=shuoshuo">
<img src="source/plugin/tom_love/images/nav_s13_gc.png">
<h6>交友圈</h6>
</a>
<?php if($jyConfig['flowers_goods_switch'] == 0) { ?>
        <?php if($jyConfig['open_tel_renzheng'] == 1) { ?>
        <a href="plugin.php?id=tom_love&amp;mod=list&amp;phone_renzheng=1">
<img src="source/plugin/tom_love/images/nav_s13_rz.png">
<h6>认证会员</h6>
</a>
        <?php } else { ?>
        <a href="plugin.php?id=tom_love&amp;mod=list&amp;renzheng=1">
<img src="source/plugin/tom_love/images/nav_s13_rz.png">
<h6>认证会员</h6>
</a>
        <?php } ?>
        <?php } elseif($jyConfig['flowers_goods_switch'] == 1) { ?>
<a href="plugin.php?id=tom_love&amp;mod=shop">
<img src="source/plugin/tom_love/images/nav_s13_flowers_shop.png">
<h6>鲜花商城</h6>
</a>
        <?php } ?>
<a href="plugin.php?id=tom_love&amp;mod=phb">
<img src="source/plugin/tom_love/images/nav_s13_phb.png">
<h6>排行榜</h6>
</a>
</div>
</section>
<section id="main">
<div class="marquee">
<div id="title">
<ul>  
                <li><a href="plugin.php?id=tom_love&amp;mod=article&amp;aid=3"><?php echo $jyConfig['index_gonggao_msg'];?></a></li>  
                <li><a href="plugin.php?id=tom_love&amp;mod=article&amp;aid=1"><?php echo $jyConfig['love_aboutus'];?></a></li>
            </ul>  
</div>
</div>
    <?php if($jyConfig['index_adbox_1']) { ?>
    <div class="guangao_list clearfix">
        <div class="guangao_list_box clearfix">
            <?php echo $jyConfig['index_adbox_1'];?>
        </div>
    </div>
    <?php } ?>
<div class="wonderful">
<div class="wonder-title clearfix">
<span class="w-left">精彩话题</span>
<a href="plugin.php?id=tom_love&amp;mod=shuoshuo" class="w-right">更多话题</a>
</div>
<div class="wonder-content"><?php if(is_array($ssList)) foreach($ssList as $key => $value) { ?>            <div class="human-list clearfix">
                <a href="plugin.php?id=tom_love&amp;mod=shuoshuo">
                    <div class="toux"><img src="<?php echo $value['userinfo']['avatar'];?>" class="lazy"></div>
                    <div class="content">
                        <div class="u-name">
                            <?php if($value['userinfo']['sex'] == 1) { ?><span class="man"> </span><?php } ?>
                            <?php if($value['userinfo']['sex'] == 2) { ?><span class="woman"> </span><?php } ?>
                            <span class="nickname"><?php echo $value['userinfo']['nickname'];?></span>&nbsp;
                            <?php if(($value['userinfo']['subscribe'] == 0) && ($jyConfig['open_subscribe'] == 1)) { ?><span class="online_no">离线</span><?php } elseif(($value['userinfo']['subscribe'] == 1) && ($jyConfig['open_subscribe'] == 1)) { ?> <span class="online_ok">在线</span><?php } ?>
                            <span class="date-time"><?php echo dgmdate($value[ss_time], 'u');?></span>
                        </div>
                        <div class="u-xy"><?php echo $value['content'];?></div>
                    </div>
                </a>
</div>
            <?php } ?>
</div>
</div>
<?php if($jyConfig['index_adbox_2']) { ?>
    <section class="guangao_list clearfix">
        <div class="guangao_list_box clearfix">
            <?php echo $jyConfig['index_adbox_2'];?>
        </div>
    </section>
    <?php } ?>
<div class="list">
<div class="list-title">
            <ul>
                <li class="on">推荐会员</li>
                <li>最新会员</li>
                <li>鲜花榜</li>
                <li>暗恋榜</li>
                <li>土豪榜</li>
            </ul>
</div>
        <?php if($jyConfig['open_index_biglist'] == 1) { ?>
        <div class="new-list clearfix list_padding" id="index-list" style="min-height: 400px;"></div>
        <?php } else { ?>
        <div class="new-list clearfix" id="index-list" style="min-height: 400px;"></div>
        <?php } ?>
        <div style="display: none;" id="load-html"><p style="height: 50px;line-height: 50px;text-align: center;color: #a5a19f;">正在加载...</p></div>
        <div style="display: none;" id="no-load-html"><p style="height: 50px;line-height: 50px;text-align: center;color: #a5a19f;">没有更多信息...</p></div>
        <div style="display: none;" id="no-list-html"><p style="height: 50px;line-height: 50px;text-align: center;color: #a5a19f;">没有信息</p></div>
</div>    
</section>
<?php if($show_guanzu_box == 1) { ?>
<section id="subscribe">
    <div class="subscribe_box">
        <span>送礼物/打招呼/暗恋/聊天/回复等实时提醒</span>
        <div class="right">
            <div class="guanzu_show"><a href="javascript:void(0);" onClick="subscribe();">开启</a></div>
            <div class="guanzu_close" onClick="closeSubscribe();">x</div>
        </div>
    </div>
</section>
<?php } ?>
<div class="site-float">
    <span class="img-dialog" onclick="dingyue();"> 订阅 <i></i> 我们 </span>
</div>
<!-- footer start--><?php include template('tom_love:footer'); ?><i id="go-top" style="display: none;"></i>
<!-- footer end-->
<script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        spaceBetween: 30,
        centeredSlides: true,
        autoplay: 2500,
        autoplayDisableOnInteraction: false
    });
});

$(".list-title ul li").click(function(){
    var index = $(this).index();
    $(this).addClass('on').siblings(this).removeClass('on');
    index = index + 1;
    loadPage = 1;
    loadList(1,index);
});

var loadPage = 1;
var loadType = 1;
function indexLoadList(){
    loadPage = 1;
    loadType = 1;
    loadList(1,1);
}

var loadListStatus = 0;
var no_list_html = $("#no-list-html").html();
var load_html = $("#load-html").html();
function loadList(Page,Type) {
    if(loadListStatus == 1){
        return false;
    }
    loadType = Type;
    loadListStatus = 1;
    $("#index-list").html(load_html);
    $.ajax({
        type: "GET",
        url: "<?php echo $ajaxLoadListUrl;?>",
        data: {page:Page,index_type:Type},
        success: function(msg){
            $('#load-html').hide();
            loadListStatus = 0;
            var data = eval('('+msg+')');
            if(data == 205){
                $("#index-list").html(no_list_html);
                return false;
            }else{
                loadPage += 1;
                $("#index-list").html(data);
            }
        }
    });
}

$(document).ready(function(){
   indexLoadList();
});

$(window).scroll(function () {
    var scrollTop       = $(this).scrollTop();
    var scrollHeight    = $(document).height();
    var windowHeight    = $(this).height();
    if ((scrollTop + windowHeight) >= (scrollHeight * 0.9)) {
        scrollLoadList();
    }
    if ((scrollTop + windowHeight) >= 1000) {
        $('#go-top').show();
    }else{
        $('#go-top').hide();
    }
});

$(document).on('click','#go-top', function () {
    $('body,html').animate({scrollTop: 0}, 500);
    return false;
});

function scrollLoadList() {
    if(loadListStatus == 1){
        return false;
    }
    if(loadPage > 50){
        return false;
    }
    $('#load-html').show();
$('#no-load-html').hide();
    loadListStatus = 1;
    $.ajax({
        type: "GET",
        url: "<?php echo $ajaxLoadListUrl;?>",
        data: {page:loadPage,index_type:loadType},
        success: function(msg){
            loadListStatus = 0;
            var data = eval('('+msg+')');
            if(data == 205){
                $('#load-html').hide();
                $('#no-load-html').show();
                return false;
            }else{
                loadPage += 1;
                $('#load-html').hide();
                $("#index-list").append(data);
            }
        }
    });
}

function closeSubscribe(){
    $('#subscribe').hide();
    $.get("<?php echo $subscribeUrl;?>");
}

function subscribe(){
    layer.open({
        content: '<img src="<?php echo $jyConfig['fuwuhao_qrcode'];?>"><p>长按二维码识别开启消息提醒<p/>'
        ,btn: '知道了'
      });
}
function dingyue(){
    layer.open({
        content: '<img src="<?php echo $jyConfig['dingyue_qrcode'];?>"><p>长按二维码识别订阅我们<p/>'
        ,btn: '知道了'
      });
}

</script>
<script type="text/javascript">
$(document).ready(function(){
  $.get("<?php echo $vipUpdateUrl;?>");
  $.get("<?php echo $recUpdateUrl;?>");
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
<script>
$(function() {
    setInterval(function() {
        var e = $("#title ul");
        e.scrollTo({
            to: e.find("li").eq(0).height(),
            durTime: 800,
            delay: 80,
            callback: function() {
                var a = e.find("li").eq(0),
                i = a.clone(!0);
                e.scrollTop(0),
                a.remove(),
                e.append(i)
            }
        })
    },
    2e3)
});

</script>
</body>
</html>
