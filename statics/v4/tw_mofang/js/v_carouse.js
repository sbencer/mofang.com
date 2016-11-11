define("video/v-carouse", ["jquery",'jquery/bxslider'], function(require, exports, module) {

	var $ = require("jquery");
	var bxslide = require("jquery/bxslider");
    var eleNum=null;
	$(".j_v_car").bxSlider({
		auto: true,
		speed:1000,
        mode:"fade",
        captions: true,
		useCSS:false,
  		autoControls: true,
        onSlideBefore: function(ele,index,activeIndex) {
            slideEle = $(".j_v_car").children();
           eleNum = slideEle.length;
            var activeEle = slideEle.eq(activeIndex);
            var bgColor = activeEle.attr("date-color");
            slideEle.eq(activeIndex).css({
                "background-color":bgColor
            });
            return false;
        },
        onSlideAfter: function(ele,index,activeIndex) {
            /*console.log(ele);
            console.log(index);*/
        },
        onSlideNext: function(ele,index,activeIndex) {
            /*console.log(ele);
            console.log(index);*/
        },
        onSlidePrev: function(ele,index,activeIndex) {
            /*console.log(ele)
            console.log(index)*/
        }
	})
})
seajs.use(["video/v-carouse"])
