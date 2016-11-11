define("moveTop",['jquery'],function(require, exports, module){
    
    var $ = require("jquery");
    var jQuery = $;


    /**
     * @example
     *$(document).onclick(function(){
	 *	$(this).moveTop(0);
     *});
     */
    /* 回到顶部特效 */
	;(function($){
		$.fn.moveTop=function(iTarget,callBackFn){
			iTarget = iTarget || 0;
	   		var obj = this;
	   		clearInterval(obj.timer);
	        var curScrollTop= $(document).scrollTop();
	        obj.timer=setInterval(function(){
	            var speed = (iTarget-curScrollTop)/6;
	            speed=speed>0?Math.ceil(speed):Math.floor(speed);
	            curScrollTop+=speed;
	            $(document).scrollTop(curScrollTop);
	            if(curScrollTop==iTarget){
	                clearInterval(obj.timer);
	                lock=false;
	                callBackFn && callBackFn();
	            }
	        },30);
	    }
	})(jQuery);

    if (typeof module !== 'undefined' && module.exports) {
        module.exports = $;
    }
});
