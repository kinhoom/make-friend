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
<title>上传头像-<?php echo $jyConfig['plugin_name'];?></title>
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link href="source/plugin/tom_love/images/style.css?v=<?php echo $cssJsVersion;?>" rel="stylesheet" type="text/css">
<link href="source/plugin/tom_love/images/weui.css?v=<?php echo $cssJsVersion;?>" rel="stylesheet" type="text/css">
<script src="source/plugin/tom_love/images/jquery-1.8.3.min.js" type="text/javascript" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_love/images';
</script>
<script src="source/plugin/tom_love/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script>
<base target="_self">
</head>
<body>
<header class="header_style2 clearfix">
<a href="plugin.php?id=tom_love&amp;mod=my">返回</a>
<h1>上传头像</h1>
</header>
<section class="avatar_box clearfix">
<div class="avatar_main_show clearfix">
    	<figure id="avatar">   
        <img src="<?php echo $__UserInfo['avatar'];?>"/>
        </figure>
    </div>
<div class="avatar_main_box clearfix">
    	<div class="avatar_main_box_file">
            <div class="weui-uploader__input-box" style="cursor: pointer;float: none;margin-left: auto;margin-right: auto;">
                <input name="Filedata" id="filedata" class="weui-uploader__input" type="file">
            </div>
        </div>
    </div>
    <div class="avatar_main_box_msg"><p>允许上传最大尺寸为：<?php echo $jyConfig['max_upload_size'];?>kb，如果图片太大上传失败，请使用美图秀秀等第三方软件压缩后再上传。</p></div>
</section>
<script src="source/plugin/tom_love/images/localResizeIMG4/dist/lrz.bundle.js" type="text/javascript"></script>
<script>
$(document).on('change', '#filedata', function() {
    loading('上传中...');
    lrz(this.files[0], {width:720,quality:0.8,fieldName:"Filedata"})
        .then(function (rst) {
            return rst;
        })
        .then(function (rst) {
            rst.formData.append('fileLen', rst.fileLen);
            $.ajax({
                url: '<?php echo $uploadUrl;?>',
                data: rst.formData,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (data) {
                    if(data == '') {
                        loading(false);
                        tusi('上传失败，请稍后再试');
                    }
                    var dataarr = data.split('|');
                    dataarr[0] = $.trim(dataarr[0]);
                    if(dataarr[0] == 'OK') {
                        loading(false);
                        $("#avatar").html('<img src="'+dataarr[1]+'">');
                        tusi('上传成功');
                        setTimeout(function(){window.location.href='<?php echo $backUrl;?>';},1888);
                    }else if(dataarr[0] == 'SIZE'){
                        loading(false);
                        tusi('超过了允许上传图片大小');
                    } else {
                        loading(false);
                        tusi('上传失败，请稍后再试');
                    }
                }
            });
            return rst;
        })
        .catch(function (err) {
loading(false);
            //alert(err);
        })
        .always(function () {
        });
});
</script>
<script type="text/javascript">
    
function showUploadMsg(){
$('body').append('<div id="upload_msg_box" onclick="hideUploadMsg();" style="position:fixed;left:0px;top:0px;width:100%;height:100%;background-color: rgba(0,0,0,0.5);text-align:right;" ontouchmove="return true;" ><img src="source/plugin/tom_love/images/upload_msg.png" style="margin-top:10px;margin-right:10px;"></div>');
}
function hideUploadMsg(){
    $("#upload_msg_box").remove();
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