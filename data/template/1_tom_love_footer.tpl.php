<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<section class="footer_block clearfix"></section>
<footer class="footer_main clearfix">
<ul class="clearfix">
        <?php if($_GET['mod'] == 'index' ) { ?>
        <li class="footer_nav_index2"><a href="plugin.php?id=tom_love&amp;mod=index&amp;prand=<?php echo $prand;?>"><span class="nav2">首 页</span></a></li>
        <?php } else { ?>
        <li class="footer_nav_index1"><a href="plugin.php?id=tom_love&amp;mod=index&amp;prand=<?php echo $prand;?>"><span class="nav1">首 页</span></a></li>
        <?php } ?>
        <?php if($_GET['mod'] == 'list' ) { ?>
        <li class="footer_nav_search2"><a href="plugin.php?id=tom_love&amp;mod=list&amp;prand=<?php echo $prand;?>"><span class="nav2">筛 选</span></a></li>
        <?php } else { ?>
        <li class="footer_nav_search1"><a href="plugin.php?id=tom_love&amp;mod=list&amp;prand=<?php echo $prand;?>"><span class="nav1">筛 选</span></a></li>
        <?php } ?>
        <?php if($_GET['mod'] == 'shuoshuo' ) { ?>
        <li class="footer_nav_ss2"><a href="plugin.php?id=tom_love&amp;mod=shuoshuo&amp;prand=<?php echo $prand;?>"><span class="nav2">交友圈</span></a></li>
        <?php } else { ?>
        <li class="footer_nav_ss1"><a href="plugin.php?id=tom_love&amp;mod=shuoshuo&amp;prand=<?php echo $prand;?>"><span class="nav1">交友圈</span></a></li>
        <?php } ?>
        <?php if($jyConfig['open_tongcheng'] == 0 ) { ?>
        <?php if($_GET['mod'] == 'sms' ) { ?>
        <li class="footer_nav_sms2"><a href="plugin.php?id=tom_love&amp;mod=sms&amp;prand=<?php echo $prand;?>"><span class="nav2">消 息</span></a></li>
        <?php } else { ?>
        <li class="<?php echo $footerNavSmsClass;?>"><a href="plugin.php?id=tom_love&amp;mod=sms&amp;prand=<?php echo $prand;?>"><span class="nav1">消 息</span></a></li>
        <?php } ?>
        <?php } ?>
        <?php if($jyConfig['open_tongcheng'] == 1 ) { ?>
        <li class="footer_nav_tc1"><a href="plugin.php?id=tom_tongcheng&amp;mod=index&amp;prand=<?php echo $prand;?>"><span class="nav1">同 城</span></a></li>
        <?php } ?>
        <?php if($_GET['mod'] == 'my' ) { ?>
        <li class="footer_nav_my2"><a href="plugin.php?id=tom_love&amp;mod=my&amp;prand=<?php echo $prand;?>"><span class="nav2">我</span></a></li>
        <?php } else { ?>
        <?php if($jyConfig['open_tongcheng'] == 1 ) { ?>
        <li class="<?php echo $footerNavMyClass;?>"><a href="plugin.php?id=tom_love&amp;mod=my&amp;prand=<?php echo $prand;?>"><span class="nav1">我</span></a></li>
        <?php } else { ?>
        <li class="footer_nav_my1"><a href="plugin.php?id=tom_love&amp;mod=my&amp;prand=<?php echo $prand;?>"><span class="nav1">我</span></a></li>
        <?php } ?>
        <?php } ?>
    </ul>
</footer>