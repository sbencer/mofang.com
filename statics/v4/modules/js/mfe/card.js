define('card',['jquery','mfe','swfobject'],function (require,exports,module) {
    var swfobject = require('swfobject'),
        $ = require("jquery"),
        mfe = require("mfe");

    function card (settings) {

        var options = {
            wrapperId:"",
            flashvars:null,
            params:null,
            attributes:null,
            onFlashBtnClick: function(){},
            onFlashWheelFinished: function(){},
            wheelUrl:"/statics/v4/modules/js/mfe/card.swf"
        };

        options = $.extend(options,settings);

        //服务器返回数据
        this.data = null;

        // 生成flash的id
        var wheelId = "wheel_" + mfe.uid();

        var that = this;

        var js_handler = mfe.globalCallback(function(obj) {

            //找到页面上的flash对象
            // var swf = document.getElementById(wheelId);
            // that.playBtn = swf;

            // if(obj.type == "init_code") {
            //  // 设置按钮可点击
            //  swf.btnEnable(true);
            // } else if(obj.type == "click_code") {

            //  options.onFlashBtnClick && options.onFlashBtnClick (that,obj);
            // }else if(obj.type == "finish_code") {
            //  options.onFlashWheelFinished && options.onFlashWheelFinished (that,obj);
            //  swf.btnEnable();
            // }

        });

        // flashvars 参数复制
        var flashvars = {
            swfID : "swfID" + Math.floor(Math.random() * 10000000),         //当前flash文件的id
            js_handler : js_handler,            //全局的句柄
            init_code : "init_code",            //flash初始化完成时回调
            start_lottery : "sss",              //通知js取数据时，调用
            lottery_result : "ss",              //转盘转动结束时，通知js调用
            urlComm : "/statics/v4/modules/js/mfe/skinA.swf",       //转盘的用到的皮肤文件urlComm
            rotate_wheel : false,               // 转盘指针
            numPrize : 4
        };

        flashvars = $.extend(flashvars,options.flashvars);

        var params = {
            menu: "false",
            scale: "noScale",
            allowFullscreen: "true",
            allowScriptAccess: "always",
            bgcolor: "",
            wmode: "transparent" // can cause issues with FP settings & webcam
        };
        params = $.extend(params,options.params);

        var attributes = {
            id:wheelId
        };

        attributes = $.extend(attributes,options.attributes);
        swfobject.embedSWF(options.wheelUrl, options.wrapperId, "620px", "620px", "10.0.0", null,flashvars,params,attributes);
    }

    ///////////////// end ////////////////////
    if (typeof module!="undefined" && module.exports ) {
        module.exports = card;
    }

});
