<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<!DOCTYPE html><html>
<head>
<?php if($isGbk) { ?>
<meta http-equiv="Content-Type" content="text/html; charset=GBK">
<?php } else { ?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php } ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0 , maximum-scale=1.0, user-scalable=0">
<?php if($pageType == 'anlian') { ?>
<title><?php if($act == 'meanlian') { ?>我的暗恋<?php } else { ?>暗恋我的<?php } ?>-<?php echo $jyConfig['plugin_name'];?></title>
<?php } if($pageType == 'chakan') { ?>
<title><?php if($act == 'mechakan') { ?>我看过谁<?php } else { ?>谁看过我<?php } ?>-<?php echo $jyConfig['plugin_name'];?></title>
<?php } ?>
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link href="source/plugin/tom_love/images/style.css?v=<?php echo $cssJsVersion;?>" rel="stylesheet" type="text/css">
<script src="source/plugin/tom_love/images/jquery.js" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_love/images';
</script>
<script src="source/plugin/tom_love/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script>
</head>
<body>
<?php if($pageType == 'anlian') { ?>
<header class="header_style2 clearfix">
<a href="plugin.php?id=tom_love&amp;mod=my">返回</a>
<h1><?php if($act == 'meanlian') { ?>我的暗恋<?php } else { ?>暗恋我的<?php } ?></h1>
</header>
<section class="anlian_list clearfix">
<div class="anlian_list_box clearfix">
    	<ul class="clearfix">
            <?php if(is_array($guanxiList)) foreach($guanxiList as $key => $value) { ?>            <li>
            	<figure><a href="plugin.php?id=tom_love&amp;mod=info&amp;uid=<?php echo $value['user']['id'];?>"><img src="<?php echo $value['user']['avatar'];?>"></a></figure>
                <article>
                	<header><?php if($value['user']['sex'] == 1) { ?><h1 class="man">♂</h1><?php } if($value['user']['sex'] == 2) { ?><h1 class="woman">♀</h1><?php } ?><h2><?php echo $value['user']['nickname'];?></h2><h3></h3></header>
                    <section><?php echo $value['describe'];?></section>
                    <footer>
                        <span class="del"><a href="javascript:void(0);" onclick="deleteanlian(<?php echo $value['id'];?>);">删除</a></span>
                    </footer>
                </article>
            </li>
            <?php } ?>
        </ul>
    </div>
    <div class="pages clearfix">
    	<ul class="clearfix">
          <li><?php if($page > 1) { ?><a href="<?php echo $prePageUrl;?>">上一页</a><?php } else { ?><span>上一页</span><?php } ?></li>
          <li><?php if($showNextPage == 1) { ?><a href="<?php echo $nextPageUrl;?>">下一页</a><?php } else { ?><span>下一页</span><?php } ?></li>
      </ul>
    </div>
</section>
<?php } if($pageType == 'chakan') { ?>
<header class="header_style2 clearfix">
<a href="plugin.php?id=tom_love&amp;mod=my">返回</a>
<h1><?php if($act == 'mechakan') { ?>我看过谁<?php } else { ?>谁看过我<?php } ?></h1>
</header>
<section class="anlian_list clearfix">
<div class="anlian_list_box clearfix">
    	<ul class="clearfix">
            <?php if(is_array($guanxiList)) foreach($guanxiList as $key => $value) { ?>            <li>
            	<figure><a href="plugin.php?id=tom_love&amp;mod=info&amp;uid=<?php echo $value['user']['id'];?>"><img src="<?php echo $value['user']['avatar'];?>"></a></figure>
                <article>
                	<header><?php if($value['user']['sex'] == 1) { ?><h1 class="man">♂</h1><?php } if($value['user']['sex'] == 2) { ?><h1 class="woman">♀</h1><?php } ?><h2><?php echo $value['user']['nickname'];?></h2><h3></h3></header>
                    <section><?php echo $value['describe'];?></section>
                    <footer>
                        <span class="del"><a href="plugin.php?id=tom_love&amp;mod=info&amp;uid=<?php echo $value['user']['id'];?>">查看</a></span>
                    </footer>
                </article>
            </li>
            <?php } ?>
        </ul>
    </div>
    <div class="pages clearfix">
    	<ul class="clearfix">
          <li><?php if($page > 1) { ?><a href="<?php echo $prePageUrl;?>">上一页</a><?php } else { ?><span>上一页</span><?php } ?></li>
          <li><?php if($showNextPage == 1) { ?><a href="<?php echo $nextPageUrl;?>">下一页</a><?php } else { ?><span>下一页</span><?php } ?></li>
      </ul>
    </div>
</section>
<?php } ?>
<script>
$(document).ready(function(){
  $.get("<?php echo $ajaxClicksUrl;?>");
});    
function deleteanlian(aid){
    $.ajax({
        type: "GET",
        url: "<?php echo $deleteUrl;?>",
        data: "aid="+aid,
        success: function(msg){
            tusi("删除成功");
            setTimeout(function(){document.location.reload();},1888);
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