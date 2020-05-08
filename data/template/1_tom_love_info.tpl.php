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
<title><?php echo $shareTitle;?></title>
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link href="source/plugin/tom_love/images/weui.css" rel="stylesheet" type="text/css">
<link href="source/plugin/tom_love/images/guangc.css?v=<?php echo $cssJsVersion;?>" rel="stylesheet" type="text/css">
<link href="source/plugin/tom_love/images/style.css?v=<?php echo $cssJsVersion;?>" rel="stylesheet" type="text/css">
<link href="source/plugin/tom_love/images/newstyle.css?v=<?php echo $cssJsVersion;?>" rel="stylesheet" type="text/css">
<script src="source/plugin/tom_love/images/jquery.js" type="text/javascript"></script>
<script src="source/plugin/tom_love/images/layer_mobile/layer.js?v=<?php echo $cssJsVersion;?>" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_love/images';
</script>
<script src="source/plugin/tom_love/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script>
<base target="_self">
<style>
.layui-m-layer0 .layui-m-layerchild{width: 70%;}
.layui-m-layercont{padding: 5px 3px;}
.none{display:none !important;}
.color{border-bottom:2px solid #FE6985; color:#FE6985 !important;}
</style>
</head>
<body id="personal">
<section id="head_portrait">
    <div class="bg"><img src="<?php echo $themeSrc;?>"></div>
<div class="portrait">
<div class="head-t"><img src="<?php echo $info['avatar'];?>"/></div>
<div class="user-xq">
<p class="clearfix">
<span class="user-name"><?php echo $info['nickname'];?></span>
                <?php if(($info['subscribe'] == 0) && ($jyConfig['open_subscribe'] == 1)) { ?><span class="online_no">离线</span><?php } elseif(($info['subscribe'] == 1) && ($jyConfig['open_subscribe'] == 1)) { ?> <span class="online_ok">在线</span><?php } ?>
                <?php if($info['renzheng'] == 1) { ?>
<i class="shield"><span class="renzheng"></span></i>
                <?php } ?>
                <?php if($info['vip_id'] == 1) { ?>
<i class="shield"><span class="vp"></span></i>
                <?php } ?>
                <?php if($jyConfig['open_tel_renzheng'] == 1 && $info['phone_renzheng'] == 1) { ?><i class="shield"><span class="phone_renzheng"></span></i><?php } ?>
                <span></span>
</p>
            <p>
                <?php if($info['sex'] == 1) { ?>男<?php } if($info['sex'] == 2) { ?>女<?php } ?>
                <?php if($age > 0) { ?>，<?php echo $age;?><?php } ?>
                <?php if($info['friend'] == 1) { ?>，交友<?php } ?>
                <?php if($info['marriage'] == 1) { ?>，婚恋<?php } ?>
            </p>
            <p>收到鲜花<?php echo $info['flowers'];?>朵，被暗恋<?php echo $info['anlians'];?>次，关注度：<?php echo $info['clicks'];?></p>
</div>
        <div class="water" style="bottom:0px">
            <div class="water-c">
                <div class="water-1"></div>
                <div class="water-2"></div>
            </div>
        </div>
</div>
<div class="hua-lian clearfix">
        <ul>
            <li>
                <a href="plugin.php?id=tom_love&amp;mod=sms&amp;act=create&amp;to_user_id=<?php echo $info['id'];?>&amp;formhash=<?php echo $formhash;?>">
                    <i class="icon-chat"></i>
                    <p>私聊</p>
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" onClick="hello();">
                    <i class="icon-hello"></i>
                    <p>打招呼</p>
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" onClick="$('#gift_shop').show(500);">
                    <i class="icon-gift"></i>
                    <p>送礼物</p>
                </a>
            </li>
            <li>
                <a href="javascript:void(0);"  onclick="anlian();" >
                    <i class="icon-anlian"></i>
                    <p>暗恋TA</p>
                </a>
            </li>
            <li class="last">
                <a href="plugin.php?id=tom_love&amp;mod=report&amp;report_user_id=<?php echo $info['id'];?>">
                    <i class="icon-report"></i>
                    <p>举报</p>
                </a>
            </li>
        </ul>
</div>
    <?php if($picList) { ?>
<div class="album">
<ul class="album-list clearfix">
            <?php if(is_array($picList)) foreach($picList as $key => $value) { ?><li>
                <?php if($__IsWeixin == 1) { ?>
                <a href="javascript:void(0);" onclick="wxLoadPic('<?php echo $value['pic_url'];?>');">
                <?php } else { ?>
                <a href="javascript:void(0);" onclick="loadPic(<?php echo $info['id'];?>,<?php echo $info['pic_num'];?>);">
                <?php } ?>
                    <img src="<?php echo $value['pic_url'];?>">
                    <?php if($info['pic_num'] > 4 && $value['i'] == 4) { ?>
                    <div class="more-pic">点击查看<br/>更多(<?php echo $info['pic_num'];?>)</div>
                    <?php } ?>
                </a>
            </li>
<?php } ?>
</ul>
</div>
    <?php } else { ?>
    <div class="tishi">该用户没有上传照片哦！</div>
    <?php } ?>
    <div class="box_both clearfix"></div>
</section>

<section id="gift">
    <?php if($giftCountList) { ?>
    <h4>收到的礼物(<?php echo $giftCount;?>份)</h4>
    <div class="gift_box clearfix">
        <?php if(is_array($giftCountList)) foreach($giftCountList as $key => $value) { ?>        <div class="trem">
            <div class="content">
                <img src="<?php echo $value['gift_picurl'];?>">
                <p class="title"><?php echo $value['gift_name'];?>(<?php echo $value['gift_num'];?>)</p>
            </div>
        </div>
        <?php } ?>
    </div>
    <?php } else { ?>
    <div class="notice">还没有收到礼物哦！</div>
    <?php } ?>
</section>
<div class="info_nav">
    <div class="infoziliao jieshao"><a class="color">介绍</a></div>
    <div class="infoziliao dongtai"><a>动态</a></div>
</div>
<section id="information" class="informations">
    <div class="info_box">
        <?php if($mate_demands) { ?>
        <ul class="clearfix ">
            <li class="info-left">择偶要求：</li>
            <li class="info-right"><?php echo $mate_demands;?></li>
        </ul>
        <?php } ?>
        <ul class="clearfix ">
            <li class="info-left">交友宣言：</li>
            <li class="info-right"><?php echo $describe;?></li>
        </ul>
        <?php if($jyConfig['closed_tel_qq'] == 0) { ?>
        <?php if($info['closed'] == 0) { ?>
        <?php if($info['qq'] != '' || $info['wx'] != '' || $info['tel'] != '') { ?>
        <?php if($contactTag == 1) { ?>
        <ul class="clearfix ">
            <li class="info-left">QQ 号：</li>
            <li class="info-right"><?php echo $info['qq'];?></li>
        </ul>
        <ul class="clearfix ">
            <li class="info-left">微信号：</li>
            <li class="info-right"><?php echo $info['wx'];?></li>
        </ul>
        <?php if($jyConfig['open_contact_tel'] == 1) { ?>
        <ul class="clearfix ">
            <li class="info-left">手机号：</li>
            <li class="info-right"><?php echo $info['tel'];?></li>
        </ul>
        <?php } ?>
        <?php } else { ?>
        <ul class="clearfix ">
            <li class="info-left">联系方式</li>
            <li class="info-right"><a class="lyfx" onclick="contact();" href="javascript:void;"><?php if($__UserInfo['vip_id'] == 1) { ?>点击查看<?php } else { ?>点击查看消耗<?php echo $jyConfig['contact_score'];?><?php echo $jyConfig['score_name'];?><?php } ?></a></li>
        </ul>
        <?php } ?>
        <?php } ?>
        <?php } ?>
        <?php } ?>
        <ul class="clearfix ">
            <li class="info-left">婚姻状况：</li>
            <li class="info-right"><?php if($info['marital_id'] > 0) { ?><?php echo $maritalArray[$info['marital_id']];?><?php } else { ?>保密<?php } ?></li>
        </ul>
        <ul class="clearfix ">
            <li class="info-left">身&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高：</li>
            <li class="info-right"><?php if($info['height'] > 0) { ?><?php echo $info['height'];?>厘米<?php } else { ?>保密<?php } ?></li>
        </ul>
        <ul class="clearfix ">
            <li class="info-left">体&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;重：</li>
            <li class="info-right"><?php if($info['weight'] > 0) { ?><?php echo $info['weight'];?>KG<?php } else { ?>保密<?php } ?></li>
        </ul>
        <ul class="clearfix ">
            <li class="info-left">学&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;历：</li>
            <li class="info-right"><?php if($info['edu_id'] > 0) { ?><?php echo $eduArray[$info['edu_id']];?><?php } else { ?>保密<?php } ?></li>
        </ul>
        <ul class="clearfix ">
            <li class="info-left">收&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;入：</li>
            <li class="info-right"><?php if($info['pay_id'] > 0) { ?><?php echo $payArray[$info['pay_id']];?>/月<?php } else { ?>保密<?php } ?></li>
        </ul>
        <ul class="clearfix ">
            <li class="info-left">职&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;业：</li>
            <li class="info-right"><?php if($info['work_id'] > 0) { ?><?php echo $worksArray[$info['work_id']];?><?php } else { ?>保密<?php } ?></li>
        </ul>
        <ul class="clearfix ">
            <li class="info-left">居住地区：</li>
            <li class="info-right"><?php if($info['area'] != '') { ?><?php echo $info['area'];?><?php } else { ?>保密<?php } ?></li>
        </ul>
        <ul class="clearfix ">
            <li class="info-left">户籍地区：</li>
            <li class="info-right"><?php if($info['hjarea'] != '') { ?><?php echo $info['hjarea'];?><?php } else { ?>保密<?php } ?></li>
        </ul>
        
    </div>
    
</section>
    
<div id="art-content" class="art-content none"></div>
<section class="pic_shuoshuoinfo id-shuoshuopic-tip box_hide clearfix" style="z-index: 9999999;height: 2000px;position: fixed;">
<div class="pic_shuoshuoinfo_in id-shuoshuopic-tip-in" style="top: 0px; height: 550px; background-image: url();"></div>
</section>
<input id="hidName" type="hidden" value="<?php echo $__UserInfo['nickname'];?>">
<input id="hidUserId" type="hidden" value="<?php echo $__UserInfo['id'];?>"> 
<input id="hidUserPic" type="hidden" value="<?php echo $__UserInfo['avatar'];?>">
<?php if($shuoshuolistStatus == 0) { if($ssCount <= 5) { } else { ?>
<div id="jiazai" class="jiazai none" onclick="clickloadlist();" style="text-align:center;color:#a5a19f;line-height: 35px;font-size: 15px;cursor: pointer;background-color: #fff;">点击加载更多</div>
<?php } ?>
<div style="display: none;" id="load-html"><p style="line-height: 35px;text-align: center;color: #a5a19f;font-size: 15px;">正在加载...</p></div>
<div style="display: none;" id="no-list-html">
    <p style="line-height: 50px;text-align: center;color: #a5a19f;padding-top:90px;"><?php echo $info['nickname'];?>还未发布任何动态哦</p>
    <a href="plugin.php?id=tom_love&amp;mod=shuoshuo&amp;act=addshuoshuo&amp;prand=<?php echo $prand;?>" class="right"><div class='fabu'>我去发布一条</div></a>
</div>
<div style="display: none;" class="no-load-html" id="no-load-html"><p style="line-height: 35px;text-align: center;color: #a5a19f;font-size: 15px;">没有更多信息...</p></div>
<?php } else { } ?>
<section class="pic_info id-pic-tip box_hide clearfix" style="z-index: 999;height: 100%; position:fixed">
<div class="pic_info_in id-pic-tip-in" style="top: 0px; height: 100%; background-image: url();">
        <div class="pic_info_nav">
            <a class="id-pic-prev">上一张</a>
            <a class="id-pic-tip-close">关闭</a>
            <a class="id-pic-next">下一张</a>
        </div>
        <div class="pic_info_count">
            <span class="id-pic_now">1</span>/<span class="id-pic_count">1</span>
        </div>
</div>
</section>
<?php if($jyConfig['info_adbox_1']) { ?>
<section class="guangao_list clearfix">
<div class="guangao_list_box clearfix">
        <?php echo $jyConfig['info_adbox_1'];?>
    </div>
</section>
<?php } ?>  

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
<?php } include template('tom_love:footer'); ?><section class="porpmt_box giftDetails">
    <div class="content"></div> 
