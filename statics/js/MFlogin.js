// 魔方网注册和登陆

var MFLogin = MFLogin || {};



MFLogin = {



    // 各焦点

    objName : {

        "accountLogin"    : $("#accountLogin"),     // 登陆用户名

        "passwordLogin"   : $("#passwordLogin"),    // 密码

        "verifyCodeLogin" : $("#verifyCodeLogin"),  // 验证码

        "rememberLogin"   : $("#rememberLogin"),    // 记住密码

        "submitLogin"     : $("#submitLogin2"),      // 登陆按钮

        "userNameReg"     : $("#userNameReg"),      // 注册用户名

        "userMailReg"     : $("#userMailReg"),      // 邮箱

        "userPasswordReg" : $("#userPasswordReg"),  // 密码

        "repeatPasswordReg": $("#repeatPasswordReg"),   // 重复密码

        "verifyCodeReg"   : $("#verifyCodeReg"),    // 验证码

        "submitReg"       : $("#submitReg"),        // 注册按钮

        "loginErr"        : $("#loginMsgBox"),      // 登录提示窗口

        "regErr"          : $("#regMsgBox")         // 注册提示窗口

    },



    regStr: {

        usReg  : /^[A-Z0-9._%+-]{5,20}$/i,        // 用户名6-32位字母和数字，以字母开头

        pwReg  : /^.{6,20}$/,

        codeReg: /^[\w]{4}$/,

        mailReg: /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i        // 邮箱

    },



	initStr: {

		accountLogin        : "请输入魔方用户名",

		passwordLogin       : "请输入密码",

		verifyCodeLogin     : "请输入验证码",

		userNameReg         : "请输入用户名",

		userMailReg         : "请输入邮箱",

		userPasswordReg     : "请输入密码",

		repeatPasswordReg   : "请重复输入密码",

		verifyCodeReg       : "请输入验证码"

	},



    urlBase: {

        loginURL      : "?m=member&c=index&a=ajax_login",      // 登陆send url

        regURL        : "?m=member&c=index&a=ajax_register",      // 注册send url

        logoutURL     : "?m=member&c=index&a=ajax_logout",      // 退出send url

        jumpeLoginURL : "",      // 登陆后跳转的url

        jumpeRegURL   : "",      // 注册后跳转的url

		jumpeLogoutURL: ""       // 退出后跳转的url

    },



    // 错误提示

    msgPrompt: function(obj, msg){

        obj.slideDown().find("p").html(msg);

    },



    // 输入正确

    msgRight: function(obj){

         obj.slideUp().find("p").html("");

    },



    /*

     * 注册块

     * */

    regUserNameReg: function(){     // 效验用户名

        var _namePath = MFLogin.objName;

        var usernameVal = $.trim(_namePath.userNameReg.val());

        if(!MFLogin.regStr.usReg.test(usernameVal)){

            MFLogin.msgPrompt(_namePath.regErr, "用户名格式错误");

            //_namePath.userNameReg.focus();

            return false;

        }

        else{

            MFLogin.msgRight(_namePath.regErr);

            return true;

        }

    },



    regMailReg: function(){    // 效验邮箱

        var _namePath = MFLogin.objName;

        var mailVal = $.trim(_namePath.userMailReg.val());

        if(!MFLogin.regStr.mailReg.test(mailVal)){

            MFLogin.msgPrompt(_namePath.regErr, "请正确填写Email地址");

            //_namePath.userMailReg.focus();

            return false;

        }

        else{

            MFLogin.msgRight(_namePath.regErr);

            return true;

        }

    },



    regPassWordReg: function(){     // 效验密码

        var _namePath = MFLogin.objName;

        var passwordVal = $.trim(_namePath.userPasswordReg.val());

        if(!MFLogin.regStr.pwReg.test(passwordVal)){

            MFLogin.msgPrompt(_namePath.regErr, "密码不正确");

            //_namePath.userPasswordReg.focus();

            return false;

        }

        else{

            MFLogin.msgRight(_namePath.regErr);

            return true;

        }

    },



    regRepeatPassWordReg: function(){   // 重复密码

        var _namePath = MFLogin.objName;

        var passwordVal = _namePath.userPasswordReg;

        var repeatPasswordVal = $.trim(_namePath.repeatPasswordReg.val());

        if(passwordVal.val() !== repeatPasswordVal){

            MFLogin.msgPrompt(_namePath.regErr, "两次密码不同");

            //_namePath.repeatPasswordReg.focus();

            return false;

        }

        else{

            MFLogin.msgRight(_namePath.regErr);

            return true;

        }

    },



    regVerifyCodeReg: function(){    // 效验证码

        var _namePath = MFLogin.objName;

        var _verifyCode = $.trim(_namePath.verifyCodeReg.val());

        if(!MFLogin.regStr.codeReg.test(_verifyCode)){

            MFLogin.msgPrompt(_namePath.regErr, "验证码格式错误");

            //_namePath.verifyCodeReg.focus();

            return false;

        }

        else{

            MFLogin.msgRight(_namePath.loginErr);

            return true;

        }

    },



    reg: function(){   // 注册

        var _namePath = MFLogin.objName;

        var username = $.trim(_namePath.userNameReg.val());

        var mail = $.trim(_namePath.userMailReg.val());

        var password = $.trim(_namePath.userPasswordReg.val());

        var verifyCode = $.trim(_namePath.verifyCodeReg.val());



        if(!MFLogin.regUserNameReg()){ return false; }

        if(!MFLogin.regMailReg()){ return false; }

        if(!MFLogin.regPassWordReg()) { return false; }

        if(!MFLogin.regRepeatPassWordReg()){ return false; }

        if(!MFLogin.regVerifyCodeReg()){ return false; }



        $.ajax({

            url:MFLogin.urlBase.regURL,

            type: "post",

            data: "username=" + username + "&email=" + mail + "&password=" + password + "&code=" + verifyCode,

            success: function(data){

                // 返回格式 {returtate:0}  0 注册成功  1、注册失败

				data = $.parseJSON(data);

                switch (data.code){

                    case 0:

						location.reload();

                        break;

                    case 1:

                        MFLogin.msgPrompt(_namePath.regErr, data.msg);

                        break;

                }

            }

        });

    },



    /*

    * 登陆块

    * */

    regAccountLogin: function(){    // 效验用户名

        var _namePath = MFLogin.objName;

        var _usernameVal = $.trim(_namePath.accountLogin.val());

        if(!MFLogin.regStr.usReg.test(_usernameVal)){

            MFLogin.msgPrompt(_namePath.loginErr, "用户名格式错误");

            //_namePath.accountLogin.focus();

            return false;

        }

        else{

            MFLogin.msgRight(_namePath.loginErr);

            return true;

        }

    },



    regPassWordLogin:function(){    // 效验登陆密码

        var _namePath = MFLogin.objName;

        var _passwordVal = $.trim(_namePath.passwordLogin.val());

        if(!MFLogin.regStr.pwReg.test(_passwordVal)){

            MFLogin.msgPrompt(_namePath.loginErr, "密码格式错误");

            //_namePath.passwordLogin.focus();

            return false;

        }

        else{

            MFLogin.msgRight(_namePath.loginErr);

            return true;

        }

	},



    regVerifyCodeLogin: function(){    // 效验证码

        var _namePath = MFLogin.objName;

        var _verifyCode = $.trim(_namePath.verifyCodeLogin.val());

        if(!MFLogin.regStr.codeReg.test(_verifyCode)){

            MFLogin.msgPrompt(_namePath.loginErr, "验证码格式错误");

            //_namePath.verifyCodeLogin.focus();

            return false;

        }

        else{

            MFLogin.msgRight(_namePath.loginErr);

            return true;

        }

    },



    rememberLogin: function(){     // 记录是否记住密码

        var _namePath = MFLogin.objName;

        if(_namePath.rememberLogin.attr("checked")){

            return true;

        }

        else{

            return false;

        }

    },



    loginCookie: function(){   // 将账号存储cookie中

        var _namePath = MFLogin.objName,

            usernmae = _namePath.accountLogin.val();

            password = _namePath.passwordLogin.val();

        $.setManyCookies({"username": usernmae, "password": password}, {expires: 30});

    },



    login: function(){     // 登陆

        var _namePath = MFLogin.objName;

        if(!MFLogin.regAccountLogin()){ return false;}

        if(!MFLogin.regPassWordLogin()){ return false; }

        if(!MFLogin.regVerifyCodeLogin()){ return false; }



        var username = _namePath.accountLogin.val();

        var password = _namePath.passwordLogin.val();

        var verifyCode = _namePath.verifyCodeLogin.val();

        var sendURL = MFLogin.urlBase.loginURL;

        $.ajax({

            url: sendURL,

            type: "post",

            data: "username=" + username + "&password=" + password + "&code=" + verifyCode,

            success: function(data){

                // 返回格式 {login:0}  0 成功  1、验证码错误

				data = $.parseJSON(data);

                switch (data.code){

                    case 0:

						location.reload();

                        break;

                    case 1:

                        MFLogin.msgPrompt(_namePath.loginErr, data.msg);

                        break;

                }

            }

        });

    },



    logout: function(){     // 退出

        var sendURL = MFLogin.urlBase.logoutURL;

        $.ajax({

            url: sendURL,

            type: "get",

            success: function(data){

                // 返回格式 {login:0}  0 成功

				data = $.parseJSON(data);

                switch (data.code){

                    case 0:

						location.reload();

                        break;

                }

            }

        });

    },



    // 注册和登陆切换

    tag: function(initial){

        var _ind = initial;

        $(".register_tab li").removeClass("current").eq(_ind).addClass("current");

        $("#fmBox .register_cont").slideUp(200).eq(_ind).slideDown(500);

    },



    // 控制浮层

    popWin: function(winObj, tagIndex){

        var obj = $(winObj);

        addOverlay('#000', 0.4);

        obj.css("position","absolute")

            .css("top", ($(window).height() - obj.height()) / 2 + $(window).scrollTop())

            .css("left", ($(window).width() - obj.width()) / 2 + $(window).scrollLeft())

            .css("z-index", "189")

            .fadeIn();



        $(window).scroll( function() {

            obj.css("top",($(window).height() - obj.height()) / 2 + $(window).scrollTop())

                .css("left",($(window).width() - obj.width()) / 2 + $(window).scrollLeft())

        });

        $(window).resize( function() {

            obj.css("top",($(window).height() - obj.height()) / 2 + $(window).scrollTop())

                .css("left",($(window).width() - obj.width()) / 2 + $(window).scrollLeft())

        });



        MFLogin.tag(tagIndex);

        $(".close", obj).click(function(){

            hideMask(obj);

            return false;

        });

        function hideMask(target){

            removeOverlay();

            target.fadeOut();

        };

        function isExist(elem){

            if(typeof elem !== 'undefined' && typeof elem !== null) {

                return true;

            }else{

                return false;

            }

        };

        function addOverlay(cl, op){

            var overlayCss = {

                    position       : 'fixed',

                    zIndex         : '9',

                    top            : '0px',

                    left           : '0px',

                    height         : '100%',

                    width          : '100%',

                    backgroundColor: '#000',

                    filter         : 'alpha(opacity=40)',

                    opacity        : 0.4

                };



            var overlay = $('<div id="Overlay" class="OverlayBG" />');

            if(isExist(cl)){

                overlayCss.backgroundColor = cl;

            }

            $('body').append(overlay.css(overlayCss));

            if(isExist(op)){

                $('#Overlay').animate({opacity: op},0);

            }

        };

        function removeOverlay(){

            if(isExist($('#Overlay'))){

                $('#Overlay').fadeOut();

                $('#Overlay').remove();

            }

        };

    },



    // 初始配置

    init: function(){

        var _name = MFLogin.objName;



        $(".register_tab li").bind("click", function(){ // 注册/登陆切换

            var cur = $(this).index();

            MFLogin.tag(cur);

        });



		//_name.accountLogin.val(MFLogin.initStr.accountLogin);

		$.each(_name, function(objname, obj) {

			if (obj.attr('type') == 'text') {

				obj.val(MFLogin.initStr[objname]);

				obj.focus(function(){

					if ( $(this).val() === MFLogin.initStr[$(this).attr('id')] ) {

						$(this).val("");

						$(this).addClass('active');

					}

				});

			}

			if (obj.attr('type') == 'password') {

				obj.focus(function(){

						$(this).addClass('active');

				});

			}

		});



        _name.accountLogin.blur(function(){ MFLogin.regAccountLogin(); });

        _name.passwordLogin.blur(function(){ MFLogin.regPassWordLogin(); });

        _name.verifyCodeLogin.blur(function(){ MFLogin.regVerifyCodeLogin(); });



        _name.submitLogin.bind("click", function(){// 登陆

			MFLogin.login();

        });



        _name.userNameReg.blur(function(){ MFLogin.regUserNameReg(); })

        _name.userMailReg.blur(function(){ MFLogin.regMailReg(); })

        _name.userPasswordReg.blur(function(){ MFLogin.regPassWordReg(); })

        _name.repeatPasswordReg.blur(function(){ MFLogin.regRepeatPassWordReg(); })

        _name.verifyCodeReg.blur(function(){ MFLogin.regVerifyCodeReg(); })



        _name.submitReg.click(function(){

            MFLogin.reg();

        });



        // 侦听第三方登陆

        $("#sinaweibo").bind("click",function(){ MF_USER.loginSina() });

        $("#qq").bind("click",function(){ MF_USER.loginByQQ() });



        // 关闭提示框

        $("#loginMsgBox .prompt_close, #regMsgBox .prompt_close").click(function(){

			MFLogin.msgRight($(this).parent());

        })

    }

};

MFLogin.init();



// 第三方登陆

var MF_CON = {

    URL:{

        passport_qq: "",

        passport_sinaweibo:""

    }

};

var MF_USER = {

    jumpeLoginUrl: function(url){

        window.location.href = url;

    },

    loginByQQ:function(){

        MF_USER.jumpeLoginUrl(encodeURIComponent(MF_CON.URL.passport_qq));

    },

    loginSina:function(){

        MF_USER.jumpeLoginUrl(encodeURIComponent(MF_CON.URL.passport_sinaweibo));

    }

};





