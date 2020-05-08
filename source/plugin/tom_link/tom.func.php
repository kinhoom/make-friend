<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

function tomgetfileurl($url){
    global $_G;
    $pic_url = "";
    if(!empty($url)){
        if(!preg_match('/^http:/', $url) ){
            $pic_url = (preg_match('/^http:/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$url;
        }else{
            $pic_url = $url;
        }
    }
    return $pic_url;
}

function loadeditorjs(){
    if (CHARSET == 'gbk'){
        echo '<script charset="gbk" src="source/plugin/tom_editor/editor/kindeditor-min.js" reload="true"></script>';
        echo '<script src="source/plugin/tom_editor/editor/lang/zh_CN.js" type="text/javascript" reload="true"></script>';
    }else{
        echo '<script charset="gbk" src="source/plugin/tom_editor/editor/kindeditor-min.js" reload="true"></script>';
        echo '<script src="source/plugin/tom_editor/editor/lang/zh_CN_UTF8.js" type="text/javascript" reload="true"></script>';
    }
    return;
}

function tomshownavheader(){
    showtableheader();
    echo '<tr><th colspan="15" class="itemtitle" style="background-color: #DEEFFA;"><ul class="tab1" style="margin-bottom: 0px;">';
    return;
}
function tomshownavli($title,$link,$cur = false,$_blank = false){
    if($cur){
        echo '<li class="current"><a><span>'.$title.'</span></a></li>';
    }else{
        if($_blank){
            echo '<li><a style="color: #2366A8;" href="'.$link.'" target="_blank"><span>'.$title.'</span></a></li>';
        }else{
            echo '<li><a style="color: #2366A8;" href="'.$link.'"><span>'.$title.'</span></a></li>';
        }
    }
    return;
}
function tomshownavfooter(){
    echo '</ul></th></tr>';
    showtablefooter();
    return;
}

function tomuploadFile($name = "",$old_file =""){
    global $_G;
    if($_FILES[$name]['tmp_name']) {
        $upload = new discuz_upload();
        if(!getimagesize($_FILES[$name]['tmp_name']) || !$upload->init($_FILES[$name], 'common', random(3, 1), random(8)) || !$upload->save()) {
            cpmsg($upload->errormessage(), '', 'error');
        }
        $file_url = $upload->attach['attachment'];
        if(!empty($old_file)){
            if(file_exists($_G['setting']['attachdir'].'common/'.$old_file)){
                @unlink($_G['setting']['attachdir'].'common/'.$old_file);
            }
        }
    } else {
        $file_url = addslashes($_GET[$name]);
    }
    return $file_url;
}

function tomshowsetting($param = array(),$type){
    if($type == 'input'){
        tomcreateInput($param);
    }else if($type == 'calendar'){
        tomcreateCalendar($param);
    }else if($type == 'textarea'){
        tomcreateTextarea($param);
    }else if($type == 'text'){
        tomcreateText($param);
    }else if($type == 'radio'){
        tomcreateRadio($param);
    }else if($type == 'select'){
        tomcreateSelect($param);
    }else if($type == 'file'){
        tomcreateFile($param);
    }
    return;
}

function tomcreateInput($config = array()){
    $outStr = '';
    $options = array(
        'title'  => 'title',
        'name'   => 'name',
        'value'  => '',
        'msg'   => '',
        'size'   => 40,
    );
    $options = array_merge($options, $config);

    $outStr = '<tr class="header"><th>'.$options['title'].'</th><th></th></tr>';
    $outStr.= '<tr><td width="300"><input name="'.$options['name'].'" type="text" value="'.$options['value'].'" size="'.$options['size'].'" /></td><td>'.$options['msg'].'</td></tr>';

    echo $outStr;
    return;
}

function tomcreateCalendar($config = array()){
    $tomSysOffset = getglobal('setting/timeoffset');
    $outStr = '';
    $options = array(
        'title'  => 'title',
        'name'   => 'name',
        'value'  => '',
        'msg'   => '',
        'size'   => 40,
    );
    $options = array_merge($options, $config);
    
    if(!empty($options['value'])){
        $options['value'] = dgmdate($options['value'],"Y-m-d H:i:s",$tomSysOffset);
    }

    $outStr = '<tr class="header"><th>'.$options['title'].'</th><th></th></tr>';
    $outStr.= '<tr><td width="300"><input name="'.$options['name'].'" type="text" value="'.$options['value'].'" onclick="showcalendar(event, this, 1)" size="'.$options['size'].'" /></td><td>'.$options['msg'].'</td></tr>';

    echo $outStr;
    return;
}
    
function tomcreateTextarea($config = array()){
    $outStr = '';
    $options = array(
        'title'  => 'title',
        'name'   => 'name',
        'value'  => '',
        'msg'   => '',
        'rows'   => 6,
        'cols'   => 40,
    );
    $options = array_merge($options, $config);
    
    $options['value'] = stripslashes($options['value']);

    $outStr = '<tr class="header"><th>'.$options['title'].'</th><th></th></tr>';
    $outStr.= '<tr><td width="300"><textarea rows="'.$options['rows'].'" name="'.$options['name'].'" cols="'.$options['cols'].'" >'.$options['value'].'</textarea></td><td>'.$options['msg'].'</td></tr>';

    echo $outStr;
    return;
}

function tomcreateText($config = array()){
    $outStr = '';
    $options = array(
        'title'  => 'title',
        'name'   => 'name',
        'value'  => '',
        'msg'   => '',
    );
    $options = array_merge($options, $config);
    
    $options['value'] = stripslashes($options['value']);

    $outStr = '<tr class="header"><th>'.$options['title'].'</th><th>'.$options['msg'].'</th></tr>';
    $outStr.= '<tr><td width="300" colspan="2"><textarea name="'.$options['name'].'" id="'.$options['name'].'" style="width:700px;height:300px">'.$options['value'].'</textarea></td></tr>';
$jsStr = <<<EOF
<script type="text/javascript" reload="true">
        KindEditor.ready(function(K) {
              window.editor = KindEditor.create('#{$options['name']}');
        });
</script>
EOF;
    echo $outStr;
    echo $jsStr;
    return;
}

function tomcreateRadio($config = array()){
    $outStr = '';
    $options = array(
        'title'  => 'title',
        'name'   => 'name',
        'value'  => '',
        'msg'   => '',
        'item'   => array(),
    );
    $options = array_merge($options, $config);

    $outStr = '<tr class="header"><th>'.$options['title'].'</th><th></th></tr>';
    $outStr.= '<tr><td width="300">';
    foreach ($options['item'] as $key => $value){
        if($key == $options['value']){
            $outStr.= '<input type="radio" name="'.$options['name'].'" value="'.$key.'" checked>'.$value.'&nbsp;';
        }else{
            $outStr.= '<input type="radio" name="'.$options['name'].'" value="'.$key.'" >'.$value.'&nbsp;';
        }
    }
    $outStr.= '</td><td>'.$options['msg'].'</td></tr>';

    echo $outStr;
    return;
}

function tomcreateSelect($config = array()){
    $outStr = '';
    $options = array(
        'title'     => 'title',
        'name'      => 'name',
        'value'     => '',
        'msg'      => '',
        'item'      => array(),
    );
    $options = array_merge($options, $config);

    $outStr = '<tr class="header"><th>'.$options['title'].'</th><th></th></tr>';
    $outStr.= '<tr><td width="300"><select name="'.$options['name'].'" >';
    foreach ($options['item'] as $key => $value){
        if($key == $options['value']){
            $outStr.=  '<option value="'.$key.'" selected>'.$value.'</option>';
        }else{
            $outStr.=  '<option value="'.$key.'">'.$value.'</option>';
        }
    }
    $outStr.= '</select></td><td>'.$options['msg'].'</td></tr>';

    echo $outStr;
    return;
}

function tomcreateFile($config = array()){
    global $_G;
    $outStr = '';
    $options = array(
        'title'  => 'title',
        'name'   => 'name',
        'value'  => '',
        'msg'   => '',
        'size'   => 40,
    );
    $options = array_merge($options, $config);
    
    if(!empty($options['value'])){
        if(!preg_match('/^http:/', $options['value']) ){
            $pic_url = (preg_match('/^http:/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$options['value'];
        }else{
            $pic_url = $options['value'];
        }
        $options['msg'] = $options['msg'].'<br/><a target="_blank" href="'.$pic_url.'"><img src="'.$pic_url.'" width="100" /></a>';
    }
    showsetting($options['title'],$options['name'], $options['value'], 'filetext',0,0,$options['msg']);
    echo $outStr;
    return;
}


