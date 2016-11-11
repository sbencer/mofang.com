define('ie/update_tip',['jquery'],function(require,exports,module){


	var $ = jQuery = require("jquery");
	// $.fn.tip = function(option){
	
	// }
	//把模板文件添加到页面中
	var appendPage = function(){
		var update_ele =$( creatTpl() );
		update_ele.appendTo('body');
		var top = $(window).scrollTop();
		$(".update-close-btn").on("click",function(){
			$(".update-tip").hide(500);
		});
		
		//页面加载时保证在页面的最底部
		$(".update-tip").css({"bottom":-top});
		$(".update-tip").show();			
	};
	//创建模板
	var creatTpl = function(){
		 
		var tpl = '<div class="update-tip">\
				    <div class="update-tip-wrap w-1000 clearfix"><span class="update-tip-wd fl">亲，您的浏览器版本过低导致图片打开速度过慢，提升打开速度您可以：</span><span class="update-close-btn fr"></span>\
				        <div class="load-brower clearfix">\
				        	<a href="http://rj.baidu.com/soft/detail/23253.html?ald" target="_blank" class="ie-update fl">升级IE浏览器</a>\
				        	<a href="http://www.google.cn/intl/zh-CN/chrome/" target="_blank" class="chrome-update fr">Chrome浏览器</a>\
				        	<span class="ie-load-wd">或者下载</span>\
				        </div>\
				    </div>\
				</div>';
		return tpl;
	}
	//随滚动条一起滚动
	
	var followScroll = function(){
		$(window).scroll(function(){
			var top = $(window).scrollTop();
			$(".update-tip").css({
				"bottom":-top
			});
		});
	}
	var init_ = function(){
		appendPage();
		followScroll();
	};
	init_();
	/////////////////// export module ////////////////////////
	if (typeof module!="undefined" && module.exports ) {
	    //module.exports = ;
	}
});
seajs.use(['update_tip']);






