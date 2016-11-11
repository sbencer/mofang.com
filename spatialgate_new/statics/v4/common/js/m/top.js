/**
 * 加加下载提示，页面微信分享
 */
define('m/top',['jquery'], function(require, exports, module){
    var $ = require('jquery');
    // 搜索
    (function(){
        var btn = $('.btn-search');
        var search = $('.search');
        btn.click(function (){
            search.toggle();
        });
    })();
    //点击登陆，传递页面来源
    addTopA();  
    function addTopA(){
        if($(".btn-tool").length){
            var Urllogin=$(".btn-tool").parent().attr("href");
            if(Urllogin.indexOf('?')<0){
                Urllogin = Urllogin + "?ref=" + encodeURIComponent(window.location.href);
            }else{
                Urllogin = Urllogin + "&ref=" + encodeURIComponent(window.location.href);
            }
            
            $(".btn-tool").parent().attr('href',Urllogin);
        }
	}
});
seajs.use("m/top");
