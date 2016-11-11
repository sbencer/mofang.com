define('index/bg', ["jquery",'jquery/tabs'], function(require, exports, module) {

  	var $ = require("jquery");
  	$(function(){
  		var loadImg = function(bgEle){
  			var imgLoad = bgEle.attr("data-uri");
  			bgEle.css({
  				"backgroundImage":"url("+imgLoad+")",
  				"backgroundRepeat":"no-repeat",
  				"backgroundPosition":"center top"
  			})
  		};
  		var closeBg = function(closeBg,bgEle){
  			closeBg.on("click",function(event){
  				event.preventDefault();//阻止默認動作及該鏈接不會跳轉
  				event.stopPropagation();//阻止冒泡時間
  				$(this)
  					.parents("div.j_bg_par")
  					.animate({"padding":0}, 500);
  				bgEle.fadeOut('500', function() {
  					bgEle.remove();
  				});
  			})
  		}
  		//window.onload = function(){
  			var bgEle = $(".tyong-bg");
  			var closeEle = $(".j_close_btn");
  			loadImg(bgEle);
  			closeBg(closeEle,bgEle);
  		//}
  	})
})
seajs.use(["index/bg"])