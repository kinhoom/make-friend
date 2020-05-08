<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); function tpl_global_login_extra() {
global $_G;?><?php
$__IMGDIR = IMGDIR;$return = <<<EOF

<div class="fastlg_fm y" style="margin-right: 10px; padding-right: 10px">
<p><a href="{$_G['connect']['login_url']}&statfrom=login_simple"><img src="{$__IMGDIR}/qq_login.gif" class="vm" alt="QQ登录" /></a></p>
<p class="hm xg1" style="padding-top: 2px;">只需一步，快速开始</p>
</div>

EOF;
?><?php return $return;?><?php }

function tpl_global_usernav_extra1() {
global $_G;?><?php
$__IMGDIR = IMGDIR;$return = <<<EOF


EOF;
 if(CURMODULE != 'connect') { if($_G['connectguest']) { 
$return .= <<<EOF

<span class="pipe">|</span><a href="member.php?mod=connect" target="_blank" title="体验本站更多功能">完善帐号信息</a><span class="pipe">|</span><a href="member.php?mod=connect&amp;ac=bind" target="_blank" title="使用QQ帐号快速登录本站">绑定已有帐号</a>

EOF;
 } else { 
$return .= <<<EOF

<span class="pipe">|</span><a href="connect.php?mod=config" target="_blank"><img src="{$__IMGDIR}/qq_bind_small.gif" class="qq_bind" align="absmiddle" alt="QQ绑定" /></a>

EOF;
 } } 
$return .= <<<EOF


EOF;
?><?php return $return;?><?php }

function tpl_login_bar() {
global $_G;?><?php
$__IMGDIR = IMGDIR;$return = <<<EOF


EOF;
 if(!$_G['connectguest']) { 
$return .= <<<EOF

<a href="{$_G['connect']['login_url']}&statfrom=login" target="_top" rel="nofollow"><img src="{$__IMGDIR}/qq_login.gif" class="vm" /></a>

EOF;
 } 
$return .= <<<EOF


EOF;
?><?php return $return;?><?php }

function tpl_index_status_extra() {
global $_G;?><?php
$return = <<<EOF

<iframe id="connectlike" allowtransparency="true" scrolling="no" border="0" width="280" height="25" frameborder="0"></iframe>
<script type="text/javascript">_attachEvent(window, 'load', function () { $('connectlike').src = 'api/connect/like.php';}, document);</script>

EOF;
?><?php return $return;?><?php }

function tpl_viewthread_share_method() {
global $_G;
if (!$_G['setting']['connect']['allow']) return;
$connect_thread_subject = addslashes(strip_tags($_G['thread']['subject']));?><?php
$__IMGDIR = IMGDIR;$return = <<<EOF

<a href="{$_G['connect']['qq_share_url']}" id="k_share_to_qq" title="QQ好友和群" target="_blank"><i><img src="{$__IMGDIR}/qq_share.png" alt="QQ好友和群" />QQ好友和群</i></a>

EOF;
?><?php return $return;?><?php }

function tpl_viewthread_bottom($jsurl) {
global $_G;?><?php
$__IMGDIR = IMGDIR;$return = <<<EOF

<script type="text/javascript">
var connect_qzone_share_url = '{$_G['connect']['qzone_share_url']}';
var connect_weibo_share_url = '{$_G['connect']['weibo_share_url']}';
var connect_thread_info = {
thread_url: '{$_G['siteurl']}{$GLOBALS['canonical']}',
thread_id: '{$_G['tid']}',
post_id: '{$_G['connect']['first_post']['pid']}',
forum_id: '{$_G['fid']}',
author_id: '{$_G['connect']['first_post']['authorid']}',
author: '{$_G['connect']['first_post']['author']}'
};

connect_autoshare = '{$_GET['connect_autoshare']}';
connect_isbind = '{$_G['member']['conisbind']}';
if(connect_autoshare == 1 && connect_isbind) {
_attachEvent(window, 'load', function(){
connect_share(connect_weibo_share_url, connect_openid);
});
}
</script>

EOF;
 if($_G['member']['conisbind']) { 
$return .= <<<EOF

<div id="connect_share_unbind" style="display: none;">
<div class="c hm">
<div style="font-size:14px; margin:10px 0;">绑定QQ帐号，轻松分享到QQ空间与腾讯微博</div>
<div><a href="connect.php?mod=config&amp;connect_autoshare=1" target="_blank"><img src="{$__IMGDIR}/qq_bind.gif" align="absmiddle" style="margin-top:5px;" /></a></div>
</div>
<input type="hidden" id="connect_thread_title" name="connect_thread_title" value="{$_G['forum_thread']['subject']}" />
</div>

EOF;
 } if($jsurl) { 
$return .= <<<EOF

<script type="text/javascript">_attachEvent(window, 'load', function () { appendscript('{$jsurl}', '', 1, 'utf-8') }, document);</script>

EOF;
 } 
$return .= <<<EOF


EOF;
?><?php return $return;?><?php }

