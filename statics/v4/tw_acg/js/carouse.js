define("index/carouse", ["jquery",'jquery/bxslider'], function(require, exports, module) {

	var $ = require("jquery");
	var bxslide = require("jquery/bxslider");
	$(".j_silder").bxSlider({
		auto: true,
		speed:1000,
		useCSS:false,
  		autoControls: true,
  		onSlideBefore:function(ele,index){
  			$(".j_detail")
  				.children()
  				.fadeOut(100,function(){
  					$(this).remove();

  					next = ele.index()-1;

		  			var activeEle = $(".j_pic_list")
		  				.find(".j_pic_li")
		  				.eq(next)
		  				.clone(true);

		  			activeEle
		  				.appendTo( $(".j_detail") )
		  				.fadeIn(300);
  				})
  		}
	})
})
seajs.use(["index/carouse"])