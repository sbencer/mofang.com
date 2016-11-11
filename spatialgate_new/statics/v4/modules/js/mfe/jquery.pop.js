define('jquery/jquery-pop', ['jquery'], function(require, exports, module) {
	var $ = jQuery = require("jquery");
	

	/*
	*	title:'标题,左上角位置',//左上角标题
        msg:'提示信息,你暂时未登录，请登录后操作',//提示信息
        titleClass:'.pop-title',//标题class
        msgClass:'.pop-msg',//提示信息class
        closeClass:'.close',//关闭class
        cancelClass:'.pop-cancel',//取消class
        okClass:'.pop-ok',//确定class
        autoTime: 2000,//自动隐藏pop时间
        isAutoClose:false,//是否自动关闭
        fnCallback: function(isTrue,msg){//回调函数，确定，true,false,msg,提示信息

        }
	*
	*
	*/
(function($) {
	//组件化
	/*测试弹出层*/
    $.fn.pop=function(data){
        var defaults={
            title:'标题,左上角位置',//左上角标题
            msg:'提示信息,初始化...',//提示信息
            titleClass:'.pop-title',//标题class
            msgClass:'.pop-msg',//提示信息class
            closeClass:'.close',//关闭class
            cancelClass:'.pop-cancel',//取消class
            okClass:'.pop-ok',//确定class
            autoTime: 2000,//自动隐藏pop时间
            isAutoClose:false,//是否自动关闭
            isAutoWH:true,
            fnCallback: function(isTrue,msg){//回调函数，确定true,取消false,msg,提示信息

            }
        };
        var options = $.extend(true, defaults, data);

        var _this = this;
        var timer = null;
        var isHide = false;
        if($(".mask-bg").length==0){
            $("body .pop").eq(0).before('<div class="mask-bg" style="position: fixed;left:0px;top:0px;width:100%;height:100%;background: #000;opacity: 0.6;z-index:9988;filter:alpha(opacity=60);display: none;">');
        }

        $(_this).find(options.msgClass).val(options.msg);
        $(_this).find(options.titleClass).html(options.title);
        $(_this).find(options.msgClass).html(options.msg);

        $(".mask-bg").eq(0).fadeIn(200);
        
        $(_this).removeClass('hidePop').addClass('showPop');
        $(_this).show();
        //处理位置
        var html = $(_this).html();
        
        if($(_this).find(".out-html").length==0){
            $(_this).html("<div class='out-html' >"+html+"</div>");
        }
        if(!options.isAutoWH){
            var h = $(_this).outerHeight();
            var w = $(_this).outerWidth();
        }else{
            var h = $(_this).find(".out-html").outerHeight();
            var w = $(_this).find(".out-html").outerWidth();
        }
       
        
        w = w+5;//兼容少许容差
        $(_this).css({
            "margin-top":(-h/2)+"px",
            "margin-left":(-w/2)+"px"
        });

        //是否自动关闭
        if(options.isAutoClose){
            timer=setTimeout(function(){
                close(null,false,options.msg);
            },options.autoTime+600);//补贴动画耗时
        }

       /* ;(function(){
            var isTouch = ('ontouchstart' in document.documentElement) ? 'touchstart' : 'click', _on = $.fn.on;
            $.fn.on = function(){
            arguments[0] = (arguments[0] === 'click') ? isTouch: arguments[0];
            return _on.apply(this, arguments);
            };
        })();*/

        //右上角关闭
        $(_this).on('click',options.closeClass,function(){
            clearTimeout(timer);
            close(this,false,options.msg);
        });
        
        //取消
        $(_this).off('click',options.cancelClass).on('click',options.cancelClass,function(){
            clearTimeout(timer);
            close(this,false,options.msg);
        });
        //确定
        $(_this).off('click',options.okClass).on('click',options.okClass,function(){
            clearTimeout(timer);
            close(this,true,options.msg);
        });

        //点击背景
        $("body").off('click','.mask-bg').on('click','.mask-bg',function(){
            close(this,false,options.msg);
            clearTimeout(timer);
        });

        function close(isThis,TF,msg){
            if(isHide){
                return false;
            }
            $(_this).removeClass('showPop').addClass('hidePop');
            $(".mask-bg").fadeOut(400);
            setTimeout(function(){
                isHide = true;
                 $(_this).css("display",'none');
            },300);
            options.fnCallback.call(isThis,TF,msg);
        }        
    };
})(jQuery);

	if(typeof module!="undefined" && module.exports){
        module.exports = $;
    }

});