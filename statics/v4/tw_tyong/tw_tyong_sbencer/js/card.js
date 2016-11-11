define('card', ["jquery"], function(require, exports, module) {
	var jquery = $ =require("jquery");
	$(function(){
		$('.nav-com-list li').mouseenter(function(){
			var index = $(this).index();
			$(this).addClass('curr').siblings('li').removeClass('curr');
			$('.card_filter').children('.filter_form').eq(index).show().siblings('.filter_form').hide();
		})
	})
})
seajs.use(["card"])