</section>
<section id="gift_shop" class='box_hide'>
    <div class="close" onClick="$('#gift_shop').hide(500);">x</div>
    <h4>礼物商城</h4>
    <div class="gift_box clearfix">
        <?php if($giftList) { ?>
        <?php if(is_array($giftList)) foreach($giftList as $key => $value) { ?>        <div class="trem" onClick="giftDetails(<?php echo $value['id'];?>)">
            <div class="content">
                <img src="<?php echo $value['gift_picurl'];?>">
                <p class="title"><?php echo $value['gift_name'];?></p>
                <p class="price"><?php echo $value['score_num'];?><?php echo $jyConfig['score_name'];?></p>
            </div>
        </div>
        <?php } ?>
        <?php } else { ?>
        <div class="notice">管理员暂未设置礼品</div>
        <?php } ?>
    </div>
</section>
<section class="rechange">
    <div class="rechange-box">
        <div class="box">
            <div class="box-img"><img src="source/plugin/tom_love/images/rechange_s13_logo.png"></div>
            <div class="box-content">
                <p class="content-title">您当前的<?php echo $jyConfig['score_name'];?>不足</p>
                <p id="have">现有<?php echo $jyConfig['score_name'];?>:&nbsp;0</p>
                <p id="need">所需<?php echo $jyConfig['score_name'];?>:&nbsp;0</p>
            </div>
            <div class="box-button"><a href="plugin.php?id=tom_love&amp;mod=scorepay"><img src="source/plugin/tom_love/images/rechange_s13_link.png"></a></div>
        </div>
        <div class="button" onClick="$('.rechange').hide();"><a href="javascript:;"><img src="source/plugin/tom_love/images/rechange_s13_hide.png"></a></div>
    </div>
