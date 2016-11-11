define('index/sortabs', ["jquery"], function(require, exports, module) {
    var $ = require("jquery");

    $('.sort-head ul li').mouseenter(function(){
        var _idx = $(this).index();
        $(this).addClass('curr').siblings().removeClass('curr');
        $(this).parents('.sort-head').siblings('.sort-main').children().eq(_idx).show().siblings().hide();
    })
    $('.sort-news dl').mouseenter(function(){
        var _idx = $(this).index();
        $(this).children('.sort-con').removeClass('disno').siblings('.turn-posi').addClass('disno');
        $(this).siblings().children('.sort-con').addClass('disno').siblings().removeClass('disno');
    })
})
seajs.use(["index/sortabs"])
