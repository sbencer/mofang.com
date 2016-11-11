define('jquery/jquery-slider-down', ['jquery'], function(require, exports, module) {
	var $ = jQuery = require("jquery");
	(function($){
		//地段划出弹窗
		$.fn.sliderDown = function(data){
			var defaults = {
				cancelClass : ".cancel-btn", //取消按钮 class
				fnCallback: function(isTrue,msg){//回调函数，确定，true,false,msg,提示信息

            	}
			};
            var options = $.extend(true, defaults, data);
            var _this = this;
            
            $("body").append('<div class="mask-bg" style="position: fixed;left:0px;top:0px;width:100%;height:100%;background: #000;opacity: 0.6;z-index:9998;filter:alpha(opacity=60);display: none;">');
            $(".mask-bg").eq(0).fadeIn(200);
            ;(function(){
                var isTouch = ('ontouchstart' in document.documentElement) ? 'touchstart' : 'click', _on = $.fn.on;
                $.fn.on = function(){
                arguments[0] = (arguments[0] === 'click') ? isTouch: arguments[0];
                return _on.apply(this, arguments);
                };
            })();

            $(".mask-bg").eq(0).fadeIn(200);
            $(_this).addClass("animation").fadeIn(200);
            
            //取消
            $(_this).off('click',options.cancelClass).on('click',options.cancelClass,function(){
                $(_this).fadeOut(200);
                $(".mask-bg").fadeOut(200);
                options.fnCallback(false,this);
            });
            //点击背景
            $("body").off('click','.mask-bg').on('click','.mask-bg',function(){
                $(_this).fadeOut(200);
                $(".mask-bg").fadeOut(200);
                options.fnCallback(false,this);
            });
		};

	})(jQuery);

		if(typeof module!="undefined" && module.exports){
	        module.exports = $;
	    }
});