</section>
<section class="dialog succ-dialog id-pic-succ" style="display: none;">
   <section class="dialog-wrap">
        <section class="dialog-center">
            <a href="javascript:void(0);" onclick="$('.id-pic-succ').hide();" class="group-link close"></a>
             <section class="dialog-body">
                  <h1>温馨提示</h1>
                  <p><span>您还没有完善相册，不能查看！</span></p>
                  <section class="dialog-btns clear">
                       <a href="plugin.php?id=tom_love&amp;mod=photo" class="share-link id-share-link">现在完善</a>
                       <a href="#" class="buy-link id-buy-link" onclick="$('.id-pic-succ').hide();">取消</a>
                  </section>
             </section>
        </section>
   </section>
</section>
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
</div>
<div class="js_dialog" id="over_contact_num" style="display: none;">
    <div class="weui-mask"></div>
    <div class="weui-dialog">
        <div class="weui-dialog__hd"><strong class="weui-dialog__title">温馨提示</strong></div>
        <div class="weui-dialog__bd">普通会员每天只能查看<font color="#fd0d0d"><?php echo $jyConfig['show_contact_num'];?></font>条联系方式，充值黄金会员可以查看更多。</div>
        <div class="weui-dialog__ft">
            <a href="plugin.php?id=tom_love&amp;mod=vippay" class="weui-dialog__btn weui-dialog__btn_default"><font color="#238206">去充值</font></a>
            <a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_primary">关闭</a>
        </div>
    </div>
