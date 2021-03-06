/**
 * 检测登录状态,wap-pc共用的检查登录状态
 * @author xukuikui
 * @date 2015-06-30
 * 这个登录状态，是pc,m端公用的
 */
define('check_login',['jquery'],function(require, exports, module) {

	var $ = jQuery = require("jquery");//jquery库

	var USE_LOCAL_DATA = 0;//本地数据
	var USE_TEST_DATA = 0;//测试数据
	window.loginStatus=false;//登录状态
	console.log("%c loginStatus ", "color:#ccc");
	window.mfconfig = window.mfconfig || {};
	window.mfconfig.userInfoUrl = window.mfconfig.userInfoUrl || "http://u.mofang.com";
	
	var getUserLoginStatus = window.mfconfig.userInfoUrl+"/account/status"; //获取用户的登录状态
	var ajaxMethod="jsonp";

	if(USE_LOCAL_DATA){
		getUserLoginStatus = "/statics/v4/common/test/get_user.json"; //获取用户的登录状态
		ajaxMethod="json";
	}
	if(USE_TEST_DATA){
		window.mfconfig.userInfoUrl="http://u.test.mofang.com";
		getUserLoginStatus = window.mfconfig.userInfoUrl+"m/account/status"; //获取用户的登录状态	
	}

	
	//显示登录状态
	function fnLoginStatus(fnCallBack){
		//若果登录，不在请求登录接口
		if(window.loginStatus){
		    return fnCallBack(true);
		}
		$.ajax({
		    url:getUserLoginStatus,
		    type:"GET",
		    dataType:ajaxMethod,
		    data:{
		    },
		    success: function(res) {
		    	if(res && res.code==0){
		    		window.loginStatus=true;
		    		if(fnCallBack){
			    		return fnCallBack(true);
			    	}
		    	}else{
		    		window.loginStatus=false;
		    		if(fnCallBack){
		    		return fnCallBack(false);
		    	}
		    	}
		    },
		    error: function() {
		    	if(fnCallBack){
		    		return fnCallBack(false);
		    	}
		    	
		    },
		    complete: function(){
		    }
		});
	}
	
	fnLoginStatus();
	if (typeof module != "undefined" && module.exports) {
        module.exports.fnLoginStatus = fnLoginStatus;
    }

});