function tpl_register_input() {
global $_G;

$connect_app_id = $_G['qc']['connect_app_id'];
$connect_openid = $_G['qc']['connect_openid'];?><?php
$return = <<<EOF

<input type="hidden" id="auth_hash" name="auth_hash" value="{$_G['qc']['connect_auth_hash']}" />
<input type="hidden" id="is_notify" name="is_notify" value="{$_G['qc']['connect_is_notify']}" />
<input type="hidden" id="is_feed" name="is_feed" value="{$_G['qc']['connect_is_feed']}" />

EOF;
?><?php return $return;?><?php }

function tpl_register_bottom() {
global $_G;

$loginhash = 'L'.random(4);
$change_qq_url = $_G['connect']['discuz_change_qq_url'];
$qq_nick = $_G['qc']['qq_nick'];
$connect_app_id = $_G['qc']['connect_app_id'];
$connect_openid = $_G['qc']['connect_openid'];
$connect_tab_1 = $_GET['ac'] != 'bind' && $_G['setting']['regconnect'] ? ' class="a"' : '';
$connect_tab_2 = $_GET['ac'] == 'bind' ? ' class="a"' : '';?><?php
$js2 = <<<EOF
	

EOF;
 if($_GET['ac'] == 'bind' || $_G['setting']['regconnect']) { 
$js2 .= <<<EOF

<div id="loggingbox" class="loggingbox">
<div class="loging_tit cl">			
<div class="z">
<p class="welcome mbn cl" style="clear:both; width:100%; "><strong>Hi</strong>,<strong>{$_G['member']['username']}</strong>, <span class="xg2">欢迎使用QQ帐号登录  {$_G['setting']['bbname']}</span></p>
<ul class="tb cl z">
<li id="connect_tab_1"{$connect_tab_1}><a id="loginlist" href="javascript:;" onclick="connect_switch(1);this.blur();" tabindex="900">创建新帐号</a></li>
<li id="connect_tab_2"{$connect_tab_2}><a id="loginlist2" href="javascript:;" onclick="connect_switch(2);this.blur();" tabindex="900">已有本站帐号</a></li>
</ul>
</div>
</div>
</div>

EOF;
 } 
$js2 .= <<<EOF


EOF;
?><?php $js2 = str_replace(array("'", "\r", "\n"), array("\'", '', ''), $js2);?><?php
$__FORMHASH = FORMHASH;$__IMGDIR = IMGDIR;$return = <<<EOF

<div class="b1lr">
<form method="post" autocomplete="off" name="login" id="loginform_{$loginhash}" class="cl"
EOF;
 if($_G['setting']['regconnect']) { 
$return .= <<<EOF
 style="display:none"
EOF;
 } 
$return .= <<<EOF
 onsubmit="ajaxpost('loginform_{$loginhash}', 'returnmessage4', 'returnmessage4', 'onerror');return false;" action="member.php?mod=connect&amp;action=login&amp;loginsubmit=yes
EOF;
 if(!empty($_GET['handlekey'])) { 
$return .= <<<EOF
&amp;handlekey={$_GET['handlekey']}
EOF;
 } 
$return .= <<<EOF
&amp;loginhash={$loginhash}">
<div class="c cl bm_c">
<input type="hidden" name="formhash" value="{$__FORMHASH}" />
<input type="hidden" name="referer" value="{$_G['qc']['dreferer']}" />
<input type="hidden" id="auth_hash" name="auth_hash" value="{$_G['qc']['connect_auth_hash']}" />
<input type="hidden" id="is_notify" name="is_notify" value="{$_G['qc']['connect_is_notify']}" />
<input type="hidden" id="is_feed" name="is_feed" value="{$_G['qc']['connect_is_feed']}" />

EOF;
 if($_G['qc']['uinlimit']) { 
$return .= <<<EOF

<div class="rfm">
<table>
<tr>
<th><img src="{$__IMGDIR}/connect_qq.gif" alt="QQ" class="mtn" /></th>
<td>
您的QQ帐号在本站注册的帐号数量达到上限，请绑定已有帐号，或<a href="{$change_qq_url}">更换其他QQ账号</a>
</td>
</tr>
</table>
</div>

EOF;
 } 
$return .= <<<EOF

<div class="rfm">
<table>
<tr>
<th>

EOF;
 if($_G['setting']['autoidselect']) { 
$return .= <<<EOF

<label for="username">帐号:</label>

EOF;
 } else { 
$return .= <<<EOF

<span class="login_slct">
<select name="loginfield" style="float: left;" width="45" id="loginfield_{$loginhash}">
<option value="username">用户名</option>
<option value="uid">UID</option>
<option value="email">Email</option>
</select>
</span>

EOF;
 } 
$return .= <<<EOF

</th>
<td><input type="text" name="username" id="username_{$loginhash}" autocomplete="off" size="36" class="txt" tabindex="1" value="{$username}" /></td>
</tr>
</table>
</div>

<div class="rfm">
<table>
<tr>
<th><label for="password3_{$loginhash}">密码:</label></th>
<td><input type="password" id="password3_{$loginhash}" name="password" size="36" class="txt" tabindex="1" /></td>
</tr>
</table>
</div>

<div class="rfm">
<table>
<tr>
<th>安全提问:</th>
<td><select id="loginquestionid_{$loginhash}" width="213" name="questionid" onchange="if($('loginquestionid_{$loginhash}').value > 0) $('loginanswer_row_{$loginhash}').style.display=''; else $('loginanswer_row_{$loginhash}').style.display='none'">
<option value="0">安全提问(未设置请忽略)</option>
<option value="1">母亲的名字</option>
<option value="2">爷爷的名字</option>
<option value="3">父亲出生的城市</option>
<option value="4">您其中一位老师的名字</option>
<option value="5">您个人计算机的型号</option>
<option value="6">您最喜欢的餐馆名称</option>
<option value="7">驾驶执照最后四位数字</option>
</select></td>
</tr>
</table>
</div>

<div class="rfm" id="loginanswer_row_{$loginhash}" style="display:none">
<table>
<tr>
<th>答案:</th>
<td><input type="text" name="answer" id="loginanswer_{$loginhash}" autocomplete="off" size="36" class="txt" tabindex="1" /></td>
</tr>
</table>
</div>				
</div>
<div class="rfm mbw bw0">
<table>
<tr>
<th>&nbsp;</th>
<td><button class="pn pnc" type="submit" name="loginsubmit" value="true" tabindex="1"><strong>绑定帐号</strong></button></td>
</tr>
</table>
</div>
</form>
</div>
<style type="text/css">
.loggingbox { width: 760px; margin: 40px auto 0; }
.loging_tit { border-bottom: 1px solid #CCC; _overflow:hidden; }
.ie_all .loging_tit { height:66px;}
.loggingbox .fm_box { border-bottom:0; padding: 20px 0; }
.loggingbox .welcome { font-size:14px; width:100%; line-height:30px;}
.loggingbox .welcome span { font-size:12px; }
.loggingbox .avt img { margin: 0 5px 5px 0; padding:0; border:0; width:60px; height:60px; }
.loggingbox .tb{ border-bottom: 0; margin-top: 0; padding-left: 0px; }
.loggingbox .tb a { background:#F6F6F6; padding:0 20px; }
.loggingbox .tb .a a { background:#FFF; }
</style>
<script type="text/javascript">

EOF;
 if($_G['setting']['regconnect']) { 
$return .= <<<EOF

$('reginfo_a').parentNode.className = '';
$('{$_G['setting']['reginput']['password']}').parentNode.parentNode.parentNode.parentNode.parentNode.style.display = 'none';
$('{$_G['setting']['reginput']['username']}').outerHTML += '{$js1}';
$('{$_G['setting']['reginput']['password']}').required = 0;
$('{$_G['setting']['reginput']['password2']}').parentNode.parentNode.parentNode.parentNode.parentNode.style.display = 'none';
$('{$_G['setting']['reginput']['password2']}').required = 0;
$('main_hnav').outerHTML = '{$js2}';
function connect_switch(op) {
$('returnmessage4').className='';
$('returnmessage4').innerHTML='';
if(op == 1) {
$('loginform_{$loginhash}').style.display='none';$('registerform').style.display='block';
$('connect_tab_1').className = 'a';
$('connect_tab_2').className = '';
//$('connect_login_register_tip').style.display = '';
//$('connect_login_bind_tip').style.display = 'none';

} else {
$('loginform_{$loginhash}').style.display='block';$('registerform').style.display='none';
$('connect_tab_2').className = 'a';
$('connect_tab_1').className = '';
//$('connect_login_register_tip').style.display = 'none';
//$('connect_login_bind_tip').style.display = '';
}
}
function connect_use_available(value) {
$('{$_G['setting']['reginput']['username']}').value = value;
checkusername(value);
}

EOF;
 if($_G['qc']['uinlimit']) { 
$return .= <<<EOF

$('registerformsubmit').disabled = true;

EOF;
 } if($_GET['action'] != 'activation') { 
$return .= <<<EOF

$('registerformsubmit').innerHTML = '<span>完成，继续浏览</span>';

EOF;
 } } else { 
$return .= <<<EOF

$('layer_reginfo_t').innerHTML = '绑定已有帐号';

EOF;
 } if($_GET['action'] != 'activation') { if(!$_G['setting']['autoidselect']) { 
$return .= <<<EOF

simulateSelect('loginfield_{$loginhash}');

EOF;
 } } if($_G['setting']['regconnect'] && $_GET['ac'] != 'bind') { 
$return .= <<<EOF

function connect_get_user_info() {
var x = new Ajax();
x.get('connect.php?mod=user&op=get&hash={$__FORMHASH}&inajax=1&_r='+Math.random(), function(s){
var nick = s;
if(nick) {
document.getElementById('{$_G['setting']['reginput']['username']}').value = nick;
}
});
}
window.load=connect_get_user_info();

EOF;
 } 
$return .= <<<EOF

</script>

EOF;
?><?php return $return;?><?php }

function tpl_spacecp_profile_bottom() {
global $_G;?><?php
$__FORMHASH = FORMHASH;$return = <<<EOF

<script type="text/javascript">
function connect_handle_get_weibosign(response, ajax) {
// 返回值形如: errCode=XX&result=XX
if (typeof(response) == "string" && response.indexOf("&") > 0) {

var errCode = response.substring(0, response.indexOf("&"));
errCode = errCode.substring(errCode.indexOf("=") + 1);

var result = response.substring(response.indexOf("&") + 1);
result = result.substring(result.indexOf("=") + 1);

response = {"errCode" : errCode, "result" : result};
} else {
return false;
}

if (response.errCode == '0') {
seditor_insertunit('sightml', response.result);
} else {
// 请求失败
showDialog('网络繁忙，暂时无法使用腾讯微博签名档功能');
}
}

function connect_get_weibosign() {
var sign_url = '{$_G['siteurl']}connect.php?mod=config&op=weibosign&hash={$__FORMHASH}&_r='+Math.random();
var get_weibosign_ajax = Ajax("HTML", null);
get_weibosign_ajax.get(sign_url, connect_handle_get_weibosign);
}

if($('sightmlsml')) {
var a = document.createElement('a');
a.href = 'javascript:void(0);';
a.style.background = 'url(' + STATICURL + 'image/common/weibo.png) no-repeat 0 2px';
a.onmouseover = function () { showTip(this); };
a.onclick = connect_get_weibosign;
a.setAttribute('tip', '插入腾讯微博做为论坛签名，可第一时间将您的微博最新信息展示给本站的会员和游客');
$('sightmlsml').parentNode.appendChild(a);
}
</script>

EOF;
?><?php return $return;?><?php }?>