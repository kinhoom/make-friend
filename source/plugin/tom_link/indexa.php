<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：大叔来 www.dasuhlai.com
   文件说明：本文件是大叔来插件自定义入口文件，请将本文件复制放到你的论坛根目录下（文件名可以自己修改）
   特别说明：本入口不支持非TOM插件
*/

define('IN_TOM_LINK', true); 

if(!file_exists("plugin.php")){
    exit('no root dir');
}

include "./source/plugin/tom_link/do.php";

require "plugin.php";

?>