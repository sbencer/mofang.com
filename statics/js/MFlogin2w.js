// 魔方网注册和登陆

var MFLogin2 = MFLogin2 || {};



MFLogin2 = {
    // 各焦点

    objName : {

        "accountLogin"    : $("#accountLogin2"),     // 登陆用户名

        "passwordLogin"   : $("#passwordLogin2"),    // 密码

        "verifyCodeLogin" : $("#verifyCodeLogin2"),  // 验证码

        "rememberLogin"   : $("#rememberLogin2"),    // 记住密码

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

        var _namePath = MFLogin2.objName;

        var usernameVal = $.trim(_namePath.userNameReg.val());

        if(!MFLogin2.regStr.usReg.test(usernameVal)){

            MFLogin2.msgPrompt(_namePath.regErr, "用户名格式错误");

            //_namePath.userNameReg.focus();

            return false;

        }

        else{

            MFLogin2.msgRight(_namePath.regErr);

            return true;

        }

    },



    regMailReg: function(){    // 效验邮箱

        var _namePath = MFLogin2.objName;

        var mailVal = $.trim(_namePath.userMailReg.val());

        if(!MFLogin2.regStr.mailReg.test(mailVal)){

            MFLogin2.msgPrompt(_namePath.regErr, "请正确填写Email地址");

            //_namePath.userMailReg.focus();

            return false;

        }

        else{

            MFLogin2.msgRight(_namePath.regErr);

            return true;

        }

    },



    regPassWordReg: function(){     // 效验密码

        var _namePath = MFLogin2.objName;

        var passwordVal = $.trim(_namePath.userPasswordReg.val());

        if(!MFLogin2.regStr.pwReg.test(passwordVal)){

            MFLogin2.msgPrompt(_namePath.regErr, "密码不正确");

            //_namePath.userPasswordReg.focus();

            return false;

        }

        else{

            MFLogin2.msgRight(_namePath.regErr);

            return true;

        }

    },



    regRepeatPassWordReg: function(){   // 重复密码

        var _namePath = MFLogin2.objName;

        var passwordVal = _namePath.userPasswordReg;

        var repeatPasswordVal = $.trim(_namePath.repeatPasswordReg.val());

        if(passwordVal.val() !== repeatPasswordVal){

            MFLogin2.msgPrompt(_namePath.regErr, "两次密码不同");

            //_namePath.repeatPasswordReg.focus();

            return false;

        }

        else{

            MFLogin2.msgRight(_namePath.regErr);

            return true;

        }

    },



    regVerifyCodeReg: function(){    // 效验证码

        var _namePath = MFLogin2.objName;

        var _verifyCode = $.trim(_namePath.verifyCodeReg.val());

        if(!MFLogin2.regStr.codeReg.test(_verifyCode)){

            MFLogin2.msgPrompt(_namePath.regErr, "验证码格式错误");

            //_namePath.verifyCodeReg.focus();

            return false;

        }

        else{

            MFLogin2.msgRight(_namePath.loginErr);

            return true;

        }

    },



    reg: function(){   // 注册

        var _namePath = MFLogin2.objName;

        var username = $.trim(_namePath.userNameReg.val());

        var mail = $.trim(_namePath.userMailReg.val());

        var password = $.trim(_namePath.userPasswordReg.val());

        var verifyCode = $.trim(_namePath.verifyCodeReg.val());



        if(!MFLogin2.regUserNameReg()){ return false; }

        if(!MFLogin2.regMailReg()){ return false; }

        if(!MFLogin2.regPassWordReg()) { return false; }

        if(!MFLogin2.regRepeatPassWordReg()){ return false; }

        if(!MFLogin2.regVerifyCodeReg()){ return false; }



        $.ajax({

            url:MFLogin2.urlBase.regURL,

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

                        MFLogin2.msgPrompt(_namePath.regErr, data.msg);

                        break;

                }

            }

        });

    },



    /*

    * 登陆块

    * */

    regAccountLogin: function(){    // 效验用户名

        var _namePath = MFLogin2.objName;

        var _usernameVal = $.trim(_namePath.accountLogin.val());

        if(!MFLogin2.regStr.usReg.test(_usernameVal)){

            MFLogin2.msgPrompt(_namePath.loginErr, "用户名格式错误");

            //_namePath.accountLogin.focus();

            return false;

        }

        else{

            MFLogin2.msgRight(_namePath.loginErr);

            return true;

        }

    },



    regPassWordLogin:function(){    // 效验登陆密码

        var _namePath = MFLogin2.objName;

        var _passwordVal = $.trim(_namePath.passwordLogin.val());

        if(!MFLogin2.regStr.pwReg.test(_passwordVal)){

            MFLogin2.msgPrompt(_namePath.loginErr, "密码格式错误");

            //_namePath.passwordLogin.focus();

            return false;

        }

        else{

            MFLogin2.msgRight(_namePath.loginErr);

            return true;

        }

	},



    regVerifyCodeLogin: function(){    // 效验证码

        var _namePath = MFLogin2.objName;

        var _verifyCode = $.trim(_namePath.verifyCodeLogin.val());

        if(!MFLogin2.regStr.codeReg.test(_verifyCode)){

            MFLogin2.msgPrompt(_namePath.loginErr, "验证码格式错误");

            //_namePath.verifyCodeLogin.focus();

            return false;

        }

        else{

            MFLogin2.msgRight(_namePath.loginErr);

            return true;

        }

    },



    rememberLogin: function(){     // 记录是否记住密码

        var _namePath = MFLogin2.objName;

        if(_namePath.rememberLogin.attr("checked")){

            return true;

        }

        else{

            return false;

        }

    },



    loginCookie: function(){   // 将账号存储cookie中

        var _namePath = MFLogin2.objName,

            usernmae = _namePath.accountLogin.val();

            password = _namePath.passwordLogin.val();

        $.setManyCookies({"username": usernmae, "password": password}, {expires: 30});

    },



    login: function(){     // 登陆

        var _namePath = MFLogin2.objName;

        if(!MFLogin2.regAccountLogin()){ return false;}

        if(!MFLogin2.regPassWordLogin()){ return false; }

        if(!MFLogin2.regVerifyCodeLogin()){ return false; }



        var username = _namePath.accountLogin.val();

        var password = _namePath.passwordLogin.val();

        var verifyCode = _namePath.verifyCodeLogin.val();

        var sendURL = MFLogin2.urlBase.loginURL;

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

                        MFLogin2.msgPrompt(_namePath.loginErr, data.msg);

                        break;

                }

            }

        });

    },



    logout: function(){     // 退出

        var sendURL = MFLogin2.urlBase.logoutURL;

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

        $(".register_tab2 li").removeClass("current").eq(_ind).addClass("current");

        $("#fmBox2 .register_cont2").slideUp(200).eq(_ind).slideDown(500);

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



        MFLogin2.tag(tagIndex);

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

        var _name = MFLogin2.objName;



        $(".register_tab2 li").bind("click", function(){ // 注册/登陆切换

            var cur = $(this).index();

            MFLogin2.tag(cur);

        });



		//_name.accountLogin.val(MFLogin.initStr.accountLogin);

		$.each(_name, function(objname, obj) {

			if (obj.attr('type') == 'text') {

				obj.val(MFLogin2.initStr[objname]);

				obj.focus(function(){

					if ( $(this).val() === MFLogin2.initStr[$(this).attr('id')] ) {

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



        _name.accountLogin.blur(function(){ MFLogin2.regAccountLogin(); });

        _name.passwordLogin.blur(function(){ MFLogin2.regPassWordLogin(); });

        _name.verifyCodeLogin.blur(function(){ MFLogin2.regVerifyCodeLogin(); });



        _name.submitLogin.bind("click", function(){// 登陆

			MFLogin2.login();

        });



        _name.userNameReg.blur(function(){ MFLogin2.regUserNameReg(); })

        _name.userMailReg.blur(function(){ MFLogin2.regMailReg(); })

        _name.userPasswordReg.blur(function(){ MFLogin2.regPassWordReg(); })

        _name.repeatPasswordReg.blur(function(){ MFLogin2.regRepeatPassWordReg(); })

        _name.verifyCodeReg.blur(function(){ MFLogin2.regVerifyCodeReg(); })



        _name.submitReg.click(function(){

            MFLogin2.reg();

        });



        // 侦听第三方登陆

        $("#sinaweibo").bind("click",function(){ MF_USER.loginSina() });

        $("#qq").bind("click",function(){ MF_USER.loginByQQ() });



        // 关闭提示框

        $("#loginMsgBox .prompt_close, #regMsgBox .prompt_close").click(function(){

			MFLogin2.msgRight($(this).parent());

        })

    }

};

MFLogin2.init();



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





