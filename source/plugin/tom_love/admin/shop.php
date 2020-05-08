<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')){
    exit('Access Denied');
}

$modBaseUrl = $adminBaseUrl.'&tmod=shop';
$modListUrl = $adminListUrl.'&tmod=shop';
$modFromUrl = $adminFromUrl.'&tmod=shop';

$get_list_url_value = get_list_url("tom_love_admin_shop_list");
if($get_list_url_value){
    $modListUrl = $get_list_url_value;
}
if($_GET['act'] == 'add'){
    if(submitcheck('submit')){
        $insertData = array();
        $insertData = __get_post_data();
        C::t('#tom_love#tom_love_shop_goods')->insert($insertData);
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        loadeditorjs();
        __create_nav_html();
        showformheader($modFromUrl.'&act=add','enctype');
        showtableheader();
        __create_info_html();
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
}else if($_GET['act'] == 'edit'){
    $shopGoodsInfo = C::t('#tom_love#tom_love_shop_goods')->fetch_by_id($_GET['id']);
    if(submitcheck('submit')){
        $updateData = array();
        $updateData = __get_post_data($shopGoodsInfo);
        C::t('#tom_love#tom_love_shop_goods')->update($shopGoodsInfo['id'], $updateData);
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        loadeditorjs();
        __create_nav_html();
        showformheader($modFromUrl.'&act=edit&id='.$_GET['id'],'enctype');
        showtableheader();
        __create_info_html($shopGoodsInfo);
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
}else if($_GET['act'] == 'del'){
    
    C::t('#tom_love#tom_love_shop_goods')->delete_by_id($_GET['id']);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    
}else if($_GET['act'] == 'orderEdit' && $_GET['formhash'] == FORMHASH){
    $orderInfo = C::t('#tom_love#tom_love_shop_order')->fetch_by_id($_GET['id']);
    $order_status = isset($_GET['order_status']) ? intval($_GET['order_status']) : 0;
    if(is_array($orderInfo) && !empty($orderInfo)){
        $updateData = array();
        $updateData['order_status'] = $order_status;
        C::t('#tom_love#tom_love_shop_order')->update($orderInfo['id'], $updateData);
        cpmsg($Lang['act_success'], $modListUrl.'&act=order', 'succeed');
    }
    
}else if($_GET['act'] == 'order'){
    $page = isset($_GET['page']) > 0 ? intval($_GET['page']) : 1;
    $pagesize = 15;
    $start = ($page-1)*$pagesize;
    $shopOrderList = C::t('#tom_love#tom_love_shop_order')->fetch_all_list("", " ORDER BY id DESC", $start, $pagesize);
    $shopOrderCount = C::t('#tom_love#tom_love_shop_order')->fetch_all_count('');

    __create_nav_html();
    showtableheader();
    echo '<tr class="header">';
    echo '<th>'.$Lang['shop_order_id'].'</th>';
    echo '<th>'.$Lang['shop_order_user_id'].'</th>';
    echo '<th>'.$Lang['shop_order_user_name'].'</th>';
    echo '<th>'.$Lang['shop_order_goods'].'</th>';
    echo '<th>'.$Lang['shop_order_xm'].'</th>';
    echo '<th>'.$Lang['shop_order_tel'].'</th>';
    echo '<th>'.$Lang['shop_order_address'].'</th>';
    echo '<th>'.$Lang['shop_order_status'].'</th>';
    echo '<th>'.$Lang['shop_order_time'].'</th>';
    echo '<th>'.$Lang['handle'].'</th>';
    echo '</tr>';
    
    $i = 1;
    foreach($shopOrderList as $key => $value){
        $userInfo = C::t('#tom_love#tom_love')->fetch_by_id($value['user_id']);
        $goodsInfo = C::t('#tom_love#tom_love_shop_goods')->fetch_by_id($value['goods_id']);
        echo '<tr>';
        echo '<td>'.$value['id'].'</td>';
        echo '<td>'.$value['user_id'].'</td>';
        echo '<td><a href="'.$adminBaseUrl.'&tmod=user&act=show&id='.$value['user_id'].'&formhash='.FORMHASH.'" target="_blank">'.$userInfo['nickname'].'('.$Lang['shop_order_flowerslog'].')</a></td>';
        echo '<td>'.$goodsInfo['goods_name'].'</td>';
        echo '<td>'.$value['xm'].'</td>';
        echo '<td>'.$value['tel'].'</td>';
        echo '<td>'.$value['address'].'</td>';
        
        $order_status = '';
        if($value['order_status'] == 1){
            $order_status = $Lang['shop_order_status_1'];
        }else if($value['order_status'] == 2){
            $order_status = $Lang['shop_order_status_2'];
        }else if($value['order_status'] == 3){
            $order_status = $Lang['shop_order_status_3'];
        }else if($value['order_status'] == 4){
            $order_status = $Lang['shop_order_status_4'];
        }else{
            $order_status = $Lang['shop_order_status_0'];
        }
        echo '<td>'. $order_status .'</td>';
        echo '<td>'. dgmdate($value['add_time'], 'Y-m-d H:i:s',$tomSysOffset) .'</td>';
        echo '<td>';
        if($value['order_status'] == 1){
            echo '<a href="'.$modBaseUrl.'&act=orderEdit&id='.$value['id'].'&formhash='.FORMHASH.'&order_status=2">'.$Lang['shop_order_duihuan_2'].'</a>&nbsp;|&nbsp;';
            echo '<a href="'.$modBaseUrl.'&act=orderEdit&id='.$value['id'].'&formhash='.FORMHASH.'&order_status=3">'.$Lang['shop_order_duihuan_3'].'</a>&nbsp;';
        }elseif($value['order_status'] == 2){
            echo '<a href="'.$modBaseUrl.'&act=orderEdit&id='.$value['id'].'&formhash='.FORMHASH.'&order_status=4">'.$Lang['shop_order_duihuan_4'].'</a>&nbsp;|&nbsp;';
            echo '<a href="'.$modBaseUrl.'&act=orderEdit&id='.$value['id'].'&formhash='.FORMHASH.'&order_status=3">'.$Lang['shop_order_duihuan_3'].'</a>&nbsp;';
        }elseif($value['order_status'] == 3){
            echo '<a href="'.$modBaseUrl.'&act=orderEdit&id='.$value['id'].'&formhash='.FORMHASH.'&order_status=2">'.$Lang['shop_order_duihuan_2'].'</a>';
        }elseif($value['order_status'] == 4){
            echo $Lang['shop_order_status_4'];
        }
        echo '</td>';
        echo '</tr>';
        $i++;
    }
    showtablefooter();
    $multi = multi($shopOrderCount, $pagesize, $page, $modBaseUrl.'&act=order');
    showsubmit('', '', '', '', $multi, false);
    
}else{
    set_list_url("tom_love_admin_shop_list");
    $page = intval($_GET['page']) > 0 ?intval($_GET['page']) : 1;
    $pagesize = 15;
    $start = ($page-1)*$pagesize;
    $shopGoodsList = C::t('#tom_love#tom_love_shop_goods')->fetch_all_list("", " ORDER BY id DESC", $start, $pagesize);
    $shopGoodsCount = C::t('#tom_love#tom_love_shop_goods')->fetch_all_count('');
    __create_nav_html();
    showtableheader();
    echo '<tr class="header"> ';
    echo '<th>'.$Lang['shop_goods_id'].'</th>';
    echo '<th>'.$Lang['shop_goods_title'].'</th>';
    echo '<th>'.$Lang['shop_goods_picurl'].'</th>';
    echo '<th>'.$Lang['shop_goods_num'].'</th>';
    echo '<th>'.$Lang['shop_goods_prize'].'</th>';
    echo '<th>'.$Lang['shop_goods_xihuashu'].'</th>';
    echo '<th>'.$Lang['shop_goods_time'].'</th>';
    echo '<th>'.$Lang['shop_goods_show'].'</th>';
    echo '<th>'.$Lang['handle'].'</th>';
    echo '</tr>';
    $i =1;
    foreach($shopGoodsList as $key => $value){
        if(!preg_match('/^http/',$value['goods_picurl'])){
            $picurl = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$value['goods_picurl'];
        }else{
            $picurl = $value['goods_picurl'];
        }
        
        echo '<tr>';
        echo '<td>'.$value['id'].'</td>';
        echo '<td>'.$value['goods_name'].'</td>';
        echo '<td><img width="40" height="40" src="'.$picurl.'"></td>';
        echo '<td>'.$value['goods_num'].'</td>';
        echo '<td>'.$value['market_price'].'</td>';
        echo '<td>'.$value['flowers_num'].'</td>';
        echo '<td>'.dgmdate($value['add_time'], 'Y-m-d H:i:s',$tomSysOffset).'</td>';
        
        $is_show = '';
        if($value['is_show'] == 1){
            $is_show = $Lang['shop_goods_show_yes'];
        }else{
            $is_show = $Lang['shop_goods_show_no'];
        }
        echo '<td>'.$is_show.'</td>';
        echo '<td>';
        echo '<a href="'.$modBaseUrl.'&act=edit&id='.$value['id'].'&formhash='.FORMHASH.'">'.$Lang['shop_goods_edit'].'</a>&nbsp;|&nbsp';
        echo '<a href="javascript:void(0);" onclick="del_confirm(\''.$modBaseUrl.'&act=del&id='.$value['id'].'&formhash='.FORMHASH.'\');">'.$Lang['shop_goods_del'].'</a>&nbsp;';
        echo '</td>';
        echo '</tr>';
        $i++;
    }
    showtablefooter();
    $multi = multi($shopGoodsCount, $pagesize, $page, $modBaseUrl);
    showsubmit('', '', '', '', $multi, false);
    
    $jsstr = <<<EOF
<script type="text/javascript">
function del_confirm(url){
  var r = confirm("{$Lang['makesure_del_msg']}")
  if (r == true){
    window.location = url;
  }else{
    return false;
  }
}
</script>
EOF;
    echo $jsstr;   
    
}

function __get_post_data($infoArr = array()){
    global $jyConfig;
    $data = array();
    
    $goods_name   = isset($_GET['goods_name'])? addslashes($_GET['goods_name']):'';
    $goods_num    = isset($_GET['goods_num'])? intval($_GET['goods_num']):0;
    $market_price = isset($_GET['market_price'])? intval($_GET['market_price']):0;
    $flowers_num  = isset($_GET['flowers_num'])? intval($_GET['flowers_num']):0;
    $content      = isset($_GET['content'])? addslashes($_GET['content']):'';
    $add_time     = TIMESTAMP;
    $is_show      = isset($_GET['is_show'])? addslashes($_GET['is_show']):1;
    
    $picurl = "";
    if($_GET['act'] == 'add'){
        $picurl        = tomuploadFile("goods_picurl");
    }else if($_GET['act'] == 'edit'){
        $picurl        = tomuploadFile("goods_picurl",$infoArr['goods_picurl']);
    }

    $data['goods_name']      = $goods_name;
    $data['goods_picurl']    = $picurl;
    $data['goods_num']       = $goods_num;
    $data['market_price']    = $market_price;
    $data['flowers_num']     = $flowers_num;
    $data['content']         = $content;
    $data['add_time']        = $add_time;
    $data['is_show']         = $is_show;
    
    return $data;
}

function __create_info_html($infoArr = array()){
    global $Lang;
    $options = array(
        'goods_name'              => '',
        'goods_picurl'         => '',
        'goods_num'          => '',
        'market_price'       => '',
        'flowers_num'       => '',
        'content'           => '',
        'is_show'           => 1,
        
    );
    $options = array_merge($options, $infoArr);
    
    tomshowsetting(array('title'=>$Lang['shop_goods_title'],'name'=>'goods_name','value'=>$options['goods_name'],'msg'=>$Lang['shop_goods_title_msg']),"input");
    tomshowsetting(array('title'=>$Lang['shop_goods_picurl'],'name'=>'goods_picurl','value'=>$options['goods_picurl'],'msg'=>$Lang['shop_goods_picurl_msg']),"file");
    tomshowsetting(array('title'=>$Lang['shop_goods_num'],'name'=>'goods_num','value'=>$options['goods_num'],'msg'=>$Lang['shop_goods_num_msg']),"input");
    tomshowsetting(array('title'=>$Lang['shop_goods_prize'],'name'=>'market_price','value'=>$options['market_price'],'msg'=>$Lang['shop_goods_prize_msg']),"input");
    tomshowsetting(array('title'=>$Lang['shop_goods_xihuashu'],'name'=>'flowers_num','value'=>$options['flowers_num'],'msg'=>$Lang['shop_goods_xihuashu_msg']),"input");
    tomshowsetting(array('title'=>$Lang['shop_goods_content'],'name'=>'content','value'=>$options['content'],'msg'=>$Lang['shop_goods_content_msg']),"edit");
    
    $is_show_item = array(1=>$Lang['shop_goods_show_yes'],2=>$Lang['shop_goods_show_no']);
    tomshowsetting(array('title'=>$Lang['shop_goods_show'],'name'=>'is_show','value'=>$options['is_show'],'msg'=>$Lang['shop_goods_show_msg'], 'item'=>$is_show_item),"radio");
    return;
}

function __create_nav_html($infoArr = array()){
    global $Lang,$modBaseUrl,$adminBaseUrl;
    tomshownavheader();
    if($_GET['act'] == 'add'){
        tomshownavli($Lang['shop_goods_user_list'],$modBaseUrl."&act=order",false);
        tomshownavli($Lang['shop_goods_list_title'],$modBaseUrl,false);
        tomshownavli($Lang['shop_goods_add'],"",true);
    }else if($_GET['act'] == 'edit'){
        tomshownavli($Lang['shop_goods_user_list'],$modBaseUrl."&act=order",false);
        tomshownavli($Lang['shop_goods_list_title'],$modBaseUrl,false);
        tomshownavli($Lang['shop_goods_add'],$modBaseUrl."&act=add",false);
        tomshownavli($Lang['shop_goods_edit'],"",true);
    }else if($_GET['act'] == 'order'){
        tomshownavli($Lang['shop_goods_user_list'],$modBaseUrl."&act=order",true);
        tomshownavli($Lang['shop_goods_list_title'],$modBaseUrl,false);
        tomshownavli($Lang['shop_goods_add'],$modBaseUrl."&act=add",false);
    }else{
        tomshownavli($Lang['shop_goods_user_list'],$modBaseUrl."&act=order",false);
        tomshownavli($Lang['shop_goods_list_title'],$modBaseUrl,true);
        tomshownavli($Lang['shop_goods_add'],$modBaseUrl."&act=add",false);
    }
    tomshownavfooter();
}