</div>
<div class="js_dialog" id="over_vip_contact_num" style="display: none;">
    <div class="weui-mask"></div>
    <div class="weui-dialog">
        <div class="weui-dialog__hd"><strong class="weui-dialog__title">温馨提示</strong></div>
        <div class="weui-dialog__bd">每天只能查看<font color="#fd0d0d"><?php echo $jyConfig['vip_show_contact_num'];?></font>条联系方式，请明天再来！</div>
        <div class="weui-dialog__ft">
            <a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_primary">关闭</a>
        </div>
    </div>
</div>
<i class="gotop" id="go-top" style="display: none;"></i><?php include template('tom_love:shuoshuohtm'); ?><script type="text/javascript">
$(document).on('click', '.weui-dialog__btn_primary', function(){
    $(this).parents('.js_dialog').fadeOut(200);
})
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
                $('#jiazai').hide();
                return false;
            }else{
                loadPage += 1;
                $("#art-content").html(data);
            }
        }
    });
}

function clickloadlist() {
    if(loadPage > 10){
        return false;
    }
    $('#jiazai').hide();
    $('#load-html').show();
$('#no-load-html').hide();
    loadListStatus = 1;
    $.ajax({
        type: "GET",
        url: "<?php echo $shuoshuoUrl;?>",
        data: {act:"shuoshuoList",page:loadPage,uid:"<?php echo $uid;?>",formhash:"<?php echo $formhash;?>"},
        success: function(msg){
            var data = eval('('+msg+')');
            if(data == 205){
                $('#load-html').hide();
                $('#no-load-html').show();
                return false;
            }else{
                loadPage += 1;
                $('#load-html').hide();
                $('#jiazai').show();
                $("#art-content").append(data);
            }
        }
    });
}

