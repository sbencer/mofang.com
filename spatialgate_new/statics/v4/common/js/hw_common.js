define('mf/hw_com', ['jquery', 'jquery/cookie'], function(require, exports, module) {

    // 魔方网注册和登陆
    var $ =  require("jquery");
    var jQuery = $;
    
    $(".j_mf_list").hover(function(){
        $(this).addClass('mf-list-hover');
        $(".j_mf_con").show();
        return false;
    },function(){
        $(this).removeClass('mf-list-hover');
        $(".j_mf_con").hide();
        return false;
    })
	//header下拉
	$('.title-diff li').mouseenter(function(){
        $(this).find('.dropdown').show();
    }).mouseleave(function(){
        $(this).find('.dropdown').hide();
    })
    if (typeof module != "undefined" && module.exports) {  
    }
});
seajs.use(['mf/hw_com']);
