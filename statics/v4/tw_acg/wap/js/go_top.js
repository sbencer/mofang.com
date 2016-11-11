//返回顶部
define('wap_tw/goUp', ['zepto'], function(require, exports, module) {
	var $ = Zepto = require("zepto");
	function scrllTop(option){

		if( $(".go-up").length == 0 ){
			return false;
		}
		$(".go-up").click(function(){
			 var scrolTop = document.body.scrollTop;
			 var _this = $(this);
			 var timer = setInterval(function(){
			 	scrolTop -= 20;
			 	if(scrolTop>0){
			 		window.scrollTo(0,scrolTop);
			 	}else{
			 		_this.hide();
			 		clearInterval(timer);
			 	}
			 },0.8)
		});
		window.onscroll = function(){
			var t = document.documentElement.scrollTop || document.body.scrollTop; 
			//var top_div = $(".go-up");
			if(t >= 300 ){
				$(".go-up").show();
			}else{
				$(".go-up").hide();
			}
		}
	}
	scrllTop();
})
seajs.use(['wap_tw/goUp'])