$(function(){
var s=0;
var o=$("#gift");
var b=$("#gift .gift_box");
var j=$("#gift .gift_box .trem");
    if(j.length <= 3){
        return false;
    }
    j.css({width:""+j.outerWidth()+"px"});
b.css({width:""+(j.length*j.outerWidth())+"px",position:"relative",left:"0px"});
var sid=function(){
s++;
if(s>(j.length - 3)){
s=0;
}
b.animate({left:"-"+s*j.outerWidth()+"px"},500);
    show=setTimeout(sid,3000);

}
var show=setTimeout(sid,3000);
    
})
</script>
<script>
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

var picListStr = '<?php echo $picListStr;?>';
function wxLoadPic(picurl){
    <?php if($show_pic_prompt_box == 1) { ?>
    $('.id-pic-succ').show();
    return false;
    <?php } ?>
    var picarr = picListStr.split('|');
    wx.previewImage({
        current: picurl,
        urls: picarr 
    });
}
    
var userId = 0;
var nowPic = 0;
var allPic = 0;
var picData = new Array();

function loadPic(uid,count){
    
    <?php if($show_pic_prompt_box == 1) { ?>
    $('.id-pic-succ').show();
    return false;
    <?php } ?>
    userId = uid;
    allPic = count;
    nowPic = 1;
    picData = [];
    
    if(allPic > 0){
    }else{
        return false;
    }
    
    $.ajax({
        type: "GET",
        url: "plugin.php?id=tom_love:ajax",
        data: "act=pic&uid="+userId,
        dataType : "jsonp",
        jsonpCallback:"jsonpCallback",
        cache : false,
        success: function(json){
            var i = 1;
            $.each(json,function(k,v){
                picData[i] = v;
                i++;
            })
            $(window).scrollTop(0);
            $(".id-pic-tip-in").css('top', 0).css('height', $(window).height());
            //$(".id-pic-tip-in").css('top', $(document.body).scrollTop()).css('height', $(window).height());
            $(".id-pic-tip").removeClass('box_hide');
            $('.id-pic-tip-in').css('background-image', 'url(' + picData[1] + ')');
            $('.id-pic-tip-in .id-pic_now').html(1);
            $('.id-pic-tip-in .id-pic_count').html(allPic);
        }
    });
}
$(".id-pic-prev").on("click", function(){
        if(nowPic > 1){
            nowPic = nowPic - 1;
            $('.id-pic-tip-in').css('background-image', 'url(' + picData[nowPic] + ')');
            $('.id-pic-tip-in .id-pic_now').html(nowPic);
        }
});

