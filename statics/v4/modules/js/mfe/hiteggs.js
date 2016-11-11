define(function(require,exports,module){


    var swfobject = require('swfobject'),
        $ = require("jquery"),
        mfe = require("mfe");

    var Hiteggs = function(settings) {

        var options = {
            wrapperId:"",
            flashvars:null,
            params:null,
            attributes:null,
            start_lottery: function(){},
            eggsUrl:""
        };
        
        options = $.extend(options,settings);
        //服务器返回数据
        //this.data = null;

        // 生成flash的id
        var eggsId = "eggs_" + mfe.uid();

        var that = this;    

        //debugger;
        // return;
       
        // var swf = document.getElementById(eggsId);
        // options.start_lottery && options.start_lottery(swf);


        var flashvars = { 
            swfID : "swfID" + Math.floor(Math.random() * 10000000), 
            //  js_handler: js_handler,//全局的句柄
            start_lottery:"",
            // hit_egg: "hit_egg",     //砸蛋
            // break_egg: "break_egg", //离开蛋
            // reset_egg: "reset_egg" , //重置蛋
            skinURL : "../modules/statics/js/mfe/"     
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
            id:eggsId,
            name:"lottery"
        };
        attributes = $.extend(attributes,options.attributes);
        swfobject.embedSWF(options.eggsUrl, options.wrapperId, "880px", "480px", "9.0.0", null,flashvars,params,attributes); 
    }

    if (typeof module!="undefined" && module.exports ) {
        //debugger
        module.exports = Hiteggs;
    }
});


