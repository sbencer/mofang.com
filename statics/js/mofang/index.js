//   头部收藏
function AddFavorite(sURL, sTitle){
        var url = sTitle;
        var title = sURL;
         
        if (window.sidebar) { 			// Mozilla Firefox Bookmark
			window.sidebar.addPanel(title, url,"");
			return false;
        } else if(window.opera) { 		// Opera 7+
			return false; 				// do nothing
        } else { 
			try
			{
				xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
				window.external.AddFavorite( url, title);
				return false;		// IE
			}
				catch (e)
				{
					alert("请按 Ctrl+D 键添加到收藏夹");
					return false;
				}
			}
}
	

////签到
//	var Login=document.getElementById("Login")
//	var sign=document.getElementById("index_sign");
//	var fr=document.getElementById("fr");
//	ogreyBox(sign,fr,Login);


//微信关注
	var dialog_weixin=document.getElementById("dialog_weixin");
	
	var fr1=document.getElementById("fr1");
	var index_weixin=document.getElementById("index_weixin");
	ogreyBox(index_weixin,fr1,dialog_weixin);
	
	

//鼠标悬浮时改变样式  index.html
	$('li.top10-list').on( 'mouseover', function( e ) {
		//e.preventDefault();
		e.stopPropagation();
		var self = $(this);
		self.parents('ul.top10-con').find('div.top10-content').hide().end().find('div.top10-contenb').show();
		self.parents('ul.top10-con').children('li.top10-list').each(function(){
			$(this).removeClass('top1').addClass('topAll');
		});
		if( !self.hasClass('top1') ) {
			self.css( 'border-top', '1px dashed #CCCCCC' );
		}
		self.addClass('top1').removeClass('topAll');
		self.children('div.top10-contenb').hide();
		self.children('div.top10-content').show();
	});
	
// tab 切换调用
//$("#top10-ios").tabs({
//        tabList: ".top10-tit ul li",
//        tabContent: ".top10Box .top10-con",
//        tabOn:"curr",
//        action: "click"
//});
//$("#top10-android").tabs({
//    tabList: ".top10-tit ul li",
//	tabContent: ".top10Box .top10-con",
//    tabOn:"curr",
//    action: "click"
//});

//  hot  搜索

//;(function(){
//	var step=0;
//	var temp=0;
//	var trime=null;
//	function autoMove(){
//		step--;
//		clearTimeout(trime);
//		if(step==-3){
//			step=0;
//			console.log(1);
//			if( !$(".gHotsear-con").is(':animated') ) {
//				$(".gHotsear-con").stop().animate({"top":step*46},
//					function(){
//						/*$(".gHotsear-con").css("top","0");*/
//						$($(".up-icom")).get(0).style.background="url(statics/images/mofang/anniu1.png) no-repeat -87px -58px";
//						$($(".down-icon")).get(0).style.background="url(statics/images/mofang/anniu1.png) no-repeat -87px -41px";	
//					}
//				)
//			}//end stop
//			temp=step;
//			step=0;
//			trime=setTimeout(autoMove,2000);
//		}else if(step==-2){
//			$(".gHotsear-con").stop().animate({"top":step*46},
//				function(){
//					$($(".up-icom")).get(0).style.background="url(statics/images/mofang/anniu1.png) no-repeat -87px -6px";
//					$($(".down-icon")).get(0).style.background="url(statics/images/mofang/anniu1.png) no-repeat -87px -24px";
//				}
//			)
//		trime=setTimeout(autoMove,2000);
//			
//		}else if(step==0){
//			$(".gHotsear-con").stop().animate({"top":step*46},
//				function(){
//					$($(".up-icom")).get(0).style.background="url(statics/images/mofang/anniu1.png) no-repeat -87px -58px";
//					$($(".down-icon")).get(0).style.background="url(statics/images/mofang/anniu1.png) no-repeat -87px -24px";
//				}
//			)
//		trime=setTimeout(autoMove,2000);
//		}
//		else {
//			temp=-step;
//			if( !$(".gHotsear-con").is(':animated') ) {
//				$(".gHotsear-con").stop().animate({"top":step*46});
//				$($(".down-icon")).get(0).style.background="url(statics/images/mofang/anniu1.png) no-repeat -87px -24px";
//				$($(".up-icom")).get(0).style.background="url(statics/images/mofang/anniu1.png) no-repeat -87px -58px";	
//			}
//			trime=setTimeout(autoMove,2000);	
//		}
//		
//	}
//	trime=setTimeout(function(){autoMove()},1000)
//	
//	
//	function moveBtn(btn1,btn2,content){
//				$(btn1).click(function(){
//					clearTimeout(trime);
//					step--;
//					if(step==-2){
//						$(btn1).get(0).style.background="url(../../images/mofang/anniu1.png) no-repeat -87px -6px";
//						$(content).stop(true,false).animate({top:step*46},
//						function(){
//							trime=setTimeout(function(){autoMove()},2000);
//						});
//					}else if(step<-2){step++;}
//					else{
//						$(btn2).get(0).style.background="url(../../images/mofang/anniu1.png) no-repeat -87px -24px";	
//						$(content).stop(true,false).animate({top:step*46},
//						function(){
//							trime=setTimeout(function(){autoMove()},2000);									
//						});	
//					}
//				});
//				$(btn2).click(function(){
//					clearTimeout(trime);
//					step++;
//					if(step==0){
//						$(btn2).get(0).style.background="url(../../images/mofang/anniu1.png) no-repeat -87px -41px";
//						$(content).stop(true,false).animate({top:step*46},
//						function(){
//							trime=setTimeout(function(){autoMove()},2000);
//						})	
//					}else if(step>0){step--;}
//					else{
//						$(btn1).get(0).style.background="url(../../images/mofang/anniu1.png) no-repeat -87px -58px";
//						$(content).stop(true,false).animate({top:step*46},
//							function(){
//								trime=setTimeout(function(){autoMove()},2000);
//							}
//						)
//					}
//			});
//		}
//	$(".gHotsear-con").hover(function(){clearTimeout(trime);},function(){trime=setTimeout(autoMove,2000)});	
//	moveBtn($(".up-icom"),$(".down-icon"),$(".gHotsear-con"))
//})()

	//$("iframe .left_orange").click(function(){
//	var omask=document.getElementById("omask");
//	console.log(omask);
//			document.documentElement.removeChild(omask);
//			greyEle.style.display="none";
//			$('.Login_middle').get(0).style.display=none;
//			$('.Login_middle').get(0).style.zIndex=0;
//			$('.Login_middle').get(0).style.zIndex=0;
//			conosole.log(1);
//})