$(".id-pic-next").on("click", function(){
if(nowPic < allPic){
            nowPic = nowPic + 1;
            $('.id-pic-tip-in').css('background-image', 'url(' + picData[nowPic] + ')');
            $('.id-pic-tip-in .id-pic_now').html(nowPic);
        }
});

$(".id-pic-tip-close").on("click", function(){
$(".id-pic-tip").addClass('box_hide');
$('.id-pic-tip-in').css('background-image', '');
userId = 0;
picData = [];
nowPic = 0;
        allPic = 0;
}); 

var submintStatus = 0;
function contact(){
    if(submintStatus == 1){
        return false;
    }
    
    <?php if($jyConfig['open_must_tel_renzheng'] == 1 && $__UserInfo['phone_renzheng'] != 1) { ?>
    $('#must_phone').show();
    return false;
    <?php } ?>

    submintStatus = 1;
    $.ajax({
        type: "GET",
        url: "<?php echo $contactUrl;?>",
        data: "",
        success: function(msg){
            submintStatus = 0;
            var data = eval('('+msg+')');
            if(data.status==101){
                $('#have').html("现有<?php echo $jyConfig['score_name'];?>:&nbsp;"+data.have);
                $('#need').html("所需<?php echo $jyConfig['score_name'];?>:&nbsp;"+data.need);
                $('.rechange').show();
                return false;
            }else if(data.status==301){
                $('#over_vip_contact_num').show();
                return false;
            }else if(data.status==302){
                $('#over_contact_num').show();
                return false;
            }else{
                tusi("查看成功");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }
        }
    });
}

var anlianTag = "<?php echo $anlianTag;?>";
anlianTag = anlianTag * 1;
function anlian(){
    if(submintStatus == 1){
        return false;
    }
    
    <?php if($jyConfig['open_must_tel_renzheng'] == 1 && $__UserInfo['phone_renzheng'] != 1) { ?>
    $('#must_phone').show();
    return false;
    <?php } ?>

    if(anlianTag == 1){
        tusi("已经暗恋");
        return false;
    }
    submintStatus = 1;
    $.ajax({
        type: "GET",
        url: "<?php echo $anlianUrl;?>",
        data: "",
        success: function(msg){
            
            submintStatus = 0;
            var data = eval('('+msg+')');
            if(data.status==101){
                $('#have').html("现有<?php echo $jyConfig['score_name'];?>:&nbsp;"+data.have);
                $('#need').html("所需<?php echo $jyConfig['score_name'];?>:&nbsp;"+data.need);
                $('.rechange').show();
                return false;
            }else{
                anlianTag = 1;
                tusi("暗恋成功");
            }
            
        }
    });
}

