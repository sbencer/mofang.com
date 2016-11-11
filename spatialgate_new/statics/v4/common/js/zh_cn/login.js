/**
 * @file login.js
 * @brief   MFE Login Module
 * @author baozi
 * @version 0.0.2
 * @date 2014-10-28
 * 增加异步回调
 * login.isLogin(function (status) {
 *       status true login
 *       status false no login
 *
 *   })
 *
 */

define('mf/login', ['tpl','transform','jquery', 'jquery/cookie'], function(require, exports, module) {
    var $ =  require("jquery");
    require('jquery/cookie');
    var Transform = require("Transform");

    var tpl = require("tpl").tpl;
    var i18n = require("tpl").i18n;

    var jQuery = $;
    var initFlag = false;

    var newVersion = !$(".header-login-user").length;

    var MFLogin = MFLogin || {};

         // 是否登陆
    var loginStatus = false;
    //登陸方式
    var loginWay = null;//-1 check_login. 0 login. 1 regester.
    // 是否检测登陆状态
    var isCheckedLogin = false;

    // 登陆检查的回调函数
    var loginCallbacks = [];

    if (newVersion) {
        var transform = new Transform();
    }
   
    // 页面打开时,异步更新登陆状态
    $.ajax({
        url: defaultURL + "/account/check_login?more=1",
        dataType: 'jsonp',
        success: function(data) {
            if (0 == data.code && data.data.nickname) {
                loginWay = 1;
                if (newVersion) {
                    transform.setTo($('#header-user-login'));
                    transform.load();
                }
                MFLogin.loginAction(data.data,data.data.sys,false);
                MFLogin.onLoginSuc && MFLogin.onLoginSuc(data,loginWay);

                // 已登陆
                triggerCallbacks(true);
            } else {
                $("#header-user-nologin").show();
                // 未登陆
                triggerCallbacks(false);
            }
        },
        error: function(data) {
            //console.log(data);
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

    //返回登录状态
    function getLoginStatus() {
        return isCheckedLogin;
    }

    // 接口函数
    function isLogin(next) {
        if (isCheckedLogin) {
            next(null, isLogin);
        } else {
            loginCallbacks.push(next);
        }
    }

    function triggerCallbacks(status) {
        loginStatus = status;
        for (var i = 0; i < loginCallbacks.length; i++) {
            var next = loginCallbacks[i];
            next && next.call && next(loginStatus);
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
            codeReg: /^(\w{6}|\w{4})$/,
            mailReg: /^([a-z0-9]*[-_]?[a-z0-9]+)+@([a-z0-9]*[-_]?[a-z0-9]+)+[\.][a-z]{2,3}([\.][a-z]{2})?$/i, // 邮箱
            telReg: /^1[34578]\d{9}$/
        },
        urlBase: {
            loginURL: defaultURL +"/home/account/login", //"http://u.mofang.com/account/login", // 登陆send url
            regURL: defaultURL +"/home/account/register", // 注册send url
            logoutURL: defaultURL + "/account/logout", // 退出send url
            jumpeLoginURL: "", // 登陆后跳转的url
            jumpeRegURL: "", // 注册后跳转的url
            jumpeLogoutURL: "", // 退出后跳转的url
            vcodeURL: defaultURL + "/user/vcode"
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
            var srcLink =   defaultURL + '/captcha/captcha/v/53808a1e178ee.html?refresh=',
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
                MFLogin.msgPrompt(_namePath.regErr, i18n.errorTips.register.niceName);
                //_namePath.userNameReg.focus();
                return false;
            } else {
                MFLogin.msgRight(_namePath.regErr);
                return true;
            }
        },
        regMailMbeReg: function(callback) { // 效验邮箱或者手机号,废弃了
            var _namePath = MFLogin.objName,
                flag = false;
            var mailVal = $.trim(_namePath.regUser.val());
            if (!MFLogin.regStr.mailReg.test(mailVal)) {
                MFLogin.msgPrompt(_namePath.regErr, i18n.errorTips.register.email);
                //_namePath.userMailReg.focus();
                callback(null,flag);
            } else {
                var userType = null;
                if(MFLogin.regStr.mailReg.test(_namePath.regUser)){
                    userType='email';
                }else if(MFLogin.regStr.telReg.test(_namePath.regUser)){
                    userType='phone';
                }
                if(!userType){
                    return false;
                }
                var password = $('#registerPssWord').val();
                var data = {
                    password : _namePath.passwordReg
                };
                var url = "";
                if(userType == "email"){
                    url="/home/account/email_register";
                    data.vcode = _namePath.regUser.val();
                }else{
                    url="/home/account/register";
                    data.phone_vcode = _namePath.regUser.val();
                    data.vcode = _namePath.regUser.val();
                }

                $.ajax({
                    url: url ,//异步验证邮箱手机号
                    type: "get",
                    data:data,
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
        regPhoneNum: function (callback) {

        },
        regPassWordReg: function() { // 效验密码
            var _namePath = MFLogin.objName;
            var passwordVal = $.trim(_namePath.userPasswordReg.val());
            if (!MFLogin.regStr.pwReg.test(passwordVal)) {
                MFLogin.msgPrompt(_namePath.regErr, i18n.errorTips.register.pass);
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
                MFLogin.msgPrompt(_namePath.regErr, i18n.errorTips.register.diffPass);
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
                MFLogin.msgPrompt(_namePath.regErr, i18n.errorTips.vcode);
                //_namePath.verifyCodeReg.focus();
                return false;
            } else {
                MFLogin.msgRight(_namePath.loginErr);
                return true;
            }
        },
        reg: function() { // 注册
            var _namePath = MFLogin.objName;
            if (_namePath.submitReg.hasClass('disable')) {
                return false;
            }

            if(!MFLogin.regEmailPhone(_namePath.regUser)){

                _namePath.regUser.addClass('highlight2');
                return false;
            }else{
                _namePath.regUser.addClass('highlight1');
            }
            //验证密码
            if (!MFLogin.regPassWordLogin(_namePath.passwordReg)) {
                return false;
            }
            //验证 验证码
            if (!MFLogin.regVerifyCodeLogin(_namePath.verifyCodeReg)) {
                return false;
            }
            
            

            var userType = null;
            var userVal = _namePath.regUser.val();
            if(MFLogin.regStr.mailReg.test(userVal)){
                userType='email';
            }else if(MFLogin.regStr.telReg.test(userVal)){
                userType='phone';
            }
            if(!userType){
                return false;
            }

            var data = {
                password : _namePath.passwordReg.val()
            };
            var url = "";
            if(userType == "email"){
                url=defaultURL + "/home/account/email_register";
                data.vcode = _namePath.verifyCodeReg.val();
                data.email = userVal;
            }else{
                url=defaultURL + "/home/account/register";
                //验证手机 验证码
                if (!MFLogin.regPhoneCodeReg(_namePath.phoneCodeReg)) {
                    return false;
                }
                data.phone_vcode = _namePath.phoneCodeReg.val();
                data.vcode = _namePath.verifyCodeReg.val();
                data.phone = userVal;
            }

            _namePath.submitReg.addClass('disable');
            $.ajax({//注册请求
                url: url ,//异步验证邮箱手机号
                type: "get",
                data:data,
                dataType: "jsonp",
                success: function(data) {
                    // 返回格式 {returtate:1}  1 注册成功  0、注册失败
                    switch (data.code) {
                        case 0:
                            loginWay = -1;
                            // MFLogin.regAction(data.data, data.data.sys);
                            triggerCallbacks(true);
                            MFLogin.onLoginSuc(data,loginWay);
                            if(userType == 'email'){
                                window.location.href=defaultURL + '/home/account/register_send_email';
                            }else{
                                window.location.reload();
                            }
                            break;
                        default:
                            MFLogin.changeVcode(_namePath.regVcode);

                            MFLogin.msgPrompt(_namePath.regErr, data.msg);
                            break;
                    }

                    _namePath.submitReg.removeClass('disable');
                },
                error: function() {
                    _namePath.submitReg.removeClass('disable');
                }
            });
            return true;
        },
        /*
         * 登陆块
         * */
        regAccountLogin: function(obj) { // 效验用户名
            var _namePath = MFLogin.objName;
            var _usernameVal = $.trim($(obj).val());
            var reg_rp_cn = /[\u4E00-\u9FA5]/g;
            var str_rp_cn = _usernameVal.replace(reg_rp_cn, "aa");
            var errImg = $(obj).siblings('.username_err');
            /*****************************************************************/
            if (MFLogin.regStr.mailReg.test(_usernameVal)) {
                MFLogin.msgRight(_namePath.loginErr);
                //_namePath.accountLogin[_usernameVal] = 0;
                MFLogin['loginName'] = 'email';
                $(obj).removeClass('highlight2').addClass('highlight1');
                errImg.removeClass('errImg');
                return true;

            // } //else if(MFLogin.regStr.telReg.test(_usernameVal)){
            //     MFLogin['loginName'] = 'phone';
            //     MFLogin.msgRight(_namePath.loginErr);
            //     //_namePath.accountLogin[_usernameVal] = 0;
            //     return true;
            }else if(MFLogin.regStr.usReg.test(str_rp_cn)){
                MFLogin['loginName'] = 'username';
                $(obj).removeClass('highlight2').addClass('highlight1');
                errImg.removeClass('errImg');
                //MFLogin.msgRight(_namePath.loginErr);
                //_namePath.accountLogin[_usernameVal] = 0;
                return true;
            }else{
                //MFLogin.msgPrompt(_namePath.loginErr, i18n.errorTips.login.user);
                //_namePath.accountLogin.focus();
                $(obj).removeClass('highlight1').addClass('highlight2');
                errImg.addClass('errImg');
                return false;
            }
        },
        regEmailPhone: function (obj) { //校验邮箱和手机
            var _namePath = MFLogin.objName;
            var isUserNameLogin = _namePath.oldUser.hasClass('isUserNameLogin');
            if (isUserNameLogin) {//用户名登录
                return MFLogin.regAccountLogin(obj);
            }

            var _usernameVal = $.trim($(obj).val());

            var errImg = $(obj).siblings('.username_err');
            if (MFLogin.regStr.telReg.test(_usernameVal)) {
                MFLogin['loginName'] = 'phone';
                $(obj).removeClass('highlight2').addClass('highlight1');
                errImg.removeClass('errImg');
                return true;
            }else if(MFLogin.regStr.mailReg.test(_usernameVal)){
                MFLogin['loginName'] = 'email';
                $(obj).removeClass('highlight2').addClass('highlight1');
                errImg.removeClass('errImg');
                return true;
            }
            $(obj).removeClass('highlight1').addClass('highlight2');
            errImg.addClass('errImg');
            return false;
        },
        regPassWordLogin: function(obj) { // 效验登陆密码
            var _namePath = MFLogin.objName;
            var _passwordVal = $.trim($(obj).val());
            var errImg = $(obj).siblings('.password_err');
            if (!MFLogin.regStr.pwReg.test(_passwordVal)) {
                $(obj).removeClass('highlight1').addClass('highlight2');
                errImg.addClass('errImg');
                //MFLogin.msgPrompt(_namePath.loginErr, i18n.errorTips.login.pass);
                //_namePath.passwordLogin.focus();
                return false;
            } else {
                $(obj).removeClass('highlight2').addClass('highlight1');
                errImg.removeClass('errImg');
                //MFLogin.msgRight(_namePath.loginErr);
                return true;
            }
        },
        regVerifyCodeLogin: function(obj) { // 效验证码
            var _namePath = MFLogin.objName;
            var _verifyCode = $.trim($(obj).val());
            var errImg = $(obj).siblings('.verifycode_err');
            if (!MFLogin.regStr.codeReg.test(_verifyCode)) {
                $(obj).removeClass('highlight1').addClass('highlight2');
                errImg.addClass('errImg');
                //MFLogin.msgPrompt(_namePath.loginErr, i18n.errorTips.vcode);
                //$(obj).focus();
                return false;
            } else {
                $(obj).removeClass('highlight2').addClass('highlight1');
                //MFLogin.msgRight(_namePath.loginErr);
                errImg.removeClass('errImg');
                return true;
            }
        },
        regPhoneCodeReg: function(obj) { // 效手机验证码
            var _namePath = MFLogin.objName;
            var _verifyCode = $.trim($(obj).val());
            var errImg = $(obj).siblings('.verifycode_err');
            if (!_verifyCode) {
                $(obj).removeClass('highlight1').addClass('highlight2');
                errImg.addClass('errImg');
                //MFLogin.msgPrompt(_namePath.loginErr, i18n.errorTips.vcode);
                //$(obj).focus();
                return false;
            } else {
                $(obj).removeClass('highlight2').addClass('highlight1');
                //MFLogin.msgRight(_namePath.loginErr);
                errImg.removeClass('errImg');
                return true;
            }
        },
        rememberLogin: function(obj) { // 记录是否记住密码
            var _namePath = MFLogin.objName;
            if ($(obj).attr("checked")) {
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
        changeUsernameLogin : function(){//切换到用户名登录
            var _namePath = MFLogin.objName;
            _namePath.loginUser.attr('placeholder', i18n.login.old_user).val("").removeClass('highlight2 highlight1');
            var errImg = $('.username_err');
            errImg.removeClass('errImg');
            _namePath.oldUser.html(i18n.login.email_phone_login + "<b>>></b>");
        },
        changeEmailPhoneLogin : function(){//切换到手机和邮箱登录
            var _namePath = MFLogin.objName;
            _namePath.loginUser.attr('placeholder', i18n.login.user).val("").removeClass('highlight2 highlight1');
            var errImg = $('.username_err');
            errImg.removeClass('errImg');
            _namePath.oldUser.html(i18n.login.usernameLogin + "<b>>></b>");
        },
        login: function() { // 登陆
            var _namePath = MFLogin.objName;
            var isUserNameLogin = _namePath.oldUser.hasClass('isUserNameLogin');
            if (isUserNameLogin) {
                //验证用户名
                if (!MFLogin.regAccountLogin(_namePath.loginUser)) {
                    _namePath.loginUser.addClass('highlight2');
                    return false;
                }
            }else{
                if(!MFLogin.regEmailPhone(_namePath.loginUser)){
                    _namePath.loginUser.addClass('highlight2');
                    return false;
                }else{
                    _namePath.loginUser.addClass('highlight1');
                }
            }
            //验证密码
            if (!MFLogin.regPassWordLogin(_namePath.passwordLogin)) {
                return false;
            }
            //验证 验证码
            if (!MFLogin.regPhoneCodeReg(_namePath.verifyCodeLogin)) {
                return false;
            }

            var username = _namePath.loginUser.val();
            var password = _namePath.passwordLogin.val();
            var _usernameVal = $.trim(username);
            var verifyCode = _namePath.verifyCodeLogin.val();
            var sendURL = MFLogin.urlBase.loginURL;
            var loginName =  MFLogin.loginName;
            var jsondata = {
                "password": password,
                "vcode": verifyCode,
                "sync": "ajax"
            };
            //document.write(sendURL+"?"+"password="+password+"&vcode="+verifyCode+"&sync=ajax"+"&callback=ss");
            jsondata[loginName] = username;
            $.ajax({//登录时请求
                url: sendURL,
                 //sendURL + "/" + MFLogin.loginName + "=" + username + "&password=" + password + "&vcode=" + verifyCode + "&type=jsonp",
                dataType: "jsonp",
                data: jsondata,
                success: function(data) {
                    // 返回格式 {login:0}  1 失败  0、成功
                    switch (data.code) {
                        case 0:
                            loginWay = 0;
                            var f = window.loginSuccessReload;
                            if(f && f.call) {
                                f(data);
                            } else {
                                MFLogin.loginAction(data.data, data.data.sys,true);
                                //TODO 异步callback
                                triggerCallbacks(true);
                               MFLogin.onLoginSuc && MFLogin.onLoginSuc(data,loginWay);
                            }
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
                error: function(error) {
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
            // 截取4个汉子长度
            var nickname = cut_str(data.nickname,4);
            $("#header-user-info").show().find('#logined').text(nickname).attr("href", defaultURL);
            $("#header-user-info").find('img').attr("src",data.avatar);
            $("#header-user-nologin").hide();
            //        var script = JSON.parse(sys);
            $("body").append($(sys));

            if(!asynFlag) return;
            if (newVersion) {
                transform.setFrom($('.register_box'));
                transform.play();
                window.setTimeout(function() {
                    $(".close").trigger('click', $(".register_box"));
                }, 1000);
            } else {
                $(".close").trigger('click', $(".register_box"));
            }
        },
        regAction : function(data, sys) {
            MFLogin.loginAction(data, sys,true);
        },
        logoutAction : function(sys) {
            $("#header-user-nologin").show();
            $("#header-user-info").hide().find("#logined").text('');
            /*if (sys) {
                var script = $(sys);
                var src_one = script.eq(0).attr("src");
                var position_ = src_one.indexOf("bbs");
                if (position_ > 0) {
                    $.getScript(src_one, function() {
                        $("body").append($(sys));

                        MFLogin.onLayOut();
                    });
                }
            }*/

            MFLogin.onLayOut()
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
            //TODO 提到绑定事件类
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

                if(!$("#Overlay").length) {
                    $('body').append(overlay.css(overlayCss));
                }
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
        init: function(num,_urlBase) {
            var num = num || 0;
            defaultURL = _urlBase || defaultURL ;

            if(!$(".register_box").length) {
                $(tpl).appendTo("body");
            }
            MFLogin.popWin(".register_box",num);
            if (newVersion) {
                transform.setTo($('#header-user-login'));
                transform.load();
            }
            // 各焦点
           MFLogin.objName = {
                "loginUser": $("#CLoginCont #CLoginUser"), // 登陆电话号码，邮箱
                "regUser": $("#CRegisterCont #CRegUser"), // 注册电话号码，邮箱
                "passwordLogin": $("#CLoginCont #CPasswordLogin"), //登录密码
                "passwordReg": $("#CRegisterCont #CPasswordReg"), //注册密码
                "verifyCodeLogin": $("#CLoginCont #CVerifyCodeLogin"), // 登录验证码
                "verifyCodeReg": $("#CRegisterCont #CVerifyCodeReg"), // 注册验证码
                "phoneCodeReg": $("#CRegisterCont #CPhoneCodeReg"), // 注册短信验证码
                "rememberLogin": $("#CLoginCont #CAutoLogin"), // 登录记住密码
                "rememberReg": $("#CRegisterCont #CAutoReg"), // 注册记住密码
                "submitLogin": $("#CLoginCont #CSubmitLogin"), // 登陆按钮
                "submitReg": $("#CRegisterCont #CSubmitReg"), // 注册按钮
                /*"userNameReg": $("#userNameReg"), // 注册
                "userMailReg": $("#userMailReg"), // 邮箱
                "userPasswordReg": $("#userPasswordReg"), // 密码
                "repeatPasswordReg": $("#repeatPasswordReg"), // 重复密码
                "submitReg": $("#submitReg"), // 注册按钮*/
                "loginErr": $("#loginMsgBox"), // 登录提示窗口
                "regErr": $("#regMsgBox"), // 注册提示窗口
                "loginVcode": $("#vcode_img_login"), //登陆验证码
                "regVcode": $("#vcode_img_reg"), //注册验证码
                "oldUser": $(".old-user"), //切换到用户名登录
                "regId":$("#CRegisterCont"),//注册表单id
                "loginId":$("#CLoginCont")//登录表单id
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
            // 密码是否展示
            $(".pwd-change").on('click', function(event) {
                var _this = $(this);
                if (_this.hasClass('pwd-active')) {
                    _this.parent().find('.loginpwd').attr('type', 'password');
                    _this.removeClass('pwd-active')
                }else{
                    _this.parent().find('.loginpwd').attr('type', 'text');
                    _this.addClass('pwd-active')
                };
                event.preventDefault();
            });

            //处理邮箱-手机验证码变化，
            var $RegisterUser =  _name.regUser;
            var $VerifyCodeReg =  _name.verifyCodeReg;
            $RegisterUser.blur(function () {
               var registerVal = $RegisterUser.val();
                MFLogin.msgRight(_name.regErr);
                if(MFLogin.regStr.mailReg.test(registerVal)){
                    $('.phone').stop().slideUp();
                }else if(MFLogin.regStr.telReg.test(registerVal)){
                    $('.phone').stop().slideDown();
                }else{
                   
                    MFLogin.msgPrompt(_name.regErr, "请输入正确的邮箱/手机号");
                }
            });
            //手机，点击发送短信
            _name.regId.find('.code-img span').on('click', function () {
                var jPublicGetCode = $(this);
                if(jPublicGetCode.hasClass('getSend')){
                    return false;
                }
                
                if(!$VerifyCodeReg.val()){
                    MFLogin.msgPrompt(_name.regErr, i18n.login.secCode);
                    return false;
                }else if(!MFLogin.regVerifyCodeReg()){
                   MFLogin.msgPrompt(_name.regErr, i18n.errorTips.vcode);
                    return false; 
                }
                $.ajax({
                    url:defaultURL + '/home/api/PhoneUniqueCheck',
                    data:{
                        phone:$RegisterUser.val(),
                        vcode:$VerifyCodeReg.val()
                    },
                    dataType:'jsonp',
                    success:function(data){
                        if(data.code !=0){
                            MFLogin.msgPrompt(_name.regErr, data.msg);
                            MFLogin.changeVcode(_name.regVcode);
                        }else{

                            MFLogin.msgRight(_name.regErr);
                            getCode(jPublicGetCode);
                        }
                    },
                    error: function(data){

                    }
                })


            });
            function getCode(jPublicGetCode){
                $.ajax({
                    url:defaultURL + '/home/api/send_phone_vcode_request',
                    data:{
                        phone:$RegisterUser.val(),
                        vcode:$VerifyCodeReg.val()
                    },
                    dataType:'jsonp',
                    success:function(data){
                        if(data.code ==0){
                            jPublicGetCode.css('color', '#999').addClass('getSend');
                            //jPublicGetCode.addClass('getSend');
                            var seconds = 60;
                            var clearInterval = setInterval(function(){
                                seconds -= 1;
                                jPublicGetCode.html('已发送(' + seconds + 's)');

                                if(seconds === 0){
                                    window.clearInterval(clearInterval);
                                    jPublicGetCode.html('获取短信验证码').removeAttr('style').removeClass('getSend');
                                }
                            }, 1000);
                        }else{
                            MFLogin.msgPrompt(_name.regErr, data.msg);
                            MFLogin.changeVcode(_name.regVcode);
                        }
                    },
                    error: function(data){
                    }
                });
            }
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
            /*_name.accountLogin.blur(function() {
                MFLogin.regAccountLogin();
            });*/
            _name.loginUser.blur(function() {
                var _this = this;
                MFLogin.regEmailPhone(_this);
            });
            _name.regUser.blur(function() {
                var _this = this;
                MFLogin.regEmailPhone(_this);
            });
            _name.oldUser.on('click',function() {//用户名登录和邮箱手机登录切换
                var isUserNameLogin = _name.oldUser.hasClass('isUserNameLogin');
                if (isUserNameLogin) {
                    MFLogin.changeEmailPhoneLogin();
                    _name.oldUser.removeClass('isUserNameLogin');
                }else{
                    MFLogin.changeUsernameLogin();
                    _name.oldUser.addClass('isUserNameLogin');
                }

            });

            _name.passwordLogin.blur(function() {
                var _this =this;
                MFLogin.regPassWordLogin(_this);
            });
            _name.passwordReg.blur(function() {
                var _this =this;
                MFLogin.regPassWordLogin(_this);
            });

            _name.verifyCodeLogin.blur(function() {
                var _this =this;
                MFLogin.regVerifyCodeLogin(_this);
            });
            _name.verifyCodeReg.blur(function() {
                var _this =this;
                MFLogin.regVerifyCodeLogin(_this);
            });
            _name.phoneCodeReg.blur(function() {
                var _this =this;
                MFLogin.regVerifyCodeLogin(_this);
            });
            _name.submitLogin.on("click", function(evt) { // 登陆
                MFLogin.login();
                evt.preventDefault();
            });
            /*_name.userNameReg.blur(function() {
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
            });*/
            _name.submitReg.on("click", function(evt) { // 登陆

                MFLogin.reg();
                evt.preventDefault();
            });


            
            // 侦听第三方登陆
            $("#sinaweibo").bind("click", function() {
                MF_USER.loginSina();
            });
            $("#qq").bind("click", function() {
                MF_USER.loginByQQ();
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
            $("#accountLogin, #passwordLogin, .reginfo li input").focus(function() {
                $(this).prevAll(".input_tips").hide();
                //$(this).next("input").focus();
            });
            $("#accountLogin, #passwordLogin, .reginfo li input").blur(function() {
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

    //MFLogin.init();

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
        /**
         * @brief sync login fun
         * @param type function
         */
        MFLogin.isLogin = isLogin;
        MFLogin.getLoginStatus = getLoginStatus;
    }
});
