define('pic/slider', ["jquery",'jquery/flexslider'], function(require, exports, module) {
  	var $ = require("jquery");
  	var flexslider = require('jquery/flexslider');
    
    $('.j_big').flexslider({
      animation: "slide",
      controlNav: false,
      animationLoop: false,
      itemWidth: 640,
      slideshow: false,
      sync: ".j_smll"
    });
    $('.j_smll').flexslider({
        animation: "slide",
        controlNav: false,
        itemWidth:100 ,
        animationLoop: false,
        asNavFor: '.j_big'
    });
})
seajs.use(["pic/slider"])
