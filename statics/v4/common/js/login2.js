/**
 *
 */

define('com/user', ['jquery','mfe','widget'], function(require, exports, module) {

    var $ = require("jquery");
    var M = require('mfe');
    var Base = M.Base;

    var Login = Base.extend({
        attrs: {},
        initialize: function(config) {
            Login.superclass.initialize.apply(this, arguments);
        },
        check: function() {
            if ($.cookie('mf_activity')) {
                if (!/account\/index/.test(window.location.href)) {
                    $.cookie('mf_activity', null);
                    window.location.href = defaultURL + '/account/index';
                };
            }
        },
        setup: function() {
            // 页面打开时,异步更新登陆状态
            $.ajax({
                url: defaultURL + "/account/check_login?more=1",
                dataType: 'jsonp',
                success: function(data) {
                    if (0 == data.code && data.data.nickname) {
                        // 已登陆
                        triggerCallbacks(true);
                    } else {
                        // 未登陆
                        triggerCallbacks(false);
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
    });
    var User = Base.extend({
        attrs: {},
        initialize: function(config) {
            Login.superclass.initialize.apply(this, arguments);
            this.login = new Login();
        },
        check: function() {
            if ($.cookie('mf_activity')) {
                if (!/account\/index/.test(window.location.href)) {
                    $.cookie('mf_activity', null);
                    window.location.href = defaultURL + '/account/index';
                };
            }
        },
        /* 初始化 */
        setup: function() {
            // 页面打开时,异步更新登陆状态
            $.ajax({
                url: defaultURL + "/account/check_login?more=1",
                dataType: 'jsonp',
                success: function(data) {
                    if (0 == data.code && data.data.nickname) {
                        // 已登陆
                        triggerCallbacks(true);
                    } else {
                        // 未登陆
                        triggerCallbacks(false);
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
    });

    var Page = Base.extend({
        initialize:function(){
            Page.superclass.initialize.apply(this, arguments);
            this.user = new User();
        }
    });
    var user = new User();

    user.isLogin(function(err,data){
        user.getInfo(function(err,data){
        });
    });

    if (typeof module != "undefined" && module.exports) {
        module.exports = {
            Login:Login,
            User:User
        };
    }

});
