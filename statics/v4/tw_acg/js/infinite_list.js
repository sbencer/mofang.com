seajs.config({
    alias: {
        'lazyload': '/statics/v4/tw_acg/js/jquery.lazyload.min.js',
        'infinite': '/statics/v4/tw_acg/js/jquery.infinite.js'
    }
})    

define('infinite_list',['jquery','lazyload','infinite','handlebars','jquery/fancybox'],function(require,exports,module){
    var Handlebars = require("handlebars");
    var $ = jQuery = require('jquery');
    require('lazyload');	//加载延时加载
    require('infinite');	//加载瀑布流
    require('jquery/fancybox'); 
    $("img.lazy").lazyload({		
		load:function(){
			$('.infiniteBox').BlocksIt({
				numOfCol:4,
				offsetX: 8,
				offsetY: 8
			});
		}
	});
	
	//window resize
	var currentWidth = 1000;
	$(window).resize(function() {
		var winWidth = $(window).width();
		var conWidth;
		if(winWidth < 480) {
			conWidth = 240;
			col = 1;
		} else if(winWidth < 720) {
			conWidth = 480;
			col = 2;
		} else if(winWidth < 1000) {
			conWidth = 720;
			col = 3;
		} else {
			conWidth = 1000;
			col = 4;
		}
		
		if(conWidth != currentWidth) {
			currentWidth = conWidth;
			$('.infiniteBox').width(conWidth);
			$('.infiniteBox').BlocksIt({
				numOfCol: col,
				offsetX: 8,
				offsetY: 8
			});
		}
	});
	$('.fancybox').fancybox();
	
	var next = true;

	var aTpl = '{{#each this}}<div class="grid">\
			   		<div class="imgholder">\
			   			<a class="fancybox" href="{{thumb}}">\
			   				<img class="lazy" src="{{thumb}}" >\
			   			</a>\
			   		</div>\
			   		<p>\
			   			<a href="{{url}}">{{title}}</a>\
			   		</p>\
				    <p class="icon_horologe">\
			      		{{inputtime}}\
			      	</p>\
			      	<p class="icon_view">\
			      		瀏覽次數:&nbsp;{{views}}\
			      	</p>\
			   	</div>{{/each}}';
	var sLock = true;//ajax lock; 

	//ajax加载新内容	
	var ajxFn = function(callback){
		if(!sLock){
			return sLock = true;
		}
		sLock = false;
		page++;
		$.ajax({
			url:SURL,
			data:{'catid':catid,'page':page},
			type:'GET',
			dataType:'json',
			beforeSend:function(){
				$('.load-img').show();
			},
			success:function(res){
				$('.load-img').hide();
				if(res.length == 0){
					next = false;
					// console.log('無更多');
				}else{
					callback(res,aTpl);
				}
			},
            error:function(){
            	$('.load-img').hide();
                console.log("請求錯誤");
            }
		})
	}

	$(window).scroll(function(){
			// 当滚动到最底部以上50像素时， 加载新内容
		if (next && $(document).height() - $(this).scrollTop() - $(this).height()<10){
			
			//$("img.lazy").lazyload();
			var renderTpl = function(res,tpl){
				var myTemplate = Handlebars.compile( tpl );
				var renderEle = myTemplate(res);
				$(".infiniteBox").append(renderEle);
		        return renderEle;
			}
			
			ajxFn(renderTpl);	
			$('.infiniteBox').BlocksIt({
				numOfCol:4,
				offsetX: 8,
				offsetY: 8
			});
			// console.log(page);
			return false;
		}
	});


	
	if (typeof module != "undefined" && module.exports) {
        //module.exports = carouse;
    }



})
seajs.use("infinite_list")


