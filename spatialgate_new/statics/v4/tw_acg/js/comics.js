define('comics',['jquery','jquery/Swiper3'],function(require,exports,module){
	var $ =  require('jquery');
	var swiper = require('jquery/Swiper3');

	//轮播图
	var swiper = new swiper('.swiper-container', {
        pagination: '.pagination',
        paginationClickable: true,
        centeredSlides: true,
        autoplay: 3000,
        autoplayDisableOnInteraction: false
    });
    
})
seajs.use('comics');