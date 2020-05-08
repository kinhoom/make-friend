<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<!DOCTYPE html>
<html><head>
<?php if($isGbk) { ?>
<meta http-equiv="Content-Type" content="text/html; charset=GBK">
<?php } else { ?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php } ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0 , maximum-scale=1.0, user-scalable=0">
<title>交友圈-<?php echo $jyConfig['plugin_name'];?></title>
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link href="source/plugin/tom_love/images/weui.css" rel="stylesheet" type="text/css">
<link href="source/plugin/tom_love/images/guangc.css?v=<?php echo $cssJsVersion;?>" rel="stylesheet" type="text/css">
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
<section class="top_tab_nav clearfix">
<div class="top_tab_nav_main clearfix">
    	<a href="plugin.php?id=tom_love&amp;mod=shuoshuo&amp;prand=<?php echo $prand;?>" class="left current">交友圈</a><a href="plugin.php?id=tom_love&amp;mod=shuoshuo&amp;act=addshuoshuo&amp;prand=<?php echo $prand;?>" class="right">发布话题</a>
    </div>
</section>
<?php if($jyConfig['ss_adbox_1']) { ?>
<section class="guangao_list clearfix">
<div class="guangao_list_box clearfix">
        <?php echo $jyConfig['ss_adbox_1'];?>
    </div>
</section>
<?php } ?>
<div id="art-content"></div>
<section class="pic_shuoshuoinfo id-shuoshuopic-tip box_hide clearfix" style="z-index: 9999999;height: 2000px;position: fixed;">
<div class="pic_shuoshuoinfo_in id-shuoshuopic-tip-in" style="top: 0px; height: 550px; background-image: url();"></div>
</section>
<div style="display: none;" id="load-html"><p style="height: 35px;line-height: 35px;text-align: center;color: #a5a19f;">正在加载...</p></div>
<div style="display: none;" id="no-load-html"><p style="height: 35px;line-height: 35px;text-align: center;color: #a5a19f;">没有更多信息...</p></div>
<div style="display: none;" id="no-list-html"><p style="height: 35px;line-height: 35px;text-align: center;color: #a5a19f;">没有信息</p></div>
<input id="hidName" type="hidden" value="<?php echo $__UserInfo['nickname'];?>">
<input id="hidUserId" type="hidden" value="<?php echo $__UserInfo['id'];?>"> 
<input id="hidUserPic" type="hidden" value="<?php echo $__UserInfo['avatar'];?>">
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
<div class="js_dialog" id="must_phone" style="display: none;">
    <div class="weui-mask"></div>
    <div class="weui-dialog">
        <div class="weui-dialog__hd"><strong class="weui-dialog__title">温馨提示</strong></div>
        <div class="weui-dialog__bd">需要手机号认证后才能继续操作</div>
        <div class="weui-dialog__ft">
            <a href="<?php echo $phoneUrl;?>" class="weui-dialog__btn weui-dialog__btn_default">去绑定</a>
            <a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_primary">取消</a>
        </div>
    </div>
</div><?php include template('tom_love:footer'); ?><i class="gotop" id="go-top" style="display: none;"></i><?php include template('tom_love:shuoshuohtm'); ?><script type="text/javascript">
$(document).on('click', '.weui-dialog__btn_primary', function(){
    $(this).parents('.js_dialog').fadeOut(200);
})

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

function showPic(picurl){
    $(".id-shuoshuopic-tip").removeClass('box_hide');
    $('.id-shuoshuopic-tip-in').css('background-image', 'url(' + picurl + ')');
}

$(".pic_shuoshuoinfo").on("click", function(){
    $(".id-shuoshuopic-tip").addClass('box_hide');
    $('.id-shuoshuopic-tip-in').css('background-image', '');
});
        

var loadPage = 1;
function shuoshuoLoadList(){
    loadPage = 1;
    loadList(1);
}

var loadListStatus = 0;
var no_list_html = $("#no-list-html").html();
var load_html = $("#load-html").html();
function loadList(Page) {
    if(loadListStatus == 1){
        return false;
    }
    loadListStatus = 1;
    $("#art-content").html(load_html);
    $.ajax({
        type: "GET",
        url: "<?php echo $shuoshuoUrl;?>",
        data: {act:"shuoshuoList",page:Page,uid:"<?php echo $uid;?>",formhash:"<?php echo $formhash;?>"},
        success: function(msg){
            $('#load-html').hide();
            loadListStatus = 0;
            var data = eval('('+msg+')');
            if(data == 205){
                $("#art-content").html(no_list_html);
                return false;
            }else{
                loadPage += 1;
                $("#art-content").html(data);
            }
        }
    });
}

$(document).ready(function(){
   shuoshuoLoadList();
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
        url: "<?php echo $shuoshuoUrl;?>",
        data: {act:"shuoshuoList",page:loadPage,uid:"<?php echo $uid;?>",formhash:"<?php echo $formhash;?>"},
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
                $("#art-content").append(data);
            }
        }
    });
}

$(document).ready(function(){
    $.get("<?php echo $ajaxClicksUrl;?>");
});
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