function hello(){
    if(submintStatus == 1){
        return false;
    }
    
    <?php if($jyConfig['open_must_tel_renzheng'] == 1 && $__UserInfo['phone_renzheng'] != 1) { ?>
    $('#must_phone').show();
    return false;
    <?php } ?>
    
    submintStatus = 1;
    $.ajax({
        type: "GET",
        url: "<?php echo $helloUrl;?>",
        data: "",
        success: function(msg){
            submintStatus = 0;
            var data = eval('('+msg+')');
            if(data.status==101){
                $('#have').html("现有<?php echo $jyConfig['score_name'];?>:&nbsp;"+data.have);
                $('#need').html("所需<?php echo $jyConfig['score_name'];?>:&nbsp;"+data.need);
                $('.rechange').show();
                return false;
            }else if(data.status==100){
                tusi("不能给自己打招呼");
            }else{
                tusi("打招呼成功");
            }
        }
    });
}

var flag = 1;
function giftDetails(id){
    if(flag == 1) {
        flag = 0;
        $.ajax({
            type: "GET",
            url: "<?php echo $detailsUrl;?>",
            data: { act:"giftDetails",gift_id:id},
            success: function(msg){
                var data = $.trim(msg);
                data = JSON.parse(data);
                if(data == 201){
                    tusi('未知错误');
                    return false;
                }else{
                    $(".giftDetails .content").html(data);
                    $(".giftDetails").show();
                    flag = 1;
                }
            }
        })
    }
}

var submintGiftStatus = 0;
function giftPay(id){
    if(submintGiftStatus == 1) {
        return false;
    }
    <?php if($jyConfig['open_must_tel_renzheng'] == 1 && $__UserInfo['phone_renzheng'] != 1) { ?>
    $('#must_phone').show();
    return false;
    <?php } ?>
    submintGiftStatus = 1;
    $.ajax({
        type: "GET",
        url: "<?php echo $scoreUrl;?>",
        data: { act:"giftPay",gift_id:id},
        success: function(msg){
            submintGiftStatus = 0;
            var data = $.trim(msg);
            data = JSON.parse(data);
            if(data.status == 202){
                tusi('不能给自己送礼物！');
                setTimeout(function(){document.location.reload();},1888);
            }else if(data.status == 203){
                $(".giftDetails").hide();
                $('#gift_shop').hide();
                $('#have').html("现有<?php echo $jyConfig['score_name'];?>:&nbsp;"+data.have);
                $('#need').html("所需<?php echo $jyConfig['score_name'];?>:&nbsp;"+data.need);
                $('.rechange').show();
            }else if(data.status == 201){
                tusi('未知错误');
                setTimeout(function(){document.location.reload();},1888);
            }else{
                tusi('赠送成功！');
                setTimeout(function(){document.location.reload();},1888);
            }
        }
    })
    
}

function noBbsId(){
    tusi("对方资料不完善");
    return false;
}

$(document).ready(function(){
    <?php if($info['status'] == 2) { ?>
    tusi("该用户已经被封号");
    setTimeout(function(){window.location.href='plugin.php?id=tom_love&mod=index';},1888);
    <?php } ?>
    $.get("<?php echo $ajaxClicksUrl;?>");
    $.get("<?php echo $ajaxInfoClicksUrl;?>");
});

$(".infoziliao.dongtai a").on("click", function(){
    shuoshuoLoadList();
    $(".informations").addClass('none');
    $(this).addClass("color");
    $(".infoziliao.jieshao a").removeClass("color");
    $(".art-content").removeClass('none');
    $(".jiazai").removeClass('none');
    $(".no-load-html").removeClass('none');
    
});

$(".infoziliao.jieshao a").on("click", function(){
    $(".art-content").addClass('none');
    $(this).addClass("color");
    $(".infoziliao.dongtai a").removeClass("color");
    $(".informations").removeClass('none');
    $(".jiazai").addClass('none');
    $(".no-load-html").addClass('none');
   
});


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
        
$(window).scroll(function () {
    var scrollTop       = $(this).scrollTop();
    var scrollHeight    = $(document).height();
    var windowHeight    = $(this).height();
    if ((scrollTop + windowHeight) >= (scrollHeight * 0.9)) {
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
      'onMenuShareAppMessage',
      'previewImage'
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