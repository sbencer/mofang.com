seajs.config({
    "alias": {
        "tpl": "/statics/v4/tw_acg/js/tpl.js",
        "mf/login": "/statics/v4/tw_acg/js/login.js",
        "login/check": "/statics/v4/tw_acg/js/login_check.js"
    }
});
define("acg/common", ["jquery"], function(require, exports, module) {
	var $ = jQuery = require("jquery");
	//人气排行切换
	tab();
	function tab(){
		$('.tab a').mouseenter(function(){
			var _idx = $(this).index();
			$(this).addClass('curr').siblings().removeClass('curr');
			$(this).parents('.title').siblings('.tab_con').children().eq(_idx).show().siblings().hide();
		})
	}
	//cos創作切換
	var _idx = 0;
	var timer;
	$('.coserBox .blue a').mouseenter(function(){
		_idx = $(this).index();
		show(_idx);
	});

	$('.coserBox').hover(function(){
		clearInterval(timer);
	},function(){
		timer = setInterval(function(){
			show(_idx);
			_idx++;
			if(_idx == 2)_idx = 0
		},5000)
	}).trigger('mouseleave');

	function show(_idx){
		$('.coserBox .blue a').eq(_idx).addClass('curr').siblings().removeClass('curr');
		$('.coserBox div').eq(_idx).show().siblings('.coser ').hide();
	}
})
seajs.use(["acg/common"])