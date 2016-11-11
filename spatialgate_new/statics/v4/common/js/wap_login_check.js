define("login/wapcheck", ['jquery',"jquery/easing","jquery/query", 'wap/login'], function(require, exports, module) {

    var $ = require("jquery");
    require("jquery/query");
    require("jquery/easing");
    var MFLogin = require('wap/login');
    var login = MFLogin;
    var C = window.CONFIG;
    var defaultURL =  window.defaultURL || "http://u.mofang.com";

    // 登陆后获取更多信息
    var urlBase = {
        loginURL: defaultURL + "/account/login?more=1", // 登陆send url
        regURL: defaultURL + "/account/register?more=1", // 注册send url
        logoutURL: defaultURL + "/account/logout" // 退出send url
    };
    login.urlBase = $.extend(login.urlBase, urlBase);

    // 显示更新信息
    function showUserInfo(data) {
        var loginBtn = $(".toolbar").find(".btn-tool").parent();
        var userIcon = $(".toolbar").find(".btn-user-icon");
        userIcon.css({
            backgroundImage:"url("+ (data.avatar || "http://u.mofang.com/images/user.png") +")"
        });
        window.setTimeout(function(){
            loginBtn.fadeOut(500,"easeOutExpo"
            ,function(){
                userIcon.fadeIn(800,"easeOutExpo");
            });
        },1000);
    }

    // 注册登陆页
    (function() {

        if (C.pageId !== "login") {
            return false;
        }
	    var jumpUrl = $.query.get("from") || C.defaultJumpUrl || "/?tpl=wap/list_gift.tpl";
        var urlBase = {
    	    jumpeRegURL:jumpUrl,
    	    jumpeLoginURL:jumpUrl
    	};
    	login.urlBase = $.extend(login.urlBase, urlBase);

        function showJumpMessage() {
                var f = $.query.get("from");
                f = decodeURIComponent(f);
                if (f) {
                    window.setTimeout(function() {
                        window.location.href = f;
                    }, 3000);
                }
            }
            // 注册登陆页面的操作
        $('.fast-link a').click(function() {
            $('.wap-login-tabs li').eq(1).click();
            return false;
        });
        login.onLoginSuc = function(data) {
            showUserInfo(data.data);
            showJumpMessage();
        };
        return true;
    })();

    // 登陆成功后更新信息
    login.isLogin(function(status, data) {
        if (status) {
            showUserInfo(data);
        }
    });

    MFLogin.init(0);

});
