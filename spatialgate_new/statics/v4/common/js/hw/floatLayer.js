define('hw/floatLayer', ["jquery"], function(require, exports, module) {
	var jquery = $ =require("jquery");
	$(function(){
		floatLayer(".mfBox");
		floatLayer(".coming_soon");
		function floatLayer(fn){
			var w =$('.floatLayer').width();
			var h =$('.floatLayer').height();
			$('.floatLayer').css({marginLeft:(-w/2)+'px',marginTop:(-h/2)+'px'});  
			
			$(fn).on('click',function(){
				$('.mask,.floatLayer').fadeIn(300);
			})
			$('.mfBox_close,.mf_sure_btn').click(function(){
				$('.mask,.floatLayer').hide();
			})
		}
	})
})
seajs.use(["hw/floatLayer"])