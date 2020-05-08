if(wx.miniProgram){
    wx.miniProgram.getEnv(function(res) {
      if(res.miniprogram){
          $.get("plugin.php?id=tom_love:ajax&act=miniprogram&ok=1");
      }
    })
}else{
    $.get("plugin.php?id=tom_love:ajax&act=miniprogram&ok=0");
}

function miniprogramReady(){
    
    if(wx.miniProgram){
        var newtitle    = document.title;
        wx.miniProgram.postMessage({ data: newtitle });
    }
    
  if(window.__wxjs_environment === 'miniprogram'){
      console.log('check miniProgram ok 1');
      $.get("plugin.php?id=tom_love:ajax&act=miniprogram&ok=1");
  }else{
      console.log('check miniProgram ok 0');
      $.get("plugin.php?id=tom_love:ajax&act=miniprogram&ok=0");
  }
}
if (!window.WeixinJSBridge || !WeixinJSBridge.invoke) {
  document.addEventListener('WeixinJSBridgeReady', miniprogramReady, false)
}else{
  miniprogramReady()
}

function jumpMiniprogram(link){
    var newviewurl  = encodeURIComponent(link);
    if(wx.miniProgram){
        if(link.indexOf("mod=index") > 0 || link.indexOf("mod=list") > 0 || link.indexOf("mod=shuoshuo") > 0){
            wx.miniProgram.reLaunch({
              url: '/pages/index/view?viewurl=' + newviewurl
            });
        }else{
            wx.miniProgram.navigateTo({
              url: '/pages/index/view?viewurl=' + newviewurl
            });
        }
    }else{
        window.location.href=link;
    }
}