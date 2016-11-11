define('mf/login_en', ['jquery', 'jquery/cookie'], function(require, exports, module) {

    // 魔方网注册和登陆
    var $ =  require("jquery");
    var jQuery = $;
    require('jquery/cookie');

    var MFLogin = MFLogin || {};

    MFLogin = {
        // 各焦点
        objName: {
            "accountLogin": $("#accountLogin"), // 登陆用户名
            "passwordLogin": $("#passwordLogin"), // 密码
            "verifyCodeLogin": $("#verifyCodeLogin"), // 验证码
            "rememberLogin": $("#rememberLogin"), // 记住密码
            //"submitLogin"     : $("#submitLogin2"),      // 登陆按钮
            "submitLogin": $("#submitLogin2"), // 登陆按钮
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

        },
        regStr: {
            usReg: /^[A-Z0-9._%+]{3,20}$/i, // 用户名6-32位字母和数字，以字母开头
            pwReg: /^.{1,16}$/,
            codeReg: /^[\w]{6}$/,
            mailReg: /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i, // 邮箱
            telReg: /^0?(13|14|15|18)[0-9]{9}$/
        },
        initStr: {
            accountLogin: "Input Username or Email",//请输入魔方用户名或邮箱
            passwordLogin: "Input Password",//请输入密码
            verifyCodeLogin: "Input Verification Code",//请输入验证码
            userNameReg: "Input Username",//请输入用户名
            userMailReg: "Input Email",//请输入邮箱
            userPasswordReg: "Input Password",//请输入密码
            repeatPasswordReg: "Input again",//请重复输入密码
            verifyCodeReg: "Input Verification Code"//请输入验证码
        },
        urlBase: {
            loginURL: "http://u.appmofang.com/account/login", // 登陆send url
            regURL: "http://u.appmofang.com/account/register", // 注册send url
            logoutURL: "http://u.appmofang.com/account/logout", // 退出send url
            jumpeLoginURL: "", // 登陆后跳转的url
            jumpeRegURL: "", // 注册后跳转的url
            jumpeLogoutURL: "", // 退出后跳转的url
            vcodeURL: "http://u.appmofang.com/user/vcode"
        },
        // 错误提示
        msgPrompt: function(obj, msg) {
            obj.slideDown().find("p").html(msg).show();
        },
        // 输入正确
        msgRight: function(obj) {
            obj.slideUp().find("p").show().html("");
        },
        onLoginSuc: function(){},
        onLayOut: function(){},
        // 变更验证码
        changeVcode: function(id) {
            var srcLink =   'http://u.appmofang.com/captcha/captcha/v/53808a1e178ee.html?refresh=',
                rand_num = Math.random();
            id.attr("src",srcLink+rand_num);
            //id.attr("src", id.attr("src").replace(/\?.*/, '?' + Math.random()));
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
                MFLogin.msgPrompt(_namePath.regErr, "Wrong Username format");//用户名格式错误
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
                MFLogin.msgPrompt(_namePath.regErr, "Please input a correct Email address");//请正确填写Email地址
                //_namePath.userMailReg.focus();
                callback(null,flag);
            } else {
                $.ajax({
                    url:"http://u.appmofang.com/account/check_email" ,
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
                })

                //MFLogin.msgRight(_namePath.regErr);
            }
        },
        regPassWordReg: function() { // 效验密码
            var _namePath = MFLogin.objName;
            var passwordVal = $.trim(_namePath.userPasswordReg.val());
            if (!MFLogin.regStr.pwReg.test(passwordVal)) {
                MFLogin.msgPrompt(_namePath.regErr, "Wrong Password");//密码不正确
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
                MFLogin.msgPrompt(_namePath.regErr, "The two Passwords are different");//两次密码不同
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
                MFLogin.msgPrompt(_namePath.regErr, "The code's format is incorrect");//验证码格式错误
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
                $.ajax({
                    url: MFLogin.urlBase.regURL + "?nickname=" + username + "&email=" + mail + "&password=" + password + "&cpassword=" + rpassword + "&vcode=" + verifyCode + "&type=jsonp",
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
            /*****************************************************************/
            if (MFLogin.regStr.mailReg.test(_usernameVal)) {
                    MFLogin.msgRight(_namePath.loginErr);
                    //_namePath.accountLogin[_usernameVal] = 0;
                    MFLogin['loginName'] = 'email';
                    return true;

            // } //else if(MFLogin.regStr.telReg.test(_usernameVal)){
            //     MFLogin['loginName'] = 'phone';
            //     MFLogin.msgRight(_namePath.loginErr);
            //     //_namePath.accountLogin[_usernameVal] = 0;
            //     return true;
            }else if(MFLogin.regStr.usReg.test(str_rp_cn)){
                MFLogin['loginName'] = 'username';
                MFLogin.msgRight(_namePath.loginErr);
                //_namePath.accountLogin[_usernameVal] = 0;
                return true;
            }else{
                MFLogin.msgPrompt(_namePath.loginErr, "Inpu Login name");//请输入登录名
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
                MFLogin.msgPrompt(_namePath.loginErr, "Input Password");//请输入密码
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
                MFLogin.msgPrompt(_namePath.loginErr, "The code's format is incorrect");//验证码格式错误
                //_namePath.verifyCodeLogin.focus();
                return false;
            } else {
                MFLogin.msgRight(_namePath.loginErr);
                return true;
            }
        },
        rememberLogin: function() { // 记录是否记住密码
            var _namePath = MFLogin.objName;
            if (_namePath.rememberLogin.attr("checked")) {
                return true;
            } else {
                return false;
            }
        },
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
            loginName =  MFLogin.loginName
            var jsondata = {
                "password": password,
                "vcode": verifyCode,
                "sync": "ajax"
            };
            jsondata[loginName] = username;
            $.ajax({
                url:"http://u.appmofang.com/account/login",
                 //sendURL + "/" + MFLogin.loginName + "=" + username + "&password=" + password + "&vcode=" + verifyCode + "&type=jsonp",
                dataType: "jsonp",
                type: "post",
                data: jsondata,
                success: function(data) {
                    // 返回格式 {login:0}  1 失败  0、成功
                    switch (data.code) {
                        case 0:
                            MFLogin.loginAction(data.data, data.data.sys);
                            MFLogin.onLoginSuc();
                            break;
                        default:
                            if (data.data.flag) {
                                MFLogin.objName.verifyCodeLogin.parent().show();
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
        logout: function() { // 退出
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
        // 注册和登陆切换
        tag: function(initial) {
            var _ind = initial;
            $(".register_tab li").removeClass("current").eq(_ind).addClass("current");
            $(".register_cont").eq(_ind).find('.validatecode_img img').trigger('click');
            $("#fmBox .register_cont").slideUp(200).eq(_ind).slideDown(500);
        },
        // 控制浮层
        popWin: function(winObj, tagIndex) {
            var obj = $(winObj);
            addOverlay('#000', 0.4);
            obj.css("position", "absolute")
            .css("top", ($(window).height() - obj.height()) / 2 + $(window).scrollTop())
            .css("left", ($(window).width() - obj.width()) / 2 + $(window).scrollLeft())
            .css("z-index", "9999")
            .fadeIn();
            $(window).scroll(function() {
                obj.css("top", ($(window).height() - obj.height()) / 2 + $(window).scrollTop())
                .css("left", ($(window).width() - obj.width()) / 2 + $(window).scrollLeft());
            });
            $(window).resize(function() {
                obj.css("top", ($(window).height() - obj.height()) / 2 + $(window).scrollTop())
                .css("left", ($(window).width() - obj.width()) / 2 + $(window).scrollLeft());
            });
            MFLogin.tag(tagIndex);
            $(".close", obj).click(function() {
                if (MFLogin.closeDelegate) {
                    MFLogin.closeDelegate(function() {
                        hideMask(obj);
                    });
                } else {
                    hideMask(obj);
                }
                return false;
            });

            function hideMask(target) {

                removeOverlay();

                target.fadeOut();

            };

            function isExist(elem) {

                if (typeof elem !== 'undefined' && typeof elem !== null) {

                    return true;

                } else {

                    return false;

                }

            };

            function addOverlay(cl, op) {

                var overlayCss = {

                    position: 'fixed',

                    zIndex: '9998',

                    top: '0px',

                    left: '0px',

                    height: '100%',

                    width: '100%',

                    backgroundColor: '#000',

                    filter: 'alpha(opacity=40)',

                    opacity: 0.4

                };



                var overlay = $('<div id="Overlay" class="OverlayBG" />');

                if (isExist(cl)) {

                    overlayCss.backgroundColor = cl;

                }

                $('body').append(overlay.css(overlayCss));

                if (isExist(op)) {

                    $('#Overlay').animate({
                        opacity: op
                    }, 0);

                }

            };

            function removeOverlay() {

                if (isExist($('#Overlay'))) {

                    $('#Overlay').fadeOut();

                    $('#Overlay').remove();

                }

            };

        },
        // 初始配置
        init: function() {
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
            // 侦听第三方登陆
            $("#sinaweibo").bind("click", function() {
                MF_USER.loginSina();
            });
            $("#qq").bind("click", function() {
                MF_USER.loginByQQ();
            });

            // 关闭提示框
            $("#loginMsgBox .prompt_close, #regMsgBox .prompt_close").click(function() {
                MFLogin.msgRight($(this).parent());
            });
        }
    };

    MFLogin.init();

    // 第三方登陆
    var MF_CON = {
        URL: {
            passport_qq: "",
            passport_sinaweibo: ""
        }
    };

    var MF_USER = {
        jumpeLoginUrl: function(url) {
            window.location.href = url;
        },
        loginByQQ: function() {
            MF_USER.jumpeLoginUrl(encodeURIComponent(MF_CON.URL.passport_qq));
        },
        loginSina: function() {
            MF_USER.jumpeLoginUrl(encodeURIComponent(MF_CON.URL.passport_sinaweibo));
        }
    };
    if (typeof module != "undefined" && module.exports) {
        module.exports = MFLogin;
    }
});
