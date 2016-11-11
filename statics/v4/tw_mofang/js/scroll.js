define("article/scroll", ["jquery",'jquery/bxslider'], function(require, exports, module) {

    var $ = require("jquery");
    
    var scroll = function(option){
        var config = {
            target:"",
            fn:function(){}
        };
        if(option) var setting = $.extend(config,option);
        this.setting = setting;
        this.init();
    };

    scroll.prototype = {
        istoTarget:function(){
            var target = this.setting.target;
            var top = $(document).scrollTop()+$(window).height();
            if(typeof target=="Number"&&top==target){
                return true;
            }else{
                var eleTop = $(target).offset().top;
                if(eleTop<=top)
                return true;
            }
        },
        bindEvent:function(){
        },
        init:function(){
            var this_ = this;
            $(window).on("scroll",function(){
                if(this_.istoTarget())
                this_.setting.fn();
            })
        }   
    }
    if (typeof module != "undefined" && module.exports) {
        module.exports = scroll;
    }
})
define("a/s", ["jquery","article/dialog","article/scroll"], function(require, exports, module) {
    var $ = require("jquery");
    var getRequest = function() {
       var url = location.search; //获取url中"?"符后的字串
       var theRequest = new Object();
       if (url.indexOf("?") != -1) {
          var str = url.substr(1);
          strs = str.split("&");
          for(var i = 0; i < strs.length; i ++) {
             theRequest[strs[i].split("=")[0]]=unescape(strs[i].split("=")[1]);
          }
       }
       return theRequest;
    }
    //var catid = getRequest()["catid"];

    var dialog = require("article/dialog");
    var scroll = require("article/scroll");
    var isTest = false;
    var sendUrl = "http://www.mofang.com.tw/index.php?m=content&c=index&a=tw_dialog&catid="+catid;
    var showFlag = false;
    var str = "";
    var timer = null;
    if(isTest){
        sendUrl = "http://www.dev.mofang.com.tw/index.php?m=content&c=index&a=tw_dialog&catid="+catid;
    };
    //ajax 请求字符串
    var ajxFn = function(){
        $.ajax({
            url:sendUrl,
            dataType:"json",
            success:function(data){
               str =  data.data;
            }
        })
    }
    ajxFn();
    //显示弹层
    var show = function(){
        if(str!=""){
            if(!$(".j_dialog").length&&!showFlag){
                showFlag=true;
                clearTimeout(timer);
                new dialog({
                    dialogTpl:str,
                    closeBtn:".j_close"
                })
            }
        }else{
            setTimeout(function(){
                show();        
            },5)
        }
    };
    //判断是文章页还是视频页
    var iswhPage = function(){
        if(parentId.toString().indexOf("58")>0){
            return 300000; 
        }else{
            return 120000;
        }
    }
    // 自动显示弹出层定义
    var autoShow = function(){
        if(!showFlag&&str!=""){    
            timer = setTimeout(function(){
                showFlag=true;
                new dialog({
                    dialogTpl:str,
                    closeBtn:".j_close"
                })
            },iswhPage())
        }else{
            setTimeout(function(){autoShow()},5);
        }
    };
    // 当用户不对电脑操作时 自动弹层 
    $(window).on("scroll",function(){
        clearTimeout(timer)
        autoShow();
    });
    autoShow();
    //当滑到底部显示弹出层
    /*var s = new scroll({
        target:".hw-footer",
        fn:show
    })*/
})
seajs.use(["a/s"])


