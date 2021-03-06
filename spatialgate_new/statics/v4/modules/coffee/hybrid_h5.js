'use strict';
define('hybridH5', ['jquery', 'atom', 'jquery/jquery-reluserurl'], function(require, exports, module) {
  var $, HybridH5, atom;
  $ = require("jquery");
  atom = require("atom");
  require("jquery/jquery-reluserurl");
  HybridH5 = (function() {
    function HybridH5(isLogin) {
      this.isLogin = isLogin != null ? isLogin : false;
      this.isLogin = window.loginStatus || false;
      this.atomObj = atom.fromUrl();
      this.atomStr = atom.getAtomStr();
      this.methods = 'closeWeb|startGame|copyToClip|setShareInfo|showToast|getAtom|login|shareWeb|refreshUserInfo|clickImage|clickVideo|downloadGame|linkClick|relationArticle';
      /*执行配置*/

      this.config();
      /*wap端登录状态配置*/

      this.urlLoginConfig();
      /*app登录状态配置*/

      this.urlAppLoginConfig();
      /*检查APP接口配置*/

      this.updateAppInterfaceConfig();
      /*处理@methods方法*/

      this.reMethods();
    }

    /*调试配置*/


    HybridH5.prototype.config = function(data) {
      var defaults, options;
      defaults = {
        /*是否打印log信息*/

        showLogger: 0,
        /*模拟app的api*/

        simulateApp: 0,
        /*接口操作提示在命令行*/

        simulateApiInConsole: 0,
        /*使用测试数据*/

        userTestData: 0,
        /*使用本地测试数据*/

        userLocalTestData: 0,
        /*停止提示版本更新*/

        disableCheckUpdate: 0
      };
      options = $.extend(true, defaults, data);
      this.showLogger = options.showLogger;
      this.simulateApp = options.simulateApp;
      this.simulateApiInConsole = options.simulateApiInConsole;
      this.userTestData = options.userTestData;
      this.userLocalTestData = options.userLocalTestData;
      this.disableCheckUpdate = options.disableCheckUpdate;
      /*是否在测试环境*/

      return this.apiReplace();
    };

    /*wap端登录接口配置*/


    HybridH5.prototype.urlLoginConfig = function(onlineUrlCheckLoginStatus, testUrlCheckLoginStatus, localUrlCheckLoginStatus) {
      this.urlCheckLoginStatus = onlineUrlCheckLoginStatus || 'http://u.mofang.com/account/status';
      if (this.userTestData) {
        this.urlCheckLoginStatus = testUrlCheckLoginStatus || 'http://u.mofang.com/account/status';
      }
      if (this.userLocalTestData) {
        return this.urlCheckLoginStatus = localUrlCheckLoginStatus || '';
      }
    };

    /*app登录接口配置*/


    HybridH5.prototype.urlAppLoginConfig = function(onlineUrlCheckLoginStatus, testUrlCheckLoginStatus, localUrlCheckLoginStatus) {
      this.urlAppCheckLoginStatus = onlineUrlCheckLoginStatus || 'http://u.mofang.com/user/login_check';
      if (this.userTestData) {
        this.urlAppCheckLoginStatus = testUrlCheckLoginStatus || 'http://u.test.mofang.com/user/login_check';
      }
      if (this.userLocalTestData) {
        return this.urlAppCheckLoginStatus = localUrlCheckLoginStatus || '';
      }
    };

    /*检查APP接口配置*/


    HybridH5.prototype.updateAppInterfaceConfig = function(onlineUrlUpdateApp, testUrlUpdateApp, localUrlUpdateApp) {
      this.UrlUpdateApp = onlineUrlUpdateApp || 'http://u.mofang.com/user/download.php?get_version=1';
      if (this.userTestData) {
        this.UrlUpdateApp = testUrlUpdateApp || 'http://u.test.mofang.com/user/download.php?get_version=1';
      }
      if (this.userLocalTestData) {
        return this.UrlUpdateApp = localUrlUpdateApp || '';
      }
    };

    /*处理带有app提供以及注册的方法*/


    HybridH5.prototype.reMethods = function() {
      /*处理IOS方法兼容问题*/

      this.IOSCompatible();
      /*测试替换app方法*/

      this.apiReplace();
      /*添加app方法*/

      return this.setAllMethod();
    };

    /*是否在app里面*/


    HybridH5.prototype.isApp = function(isAppReg) {
      var reg, ua;
      isAppReg = isAppReg || 'mfyxb|jiajia';
      ua = navigator.userAgent.toLowerCase();
      reg = new RegExp(isAppReg);
      if (reg.test(ua)) {
        return true;
      } else {
        return false;
      }
    };

    /*处理IOS内嵌对象兼容跳转接口*/


    HybridH5.prototype.IOSCompatible = function() {
      var iosApi, o;
      if (!this.isApp()) {
        this.log("not in APP");
        return false;
      }
      this.log("init mfyxb api");
      /*isIosApp = true;
      @methods.replace /\w+/g,(s)->
          if !window.mofang
               isIosApp=false
          if window.mofang && !window.mofang[s]
              isIosApp=false
      */

      if (window.mofang && window.mofang.login) {
        return false;
      }
      o = window.mofang = {};
      iosApi = function(name) {
        var arg, argStr, args, funCall, i, _i, _len;
        args = [];
        for (i = _i = 0, _len = arguments.length; _i < _len; i = ++_i) {
          arg = arguments[i];
          if (i > 0) {
            args.push(arg);
          }
        }
        argStr = args.join(",");
        funCall = "jiajiajs." + name + "(" + argStr + ");";
        window.location.href = funCall;
        return this.log(funCall);
      };
      return this.methods.replace(/\w+/g, function(s) {
        return o[s] = function() {
          var arg, args, _i, _len;
          args = [s];
          for (_i = 0, _len = arguments.length; _i < _len; _i++) {
            arg = arguments[_i];
            args.push(arg);
          }
          return iosApi.apply(o, args);
        };
      });
    };

    /*模拟app提示信息*/


    HybridH5.prototype.apiTip = function() {
      if (this.simulateApiInConsole) {
        return window.console.log.apply(window.console, arguments);
      } else {
        return window.alert.apply(window, arguments);
      }
    };

    /*alert弹出框*/


    HybridH5.prototype.alert = function(msg) {
      if (!this.isApp()) {
        return window.alert(msg);
      } else {
        return window.mofang.showToast(msg);
      }
    };

    /*logger*/


    HybridH5.prototype.log = function(msg) {
      var bd, loger, n;
      bd = $("body");
      if (this.showLogger) {
        n = $(".LOG").length;
        loger = $("<div class='LOG'>[" + n + "]:" + msg + "<br/></div>");
        return bd.prepend(loger);
      }
    };

    /*生成uid*/


    HybridH5.prototype.uuid = function() {
      return "u" + Math.floor(Math.random() * 100000000000000000000);
    };

    /*argument去掉最后一个参数转数组*/


    HybridH5.prototype.removeLastToArr = function() {
      var agt, arr, i, _i, _len;
      arr = [];
      for (i = _i = 0, _len = arguments.length; _i < _len; i = ++_i) {
        agt = arguments[i];
        if (i < arguments.length - 1) {
          arr.push(agt);
        }
      }
      return arr;
    };

    /*ajax*/


    HybridH5.prototype.ajax = function(setting) {
      var ajaxMethod, defaults, options;
      this.ajaxMethod = 'jsonp';
      if (this.userLocalTestData) {
        ajaxMethod = 'json';
      }
      defaults = {
        url: null,
        timeout: 8000,
        dataType: this.ajaxMethod,
        data: {
          atom: this.atomStr
        },
        success: function() {},
        error: function() {
          return this.alert("网络异常");
        }
      };
      options = $.extend(true, defaults, setting);
      return $.ajax(options);
    };

    /*测试替换app方法*/


    HybridH5.prototype.apiReplace = function() {
      var _this;
      _this = this;
      if (this.simulateApp) {
        this.atomStr = "dWlkPTE0NjE1MzQmc2lkPTJkOTNiYTc1ZTNkZmQ4YzImY2M9MTAwMDAmcGY9YW5kcm9pZCZjbj1X%250ASUZJJmN2PU1HQV8xLjEuNS4wMF9BX0NOJmR0PUxFTk9WT0xlbm92byBTOTYwJmltZWk9ODYyMzIx%250AMDI0MTIzMTczJmltc2k9JnBuPQ%253D%253D%250A";
      }
      if (this.simulateApp) {
        window.mofang = {};
        return this.methods.replace(/\w+/g, function(s) {
          return window.mofang[s] = function() {
            var agt, i, str, _i, _len;
            str = '';
            for (i = _i = 0, _len = arguments.length; _i < _len; i = ++_i) {
              agt = arguments[i];
              str += '\n(' + i + ')' + agt;
            }
            return _this.apiTip("APP api:" + s + ":" + str);
          };
        });
      }
    };

    /*获取登录状态*/


    HybridH5.prototype.isLogin = function() {
      return this.isLogin;
    };

    /*是否登录*/


    HybridH5.prototype.goLogin = function(toUserUrl, next) {
      var isgoLogin, _this;
      _this = this;
      if (this.isApp()) {
        return this.APPCheckLogin(function(err, logined) {
          _this.log("login callback called");
          if (err) {
            _this.alert("连接服务器失败！");
            next(false);
          }
          if (logined) {
            _this.isLogin = true;
            return next(true);
          } else {
            _this.isLogin = false;
            return next(false);
          }
        });
      } else {
        isgoLogin = function(loginStatus) {
          console.log(loginStatus);
          if (loginStatus) {
            return next(true);
          } else {
            console.log(111);
            return window.location.href = $(document).loginUserUrl(window.location.href, toUserUrl);
          }
        };
        return this.checkLoginStatus(isgoLogin);
      }
    };

    /*APP内嵌登录检查*/


    HybridH5.prototype.APPCheckLogin = function(next) {
      var callbackName, _this;
      _this = this;
      if (this.isLogin) {
        next(null, true);
        return true;
      }
      _this.log("before APP login");
      callbackName = "logincallback" + (this.uuid());
      window[callbackName] = function(atom) {
        _this.log("after APP login");
        if (atom) {
          _this.atomStr = atom;
          _this.log("APP api callback atom:" + atom);
          return next(null, true);
        } else {
          return next(null, false);
        }
      };
      window.mofang.login(callbackName);
      return true;
    };

    HybridH5.prototype.checkLoginStatus = function(next) {
      var data, url, _this;
      _this = this;
      if (this.isLogin) {
        next(true);
        return true;
      }
      _this.log('atom to check login:' + this.atomStr);
      _this.log('AA:check login url' + this.urlCheckLoginStatus);
      if (this.isApp()) {
        data = {
          uid: this.atomObj.uid,
          atom: this.atomStr,
          sid: this.atomObj.sid
        };
        url = this.urlAppCheckLoginStatus;
      } else {
        data = {};
        url = this.urlCheckLoginStatus;
      }
      return this.ajax({
        url: url,
        data: data,
        success: function(res) {
          _this.log('check login response:' + JSON.stringify(res));
          if (res && !res.code) {
            _this.log('check login success!!!');
            _this.isLogin = true;
          }
          if (_this.isApp() && res.data.status !== 0) {
            _this.isLogin = false;
          }
          return next(_this.isLogin);
        },
        error: function() {
          var isLogin;
          isLogin = false;
          _this.log(JSON.stringify(arguments));
          _this.log('check login error');
          return next(false);
        }
      });
    };

    HybridH5.prototype.checkAppUpdate = function(next) {
      var _this;
      _this = this;
      if (this.disableCheckUpdate) {
        return false;
      }
      return this.ajax({
        url: this.UrlUpdateApp,
        success: function(res) {
          var currentVersion, latestAPPVersion, o;
          _this.log('check APP update:' + JSON.stringify(res));
          o = this.atom.fromUrl();
          if (!o || o.cv) {
            next(false);
            return false;
          }
          currentVersion = o.cv;
          if (res.code) {
            next(false);
            return false;
          }
          if (!res.data || !res.data.version) {
            next(false);
            return false;
          }
          latestAPPVersion = res.data.version;
          next(true, currentVersion, latestAPPVersion);
          return true;
        },
        error: function() {
          _this.log("API ERROR:check update");
          return next(false);
        }
      });
    };

    /*注册方法*/


    HybridH5.prototype.setMethod = function() {
      var agt, arr, isexist, str, _i, _len, _this;
      _this = this;
      arr = [];
      str = '';
      for (_i = 0, _len = arguments.length; _i < _len; _i++) {
        agt = arguments[_i];
        isexist = false;
        this.methods.replace(/\w+/g, function(s) {
          if (agt === s) {
            isexist = true;
            return _this.alert("sorry," + s + "方法已经存在,注册失败");
          }
        });
        if (isexist) {
          continue;
        }
        arr.push(agt);
        str += '|' + agt;
      }
      this.methods += str;
      return this.reMethods();
    };

    /*遍历所有的方法*/


    HybridH5.prototype.setAllMethod = function() {
      var _this;
      _this = this;
      return this.methods.replace(/\w+/g, function(s) {
        return HybridH5.prototype[s] = function() {
          var arr;
          arr = this.removeLastToArr.apply(this, arguments);
          if (this.isApp()) {
            _this.log('atom to check login:' + window.mofang[s]);
            /*apply方法APP没有，投机的方法*/

            switch (arr.length) {
              case 0:
                return window.mofang[s]();
              case 1:
                return window.mofang[s](arr[0]);
              case 2:
                return window.mofang[s](arr[0], arr[1]);
              case 3:
                return window.mofang[s](arr[0], arr[1], arr[2]);
              case 4:
                return window.mofang[s](arr[0], arr[1], arr[2], arr[3]);
              case 5:
                return window.mofang[s](arr[0], arr[1], arr[2], arr[3], arr[4]);
              case 6:
                return window.mofang[s](arr[0], arr[1], arr[2], arr[3], arr[4], arr[5]);
              default:
                return _this.log('APP 提供的方法没有apply方法，6个参数以上不匹配');
            }
          } else {
            return arguments[arguments.length - 1].apply(window, arr);
          }
        };
      });
    };

    return HybridH5;

  })();
  if (typeof module !== "undefined" && module.exports) {
    return module.exports = {
      HybridH5: HybridH5
    };
  }
});
