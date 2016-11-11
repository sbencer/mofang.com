define('mf/hw_com', ['jquery','jquery/cookie','mf/floatLayer'], function(require, exports, module) {

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
    $('.title-diff li').mouseenter(function(){//header下拉
        $(this).find('.dropdown').show();
    }).mouseleave(function(){
        $(this).find('.dropdown').hide();
    })
    if (typeof module != "undefined" && module.exports) {  
    }
});
seajs.use(['mf/hw_com']);
