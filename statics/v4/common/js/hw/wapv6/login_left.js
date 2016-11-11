/**
 * 移动端的登录状态
 * @author xukuikui
 * @date 2015-05-15
 */
define('login_left',['jquery','check_login',"jquery/jquery-reluserurl"],function(require, exports, module){
	var $ = jQuery = require("jquery");//jquery库
	var login = require("check_login");//登录状态
		require("jquery/jquery-reluserurl");//把当前路径带上
	var USE_LOCAL_DATA = 0;//本地数据
	var USE_TEST_DATA = 0;//测试数据

	window.mfconfig.userInfoUrl = window.mfconfig.userInfoUrl || "http://u.mofang.com";

	var getUserInfo = window.mfconfig.userInfoUrl+"/home/api/get_login_userinfo"; //获取用户信息
	var getUserLogout = window.mfconfig.userInfoUrl+"/account/logout"; //用户退出接口
	var getUserNotice = "";
	var ajaxMethod="jsonp"; 

	if(USE_LOCAL_DATA){
		getUserInfo = "../../test/get_user.json"; //获取用户信息
		getUserLogout = "../../test/get_user.json"; //用户退出接口
		getUserNotice = "../../test/get_user_notice.json";
		ajaxMethod="json";
	}
	if(USE_TEST_DATA){
		getUserLoginStatus = window.mfconfig.userInfoUrl+"m/account/status"; //获取用户的登录状态
		getUserInfo = window.mfconfig.userInfoUrl+"/home/api/get_login_userinfo"; //获取用户信息
		getUserLogout = window.mfconfig.userInfoUrl+"/account/logout"; //用户退出接口
	}

	//显示登录样式
	function showHeader(isLogin){//isLogin->登录状态(true,false),data->个人信息
		if(isLogin){
			$.ajax({
			    url:getUserInfo,
			    type:"GET",
			    dataType:ajaxMethod,
			    data:{
			    },
			    success: function(res) {
			    	if(res && res.code==0){
			    		//头像
			    		$("#userImg").attr("src",res.data.avatar);

			    		//用户连接地址
			    		$(".userUrl").attr("href",window.mfconfig.userInfoUrl+"/home/person/main");
			    		//昵称
			    		$("#userName").html(res.data.nickname);
			    		//魔币
			    		$("#userMoney").html(res.data.coin);
			    		$(".money").show();
		    				
			    	}else{}
			    },
			    error: function() {
			    	
			    },
			    complete: function(){

			    }
			});
		}else{
			$(".userUrl").attr("href",window.mfconfig.userInfoUrl+"/home/account/index");
			$(".userUrl").loginUserUrl()
		}
	}

	//退出
	function logout(){
		$.ajax({
		    url:getUserLogout,
		    type:"GET",
		    dataType:ajaxMethod,
		    data:{
		    },
		    success: function(res) {
		    	if(res && res.code==0){

		    		window.location.reload();		
		    	}
		    },
		    error: function() {
		    	
		    },
		    complete: function(){

		    }
		});
	}

	/*//消息通知
	function getNotice(){
		$.ajax({
		    url:getUserNotice,
		    type:"GET",
		    dataType:ajaxMethod,
		    data:{
		    },
		    success: function(res) {
		    	if(res && res.code==0){

		    		if(res.data.sys_message.unread_count>0 || res.data.reply.unread_count>0 || res.data.recommend.unread_count>0){
		    			
		    			$("#userName").find(".icon-red").show();
		    			if(res.data.reply.unread_count>0){
		    				$(".header .zj").find(".icon-red").show();
		    			}
		    			if(res.data.sys_message.unread_count>0 || res.data.recommend.unread_count>0){
		    				$(".header .msg").find(".icon-red").show();
		    			}
		    			
		    		}else{
		    			$("#userName").find(".icon-red").hide();
		    			$(".header .zuji").find(".icon-red").hide();
		    		}

		    	}
		    },
		    error: function() {
		    	
		    },
		    complete: function(){

		    }
		});
	}*/
	//启动函数
	function init(){

		login.fnLoginStatus(function(isLogin){
			//是否显示信息
			showHeader(isLogin);

		});
		/*getNotice();//消息通知
		setInterval(function(){
			getNotice();
		},60*1000);*/

		//退出
		$(document).on("click","#logout",function(){
			logout();
		});
	}
	init();
	

});
seajs.use('login_left');
