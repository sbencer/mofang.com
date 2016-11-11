/**
 * 移动端共用部分
 */
define('m/common',['jquery','jquery/jquery-pop','jquery/jquery-slider-down','moveTop'], function(require, exports, module){
   var $ = jQuery = require("jquery");//jquery库
   require("jquery/jquery-pop");//加载弹出框
   require("jquery/jquery-slider-down");//加载分享弹出框
   require("moveTop"); //加载回到顶部

    $(function(){
      //左侧菜单显示
      $(".left-menu").css("display","block");
      var minH = $('.left-menu').height();
      $('html,body,.left-menu').css('min-height',minH+'px');
    });
    

    function fnMenu(){
        $(".left-menu").css({
            "width":px2rem(550)
        });
        if($("#menu").hasClass('menu-show')){
            $("#menu").removeClass('menu-show');
            $(".left-menu").css({
                "left":px2rem(-550)
            });
            $(".wrapper").css({
                "left":px2rem(0)
            });
            $("body").css("overflow-x","initial");
        }else{
            $("#menu").addClass('menu-show');
            $(".left-menu").css({
                "left":px2rem(0)
            });
            $(".wrapper").css({
                "left":px2rem(550)
            });
            $("body").css("overflow-x","hidden");
        }
    }
     //左边的快捷导航
    $("#menu").on("click",function(){
        fnMenu();
    });
     
    $(".left-menu")[0].addEventListener('touchstart',function(ev){
        var lastDis=0;
        var disX = ev.touches[0].pageX;
        function fnMenuMove(ev){
            lastDis=ev.touches[0].pageX-disX;
            
        }
        function fnMenuEnd(ev){
            if(lastDis<-80){
                fnMenu();
            }
            $(".left-menu")[0].removeEventListener('touchmove',fnMenuMove,false);
            $(".left-menu")[0].removeEventListener('touchend',fnMenuEnd,false);
        }
        $(".left-menu")[0].addEventListener('touchmove',fnMenuMove,false);
        $(".left-menu")[0].addEventListener("touchend",fnMenuEnd,false);


     },false);


    //顶部搜索 
    topSearch();
    function topSearch(){
        $(".menu-r").on("click",function(){ 
            $(".search").show();  
            $(".search .ser-text").focus();
        });
        $(".ser-sub").on("click",function(){
            $("#formSearch").submit();
        })
        $(".ser-close-icon").on("click",function(){
            $(".search .ser-text").val("");
            $(".search .ser-text").focus();
        })
        $(".search .ser-text").on("focus keypress keydown touchstart",function(){
            if($(".search .ser-text").val() == "" || $(".search .ser-text").val() == " "){
                $(".ser-close-icon").hide();
            }else{
                $(".ser-close-icon").show(); 
            }
        });

        $('.ser-text').on("blur",function(){
            if($(".search .ser-text").val() == "" || $(".search .ser-text").val() == " "){
                $(".search").hide();
            }
        })

    }
    

    //share按钮点击

    $(".nav-share").on("click",function(){
        $(".share-bg").show();
        //文章页分享
        // $(".share-menu").pop({
        //     msg:""
        // });
        $(".share-menu").sliderDown({
            cancelClass : ".cancel-btn"
        });
    });

    $(".share-bg").on("click",function(){
        $(".share-bg").hide();
        $(".share-menu").hide();
    });

    

   /*小方法*/
   function px2rem(px){
        return px/28.125+'rem';
   }
   /*评分*/
    /*$(function() {
        $('.circle-scroe').each(function(index, el) {
            var num = $(this).find('span').text() * 36;
            if (num<=180) {
                $(this).find('.scroe-left-right').css('transform', "rotate(" + num + "deg)");
            } else {
                $(this).find('.scroe-left-right').css('transform', "rotate(180deg)");
                $(this).find('.scroe-left-left').css('transform', "rotate(" + (num - 180) + "deg)");
            };
        });
    });*/
   /*   pop参数
    *   title:'标题,左上角位置',//左上角标题
        msg:'提示信息,你暂时未登录，请登录后操作',//提示信息
        titleClass:'.pop-title',//标题class
        msgClass:'.pop-msg',//提示信息class
        closeClass:'.close',//关闭class
        cancelClass:'.pop-cancel',//取消class
        okClass:'.pop-ok',//确定class
        autoTime: 2000,//自动隐藏pop时间
        isAutoClose:false,//是否自动关闭
        fnCallback: function(isTrue,msg){//回调函数，确定，true,false,msg,提示信息

        }
    *
    *
    */

    //文章页微信分享
    $("body").on("click",".weixin-share",function(){
        var url = location.href,
        qCodeApi = "http://url.mofang.com/?url=",
        generateQCode = qCodeApi+url+"&size=200";
        $(".share-menu").hide();
        $(".share-weixin-pop").pop({
            msg:"<img src="+generateQCode+" /><p style='text-align:center;color:#fff'>微信扫一扫，分享文章</p>"
        });
    });

    //回到顶部
    $(".fixed-top").click(function(){
        $(this).moveTop(0);
    });
    var topBtn = $('.fixed-top');
    $(window).scroll(function(){
        var scrollH = $(window).scrollTop();
        var height = $(window).height();
        if(scrollH > height){
            topBtn.fadeIn();
        }else{
            topBtn.fadeOut();
        }
    });
});
seajs.use("m/common");
