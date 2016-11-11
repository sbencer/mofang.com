define("mfe/wheel",['jquery','swfobject','mfe'],function(require, exports, module){

    var swfobject = require('swfobject'),
        $ = require("jquery"),
        mfe = require("mfe");


    function Wheel (settings) {

        var options = {
            wrapperId:"",
            flashvars:null,
            params:null,
            attributes:null,
            onFlashBtnClick: function(){},
            onFlashWheelFinished: function(){},
            wheelUrl:"/statics/v4/modules/js/mfe/Wheel.swf"
        };

        options = $.extend(options,settings);

        //服务器返回数据
        this.data = null;


        // 生成flash的id
        var wheelId = "wheel_" + mfe.uid();

        var that = this;    

        var js_handler = mfe.globalCallback(function(obj) {
            
            // 找到页面上的flash对象
            var swf = document.getElementById(wheelId);
            
            that.playBtn = swf;

            if(obj.type == "init_code") {
                // 设置按钮可点击
                swf.btnEnable(true);

            } else if(obj.type == "click_code") {

                options.onFlashBtnClick && options.onFlashBtnClick (that,obj,swf);

            //结束通知
            }else if(obj.type == "finish_code") {
                //todo 更改返回值为
                options.onFlashWheelFinished && options.onFlashWheelFinished (that.data,obj);
                swf.btnEnable();
            }
        });     
        // flashvars 参数复制
        var flashvars = {
            swfID : "swfID" + Math.floor(Math.random() * 10000000),         //当前flash文件的id
            js_handler : js_handler,            //全局的句柄
            init_code : "init_code",            //flash初始化完成时回调
            click_code : "click_code",          //通知js取数据时，调用
            finish_code : "finish_code",        //转盘转动结束时，通知js调用
            skinURL : "/statics/v4/modules/js/mfe/skinA.swf",     //转盘的用到的皮肤文件
            rotate_wheel : true,                // 转盘指针
            prize_num : 10
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

        swfobject.embedSWF(options.wheelUrl, options.wrapperId, "624px", "624px", "10.0.0", null,flashvars,params,attributes);
    }
    
    //////////////////////////////////////////////////////////////
    if (typeof module!="undefined" && module.exports ) {
        module.exports = Wheel;
    }
});
