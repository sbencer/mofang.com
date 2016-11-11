define('iframe',['jquery'],function(require,exports,module){
	var $ =  require('jquery');
	
	function iframeH(){
		height = $(window).height()-140;
		$("#v_iframe").height(height); 
	}
	iframeH();
	//监听浏览器窗口变化
	window.onresize=function(){
		iframeH();	
	}
})
seajs.use('iframe');