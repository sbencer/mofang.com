define('floatLayer', ["jquery"], function(require, exports, module) {
	var jquery = $ =require("jquery");
	$(function(){
		floatLayer(".mofBox");
		function floatLayer(fn){
			var w =$('.floatLayer').width();
			var h =$('.floatLayer').height();
			$('.floatLayer').css({marginLeft:(-w/2)+'px',marginTop:(-h/2)+'px'});  
			
			$(fn).on('click',function(){
				$('.mask,.floatLayer').show();
			})
			$('.mofBox_close').click(function(){
				$('.mask,.floatLayer').hide();
				//$('.floatLayer').find('param[name="movie"]').val('');
				$('.floatLayer').find('iframe').attr('src','');
			})
		}
		/*$('.mofBox').on('click',function(){
			var src = $(this).attr('data-src');
			$('.floatLayer').find('param[name="movie"]').val(src);
			$('.floatLayer').find('embed').attr('src',src);
		})*/
		$('.mofBox').on('click',function(){
			var src = $(this).attr('data-src');
			$('.floatLayer').find('iframe').attr('src',src);
		})
	})
})
seajs.use(["floatLayer"])