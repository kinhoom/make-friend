<?php
/**
 * 
 * 大叔来出品 必属精品
 * 大叔来  全网首发 https://dwz.cn/bEeiwujz
 * 本资源来源于网络收集,仅供个人学习研究欣赏，请勿用于商业用途，并于下载24小时后删除!
 * 感谢支持！您的支持是我们最大的动力！为站长提供最适合的运营资源！
 * 欢迎大家来访获得最新更新的优秀资源！更多VIP特色资源不容错过！！
 * [大叔来]站长交流群: ①群 205670720
 * 永久域名：https://www.dashulai.com/ (请收藏备用!)
 * 
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function tomoutput(){
    global $_G;
    
    $INminiprogram = false;
    $cookie_tom_miniprogram = getcookie('tom_miniprogram');
    if($cookie_tom_miniprogram == 1 || $_GET['f'] == 'miniprogram'){
        $INminiprogram = true;
    }
    
    if($INminiprogram){
        $content = ob_get_contents();
        $content = preg_replace('#\s+href="(plugin.php?[^"]*)"#', ' data-href="'.$_G['siteurl'].'\\1" onclick="jumpMiniprogram(\''.$_G['siteurl'].'\\1&f=miniprogram\');"', $content);
        $content = str_replace('res.wx.qq.com/open/js/jweixin-1.0.0.js', 'res.wx.qq.com/open/js/jweixin-1.3.2.js', $content);
        ob_end_clean();
        $_G['gzipcompress'] ? ob_start('ob_gzhandler') : ob_start();
        echo $content;
        echo '<script src="source/plugin/tom_love/images/miniprogram.js?v=20180503"></script>';
    }
    
    exit;
}

function tom_link_replace($string){
    global $_G;
    
    $INminiprogram = false;
    $cookie_tom_miniprogram = getcookie('tom_miniprogram');
    if($cookie_tom_miniprogram == 1 || $_GET['f'] == 'miniprogram'){
        $INminiprogram = true;
    }
    
    if($INminiprogram){
        $string = preg_replace('#\s+href="(plugin.php?[^"]*)"#', ' data-href="'.$_G['siteurl'].'\\1" onclick="jumpMiniprogram(\''.$_G['siteurl'].'\\1&f=miniprogram\');"', $string);
        $string = preg_replace('#\s+href="(http[^"]*)"#', ' data-href="\\1" onclick="jumpMiniprogram(\'\\1&f=miniprogram\');"', $string);
    }
    return $string;
}