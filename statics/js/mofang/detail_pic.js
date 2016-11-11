
	//图片详情页图片轮播
	window.onload=function(){
	//计算图片的宽高  然后上下左右居中
	$(".phtsc_cen>li>a>img").each(function(){
		var imgH=$(this).height();
		if(imgH<560){
				$(this).css({"margin-top":280-imgH/2});
		}	
	})
	var step1=0;
	var oLis=$(".phtsc_cen").children().length;
	//向左轮播
	$(".tuji_countAll").html(oLis)
		$(".tuji_left").click(
		function(){
			if(step1<0){
			step1++;
			$(".phtsc_cen").stop().animate({"left":step1*750},500);
			var small_index=-step1;
			$(".small_pht").children().get(small_index).className="small_special";
			$(".small_pht").children().get(temp).className="";
			temp=small_index;
			if(step1<-1){
					$(".tuji_right").get(0).style.background='url("../statics/images/mofang/details_phs.png") no-repeat scroll right -180px transparent';}else if(step1==0){
					$(".tuji_left").get(0).style.background='url("../statics/images/mofang/details_phs.png") no-repeat scroll left -85px transparent';	
				}
				if((step1-1)%5==0){
					$(".small_pht").stop().animate({"left":550*((step1-1)/5+1)},500);
					step++;
				};
				$(".tuji_count").html(-step1+1)
			}
		})

		//向右轮播
		$(".tuji_right").click(
		function(){
			var oLis_count=1-oLis;
			if(step1>oLis_count){
			//if((step-2)%5){}
				step1--;
				$(".phtsc_cen").stop().animate({"left":step1*750},500);	
				var small_index=-step1;
				$(".small_pht").children().get(small_index).className="small_special";
				$(".small_pht").children().get(temp).className="";
				temp=small_index;
				if(step1>-oLis+1){
					$(".tuji_left").get(0).style.background='url("../statics/images/mofang/details_phs.png") no-repeat scroll left -180px transparent';
				}else if(step1==-oLis+1){
					$(".tuji_right").get(0).style.background='url("../statics/images/mofang/details_phs.png") no-repeat scroll right -85px transparent';	
				};//end 图片切换
				if(step1%5==0){
					$(".small_pht").stop().animate({"left":550*(step1/5)},500);
					step--;
				}
				$(".tuji_count").html(-step1+1);
			}
		})
		//点击缩略图的效果
		var temp=0;
		$(".small_pht").stop().children().each(
		function(index){
			$(this).click(
				function(step){
					step=$(this).index();
					$(".phtsc_cen").stop().animate({"left":-index*750},500);
					$(".small_pht").children().get(temp).className="";
					$(".small_pht").children().get(step).className="small_special";
					
					temp=step;	
					step1=-step;
					if(step==0){
						$(".tuji_left").get(0).style.background='url("../statics/images/mofang/details_phs.png") no-repeat scroll left -85px transparent';	
						$(".tuji_right").get(0).style.background='url("../statics/images/mofang/details_phs.png") no-repeat scroll right -180px transparent';
					}else if(step==oLis-1){
						$(".tuji_right").get(0).style.background='url("../statics/images/mofang/details_phs.png") no-repeat scroll right -85px transparent';
						$(".tuji_left").get(0).style.background='url("../statics/images/mofang/details_phs.png") no-repeat scroll left -180px transparent';
					}else{
						$(".tuji_left").get(0).style.background='url("../statics/images/mofang/details_phs.png") no-repeat scroll left -180px transparent';
						$(".tuji_right").get(0).style.background='url("../statics/images/mofang/details_phs.png") no-repeat scroll right -180px transparent';
					}//end if
					$(".tuji_count").html(-step1+1)
				}
			);	
		})
		
	
	
	//下一图集 write less  do  more
	function hoverChan(oHover,mask){
			$(mask).css({"opacity":0.6})
			$(oHover).hover(function(){
				$(mask).stop().animate({"opacity":0},0);
				$(oHover+">.next_1").removeClass("next_1").addClass("next_hover")
			},function(){$(oHover+">.next_hover").removeClass("next_hover").addClass("next_1");
				$(mask).stop().animate({"opacity":0.6})
			});
		}
		hoverChan(".phtbtt_r",".mask2")
		hoverChan(".phtbtt_l",".mask1")
		
	//缩略图的左右按钮	
	var step=0;
	var count_small=Math.floor($(".small_pht").children().length/5);
	$(".phts_left").click(function(){
		if(step<0){
			step++;
			$(".small_pht").animate({"left":step*550})	
		};
	});
	$(".phts_right").click(function(){
		if(step>-count_small&$(".small_pht").children().length%5!=0){
			step--;
			$(".small_pht").animate({"left":step*550});
		}else if($(".small_pht").children().length%5==0&step>-count_small+1){
			step--;
			$(".small_pht").animate({"left":step*550});
		}	
	})
	
	
	//滚动条
		
	//	$(".pht_scro").mousedown(function(e){
//		$(document).mousemove(
//			function(e){
//				e.stopPropagation();
//				if(e.clientX>680+72&e.clientX<1440-290)
//				$(".pht_scro").css({"left":e.pageX-680-72});
//			}
//		);
//		});
//
//		var scro=$(".pht_scro");
//		scro.preposi=0;
//		scro.lastPosi=0;
//		var oLis=$(".phtsc_cen").children().length;
//		function emove(e){
//			//var re=((e.clientX-scro.positionOld)/392)*(oLis*110);
//			var oLis=$(".phtsc_cen").children().length;
//			if(e.clientX>750&e.clientX<1150){
//				$(".pht_scro").css({"left":e.pageX-750});
//				oLias=(Math.floor(oLis/5))*550;
//				//console.log("e.page:"+e.pageX);
////				console.log("scro.positionOld:"+scro.positionOld);
//				var re=((e.pageX-scro.positionOld)/400)*oLias;
//				//console.log(re);//11
////				console.log(scro.preposi);//0
////				console.log(scro.preposi-re);
//////				if(e.clientX-scro.positionOld<0){
//////					$(".small_pht").animate({"left":-re+scro.preposi},0);
//////					console.log(scro.preposi);
//////				}else{
//////					$(".small_pht").animate({"left":-re+scro.lastPosi},0);
//////				}
//					console.log(re)
//					console.log(e.pageX);//55
//					console.log(-re+scro.lastPosi)
//					$(".small_pht").animate({"left":-re+scro.lastPosi},0);
//				
//			}
//		}
//		function ecancel(e){
//			scro.unbind("mousemove",emove).unbind("mouseup",ecancel);
//			$(document).unbind("mousemove",emove);
//			scro.lastPosi=$(".small_pht").get(0).offsetLeft;
//			
//		}
//		
//		function edown(e){
//			$(document).mousemove(emove).mouseup(ecancel);
//			scro.positionOld=e.clientX;
//			
//		}
//		scro.bind("mousedown",edown);
		
}//$ end 