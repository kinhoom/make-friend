<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
<?php if($isGbk) { ?>
<meta http-equiv="Content-Type" content="text/html; charset=GBK">
<?php } else { ?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php } ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<title>登录注册</title>
<link rel="stylesheet" href="source/plugin/tom_love/images/bootstrap.min.css">
<script src="source/plugin/tom_love/images/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_love/images';
</script>
<script src="source/plugin/tom_love/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script>
<style>
html,body,div,table,tr,td,tbody,th,span,p,h1,h2,h3,h4,h5,ul,ol,li,button,img,input,a{
margin: 0 0 0 0;padding: 0 0 0 0;border: none;text-decoration: none;list-style: none;cursor:default;font-size: 16px;font-family: 'Microsoft Yahei';outline: none;-webkit-tap-highlight-color:rgba(255,0,0,0);
}
body{ min-width:320px; margin: 0px; padding: 0px; background-color: #F6F6F6; }
.tom_top { height: 40px; width: 100%; position: relative; margin-top: 0px; line-height: 40px; text-align: center; font-weight: 600; font-size: 18px; box-shadow: 0px 0px 8px #F0F0F0; background-color: #F0F0F0; border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: #E3E3E3; }
.tom_back { height: 40px; width: 40px; float: left; position: absolute; left: 0px; top: 0px; }
.tom_back a{ height: 40px; width: 40px; display: block; float: left; text-align: center; line-height: 40px; font-size: 18px; color: #FFF; background-image: url(source/plugin/tom_love/images/back_ico2.png); background-repeat: no-repeat;background-size: contain; }
.tom_bind{ width: 90%; padding: 10px; margin-right: auto; margin-left: auto; }
.tom_bind_zc_title{ margin-top: 5px; margin-bottom: 5px; color: #666; }
.tom_bind_zc{ margin-top: 20px; }
.tom_bind_zc span{ font-size: 18px; font-weight: 600; }
.tom_bind_zc_p{ font-size: 16px; color: #999; margin-top: 10px; text-align: center; }
.tom_bind_dl_title{ margin-top: 30px; margin-bottom: 5px; color: #666; }
.tom_bind_dl_from{}
.tom_bind_dl_from input{ margin-top: 5px; margin-bottom: 5px; }
.tom_bind_dl{ margin-top: 10px; }
.tom_bind_dl span{ font-size: 18px; font-weight: 600; }
.tom_reg{ width: 90%; padding: 10px; margin-right: auto; margin-left: auto; }
.tom_reg_dl_title{ margin-top: 30px; margin-bottom: 5px; color: #666; }
.tom_reg_dl_from{}
.tom_reg_dl_from input{ margin-top: 5px; margin-bottom: 5px; }
.tom_reg_dl{ margin-top: 10px; }
.tom_reg_dl span{ font-size: 18px; font-weight: 600; }
.tom_reg_p{ font-size: 13px; color: #999; margin-top: 5px;}
.tom_user{ margin-top: 0px; width: 90%; padding: 10px; margin-right: auto; margin-left: auto; }
.tom_user img{ height: 120px; width: 120px; }
.tom_user h3{ color: #999; margin-top: 5px; }
.tom_user p{ font-size: 14px; margin-top: 0px; }
.tom_user_qx{ margin-top: 0px; }
</style>
</head>
<body>
<?php if($pageType == 'login') { ?>
<div class="tom_top">
   登录<?php echo $jyConfig['plugin_name'];?>
</div>
<div class="tom_bind" >
    <div class="tom_bind_dl_title">使用"<?php echo $jyConfig['bbs_site_name'];?>"账号登录</div>
    <div class="tom_bind_dl_from">
        <form id="loginform" onSubmit="return false;">
            <input type="text" class="form-control" id="username" name="username" placeholder="用户名">
            <input type="text" class="form-control" id="password" name="password" placeholder="密码">
            <input type="hidden" name="openid" value="<?php echo $openid;?>"/>
            <input type="hidden" name="formhash" value="<?php echo $formhash;?>">
            <input type="hidden" name="act" value="doLogin">
        </form>
    </div>
    <div class="tom_bind_dl">
      <button type="button" onClick="loginBbs();" class="btn  btn-success btn-block"><span>登 录</span></button>
    </div>
    <div class="tom_bind_zc_p"><a href="plugin.php?id=tom_love:register&amp;act=register">注册新"<?php echo $jyConfig['bbs_site_name'];?>"账号</a></div>
    <div class="tom_bind_dl">
        <a style="display:none;" href="<?php echo $qqLoginUrl;?>" class="btn btn-info btn-block"><span><img width="25" height="25" src="source/plugin/tom_love/images/qq_ico.png"/>QQ登录</span></a>
        <?php if($jyConfig['open_wx_login']==1 && $__IsWeixin==1 ) { ?>
        <a href="<?php echo $wxLoginUrl;?>" class="btn btn-info btn-block"><span><img width="28" height="28" src="source/plugin/tom_love/images/wx_ico.png"/>微信一键登录</span></a>
        <?php } ?>
    </div>
</div>
<?php } if($pageType == 'register') { ?>
<div class="tom_top">
<div class="tom_back"><a href="plugin.php?id=tom_love:register"></a></div>
   注册新账号
</div>
<div class="tom_reg">
    <div class="tom_reg_p">注册新"<?php echo $jyConfig['bbs_site_name'];?>"账号</div>
    <div class="tom_reg_dl_from">
        <form id="regform" onSubmit="return false;">
            <input type="text" class="form-control" id="username" name="username" placeholder="用户名">
            <input type="text" class="form-control" id="password" name="password" placeholder="密码">
            <input type="text" class="form-control" id="email" name="email" placeholder="邮箱">
            <input type="hidden" name="openid" value="<?php echo $openid;?>"/>
            <input type="hidden" name="formhash" value="<?php echo $formhash;?>">
            <input type="hidden" name="act" value="doRegister">
        </form>
    </div>
    <div class="tom_reg_dl">
      <button type="button" onClick="reg();" class="btn btn-warning btn-block"><span>注册账号</span></button>
    </div>
</div>
<?php } ?>
<div class="tom_user">
    <p style="text-align: center;"><a href="plugin.php?id=tom_love&amp;mod=article&amp;aid=2" style="font-size: 0.8em;"><img style="width:16px;height:16px;" src="source/plugin/tom_love/images/sign-check-icon.png"/>已经阅读并同意“<?php echo $jyConfig['plugin_name'];?>”协议</a></p>
</div>
<script>
    
var loginProcess = 0;
function loginBbs(){
    if(loginProcess == 1){
        return false;
    }
    var username = $('#username').val();
    var password = $('#password').val();
    if(username == ''){
        tusi("请填写用户名");
        return false;
    }
    if(password == ''){
        tusi("请填写密码");
        return false;
    }
    loginProcess = 1;
    $.ajax({
        type: "GET",
        url: "<?php echo $loginUrl;?>",
        data: $('#loginform').serialize(),
        success: function(msg){
            loginProcess = 0;
            var data = eval('('+msg+')');
            if(data.status==200){
                tusi("登录成功");
                setTimeout(function(){window.location="<?php echo $indexUrl;?>";},1888);
            }else if(data.status==100){
                tusi("用户名或者密码输入不正确！");
                setTimeout(function(){document.location.reload();},1888);
            }else{
                tusi("遇到错误，请重新登录");
                setTimeout(function(){document.location.reload();},1888);
            }
            
        }
    });
}

var regProcess = 0;
function reg(){
    if(regProcess == 1){
        return false;
    }
    regProcess = 1;
    var username = $('#username').val();
    var password = $('#password').val();
    var email = $('#email').val();
    if(username == ''){
        tusi("请填写用户名");
        return false;
    }
    if(password == ''){
        tusi("请填写密码");
        return false;
    }
    if(email == ''){
        tusi("请填写邮箱");
        return false;
    }
    $.ajax({
        type: "GET",
        url: "<?php echo $regUrl;?>",
        data: $('#regform').serialize(),
        success: function(msg){
            regProcess = 0;
            var data = eval('('+msg+')');
            if(data.status==200){
                tusi("注册成功");
                setTimeout(function(){window.location="<?php echo $indexUrl;?>";},1888);
            }else if(data.status==201){
                tusi("你的用户名小于3个字符，请输入较长的用户名");
            }else if(data.status==202){
                tusi("你的用户名超过15个字符，请输入较短的用户名");
            }else if(data.status==203){
                tusi("用户名包含被系统屏蔽的字符");
            }else if(data.status==301){
                tusi("用户名不合法");
            }else if(data.status==302){
                tusi("包含不允许注册的词语");
            }else if(data.status==303){
                tusi("用户名已经存在");
            }else if(data.status==304){
                tusi("Email 格式有误");
            }else if(data.status==305){
                tusi("Email 不允许注册");
            }else if(data.status==306){
                tusi("该 Email 已经被注册");
            }else{
                tusi("注册失败，请重试");
            }
        }
    });
}
</script>
</body>
</html>
