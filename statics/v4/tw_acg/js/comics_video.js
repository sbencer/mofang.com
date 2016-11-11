define('comics_video',['jquery'],function(require,exports,module){
	var $ =  require('jquery');

	function changeCss()
	{
	    // 操作iframe中内容的CSS
	    var iframe = document.getElementById('v_iframe');
	    var body = iframe.contentWindow.document.body;

	    body.style.marginTop = 50;
	    body.style.padding = 0;
	    body.style.fontSize = 30;
	    body.style.textAlign = 'center';
	    body.style.backgroundColor = 'red';
	    body.style.color = 'blue';
	console.log('00');
	}
	changeCss();
})
seajs.use('comics_video');