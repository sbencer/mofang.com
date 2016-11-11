define("login_en/check", ["jquery", 'mf/login_en', 'jquery/jq_cookie'], function(require, exports, module) {

    var $ = require("jquery");
    var MFLogin = require('mf/login_en');
    require('jquery/jq_cookie');

    var Transform = (function() {

        function Transform(settings) {
            settings = settings || {};

            this.settings_ = settings;
            this.from_ = settings.from;
            this.to_ = settings.to;
            this.transform_ = this.transformLow_;
            this.transform_ = this.transformHigh_;
        }
        Transform.prototype.transformLow_ = function() {
            this.from_.hide();
        };
        Transform.prototype.transformHigh_ = function() {
            var f = this.from_;

            var t = this.to_;

            var sx = t.outerWidth() / f.outerWidth();
            var sy = t.outerHeight() / f.outerHeight();
            var tx = (t.offset().left - f.offset().left);
            var ty = (t.offset().top - f.offset().top);
            var transforms = [
                'scale(' + sx + ',' + sy + ')',
                'translate(' + tx + 'px,' + ty + 'px)'
            ];
            var str = transforms.join(" ");
            //this.from_.animate({transform: str});

            f.css({
                overflow: "hidden"
            });
            var w = t.outerWidth();
            var h = t.outerHeight();
            w = 0;
            h = 0;
            var l = f.position().left + tx;
            var to = f.position().top + ty;
            l = l + t.outerWidth() / 2;
            to = to + t.outerHeight() / 2;

            f.animate({
                width: w,
                height: h,
                left: l,
                top: to
            });
        };
        Transform.prototype.load = function() {
            return true;
            /// todo:
            if (this.loading_) {
                return false;
            };
            var self = this;
            this.loading_ = true;
            seajs.use(["jquery/transform2d"], function(transform) {
                self.transform_ = self.transformHigh_;
                self.loading_ = false;
            });
            return true;
        };
        Transform.prototype.setFrom = function(from) {
            this.from_ = from;
        };
        Transform.prototype.setTo = function(to) {
            this.to_ = to;
        };
        Transform.prototype.play = function() {
            if (!this.from_ || !this.to_) {
                throw new Error('to parm error.');
            };
            this.transform_();
        };
        return Transform;
    })();



    // TODO:fixed 兼容老版本的工具条
    var newVersion = !$(".header-login-user").length;
    if (newVersion) {
        var transform = new Transform();
    }
    MFLogin.onLayOut = function() {
        window.location.reload();
    };
    MFLogin.loginAction = function(data, sys) {
        // 截取4个汉子长度
        var nickname = cut_str(data.nickname,4);
        $("#header-user-info").show().find('#logined').text(nickname);
        $("#header-user-nologin").hide();
        //        var script = JSON.parse(sys);
        $("body").append($(sys));


        if (newVersion) {
            transform.setFrom($('.register_box'));
            transform.play();
            window.setTimeout(function() {
                $(".close").trigger('click', $(".register_box"));
            }, 1000);
        } else {
            $(".close").trigger('click', $(".register_box"));
        }
    };

    MFLogin.regAction = function(data, sys) {
        MFLogin.loginAction(data, sys);
    };

    MFLogin.logoutAction = function(sys) {
        $("#header-user-nologin").show();
        $("#header-user-info").hide().find("#logined").text('');
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
    };
    //MFLogin.enterClcik = function(){
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
    //}
    $("#login").click(function() {
        MFLogin.popWin(".register_box", 0);
        if (newVersion) {
            transform.setTo($('#header-user-login'));
            transform.load();
        }
    });

    $("#reg").click(function() {
        MFLogin.popWin(".register_box", 1);
        if (newVersion) {
            transform.setTo($('#header-user-login'));
            transform.load();
        }
    });

    $("#logout").click(function() {
        MFLogin.logout();
    });

    $("#vcode_img_login,#vcode_img_reg").click(function() {
        MFLogin.changeVcode($(this));
    });

    // 是否登陆
    var loginStatus = false;

    // 是否检测登陆状态
    var isCheckedLogin = false;

    // 登陆检查的回调函数
    var loginCallbacks = [];

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

    // 页面打开时,异步更新登陆状态
    $.ajax({
        url: "http://u.appmofang.com/account/check_login",
        dataType: 'jsonp',
        success: function(data) {
            if (0 == data.code && data.data.nickname) {
                if (newVersion) {
                    transform.setTo($('#header-user-login'));
                    transform.load();
                }
                MFLogin.loginAction(data.data);
                // 已登陆
                triggerCallbacks(true);
            } else {
                $("#header-user-nologin").show();
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
            window.location.href = 'http://u.appmofang.com/account/index';
        };
    }

    // 用户同步登陆
    // 页面装在时，检查mf_websiteli cookie 代表没有同步登陆其他应用.如:bbs
    // COOKIE: mf_websiteli ：(服务器端)用户需要三方登陆
    if ($.cookie('mf_websiteli')) {
        $.ajax({
            url: 'http://u.appmofang.com/account/ucenter_syslogin',
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
            url: 'http://u.appmofang.com/account/ucenter_syslogout',
            dataType: 'jsonp',
            success: function(data) {
                if (data.data.sys) {
                    $("body").append($(data.data.sys));
                };
            }
        });
    }
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
    if (typeof module != "undefined" && module.exports) {
        module.exports.isLogin = isLogin;
    }
});
