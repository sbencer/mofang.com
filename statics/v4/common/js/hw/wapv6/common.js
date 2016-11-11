/**
 * 移动端共用部分
 */
define('m/common',['jquery','jquery/jquery-pop','moveTop'], function(require, exports, module){
   var $ = jQuery = require("jquery");//jquery库
   require("jquery/jquery-pop");//加载弹出框
   require("moveTop"); //加载回到顶部

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
