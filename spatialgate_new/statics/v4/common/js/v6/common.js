/**
 * common
 * @author xukuikui
 * @date 2015-06-30
 */
define('common',['jquery',"jquery/jquery-reluserurl"],function(require, exports, module) {

	var $ = jQuery = require("jquery");//jquery库
	require("jquery/jquery-reluserurl");//登录带上参数

	topSearch();
	//顶部搜索处理
	function topSearch(){
        if($.trim($("#topSearch").val()) != ""){
            $("#topSearch").animate({
                "position":"relative",
                "width":"235px"
            },100);
        }
		$('#topSearch').focus(function() {

		  	$(this).animate({
		  		"position":"relative",
		  		"width":"235px"
		  	},200);
		});
		$('#topSearch').blur(function() {
  			if($.trim($("#topSearch").val()) != ""){
                return false;
            }
		  	$(this).animate({
		  		"position":"relative",
		  		"width":"144px"
		  	},200);
		});
	}
	//顶部登录跳转
	$("#login").loginUserUrl();

	/*微信分享*/
	//文章页微信分享
    $("body").on("click",".weixin-share",function(){
        var url = location.href,
        qCodeApi = "http://url.mofang.com/?url=",
        generateQCode = qCodeApi+url+"&size=200";
        
        $("body").append('<div class="share-weixin-pop"><span class="pop-msg"></span></div>')
        $(".share-weixin-pop").pop({
            msg:"<img src="+generateQCode+" /><p style='text-align:center;color:#fff'>微信扫一扫，分享文章</p>"
        });
    });

	//头部微信扫描
    $(".nav-contact").on("click",".weixin-icon",function(){
    	$(".weixin-bg").fadeIn();
      $(".weixin-box .weixin-img").fadeIn();
    	return false;
    });
    $(".weixin-box").on("click","",function(){
    	return false;
    });
    $(document).on("click",function(){
    	$(".weixin-bg").fadeOut();
      $(".weixin-box .weixin-img").fadeOut();
    });
    
    //按esc二维码消失
    document.onkeyup = function (e){ 
           e = e || window.event; 
           var code = e.which || e.keyCode; 
           if (code == 27) { 
           		$(".weixin-bg").fadeOut();
              $(".weixin-box .weixin-img").fadeOut();
           }   
       }
});
seajs.use('common');