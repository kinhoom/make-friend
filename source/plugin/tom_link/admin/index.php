<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$modBaseUrl = $adminBaseUrl.'&tmod=index';
$modListUrl = $adminListUrl.'&tmod=index';
$modFromUrl = $adminFromUrl.'&tmod=index';

if($_GET['act'] == 'save'){
    if(submitcheck('submit')){
        
        if(isset($_GET['rukou']) && is_array($_GET['rukou']) && !empty($_GET['rukou'])){
            foreach ($_GET['rukou'] as $key => $value){
                $rukouValue = trim(addslashes($value));
                $biaoshiValue = trim(addslashes($_GET['biaoshi'][$key]));
                $rukouValue = strtolower($rukouValue);
                $biaoshiValue = strtolower($biaoshiValue);
                $statusValue = isset($_GET['status'][$key])?intval($_GET['status'][$key]):0;
                
                if(empty($rukouValue) || empty($biaoshiValue)){
                    continue;
                }
                
                if(!preg_match("/^([a-z_0-9]+)$/",$rukouValue) || !preg_match("/^([a-z_0-9]+)$/",$biaoshiValue)){
                    cpmsg($Lang['save_error301'], $modListUrl, 'error');exit;
                }
                
                if(in_array($rukouValue, array('admin','api','connect','cp','forum','group','home','index','member','misc','plugin','portal','search','userapp'))){
                    cpmsg($Lang['save_error302'], $modListUrl, 'error');exit;
                }
                
                if(strpos($biaoshiValue, "tom_") !== FALSE){
                    cpmsg($Lang['save_error303'], $modListUrl, 'error');exit;
                }
                
                if(!empty($rukouValue) && !empty($biaoshiValue)){
                    $ruleInfoTmp = C::t('#tom_link#tom_link_rule')->fetch_by_plugin_id($key);
                    if($ruleInfoTmp){
                        if($rukouValue != $ruleInfoTmp['rukou'] || $biaoshiValue != $ruleInfoTmp['biaoshi'] || $statusValue != $ruleInfoTmp['status']){
                            $updateData = array();
                            $updateData['rukou']     = $rukouValue;
                            $updateData['biaoshi']   = $biaoshiValue;
                            $updateData['status']   = $statusValue;
                            C::t('#tom_link#tom_link_rule')->update($ruleInfoTmp['id'],$updateData);
                        }
                    }else{
                        $insertData = array();
                        $insertData['plugin_id']    = $key;
                        $insertData['rukou']        = $rukouValue;
                        $insertData['biaoshi']      = $biaoshiValue;
                        $insertData['status']   = $statusValue;
                        $insertData['add_time']     = TIMESTAMP;
                        C::t('#tom_link#tom_link_rule')->insert($insertData);
                    }
                }
            }
        }
        
        $ruleListTmp = C::t('#tom_link#tom_link_rule')->fetch_all_list(" AND status=1 ");
        $ruleList = array();
        if(is_array($ruleListTmp) && !empty($ruleListTmp)){
            foreach ($ruleListTmp as $key => $value){
                $newBiaoshi = $value['biaoshi'].$pluginArray[$value['plugin_id']]['suffix'];
                $ruleList['a'][$newBiaoshi] = $value['plugin_id'];
                $ruleList['b'][$value['plugin_id']]['rk'] = $value['rukou'].'.php';
                $ruleList['b'][$value['plugin_id']]['bs'] = $newBiaoshi;
            }
        }
        
        $dataDir = DISCUZ_ROOT.'.'."/source/plugin/tom_link/data/";
        chmod($dataDir, 0777); 
        file_put_contents($dataDir.'map.php', "<?php\n " .'$tom_link_map='. var_export($ruleList['a'], true) . ";\n?>");
        file_put_contents($dataDir.'rule.php', "<?php\nreturn " . var_export($ruleList['b'], true) . ";\n?>");
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }
}else{
    
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $Lang['link_help_title'] . '</th></tr>';
    echo '<tr><td  class="tipsblock" s="1"><ul id="tipslis">';
    echo '<li>' . $Lang['link_help_1_a'] . '<a target="_blank" href="http://www.dasuhlai.com/index.php?m=help&t=plugin&pluginid=tom_link"><font color="#FF0000">' . $Lang['link_help_1_b'] . '</font></a></li>';
    echo '<li>' . $Lang['link_help_2'] . '</font></a></li>';
    echo '<li>' . $Lang['link_help_3'] . '</font></a></li>';
    //echo '<li>' . $Lang['link_help_4'] . '</font></a></li>';
    echo '</ul></td></tr>';
    showtablefooter();
    
    tomshownavheader();
    tomshownavli($Lang['link_show_list_title'],"",true);
    tomshownavfooter();
    echo '<form name="cpform1" id="cpform1" method="post" autocomplete="off" action="'.ADMINSCRIPT.'?action='.$modFromUrl.'&act=save&formhash='.FORMHASH.'">'.
		'<input type="hidden" name="formhash" value="'.FORMHASH.'" />'.
		'<input type="hidden" id="formscrolltop" name="scrolltop" value="" />'.
		'<input type="hidden" name="anchor" value="" />';
    showtableheader();
    echo '<tr class="header">';
    echo '<th>' . $Lang['link_plugin_name'] . '</th>';
    echo '<th>' . $Lang['link_rukou'] . '</th>';
    echo '<th>' . $Lang['link_biaoshi'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    foreach ($pluginArray as $key => $value) {
        
        if(!is_dir(DISCUZ_ROOT.'./source/plugin/'.$key.'/')){
            continue;
        }
        
        $ruleInfoTmp = C::t('#tom_link#tom_link_rule')->fetch_by_plugin_id($key);
        echo '<tr>';
        echo '<td>' . $value['name'] . '</td>';
        
        if(empty($ruleInfoTmp['rukou'])){
            $ruleInfoTmp['rukou'] = 'indexa';
        }
        
        $noRukouFileStr = "";
        if(!file_exists(DISCUZ_ROOT.'./'.$ruleInfoTmp['rukou'].'.php')){
            $noRukouFileStr = $Lang['no_rukou_file_str'];
            $noRukouFileStr = str_replace("{FILENAME}", $ruleInfoTmp['rukou'].'.php', $noRukouFileStr);
        }
        
        echo '<td><input name="rukou['.$key.']" type="text" value="'.$ruleInfoTmp['rukou'].'" size="10" />.php'.$noRukouFileStr.'</td>';
        echo '<td><input name="biaoshi['.$key.']" type="text" value="'.$ruleInfoTmp['biaoshi'].'" size="10" />' . $value['suffix'] . '</td>';
        echo '<td>';
        
        $checkedStr = '';
        if($ruleInfoTmp['status'] == 1){$checkedStr = 'checked="checked"';}
        echo '<input type="checkbox" name="status['.$key.']" value="1" '.$checkedStr.' />' . $Lang['link_status1'] . '</a>';
        echo '</td>';
        echo '</tr>';
    }
    echo '<tr>';
    echo '<td>';
    echo '<input type="submit" class="btn" id="submit_submit" name="submit" value="' . $Lang['link_submit'] . '">';
    echo '</td>';
    echo '</tr>';
    showtablefooter();
    showformfooter();
    
}


