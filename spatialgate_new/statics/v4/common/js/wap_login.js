/**
 * wap login
 */
define('wap/login', ['jquery', 'jquery/cookie'], function(require, exports, module) {

    require('jquery/cookie');
    var $ =  require("jquery");

    var jQuery = $;
    var initFlag = false;
    var defaultURL =  window.defaultURL || "http://u.mofang.com";

    var MFLogin = MFLogin || {};
    // 是否登陆
    var loginStatus = false;
    // 是否检测登陆状态
    var isCheckedLogin = false;
    // 登陆检查的回调函数
    var loginCallbacks = [];
    // 页面打开时,异步更新登陆状态
    $.ajax({
        url: defaultURL + "/account/check_login",
        dataType: 'jsonp',
        success: function(data) {
            _isCheckedLogin = true;
            if (0 == data.code && data.data.nickname) {
                MFLogin.loginAction(data.data,data.data.sys,false);
                // 已登陆
                triggerCallbacks(true,data.data);
                _isLogin = true;
            } else {
                //$("#header-user-nologin").show();
                // 未登陆
                triggerCallbacks(false);
            }
        },
        error: function(data) {
            console.log(data);
        }
    });
    // 用户激活
    // 如果用户不在user/index页面,则跳转到user/index页面,完成用户激活过程
    // COOKIE: mf_activity ：(服务器端)用户没有完成激活过程标识
    if ($.cookie('mf_activity')) {
        if (!/account\/index/.test(window.location.href)) {
            $.cookie('mf_activity', null);
            window.location.href = defaultURL + '/account/index';
        };
    }
    // 用户同步登陆
    // 页面装在时，检查mf_websiteli cookie 代表没有同步登陆其他应用.如:bbs
    // COOKIE: mf_websiteli ：(服务器端)用户需要三方登陆
    if ($.cookie('mf_websiteli')) {
        $.ajax({
            url: defaultURL + '/account/ucenter_syslogin',
            dataType: 'jsonp',
            success: function(data) {
                if (data.data.sys) {
                    $("body").append($(data.data.sys));
                };
            }
        });
    }
    // 用户同步退出
    // 页面装在时，检查mf_websitelo标识 代表没有同步登陆其他应用.如:bbs
    // COOKIE: mf_websitelo ：(服务器端)用户需要三方退出
    if ($.cookie('mf_websitelo')) {
        $.ajax({
            url: defaultURL + '/account/ucenter_syslogout',
            dataType: 'jsonp',
            success: function(data) {
                if (data.data.sys) {
                    $("body").append($(data.data.sys));
                };
            }
        });
    }

    // 接口函数
    var _isLogin = false;
    var _isCheckedLogin = false;
	// 若登陆则执行
    function ifLogin(next) {
        if (_isCheckedLogin) {
            next(null, _isLogin);
        } else {
            loginCallbacks.push(next);
        }
    }

	// 判断是否登陆
    function isLogin(callback) {
		if (typeof callback == "function") {
			ifLogin(callback);
		}

		return _isLogin;
    }

	// 检查是否登陆
	function checkLogin() {
		return isCheckedLogin;
	}

    function triggerCallbacks(status,data) {
        loginStatus = status;
        for (var i = 0; i < loginCallbacks.length; i++) {
            var next = loginCallbacks[i];
	    next && next.call && next(loginStatus,data);
        }
    }

    // 截取字符串
    function get_length(s){
        var char_length = 0;
        for (var i = 0; i < s.length; i++){
            var son_char = s.charAt(i);
            encodeURI(son_char).length > 2 ? char_length += 1 : char_length += 0.5;
        }
        return char_length;
    }
    function cut_str(str, len){
        var char_length = 0;
        for (var i = 0; i < str.length; i++){
            var son_str = str.charAt(i);
            encodeURI(son_str).length > 2 ? char_length += 1 : char_length += 0.5;
            if (char_length >= len){
                var sub_len = char_length == len ? i+1 : i;
                return str.substr(0, sub_len) + "..";
                break;
            }
        }
        return str;
    }

    MFLogin = {
        regStr: {
            usReg: /^[A-Z0-9._%+]{3,20}$/i, // 用户名6-32位字母和数字，以字母开头
            pwReg: /^.{1,16}$/,
            codeReg: /^[\w]{6}$/,
            mailReg: /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i, // 邮箱
            telReg: /^0?(13|14|15|18)[0-9]{9}$/
        },
        urlBase: {
            loginURL: defaultURL +"/account/login", // 登陆send url
            regURL: defaultURL +"/account/register", // 注册send url
            logoutURL: defaultURL + "/account/logout", // 退出send url
            jumpeLoginURL: "", // 登陆后跳转的url
            jumpeRegURL: "", // 注册后跳转的url
            jumpeLogoutURL: "", // 退出后跳转的url
            vcodeURL: defaultURL + "/user/vcode"
        },
        // 错误提示
        msgPrompt: function(obj, msg) {
            obj.show().find("p").html(msg).show();
        },
        // 输入正确
        msgRight: function(obj) {
            obj.hide().find("p").show().html("");
        },
        onLoginSuc: function(){},
        onLayOut: function(){},
        // 变更验证码
        changeVcode: function(id) {
            var srcLink =   defaultURL + '/captcha/captcha/v/53808a1e178ee.html?refresh=',
                rand_num = Math.random();
            id.attr("src",srcLink+rand_num);
        },
        /*
         * 注册块
         * */
        regUserNameReg: function() { // 效验用户名
            var _namePath = MFLogin.objName;
            var usernameVal = $.trim(_namePath.userNameReg.val());
            var reg_rp_cn = /[\u4E00-\u9FA5]/g;
            var str_rp_cn = usernameVal.replace(reg_rp_cn, "aa");
            if (!MFLogin.regStr.usReg.test(str_rp_cn)) {
                MFLogin.msgPrompt(_namePath.regErr, "用户名格式错误");
                //_namePath.userNameReg.focus();
                return false;
            } else {
                MFLogin.msgRight(_namePath.regErr);
                return true;
            }
        },
        regMailReg: function(callback) { // 效验邮箱
            var _namePath = MFLogin.objName,
                flag = false;
            var mailVal = $.trim(_namePath.userMailReg.val());
            if (!MFLogin.regStr.mailReg.test(mailVal)) {
                MFLogin.msgPrompt(_namePath.regErr, "请正确填写Email地址");
                //_namePath.userMailReg.focus();
                callback(null,flag);
            } else {
                $.ajax({
                    url: defaultURL + "/account/check_email" ,//异步验证邮箱
                    type: "post",
                    data:"email" + '=' + mailVal,
                    dataType: "jsonp",
                    success: function(data) {
                        if (data.code == 0) {
                            MFLogin.msgRight(_namePath.regErr);
                            flag = true;
                            callback(null,flag);
                        } else {
                            MFLogin.msgPrompt(_namePath.regErr,data.msg);
                            callback(null,flag);
                        }
                    },
                    error: function() {
                        callback('网络异常');
                    }
		});

                //MFLogin.msgRight(_namePath.regErr);
            }
        },
        regPassWordReg: function() { // 效验密码
            var _namePath = MFLogin.objName;
            var passwordVal = $.trim(_namePath.userPasswordReg.val());
            if (!MFLogin.regStr.pwReg.test(passwordVal)) {
                MFLogin.msgPrompt(_namePath.regErr, "密码不正确");
                //_namePath.userPasswordReg.focus();
                return false;
            } else {
                MFLogin.msgRight(_namePath.regErr);
                return true;
            }
        },
        regRepeatPassWordReg: function() { // 重复密码
            var _namePath = MFLogin.objName;
            var passwordVal = _namePath.userPasswordReg;
            var repeatPasswordVal = $.trim(_namePath.repeatPasswordReg.val());
            if (passwordVal.val() !== repeatPasswordVal) {
                MFLogin.msgPrompt(_namePath.regErr, "两次密码不同");
                //_namePath.repeatPasswordReg.focus();
                return false;
            } else {
                MFLogin.msgRight(_namePath.regErr);
                return true;
            }
        },
        regVerifyCodeReg: function() { // 效验证码
            var _namePath = MFLogin.objName;
            var _verifyCode = $.trim(_namePath.verifyCodeReg.val());
            if (!MFLogin.regStr.codeReg.test(_verifyCode)) {
                MFLogin.msgPrompt(_namePath.regErr, "验证码格式错误");
                //_namePath.verifyCodeReg.focus();
                return false;
            } else {
                MFLogin.msgRight(_namePath.loginErr);
                return true;
            }
        },
        reg: function() { // 注册
	    
            var _namePath = MFLogin.objName;
            var username = $.trim(_namePath.userNameReg.val());
            var mail = $.trim(_namePath.userMailReg.val());
            var password = $.trim(_namePath.userPasswordReg.val());
            var rpassword = $.trim(_namePath.repeatPasswordReg.val());
            var verifyCode = $.trim(_namePath.verifyCodeReg.val());
            if (!MFLogin.regUserNameReg()) {
                return false;
            }
            MFLogin.regMailReg(function(err,flag){
                if(err){
                    return false;
                };
                if ( !flag ) {
                    return false;
                }
                if (!MFLogin.regPassWordReg()) {
                    return false;
                }
                if (!MFLogin.regRepeatPassWordReg()) {
                    return false;
                }
                if (!MFLogin.regVerifyCodeReg()) {
                    return false;
                }
                $.ajax({//注册请求
                    url: MFLogin.urlBase.regURL + "&nickname=" + username + "&email=" + mail + "&password=" + password + "&cpassword=" + rpassword + "&vcode=" + verifyCode + "&type=jsonp",
                    dataType: "jsonp",
                    success: function(data) {
                        // 返回格式 {returtate:1}  1 注册成功  0、注册失败
                        switch (data.code) {
                            case 0:
                                MFLogin.regAction(data.data, data.data.sys);
                                break;
                            default:
                                MFLogin.changeVcode(_namePath.regVcode);
                                MFLogin.msgPrompt(_namePath.regErr, data.msg);
                                break;
                        }
                    }
                });
		return true;
            });
            return true;
        },
        /*
         * 登陆块
         * */
        regAccountLogin: function() { // 效验用户名
            var _namePath = MFLogin.objName;
            var _usernameVal = $.trim(_namePath.accountLogin.val());
            var reg_rp_cn = /[\u4E00-\u9FA5]/g;
            var str_rp_cn = _usernameVal.replace(reg_rp_cn, "aa");
            if (MFLogin.regStr.mailReg.test(_usernameVal)) {
                    MFLogin.msgRight(_namePath.loginErr);
                    //_namePath.accountLogin[_usernameVal] = 0;
                    MFLogin['loginName'] = 'email';
                    return true;
            }else if(MFLogin.regStr.usReg.test(str_rp_cn)){
                MFLogin['loginName'] = 'username';
                MFLogin.msgRight(_namePath.loginErr);
                //_namePath.accountLogin[_usernameVal] = 0;
                return true;
            }else{
                MFLogin.msgPrompt(_namePath.loginErr, "请输入登录名");
                //_namePath.accountLogin.focus();
                return false;
            }
        },
        regPassWordLogin: function() { // 效验登陆密码
            var _namePath = MFLogin.objName;
            var _usernameVal = $.trim(_namePath.accountLogin.val());
            _namePath = MFLogin.objName;
            var _passwordVal = $.trim(_namePath.passwordLogin.val());
            if (!MFLogin.regStr.pwReg.test(_passwordVal)) {
                MFLogin.msgPrompt(_namePath.loginErr, "帐号或密码错误");
                //_namePath.passwordLogin.focus();
                return false;
            } else {
                MFLogin.msgRight(_namePath.loginErr);
                return true;
            }
        },
        regVerifyCodeLogin: function() { // 效验证码
            var _namePath = MFLogin.objName;
            var _verifyCode = $.trim(_namePath.verifyCodeLogin.val());
            if (!MFLogin.regStr.codeReg.test(_verifyCode)) {
                MFLogin.msgPrompt(_namePath.loginErr, "验证码格式错误");
                //_namePath.verifyCodeLogin.focus();
                return false;
            } else {
                MFLogin.msgRight(_namePath.loginErr);
                return true;
            }
        },
        // rememberLogin: function() { // 记录是否记住密码
        //     var _namePath = MFLogin.objName;
        //     if (_namePath.rememberLogin.attr("checked")) {
        //         return true;
        //     } else {
        //         return false;
        //     }
        // },
        loginCookie: function() { // 将账号存储cookie中
            var _namePath = MFLogin.objName,
                usernmae = _namePath.accountLogin.val();
            var password = _namePath.passwordLogin.val();
            $.setManyCookies({
                "username": usernmae,
                "password": password
            }, {
                expires: 30
            });
        },
        QQLogin:function(){
            var url = MFLogin.objName.qqLogin.attr('href');
            url = url+'?backurl='+MFLogin.urlBase.jumpeLoginURL;
            MFLogin.objName.qqLogin.attr('href',url);
            return true;
        },
        login: function() { // 登陆
            var _namePath = MFLogin.objName;
            var _usernameVal = $.trim(_namePath.accountLogin.val());
            //验证用户名
            if (!MFLogin.regAccountLogin()) {
                return false;
            };
            //验证密码
            if (!MFLogin.regPassWordLogin()) {
                return false;
            };
            //验证 验证码
            if (!MFLogin.regVerifyCodeLogin()) {
                return false;
            };
            var username = _namePath.accountLogin.val();
            var password = _namePath.passwordLogin.val();
            _usernameVal = $.trim(username);
            var verifyCode = _namePath.verifyCodeLogin.val();
            var sendURL = MFLogin.urlBase.loginURL;
	        var loginName =  MFLogin.loginName;
            var jsondata = {
                "password": password,
                "vcode": verifyCode,
                "sync": "ajax"
            };
            jsondata[loginName] = username;
            $.ajax({//登录时请求
                url: sendURL,
                dataType: "jsonp",
                type: "post",
                data: jsondata,
                success: function(data) {
                    // 返回格式 {login:0}  1 失败  0、成功
                    switch (data.code) {
                        case 0:
                            MFLogin.loginAction(data.data, data.data.sys,true);
                            //TODO 异步对外接口
                            MFLogin.onLoginSuc(data);
                            break;
                        default:
                            if (data.data.flag) {
                                MFLogin.objName.verifyCodeLogin.parent().show();
                                MFLogin.changeVcode(_namePath.loginVcode);
			    }else if(data.code == 400){// 当返回验证码错误时,更新验证码
				MFLogin.changeVcode(_namePath.loginVcode);
                            }
                            MFLogin.msgPrompt(_namePath.loginErr, data.msg);
                            //console.log(num);
                            break;
                    }
                },
                error: function() {
                    //console.log('510')
                }
            });
            return true;
        },

        logout: function() { // 退出请求
            var sendURL = MFLogin.urlBase.logoutURL + "?type=jsonp";
            $.ajax({
                url: sendURL,
                dataType: "jsonp",
                success: function(data) {
                    // 返回格式 {login:1}  1 成功
                    switch (data.code) {
                        case 0:
                            MFLogin.logoutAction(data.data.sys);
                            //MFLogin.onLayOut();
                            break;
                    }
                }
            });
        },
        onLayOut : function() {
            window.location.reload();
        },
        loginAction : function(data, sys,asynFlag) {
            $("body").append($(sys));

            if(!asynFlag) return;
            window.location.href = MFLogin.urlBase.jumpeLoginURL;

            // if ($(".wap-login").length > 0) {
            // } else{
            //         window.location.reload();
            // };

        },
        regAction : function(data, sys) {
            MFLogin.loginAction(data, sys,true);
        },
        logoutAction : function(sys) {
            if (sys) {
                var script = $(sys);
                var src_one = script.eq(0).attr("src");
                var position_ = src_one.indexOf("bbs");
                if (position_ > 0) {
                    $.getScript(src_one, function() {
                        $("body").append($(sys));
                        MFLogin.onLayOut();
                    });
                }
            }
        },
        // 注册和登陆切换
        tag: function(initial) {
            var _ind = initial;
            $(".register_tab li").removeClass("current").eq(_ind).addClass("current");
            $(".register_cont").eq(_ind).find('.validatecode_img img').trigger('click');
            $("#loginBox .register_cont").hide().eq(_ind).show();
        },
        // 初始配置
        init: function(num,_urlBase) {
	    num = num || 0;
            defaultURL = _urlBase || defaultURL ;
            // 各焦点
            MFLogin.objName = {
                "accountLogin": $("#accountLogin"), // 登陆用户名
                "passwordLogin": $("#passwordLogin"), // 密码
                "verifyCodeLogin": $("#verifyCodeLogin"), // 验证码
                //"rememberLogin": $("#rememberLogin"), // 记住密码
                "submitLogin": $("#submitLogin2"), // 登陆按钮
                "qqLogin":$("#qqLogin"),//QQ快捷登录
                "userNameReg": $("#userNameReg"), // 注册用户名
                "userMailReg": $("#userMailReg"), // 邮箱
                "userPasswordReg": $("#userPasswordReg"), // 密码
                "repeatPasswordReg": $("#repeatPasswordReg"), // 重复密码
                "verifyCodeReg": $("#verifyCodeReg"), // 验证码
                "submitReg": $("#submitReg"), // 注册按钮
                "loginErr": $("#loginMsgBox"), // 登录提示窗口
                "regErr": $("#regMsgBox"), // 注册提示窗口
                "loginVcode": $("#vcode_img_login"), //登陆验证码
                "regVcode": $("#vcode_img_reg") //注册验证码

            };
            if(initFlag) {
                return;
            }
            MFLogin.bind();
    },
    bind : function () {
            var _name = MFLogin.objName;
            $(".register_tab li").bind("click", function() { // 注册/登陆切换
                var cur = $(this).index();
                MFLogin.tag(cur);
            });
            var email_list = _name.accountLogin.siblings('ul').children();
            var _this = _name.accountLogin;
            _this.keyup(function() {
                email_list.each(function() {
                    var username_val = _this.val();
                    if (username_val.indexOf("@") > -1) {
                        var titl = $(this).attr("title"); //获取title的内容
                        var str_email = username_val + titl; //拼接邮箱
                        $(this).html(str_email);
                        _this.siblings().show(); //显示邮箱列表
                        $(this).click(function() {
                            _this.val($(this).html());
                            _this.siblings().hide();
                        });
                    }
                });
            });
            $.each(_name, function(objname, obj) {
                if (obj.attr('type') == 'text') {
                    //obj.val(MFLogin.initStr[objname]);
                    // obj.focus(function(){
                    //     if ( $(this).val() === MFLogin.initStr[$(this).attr('id')] ) {
                    //         $(this).val("");
                    //         $(this).addClass('active');
                    //     }
                    // });
                }
                if (obj.attr('type') == 'password') {
                    obj.focus(function() {
                        $(this).addClass('active');
                    });
                }
            });
            // 为QQ登陆改变路径
            
             _name.qqLogin.bind("click", function() { // 登陆
                MFLogin.QQLogin();
            });
            
            _name.accountLogin.blur(function() {
                MFLogin.regAccountLogin();
            });
            _name.passwordLogin.blur(function() {
                MFLogin.regPassWordLogin();
            });
            _name.verifyCodeLogin.blur(function() {
                MFLogin.regVerifyCodeLogin();
            });
            _name.submitLogin.bind("click", function() { // 登陆
                MFLogin.login();
            });
            _name.userNameReg.blur(function() {
                MFLogin.regUserNameReg();
            });
            _name.userMailReg.blur(function() {
                MFLogin.regMailReg(function(){});
            });
            _name.userPasswordReg.blur(function() {
                MFLogin.regPassWordReg();
            });
            _name.repeatPasswordReg.blur(function() {
                MFLogin.regRepeatPassWordReg();
            });
            _name.verifyCodeReg.blur(function() {
                MFLogin.regVerifyCodeReg();
            });

            _name.submitReg.click(function() {
                MFLogin.reg();
            });

            $("#vcode_img_login,#vcode_img_reg").click(function() {
                MFLogin.changeVcode($(this));
            });

            $("#login-cont").find("input").each(function() {
                $(this).keydown(function(event) {
                    if (event.keyCode == 13) {
                        $("#submitLogin2").click();
                    }
                });
            });
            $("#register-cont").find("input").each(function() {
                $(this).keydown(function(event) {
                    if (event.keyCode == 13) {
                        $("#submitReg").click();
                    }
                });
            });
            $("#accountLogin, #passwordLogin, #verifyCodeLogin, #verifyCodeReg, .reginfo li input").focus(function() {
                $(this).prevAll(".input_tips").hide();
            });
            $("#accountLogin, #passwordLogin, #verifyCodeLogin, #verifyCodeReg, .reginfo li input").blur(function() {
                var val = $(this).val(),
                    init_val = $(this).prevAll(".input_tips").html();
                val = $.trim(val);
                if (val == init_val || val == "") {
                    $(this).html("");
                    $(this).prevAll(".input_tips").show();
                } else {
                    //console.log("success")
                }
            });
            // 关闭提示框
            $("#loginMsgBox .prompt_close, #regMsgBox .prompt_close").click(function() {
                MFLogin.msgRight($(this).parent());
            });

            initFlag = true;
        }
    };

    if (typeof module != "undefined" && module.exports) {
        module.exports = MFLogin;
        /**
         * @brief sync login fun
         * @param type function
         */
        MFLogin.isLogin = isLogin;
        MFLogin.ifLogin = ifLogin;
    }
});

