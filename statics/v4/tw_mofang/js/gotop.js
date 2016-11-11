define('index/top', ["jquery"], function(require, exports, module) {

  	var $ = require("jquery");
  	$(".j_top").on("click",function(){
  		$('body,html').animate({scrollTop:0},1000);  
        return false;  
  	})
})
seajs.use(["index/top"])