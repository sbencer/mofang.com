
/**
 * @file editor-main.js
 * @brief   editor upload mod
 * @author xukuikui
 * @version
 * @date 2015-7-1
 */

define("jquery/jquery-reluserurl",["jquery"],function(require, exports, module) {

   
    var $ = require("jquery");
    var c = require("config");
    //登录跳转插件
	$.fn.loginUserUrl=function(isDesigUrl,toUserUrl){
		var _this = this;
		console.log();

		var urlcur = toUserUrl || $(_this).attr('href') || "";
		var urlref = isDesigUrl || window.location.href;
		
		var jumpUrl = '';
		if(urlcur.indexOf('mofang.com')<0){
			if(window.mfconfig){
				urlcur=window.mfconfig.userInfoUrl;
			}else{
				urlcur="http://u.mofang.com";
			}
		}
		urlcur = urlcur.indexOf("?") < 0 ? urlcur + "?ref=" + encodeURIComponent(urlref) : urlcur + "&ref=" + encodeURIComponent(urlref);
		$(_this).attr('href',urlcur);
		return urlcur;
	};
    
  

});
seajs.use("jquery/jquery-reluserurl");
