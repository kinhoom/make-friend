<?php
if(!defined('IN_DISCUZ')){
    echo 'Access Denied';
}

if($__UserInfo['id'] > 0 && $jyConfig['flowers_goods_switch'] == 1){
}else{
    dheader('location:'.$_G['siteurl']."plugin.php?id=tom_love&mod=index");exit;
}

if($_GET['act'] == 'shopDetails' && $_GET['formhash'] == FORMHASH){
    $outStr = '';

    $goods_id = isset($_GET['goods_id']) ? intval($_GET['goods_id']) : 0 ;
    
    $goodsInfo = C::t('#tom_love#tom_love_shop_goods')->fetch_by_id($goods_id);
 
    if(is_array($goodsInfo) && !empty($goodsInfo)){
        if(!preg_match('/^http/', $goodsInfo['goods_picurl'])){
            $goodsInfo['goods_picurl'] = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$goodsInfo['goods_picurl'];  
        }else{
            $goodsInfo['goods_picurl'] = $goodsInfo['goods_picurl'];
        }
        $goodsInfo['content'] = stripslashes($goodsInfo['content']);
       
        $outStr.= '<section id="shop_xq" class="">';
            $outStr.='<div class="poupo clearfix">';
                $outStr.='<div class="pic clearfix">';
                    $outStr.='<img src="'.$goodsInfo['goods_picurl'].'">';
                $outStr.='</div>';
                $outStr.='<div class="title clearfix">';
                    $outStr.='<h4>&nbsp;'.$goodsInfo['goods_name'].'</h4>';
                    $outStr.='<table>';
                        $outStr.='<tr style="line-height: 15px;">';
                            $outStr.='<td>'.lang('plugin/tom_love', 'shop_flowers_num').'</td>';
                            $outStr.='<td><font color="#fd0d0d">'.$goodsInfo['flowers_num'].lang('plugin/tom_love', 'shop_flowers_num_1').'</font></td>';
                        $outStr.='</tr>';
                        $outStr.='<tr style="line-height: 15px;">';
                            $outStr.='<td>'.lang('plugin/tom_love', 'shop_prize').'</td>';
                            $outStr.='<td><font color="#fd0d0d">'.$goodsInfo['market_price'].lang('plugin/tom_love', 'shop_prize_1').'</font></td>';
                        $outStr.='</tr>';
                        $outStr.='<tr style="line-height: 15px;">';
                            $outStr.='<td>'.lang('plugin/tom_love', 'shop_sy').'</td>';
                            $outStr.='<td><font color="#fd0d0d">'.$goodsInfo['goods_num'].lang('plugin/tom_love', 'shop_sy_1').'</font></td>';
                        $outStr.='</tr>';
                    $outStr.='</table>';
                $outStr.='</div>';
                $outStr.='<div class="xq">'.$goodsInfo['content'].'</div>';
                $outStr.='<div class="close_shop" onclick="removeId()"></div>';
            $outStr.='</div>';
        $outStr.='</section>';
    }else{
        $outStr = '205';
    }
    
    $outStr = diconv($outStr,CHARSET,'utf-8');
    echo json_encode($outStr);exit;
}else if($_GET['act'] == 'check' && $_GET['formhash'] == FORMHASH){
    
    $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
    
    $shopOrderInfo = C::t('#tom_love#tom_love_shop_order')->fetch_by_id($order_id);
    if(is_array($shopOrderInfo) && !empty($shopOrderInfo)){
        if($shopOrderInfo['user_id'] == $__UserInfo['id']){
            $updateData = array();
            $updateData['order_status'] = 4;
            C::t('#tom_love#tom_love_shop_order')->update($order_id, $updateData);
            echo '200';exit;
        }else{
            echo '202';exit;
        }
    }else{
        echo '201'; exit;
    }
    
}else if($_GET['act'] == 'exchange' && $_GET['formhash'] == FORMHASH){
    
    $xm         = isset($_GET['xm']) ? daddslashes(diconv(urldecode($_GET['xm']),'utf-8')) : '';
    $tel        = isset($_GET['tel']) ? daddslashes(diconv(urldecode($_GET['tel']),'utf-8')) : '';
    $address    = isset($_GET['address']) ? daddslashes(diconv(urldecode($_GET['address']),'utf-8')) : '';
    $goods_id   = isset($_GET['goods_id']) ? daddslashes(diconv(urldecode($_GET['goods_id']),'utf-8')) : '';
    
    $goodsInfo = C::t('#tom_love#tom_love_shop_goods')->fetch_by_id($goods_id);
    if(empty($xm) || empty($tel) || empty($address)){
        echo '201';exit;
    }
    if(!$goodsInfo){
        echo '202';exit;
    }
    if($goodsInfo['goods_num'] <= 0){
        echo '203';exit;
    }
    if($__UserInfo['flowers'] < $goodsInfo['flowers_num']){
        echo '204';exit;
    }
    $updateData = array();
    $updateData['flowers'] = $__UserInfo['flowers'] - $goodsInfo['flowers_num'];
    C::t('#tom_love#tom_love')->update($__UserInfo['id'], $updateData);
    
    $updateData = array();
    $updateData['goods_num'] = $goodsInfo['goods_num'] - 1;
    C::t('#tom_love#tom_love_shop_goods')->update($goods_id, $updateData);
    
    $insertData = array();
    $insertData['user_id'] = $__UserInfo['id'];
    $insertData['goods_id'] = $goods_id;
    $insertData['xm'] = $xm;
    $insertData['tel'] = $tel;
    $insertData['address'] = $address;
    $insertData['order_status'] = 1;
    $insertData['add_time'] = TIMESTAMP;
    C::t('#tom_love#tom_love_shop_order')->insert($insertData);
    
    $insertData = array();
    $insertData['user_id'] = $__UserInfo['id'];
    $insertData['type_id'] = 2;
    $insertData['change_num'] = $goodsInfo['flowers_num'];
    $insertData['old_num'] = $__UserInfo['flowers'];
    $insertData['txt'] = lang("plugin/tom_love", "shop_duihuan").lang("plugin/tom_love", "shop_duihuan_yinghao_1").$goodsInfo['goods_name'].lang("plugin/tom_love", "shop_duihuan_yinghao_2").lang("plugin/tom_love", "flowerslog_change_zf").$goodsInfo['flowers_num'].lang("plugin/tom_love", "flowerslog_change_duo_xh");
    $insertData['log_time'] = TIMESTAMP;
    C::t('#tom_love#tom_love_flowers_log')->insert($insertData);
    echo '200';exit;
    
}else if($_GET['act'] == 'shoporder'){
    
    $orderPage = isset($_GET['orderPage']) ? intval($_GET['orderPage']) : 1;
    
    $pagesize = 6;
    $start = ($orderPage-1)*$pagesize;
    $shopOrderListTmp = C::t('#tom_love#tom_love_shop_order')->fetch_all_list("AND user_id = {$__UserInfo['id']}", " ORDER BY id DESC", $start, $pagesize);
    $shopOrderCount = C::t('#tom_love#tom_love_shop_order')->fetch_all_count("AND user_id = {$__UserInfo['id']}");
    
    $shopOrderList = array();
    $shopGoodsListTmp = array();
    if(is_array($shopOrderListTmp) && !empty($shopOrderListTmp)){
        foreach($shopOrderListTmp as $key => $value){
            $shopOrderList[$key] = $value;
            $shopGoodsListTmp = C::t('#tom_love#tom_love_shop_goods')->fetch_by_id($value['goods_id']);
            $shopOrderList[$key]['shop_goods'] = $shopGoodsListTmp;
            if(!preg_match('/^http/', $shopOrderList[$key]['shop_goods']['goods_picurl'])){
                $shopOrderList[$key]['shop_goods']['goods_picurl'] = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$shopOrderList[$key]['shop_goods']['goods_picurl'];  
            }else{
                $shopOrderList[$key]['shop_goods']['goods_picurl'] = $shopOrderList[$key]['shop_goods']['goods_picurl'];
            }
        }
    }
    
    $orderTotal = ceil($shopOrderCount/$pagesize);
    $orderShowNextPage = 1;
    if(($start + $pagesize) >= $shopOrderCount){
        $orderShowNextPage = 0;
    }
    $orderPrePage = $orderPage - 1;
    $orderNextPage = $orderPage + 1;
    $orderPrePageUrl = "plugin.php?id=tom_love&mod=shop&act=shoporder&orderPage={$orderPrePage}";
    $orderNextPageUrl = "plugin.php?id=tom_love&mod=shop&act=shoporder&orderPage={$orderNextPage}";
    
    $isGbk = false;
    if (CHARSET == 'gbk') $isGbk = true;
    include template("tom_love:shoporder");
}else{
    
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    
    $pagesize = 8;
    $start = ($page-1)*$pagesize;
    $shopGoodsListTmp = C::t('#tom_love#tom_love_shop_goods')->fetch_all_list("AND is_show = 1", " ORDER BY id DESC", $start, $pagesize);
    $shopGoodsCount = C::t('#tom_love#tom_love_shop_goods')->fetch_all_count("AND is_show = 1");
    
    $shopGoodsList = array();
    if(is_array($shopGoodsListTmp) && !empty($shopGoodsListTmp)){
        foreach($shopGoodsListTmp as $key => $value){
            $shopGoodsList[$key] = $value;
            if(!preg_match('/^http/', $value['goods_picurl'])){
                $shopGoodsList[$key]['goods_picurl'] = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$value['goods_picurl'];  
            }else{
                $shopGoodsList[$key]['goods_picurl'] = $value['goods_picurl'];
            }
        }
    }
    $showNextPage = 1;
    if(($start + $pagesize) >= $shopGoodsCount){
        $showNextPage = 0;
    }
    $total = ceil($shopGoodsCount/$pagesize);
    $prePage = $page - 1;
    $nextPage = $page + 1;
    $prePageUrl = "plugin.php?id=tom_love&mod=shop&page={$prePage}";
    $nextPageUrl = "plugin.php?id=tom_love&mod=shop&page={$nextPage}";
    
    $content = discuzcode($jyConfig['flowers_goods_prompt'], 0, 0, 0, 1, 1, 1, 0, 0, 0, 0);
    
    $flowerslogListTmp = C::t('#tom_love#tom_love_shop_order')->fetch_all_list(" AND order_status in(1, 2, 4)", " ORDER BY id DESC", 0, 10);
    $flowerslogList = array();
    if(is_array($flowerslogListTmp) && !empty($flowerslogListTmp)){
        foreach($flowerslogListTmp as $key => $value){
            $flowerslogList[$key] = $value;
            $userInfo = C::t('#tom_love#tom_love')->fetch_by_id($flowerslogList[$key]['user_id']);
            $flowerslogList[$key]['nickname'] = $userInfo['nickname'];
            $goodsInfo = C::t('#tom_love#tom_love_shop_goods')->fetch_by_id($flowerslogList[$key]['goods_id']);
            $flowerslogList[$key]['goods_name'] = $goodsInfo['goods_name'];
        }
    }
    
    $shopAjaxUrl = "plugin.php?id=tom_love&mod=shop&formhash=".FORMHASH;
    
    $isGbk = false;
    if (CHARSET == 'gbk') $isGbk = true;
    include template("tom_love:shopgoods");
    
}