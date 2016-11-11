define('fliter', ["jquery"], function(require, exports, module) {
	var jquery = $ =require("jquery");
	$(function(){
		$('.filter_form .item ul.fl li').click(function(){
			var index = $(this).index(),
				html = $(this).children('a').html(),
				val = $(this).parents('.item').children('input[type=hidden]').val();
			if($(this).hasClass('curr')){
				$(this).removeClass('curr');
				$(this).parents('.item').children('input[type=hidden]').val(val.replace(html+',',''));
			}else{
				$(this).addClass('curr');
				$(this).parents('.item').children('input[type=hidden]').val(val+html+',');
			}
			//console.log(val);
		})
		
		$('.filter_form .item  div.fl .input_text').blur(function(){
			var val = $(this).val(),
				index = $(this).index();
			if(isNaN(val)){
				alert("请输入数值");
			}else{
				/*var val1 = $('.filter_form .item  div.fl .input_text').eq(0).val(), 
					val2 = $('.filter_form .item  div.fl .input_text').eq(1).val(); 
				$(this).parent('div').siblings('input[type="hidden"]').val(val1+"  "+val2);*/
			}
		})
		//reset
		$('.reset_btn').click(function(){
			$('.filter_form').find('input[type=text],input[type=hidden]').val('');
			$('.filter_form .item ul li').removeClass('curr');
		})
	})
	
})
seajs.use(["fliter"])