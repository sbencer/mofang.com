define('tyong/index',['jquery',"jquery/tabs",'jquery/bxslider','jquery/nicescroll'],function(require,exports,module){
	var jquery = $ =require("jquery");
		require("jquery/tabs");
		require('jquery/bxslider');
		require('jquery/nicescroll');
	$(".j_wrap").tabs({
		tabList: ".j_tab>li",               // 标题列表
        tabContent: ".j_con",            //内容列表
        tabOn: "curr",                 //菜单划过的类名
        action: "mouseover"               // c
	})
	$(".j_wrap").tabs({
		tabList: ".j_tabs>li",               // 标题列表
        tabContent: ".article-new",            //内容列表
        tabOn: "curr",                 //菜单划过的类名
        action: "mouseover"               // c
	})
	$('.time-con').niceScroll();
	
	$(".j_carouse").bxSlider();

	$(".j_hover").hover(function(){
		$(this).find(".j_select").show();
	},function(){
		$(this).find(".j_select").hide();
	});

	$(".j_select").on("click",function(){
		var _this=$(this);
		if(_this.find("em, span").hasClass("lin_jian")){
			_this
				.find("em,span")
				.addClass("lin_add")
				.removeClass("lin_jian");
			_this 
				.siblings(".j_select_con")
				.slideUp(200,function(){

				})
			return false;
		};
		$(this).siblings(".j_select_con").slideDown(200, function() {
			_this.find('.lin_add').removeClass('lin_add').addClass('lin_jian')
		});""
		/*$(this).parent().siblings().find(".j_select_con").slideUp(200,function(){
			_this.parent()
				.siblings().find(".j_select")
				.find('.lin_jian').addClass('lin_add')
				.removeClass('lin_jian')
		});*/
		return false;
	})
	//侧边栏
	$('#demo').on("click",function(){
		$('.demo').hide();
		return false;
	})
	$(".j_select").on("click","j_ic_close",function(){
		$(this).addClass("j_ic_open");
	});
	$(".j_select").on("click","j_ic_open",function(){
		$(this).addClass("j_ic_close");
	})
	/*关闭直播*/
	$('.close_live').click(function(){
		$(this).hide();
		$('.iframe_live').hide().attr('src','');
		$('.live').children('h2').hide();
		$('.live_list').children('.status').html('即將上映');
	})
	/*开启直播*/
	$('.marquee_table a').click(function(){
		var src = $(this).attr('data-src');
		$('.live').children('h2').show();
		$('.live_list').children('.status').html('LIVE');
		$('.iframe_live').show().attr('src',src);
		$('.close_live').css('display','block');
	})
})
seajs.use(['tyong/index'])