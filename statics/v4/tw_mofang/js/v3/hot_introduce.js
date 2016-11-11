define('hot_introduce', ["jquery"], function(require, exports, module) {
    var $ = require("jquery");

    $('.con-hd ul li').mouseenter(function(){
        var _idx = $(this).index();
        $(this).addClass('curr').siblings().removeClass('curr');
        $(this).parents('.con-hd').siblings('.con-cont').children().eq(_idx).show().siblings().hide();
    })

})
seajs.use(["hot_introduce"])
