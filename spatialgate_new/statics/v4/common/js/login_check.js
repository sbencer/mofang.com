define("login/check", ["jquery",'transform', 'mf/login'], function(require, exports, module) {

    var $ = require("jquery");
    var MFLogin = require('mf/login');

    //require('jquery/jq_cookie');
    //var Transform = require("Transform");
    //var newVersion = !$(".header-login-user").length;
    //if (newVersion) {
        //var transform = new Transform();
    //}


    // TODO:fixed 兼容老版本的工具条
    //MFLogin.enterClcik = function(){
    //}
    $("#login").on("click",function() {
        //http://u.mofang.jp;
        //http://u.appmofang.com
        //var jp = "http://u.mofang.jp"
        MFLogin.init(0) // 0 标签默认登录
    });

    $("#reg").on("click",function() {
        MFLogin.init(1)
    });
    $("#logout").on("click",function() {
        MFLogin.logout();
    });

    if (typeof module != "undefined" && module.exports) {
        module.exports.isLogin = MFLogin.isLogin;
    };
})

seajs.use("login/check");
