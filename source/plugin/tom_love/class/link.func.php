<?php
/**
 * 
 * ��������Ʒ ������Ʒ
 * ������  ȫ���׷� https://dwz.cn/bEeiwujz
 * ����Դ��Դ�������ռ�,��������ѧϰ�о����ͣ�����������ҵ��;����������24Сʱ��ɾ��!
 * ��л֧�֣�����֧�����������Ķ�����Ϊվ���ṩ���ʺϵ���Ӫ��Դ��
 * ��ӭ������û�����¸��µ�������Դ������VIP��ɫ��Դ���ݴ������
 * [������]վ������Ⱥ: ��Ⱥ 205670720
 * ����������https://www.dashulai.com/ (���ղر���!)
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