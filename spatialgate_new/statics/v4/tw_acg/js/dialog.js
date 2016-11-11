define('acg/dialog',['jquery','jquery/fancybox'],function(require,exports,module){
	var $ = jQuery = require('jquery');
	require('jquery/fancybox'); 
	$('.fancybox').fancybox();
	//視頻懸浮顯示關閉按鈕
	$('.pop_video').mouseenter(function(){
		$(this).children('.close_btn').show();
	}).mouseleave(function(){
		$(this).children('.close_btn').hide();
	})
	//切換到日曆
	$('.icon_calendar').click(function(){
		$(this).parent('.activity_list').hide();
		$('#calendar').show();
	})
	//切換為活動快訊
	$('.icon_act_list').click(function(){
		$(this).parents('#calendar').hide();
		$('.activity_list').show();
	})
	//日曆活動彈出 
	$('.remind').live('click',function(){
		var id = $(this).attr('data-id');
		$.fancybox.open('#'+id);
	}) 
	
	$('.close_btn').live('click',function(){
		$('.fancybox-close').trigger('click');
	}) 
	var year = new Date().getFullYear();
	var p_m = parseInt($('.prev_mounth').html());
	var t_m = parseInt($('.this_mounth').html());
	var n_m = parseInt($('.next_mounth').html());
	$('.next_mounth').on('click',function(){
		if(p_m == 12){
			p_m = 1;
		}else{
			p_m++;
		}
		if(t_m == 12){ 
			t_m = 1;
			year ++;
		}else{
			t_m++;
		}
		if(n_m == 12){
			n_m = 1;
		}else{
			n_m++;
		}
		var month = t_m;
		//console.log(year+','+month);
		$('.prev_mounth').html(p_m+'月');
		$('.this_mounth').html(t_m+'月');
		$('.next_mounth').html(n_m+'月');
		$.ajax({
			url:'/api.php?op=get_calendar&event=1',
			data:{'year':year,'month':month},
			type:'GET',
			dataType:'html',
			success:function(data){
				$('#calendar').children('.activity_alert').remove();
				$('table').remove('.calendar-month');
				$('#calendar').append(data);
			},
			error:function(){
				console.log('請求錯誤');
			}
		})
	})
	$('.prev_mounth').click(function(){
		if(p_m == 1){
			p_m = 12;
		}else{
			p_m--;
		}
		if(t_m == 1){ 
			t_m = 12;
			year--;
		}else{
			t_m--;
		}
		if(n_m == 1){
			n_m = 12;
		}else{
			n_m--;
		}
		var month = t_m;
		//console.log(year+','+month);
		$('.prev_mounth').html(p_m+'月');
		$('.this_mounth').html(t_m+'月');
		$('.next_mounth').html(n_m+'月');
		$.ajax({
			url:'/api.php?op=get_calendar&event=1',
			data:{'year':year,'month':month},
			type:'GET',
			dataType:'html',
			success:function(data){
				$('#calendar').children('.activity_alert').remove();
				$('table').remove('.calendar-month');
				$('#calendar').append(data);
			},
			error:function(){
				console.log('請求錯誤');
			}

		})
	})


})
seajs.use('acg/dialog');