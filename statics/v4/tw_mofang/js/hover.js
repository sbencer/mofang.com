define('index/hover', ["jquery"], function(require, exports, module) {

  	var $ = require("jquery");
  	$(".j_hover").on('hover', function(event) {
  		event.preventDefault();
  		$(this)
  			.addClass('hover')
  			.siblings()
  			.removeClass("hover");
  	});
})
seajs.use(["index/hover"])
