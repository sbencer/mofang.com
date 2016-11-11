define('common', ['jquery'], function(require, exports, module) {
    var $ = jQuery = require("jquery");
	$(function(){
		//左侧菜单
		var clicknum = 0;
		$('.icon-menu').on('click',function(){
			var h = $('.classify').height();
			$('html,body,.classify').css('min-height',h+'px');
			if(clicknum){
				$('.classify').removeClass('sidebar');
				$('.wrapper').css('left',0);
				$('body').css('overflow-x','initial');
				clicknum = 0;
			}else{
				$('.classify').addClass('sidebar');
				$('.wrapper').css('left',conversion(792));
				$('body').css('overflow-x','hidden');
				clicknum = 1;
			}
			return false;
		})
		//右侧搜索
		$('.icon-search').on('click',function(){
			var h = $('.classify').height();
			$('html,body,.right_search').css('min-height',h+'px');
			if(clicknum){
				$('.right_search').removeClass('sidebar');
				$('.wrapper').css({'left':0});
				$('body').css('overflow-x','initial');
				clicknum = 0;
			}else{
				$('.right_search').addClass('sidebar');
				$('.wrapper').css('left',conversion(-792));
				$('body').css('overflow-x','hidden');
				clicknum = 1;
			}
			return false;
		})
		function conversion(e) { 
			return e / 40.5 + "rem"
		}
		
		//活动弹窗
		$('.remind').on('click',function(){
			var _id = $(this).attr('data-id');
			$('.mask').show();
			console.log('#'+_id);
			$('#'+_id).show();
		})
		$('.close_btn').on('click',function(){
			$('.activity_alert,.mask').hide();
		})
	})
})
seajs.use(['common']);