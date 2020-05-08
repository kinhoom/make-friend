<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<!DOCTYPE html><html>
<head>
<?php if($isGbk) { ?>
<meta http-equiv="Content-Type" content="text/html; charset=GBK">
<?php } else { ?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php } ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0 , maximum-scale=1.0, user-scalable=0">
<title>会员列表-<?php echo $jyConfig['plugin_name'];?></title>
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link href="source/plugin/tom_love/images/style.css?v=<?php echo $cssJsVersion;?>" rel="stylesheet" type="text/css">
<script src="source/plugin/tom_love/images/jquery.js" type="text/javascript"></script>
<script src="source/plugin/tom_love/images/layer_mobile/layer.js?v=<?php echo $cssJsVersion;?>" type="text/javascript"></script>
<style>
.layui-m-layer0 .layui-m-layerchild{width: 70%;}
.layui-m-layercont{padding: 5px 3px;}
<?php if($__Android == 1) { ?>
.new-list .item .right .topInfo .name p{padding-top: 2px;}
<?php } ?>
</style>
</head>
<body>
<header class="header_nav clearfix">
<h2>会员列表</h2>
    <div class="nav">
        <div class="nav_bg"></div>
        <ul id="nav_list" class="nav_list">
            <li data-id="nav_nearby"><?php echo $nearby_name;?><i></i></li>
            <li data-id="nav_sex"><?php if($sex == 1) { ?>男性<?php } elseif($sex==2) { ?>女性<?php } else { ?>性别<?php } ?><i></i></li>
            <li data-id="nav_age"><?php if($age == 0) { ?>年龄<?php } else { ?><?php echo $ageSearchArray[$age];?><?php } ?><i></i></li>
            <li data-id="nav_filt">筛选<i></i></li>
        </ul>
        <div id="nav_nearby" class="nav_box nav_nearby">
            <ul class="nearby_list <?php if($nearby_type != 0) { ?>active<?php } ?>">
                <li data-id="nearby" <?php if($nearby_type == 0) { ?>class="on"<?php } ?>><a href="<?php echo $listUrl;?><?php echo $districtUrlParam;?>">全部</a></li>
                <?php if($__UserInfo) { ?>
                <li data-id="nearby_hjarea" <?php if($nearby_type == 1) { ?>class="on"<?php } ?>><a href="javascript:;">家乡附近</a></li>
                <?php } ?>
                <li data-id="nearby_area" <?php if($nearby_type == 2) { ?>class="on"<?php } ?>><a href="javascript:;">同城附近</a></li>
            </ul>
            <?php if($__UserInfo) { ?>
            <div id="nearby_hjarea" class="nearby_box <?php if($nearby_type == 1) { ?>active<?php } ?>">
                <?php if(is_array($hjcityList)) foreach($hjcityList as $key => $value) { ?>                <a <?php if($value['id'] == $hjcity_id) { ?>class="on"<?php } ?> href="<?php echo $listUrl;?><?php echo $value['link_url'];?>"><?php echo $value['name'];?></a>
                <?php } ?>
            </div>
            <?php } ?>
            <div id="nearby_area" class="nearby_box <?php if($nearby_type == 2) { ?>active<?php } ?>">
                <?php if(is_array($districtList)) foreach($districtList as $key => $value) { ?>                <a <?php if($value['id'] == $city_id) { ?>class="on"<?php } ?> href="<?php echo $listUrl;?><?php echo $value['link_url'];?>"><?php echo $value['name'];?></a>
                <?php } ?>
            </div>
        </div>
        <div id="nav_sex" class="nav_box nav_sex">
            <ul class="sex_list">
                <li <?php if($sex == 0) { ?>class="on"<?php } ?>><a href="<?php echo $listUrl;?><?php echo $sexUrlParam;?>">全部</a></li>
                <li <?php if($sex == 2) { ?>class="on"<?php } ?>><a href="<?php echo $listUrl;?><?php echo $sexUrlParam;?>&sex=2">女性</a></li>
                <li <?php if($sex == 1) { ?>class="on"<?php } ?>><a href="<?php echo $listUrl;?><?php echo $sexUrlParam;?>&sex=1">男性</a></li>
            </ul>
        </div>
        <div id="nav_age"  class="nav_box nav_age ">
            <ul class="age_list">
                <li <?php if($age == 0) { ?>class="on"<?php } ?>><a href="<?php echo $listUrl;?><?php echo $ageUrlParam;?>">全部</a></li>
                <?php if(is_array($ageSearchArray)) foreach($ageSearchArray as $key => $value) { ?>                <li <?php if($age == $key) { ?>class="on"<?php } ?>><a href="<?php echo $listUrl;?><?php echo $ageUrlParam;?>&age=<?php echo $key;?>"><?php echo $value;?></a></li>
                <?php } ?>
            </ul>
        </div>
        <div id="nav_filt" class="nav_box nav_filt">
            <div class="filt_box">
                <form id="search_form" onsubmit="return false;">
                    <div class="s-trem">
                        <div class="trem-b trem-text clearfix">
                            <span>用户昵称</span>
                            <input type="text" name="nickname" value="<?php echo $nickname;?>">
                        </div>
                    </div>
                    <?php if($jyConfig['open_tel_renzheng'] == 1) { ?>
                    <div class="s-trem">
                        <h6>手机认证</h6>
                        <div id="phone_renzheng_box" class="trem-b clearfix">
                            <input type="radio" id="phone_renzheng_0" name="phone_renzheng" value="0" <?php if($phone_renzheng == 0) { ?>checked<?php } ?>>
                            <label <?php if($phone_renzheng == 0) { ?>class='active'<?php } ?> for="phone_renzheng_0">全部</label>
                            <input type="radio" id="phone_renzheng_1" name="phone_renzheng" value="1" <?php if($phone_renzheng == 1) { ?>checked<?php } ?>>
                            <label <?php if($phone_renzheng == 1) { ?>class='active'<?php } ?> for="phone_renzheng_1">是</label>
                            <input type="radio" id="phone_renzheng_2" name="phone_renzheng" value="2" <?php if($phone_renzheng == 2) { ?>checked<?php } ?>>
                            <label <?php if($phone_renzheng == 2) { ?>class='active'<?php } ?> for="phone_renzheng_2">否</label>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="s-trem">
                        <h6>交友类别</h6>
                        <div id="type_box" class="trem-b clearfix">
                            <input type="radio" id="type_0" name="type" value="0" <?php if($type == 0) { ?>checked<?php } ?>>
                            <label <?php if($type == 0) { ?>class='active'<?php } ?> for="type_0">全部</label>
                            <input type="radio" id="type_1" name="type" value="1" <?php if($type == 1) { ?>checked<?php } ?>>
                            <label <?php if($type == 1) { ?>class='active'<?php } ?> for="type_1">交友</label>
                            <input type="radio" id="type_2" name="type" value="2" <?php if($type == 2) { ?>checked<?php } ?>>
                            <label <?php if($type == 2) { ?>class='active'<?php } ?> for="type_2">婚恋</label>
                        </div>
                    </div>
                    <div class="s-trem">
                        <h6>婚姻状况</h6>
                        <div id="marital_box" class="trem-b clearfix">
                            <input type="radio" id="marital_0" name="marital" value="0" <?php if($marital == 0) { ?>checked<?php } ?>>
                            <label <?php if($marital == 0) { ?>class='active'<?php } ?> for="marital_0">全部</label>
                            <?php if(is_array($maritalArray)) foreach($maritalArray as $key => $value) { ?>                            <input type="radio" id="marital_<?php echo $key;?>" name="marital" value="<?php echo $key;?>" <?php if($marital == $key) { ?>checked<?php } ?>>
                            <label <?php if($marital == $key) { ?>class='active'<?php } ?> for="marital_<?php echo $key;?>"><?php echo $value;?></label>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="s-trem">
                        <h6>职业<i data-trem-id="job_box"></i></h6>
                        <div id="job_box" class="trem-b clearfix">
                            <input type="radio" id="job_0" name="job" value="0" <?php if($job == 0) { ?>checked<?php } ?>>
                            <label <?php if($job == 0) { ?>class='active'<?php } ?> for="job_0">全部</label>
                            <?php if(is_array($worksArray)) foreach($worksArray as $key => $value) { ?>                            <input type="radio" id="job_<?php echo $key;?>" name="job" value="<?php echo $key;?>" <?php if($job == $key) { ?>checked<?php } ?>>
                            <label <?php if($job == $key) { ?>class='active'<?php } ?> for="job_<?php echo $key;?>"><?php echo $value;?></label>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="s-trem">
                        <div class="search_list" style="border:none;">
                            <h6>地区选择</h6>
                            <div id="area_box" class="search_trem-b clearfix">
                                <label <?php if($province_id == 0) { ?>class='active'<?php } ?> for="province_0">不限</label>
                                <select <?php if($province_id > 0) { ?>class='active'<?php } ?>class="search_select" name="province_id" id="province_id" onchange="getCity();">
                                    <option value="0">全部</option>
                                    <?php if(is_array($provinceList)) foreach($provinceList as $key => $value) { ?>                                    <option value="<?php echo $value['id'];?>" <?php if($province_id == $value['id']) { ?>  selected<?php } ?>><?php echo $value['name'];?></option>
                                    <?php } ?>
                                </select>
                                <select <?php if($city_id > 0) { ?>class='active'<?php } ?>class="search_select" name="city_id" id="city_id">
                                    <option value="0">全部</option>
                                    <?php if(is_array($cityList)) foreach($cityList as $key => $value) { ?>                                    <option value="<?php echo $value['id'];?>" <?php if($city_id == $value['id']) { ?>selected<?php } ?>><?php echo $value['name'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="formhash" value="<?php echo $formhash;?>">
                </form>
                <div class="search_button clearfix">
                    <span class="reset" onClick="resetSearch();">重置</span>
                    <span class="confirm" onClick="startSearch();">确定</span>
                </div>
            </div>
        </div>
    </div>
</header>
<?php if($jyConfig['search_adbox_1']) { ?>
<section class="guangao_list clearfix">
<div class="guangao_list_box clearfix">
        <?php echo $jyConfig['search_adbox_1'];?>
    </div>
</section>
<?php } ?>
<div class="new-list clearfix" id="index-list" style="margin-top: 10px;"></div>
<div style="display: none;" id="load-html"><p style="height: 50px;line-height: 50px;text-align: center;color: #a5a19f;">正在加载...</p></div>
<div style="display: none;" id="no-load-html"><p style="height: 50px;line-height: 50px;text-align: center;color: #a5a19f;">没有更多信息...</p></div>
<div style="display: none;" id="no-list-html"><p style="height: 50px;line-height: 50px;text-align: center;color: #a5a19f;">没有信息</p></div>
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
<?php } include template('tom_love:footer'); ?><i id="go-top" style="display: none;"></i>
<script type="text/javascript">
var loadPage = 1;
function indexLoadList(){
    loadPage = 1;
    loadList(1);
}

var loadListStatus = 0;
function loadList(Page) {
    if(loadListStatus == 1){
        return false;
    }
    loadListStatus = 1;
    $("#index-list").html('');
    $("#load-html").show();
    $.ajax({
        type: "GET",
        url: "<?php echo $ajaxLoadListUrl;?>",
        data: {page:Page},
        success: function(msg){
            $('#load-html').hide();
            loadListStatus = 0;
            var data = eval('('+msg+')');
            if(data == 205){
                $("#no-list-html").show();
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
    if(loadPage > 500){
        return false;
    }
    $('#load-html').show();
$('#no-load-html').hide();
    loadListStatus = 1;
    $.ajax({
        type: "GET",
        url: "<?php echo $ajaxLoadListUrl;?>",
        data: {page:loadPage},
        success: function(msg){
            loadListStatus = 0;
            var data = eval('('+msg+')');
            if(data == 205){
                loadListStatus = 1;
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

$(".nav_list li").on('click', function() {
    var id = $(this).data('id');
    $(this).toggleClass('on').siblings('.nav_list li').removeClass('on');
    $('#'+id).toggleClass('active').siblings('.nav .nav_box').removeClass('active');
    if($(this).hasClass('on')){
        $(".nav .nav_bg").show();
    }else{
        $(".nav .nav_bg").hide();
    }
});

$(".nav .nav_bg").on('click', function(){
    $(this).hide();
    $('.nav_list').find('li').removeClass('on');
    $('.nav').find('.nav_box').removeClass('active');
})

$('.nearby_list li').on('click', function() { 
    var id = $(this).data('id');
    $(this).addClass('on').siblings('.nearby_list li').removeClass('on');
    if(id == 'nearby'){
        $('.nav_nearby .nearby_list').removeClass('active');
        $('.nav_nearby').find('.nearby_box').removeClass('active');
    }else{
        $('.nav_nearby .nearby_list').hasClass("active") ? '' : $('.nav_nearby .nearby_list').addClass("active");
        $('#'+id).addClass('active').siblings('.nav_nearby .nearby_box').removeClass('active');
    }
});

$('.nav_sex li').on('click', function() { 
    $(this).addClass('on').siblings('.nav_sex li').removeClass('on');
});
    
$('.nav_age li').on('click', function() { 
    $(this).addClass('on').siblings('.nav_age li').removeClass('on');
});

$('.filt_box .s-trem h6 i').on('click', function() { 
    var id = $(this).data('trem-id');
    $(this).toggleClass('on');
    $('#'+id).toggleClass('active');
});
    
function startSearch(){
    window.location="<?php echo $listUrl;?><?php echo $filterUrlParam;?>&"+$('#search_form').serialize();
}

$("#search_form .s-trem label").on('click',function(){
    $(this).parent().find('label').removeClass('active');
    $(this).addClass('active');
})
$("#search_form .s-trem select").on('click',function(){
    $(this).addClass('active');
    $("#area_box label").removeClass("active");
    $("#area_box .search_select").addClass('active');
})

$("#area_box label").on('click',function(){
    $("#area_box select").removeClass('active');
    $("#area_box select").find("option:first").prop("selected",true);
    $("#area_box select").find("option:first").html("全部");
    
})

function resetSearch(){
    
    $("#search_form input[type=text]").val('');
    $("#phone_renzheng_0").attr("checked","checked");
    $("#phone_renzheng_0 + label").addClass('active').siblings('label').removeClass('active');
    $("#type_0").attr("checked","checked");
    $("#type_0 + label").addClass('active').siblings('label').removeClass('active');
    $("#marital_0").attr("checked","checked");
    $("#marital_0 + label").addClass('active').siblings('label').removeClass('active');
    $("#job_0").attr("checked","checked");
    $("#job_0 + label").addClass('active').siblings('label').removeClass('active');
    $("#area_box select").removeClass('active');
    $("#area_box label").addClass("active");
    $("#area_box select").find("option:first").prop("selected",true);
    $("#area_box select").find("option:first").html("全部");
   
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

$(document).ready(function(){
  $.get("<?php echo $ajaxClicksUrl;?>");
});

function getCity(){
var province_id = $("#province_id").val();
    $.ajax({
          type: "GET",
          url: "plugin.php?id=tom_love:ajax",
          data: "act=city&pid="+province_id,
          dataType : "jsonp",
          jsonpCallback:"jsonpCallback",
          cache : false,
          success: function(json){
              var cityHtml = '<option value="0">请选择城市</option>';
              $.each(json,function(k,v){
                  cityHtml+= '<option value="'+v.id+'">'+v.name+'</option>';
              })
              $("#city_id").html(cityHtml);
              $("#city_id").show();
          }
    });
}   

function getArea(){
  var city_id = $("#city_id").val();
  $.ajax({
        type: "GET",
        url: "plugin.php?id=tom_love:ajax",
        data: "act=area&pid="+city_id,
        dataType : "jsonp",
        jsonpCallback:"jsonpCallback",
        cache : false,
        success: function(json){
            var areaHtml = '<option value="0">请选择区/县</option>';
            $.each(json,function(k,v){
                areaHtml+= '<option value="'+v.id+'">'+v.name+'</option>';
            })
            $("#area_id").html(areaHtml);
            $("#area_id").show();
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