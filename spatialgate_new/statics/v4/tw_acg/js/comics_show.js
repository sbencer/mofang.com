seajs.config({
    alias: {
        'jScrollPane': '/statics/v4/tw_acg/js/jscrollpane.js'
    }
}) 
define('comics_show',['jquery','jquery/fancybox','jScrollPane','jquery/jquery-pop'],function(require,exports,module){
	var $ =  require('jquery');
	require('jquery/fancybox');
    require('jScrollPane');
    require('jquery/jquery-pop');

	function scroll(parents){
		var sWidth = $(parents).children('.comics_list_box').width(); //获取的宽度（显示面积）
		var len = $(parents+" ul li").length; //获取li个数
		var index = 0;
		
		//上一页按钮
		$(parents+" .btn_prev").click(function() {
			index -= 1;
			if(index == -1) {index = len - 1;}
			showPics(index);
		});

		//下一页按钮
		$(parents+" .btn_next").click(function() {
			index += 1;
			if(index == len) {index = 0;}
			showPics(index);
		
		//本例为左右滚动，即所有li元素都是在同一排向左浮动，所以这里需要计算出外围ul元素的宽度
		$(parents).find('ul').css("width",sWidth * (len));
});

		//显示li函数，根据接收的index值显示相应的内容
		function showPics(index) { //普通切换
			var nowLeft = -index*sWidth; //根据index值计算ul元素的left值
			$(parents).find('ul').stop(true,false).animate({"left":nowLeft},300); //通过animate()调整ul元素滚动到计算出的position			
		}
	}
	scroll('#anicomic');
	scroll('#manga');

	//点击封面弹出浮层
	var SURL = "/spatialgate_new/index.php?m=content&c=index&a=show_comics&format=html"
	$('.comics_list li dl a').click(function(){
		var catid = $(this).parents('dl').attr('data-catid'),
			id = $(this).parents('dl').attr('data-id');
		$.ajax({
			url:SURL,
			data:{"catid":catid,"id":id},
			type:"GET",
			dataType:"HTML",
			success:function(data){
				$("#pop_works").html(data);
				$.fancybox.open('#pop_works');
				$('.chapter-ul').jScrollPane();
			},
			error:function(){
				console.log('请求错误');
			}
		})
	})
	//点击返回关闭浮层
	$('.works_back').live('click',function(){
		$.fancybox.close();
	})

	//点击收藏
	$('.icon_like').click(function(){
		var like_num = parseInt($(this).html());
		console.log(like_num);
		if(!$(this).hasClass('already')){
			like_num++;
			$(this).html(like_num);
			$(this).addClass('already');
			$('.pop-post-ok').pop({
				msg:'收藏成功',
				autoTime:1000,
                isAutoClose:true
			})
			$.ajax({
				url:'',
				data:{'like':like_num},
				type:'POST',
				dataType:'json',
				success:function(){
					alert('收藏成功')
				}
			})
		}else{
			$(this).html(like_num);
			$(this).removeClass('already');
			$('.pop-cancel-like').pop({
				msg:'確定要取消收藏嗎？',
				fnCallback:function(isTrue){
					like_num--;
					$.ajax({
						url:'',
						data:{'like':like_num},
						type:'POST',
						dataType:'json'
					})
					console.log('确定');
				}
			})
		}
	})
})
seajs.use('comics_show');